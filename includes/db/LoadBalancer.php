<?php
/**
 * Database load balancing
 *
 * @file
 * @ingroup Database
 */

/**
 * Database load balancing object
 *
 * @todo document
 * @ingroup Database
 */
class LoadBalancer {
	private $mServers, $mConns, $mLoads, $mGroupLoads;
	private $mErrorConnection;
	private $mReadIndex;
	private $mWaitForPos, $mWaitTimeout;
	private $mLaggedSlaveMode, $mLastError = 'Unknown error';
	private $mParentInfo;
	private $mLoadMonitorClass, $mLoadMonitor;

	/** @var string|bool Reason the LB is read-only or false if not */
	private $readOnlyReason = false;

	/**
	 * @param $params Array with keys:
	 *    servers           Required. Array of server info structures.
	 *    masterWaitTimeout Replication lag wait timeout
	 *    loadMonitor       Name of a class used to fetch server lag and load.
	 *    readOnlyReason    Reason the master DB is read-only if so [optional]
	 */
	function __construct( $params ) {
		if ( !isset( $params['servers'] ) ) {
			throw new MWException( __CLASS__.': missing servers parameter' );
		}
		$this->mServers = $this->resolveServerArray( $params['servers'] );

		if ( isset( $params['waitTimeout'] ) ) {
			$this->mWaitTimeout = $params['waitTimeout'];
		} else {
			$this->mWaitTimeout = 10;
		}

		$this->mReadIndex = -1;
		$this->mWriteIndex = -1;
		$this->mConns = array(
			'local' => array(),
			'foreignUsed' => array(),
			'foreignFree' => array() );
		$this->mLoads = array();
		$this->mWaitForPos = false;
		$this->mLaggedSlaveMode = false;
		$this->mErrorConnection = false;

		if ( isset( $params['readOnlyReason'] ) && is_string( $params['readOnlyReason'] ) ) {
			$this->readOnlyReason = $params['readOnlyReason'];
		}

		if ( isset( $params['loadMonitor'] ) ) {
			$this->mLoadMonitorClass = $params['loadMonitor'];
		} else {
			$master = reset( $params['servers'] );
			if ( isset( $master['type'] ) && $master['type'] === 'mysql' ) {
				$this->mLoadMonitorClass = 'LoadMonitor_MySQL';
			} else {
				$this->mLoadMonitorClass = 'LoadMonitor_Null';
			}
		}

		foreach( $params['servers'] as $i => $server ) {
			$this->mLoads[$i] = $server['load'];
			if ( isset( $server['groupLoads'] ) ) {
				foreach ( $server['groupLoads'] as $group => $ratio ) {
					if ( !isset( $this->mGroupLoads[$group] ) ) {
						$this->mGroupLoads[$group] = array();
					}
					$this->mGroupLoads[$group][$i] = $ratio;
				}
			}
		}
	}

	/**
	 * Given an array of LoadBalancer server configurations expected to contain at most two servers,
	 * resolve the Consul hostname of the replica server configuration (if present) and add the IP addresses of the
	 * replica nodes to the configuration.
	 * @param array $servers
	 * @return array
	 */
	private function resolveServerArray( array $servers ): array {
		// Nothing to do for non-replicating clusters.
		if ( count( $servers ) === 1 ) {
			return $servers;
		}

		[ $masterServerConfig, $replicaServerConfig ] = $servers;

		// Don't bother eagerly resolving the master DB host name as it should always resolve to a single physical DB.
		$physicalServers = [ $masterServerConfig ];

		// Consul DNS records will contain all hosts that it considers healthy.
		// Make sure that we make all of these hosts available to MediaWiki for optimal app-level load balancing.
		// https://www.consul.io/docs/agent/dns
		$healthyReplicaHosts = (array)gethostbynamel( $replicaServerConfig['host'] );
		// Split the load equally between each replica
		$loadPerHost = $replicaServerConfig['load'];

		foreach ( $healthyReplicaHosts as $host ) {
			// Preserve additional connection params (credentials, flags etc.)
			$physicalServers[] = [ 'host' => $host, 'load' => $loadPerHost ] + $replicaServerConfig;
		}

		return $physicalServers;
	}

	/**
	 * Get a LoadMonitor instance
	 *
	 * @return LoadMonitor
	 */
	function getLoadMonitor() {
		if ( !isset( $this->mLoadMonitor ) ) {
			$class = $this->mLoadMonitorClass;
			$this->mLoadMonitor = new $class( $this );
		}
		return $this->mLoadMonitor;
	}

	/**
	 * Get or set arbitrary data used by the parent object, usually an LBFactory
	 * @param $x
	 * @return \Mixed
	 */
	function parentInfo( $x = null ) {
		return wfSetVar( $this->mParentInfo, $x );
	}
	/**
	 * Given an array of non-normalised probabilities, this function will select
	 * an element and return the appropriate key
	 *
	 * @param int[] $weights
	 * @return int|bool
	 */
	private function pickRandom( array $weights ) {
		if ( count( $weights ) == 0 ) {
			return false;
		}

		$sum = array_sum( $weights );
		if ( $sum == 0 ) {
			# No loads on any of them
			# In previous versions, this triggered an unweighted random selection,
			# but this feature has been removed as of April 2006 to allow for strict
			# separation of query groups.
			return false;
		}
		$max = mt_getrandmax();
		$rand = mt_rand( 0, $max ) / $max * $sum;

		$sum = 0;

		foreach ( $weights as $i => $w ) {
			$sum += $w;
			if ( $sum >= $rand ) {
				break;
			}
		}

		return $i;
	}

	/**
	 * Get the index of the reader connection, which may be a slave
	 * This takes into account load ratios and lag times. It should
	 * always return a consistent index during a given invocation
	 *
	 * Side effect: opens connections to databases
	 * @param $group bool
	 * @param $wiki bool
	 * @return bool|int|string
	 * @throws MWException
	 */
	function getReaderIndex( $group = false, $wiki = false ) {
		if ( count( $this->mServers ) == 1 )  {
			# Skip the load balancing if there's only one server
			return 0;
		} elseif ( $this->mReadIndex >= 0 ) {
			# Shortcut if generic reader exists already
			return $this->mReadIndex;
		}

		$i = false;
		$currentLoads = $this->mLoads;
		while ( count( $currentLoads ) ) {
			$i = $this->pickRandom( $currentLoads );

			// No loads on any of the servers
			if ( $i === false ) {
				return false;
			}

			$conn = $this->openConnection( $i, $wiki );

			if ( !$conn ) {
				unset( $currentLoads[$i] );
				continue;
			}

			// Decrement reference counter, we are finished with this connection.
			// It will be incremented for the caller later.
			if ( $wiki !== false ) {
				$this->reuseConnection( $conn );
			}

			// Return this server
			break;
		}

		if ( $i !== false ) {
			# Wikia change - SUS-1801: don't abuse MASTER_POS_WAIT when obtaining slave connection
			# Slave connection successful
			if ( $this->mReadIndex <=0 && $this->mLoads[$i]>0 && $i !== false ) {
				$this->mReadIndex = $i;
			}
		}

		return $i;
	}

	/**
	 * Wait for a specified number of microseconds, and return the period waited
	 * @param $t int
	 * @return int
	 */
	function sleep( $t ) {
		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__.": waiting $t us\n" );
		usleep( $t );
		wfProfileOut( __METHOD__ );
		return $t;
	}

	/**
	 * Set the master wait position
	 * If a DB_SLAVE connection has been opened already, waits
	 * Otherwise sets a variable telling it to wait if such a connection is opened
	 * @param $pos int
	 */
	public function waitFor( $pos ) {
		wfProfileIn( __METHOD__ );
		$this->mWaitForPos = $pos;
		$i = $this->getReaderIndex();
		$conn = $this->getAnyOpenConnection( $i );

		if ( $conn && !$this->doWait( $i ) ) {
			$this->mServers[$i]['slave pos'] = $conn->getSlavePos();
			$this->mLaggedSlaveMode = true;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Set the master wait position and wait for ALL slaves to catch up to it
	 * @param $pos int
	 * @param $wiki
	 */
	public function waitForAll( $pos, $wiki ) {
		wfProfileIn( __METHOD__ );
		$this->mWaitForPos = $pos;
		for ( $i = 1; $i < count( $this->mServers ); $i++ ) {
			$this->doWait( $i , true, $wiki );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get any open connection to a given server index, local or foreign
	 * Returns false if there is no connection open
	 *
	 * @param $i int
	 * @return DatabaseBase|false
	 */
	function getAnyOpenConnection( $i ) {
		foreach ( $this->mConns as $conns ) {
			if ( !empty( $conns[$i] ) ) {
				return reset( $conns[$i] );
			}
		}
		return false;
	}

	/**
	 * Wait for a given slave to catch up to the master pos stored in $this
	 * @param $index
	 * @param $open bool
	 * @param $wiki
	 * @return bool
	 */
	function doWait( $index, $open = false, $wiki = false ) {
		# Find a connection to wait on
		$conn = $this->getAnyOpenConnection( $index );
		if ( !$conn ) {
			if ( !$open ) {
				wfDebug( __METHOD__ . ": no connection open\n" );
				return false;
			} else {
				$conn = $this->openConnection( $index, $wiki );
				if ( !$conn ) {
					wfDebug( __METHOD__ . ": failed to open connection\n" );
					return false;
				}
			}
		}

		$then = microtime( true ); // Wikia change

		wfDebug( __METHOD__.": Waiting for slave #$index ({$conn->getServer()}) to catch up...\n" );
		$result = $conn->masterPosWait( $this->mWaitForPos, $this->mWaitTimeout );

		if ( $result == -1 || is_null( $result ) ) {
			# Timed out waiting for slave, use master instead
			wfDebug( __METHOD__.": Timed out waiting for slave #$index pos {$this->mWaitForPos}\n" );

			// Wikia change - begin
			// log failed wfWaitForSlaves
			// @see PLATFORM-1219
			Wikia\Logger\WikiaLogger::instance()->error( 'LoadBalancer::doWait timed out', [
				'exception' => new Exception(),
				'db'        => $conn->getDBname(),
				'host'      => $conn->getServer(),
				'pos'       => (string) $this->mWaitForPos,
				'result'    => $result,
				'waited'    => microtime( true ) - $then,
			] );
			// Wikia change - end

			return false;
		} else {
			wfDebug( __METHOD__.": Done\n" );
			return true;
		}
	}

	/**
	 * Get a connection by index
	 * This is the main entry point for this class.
	 *
	 * @param $i Integer: server index
	 * @param $groups Array: query groups
	 * @param $wiki String: wiki ID
	 *
	 * @return DatabaseBase
	 */
	public function &getConnection( $i, $groups = array(), $wiki = false ) {
		wfProfileIn( __METHOD__ );

		// Set this flag to ensure that all select operations go against master
		// Slave lag can cause random errors during wiki creation process
		global $wgForceMasterDatabase;

		if ( $i == DB_LAST ) {
			throw new MWException( 'Attempt to call ' . __METHOD__ . ' with deprecated server index DB_LAST' );
		} elseif ( $i === null || $i === false ) {
			throw new MWException( 'Attempt to call ' . __METHOD__ . ' with invalid server index' );
		}

		if ( $wiki === wfWikiID() ) {
			$wiki = false;
		}

		# Query groups
		if ( $i == DB_MASTER || $wgForceMasterDatabase ) {
			$i = $this->getWriterIndex();
		} elseif ( !is_array( $groups ) ) {
			$groupIndex = $this->getReaderIndex( $groups, $wiki );
			if ( $groupIndex !== false ) {
				$serverName = $this->getServerName( $groupIndex );
				wfDebug( __METHOD__.": using server $serverName for group $groups\n" );
				$i = $groupIndex;
			}
		} else {
			foreach ( $groups as $group ) {
				$groupIndex = $this->getReaderIndex( $group, $wiki );
				if ( $groupIndex !== false ) {
					$serverName = $this->getServerName( $groupIndex );
					wfDebug( __METHOD__.": using server $serverName for group $group\n" );
					$i = $groupIndex;
					break;
				}
			}
		}

		# Operation-based index
		if ( $i == DB_SLAVE ) {
			$i = $this->getReaderIndex( false, $wiki );
			# Couldn't find a working server in getReaderIndex()?
			if ( $i === false ) {
				$this->mLastError = 'No working slave server: ' . $this->mLastError;
				$this->reportConnectionError( $this->mErrorConnection );
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		# Now we have an explicit index into the servers array
		$conn = $this->openConnection( $i, $wiki );
		if ( !$conn ) {
			$this->reportConnectionError( $this->mErrorConnection );
		}

		wfProfileOut( __METHOD__ );
		return $conn;
	}

	/**
	 * Mark a foreign connection as being available for reuse under a different
	 * DB name or prefix. This mechanism is reference-counted, and must be called
	 * the same number of times as getConnection() to work.
	 *
	 * @param DatabaseBase $conn
	 */
	public function reuseConnection( $conn ) {
		$serverIndex = $conn->getLBInfo('serverIndex');
		$refCount = $conn->getLBInfo('foreignPoolRefCount');
		$dbName = $conn->getDBname();
		$prefix = $conn->tablePrefix();
		if ( strval( $prefix ) !== '' ) {
			$wiki = "$dbName-$prefix";
		} else {
			$wiki = $dbName;
		}
		if ( $serverIndex === null || $refCount === null ) {
			wfDebug( __METHOD__.": this connection was not opened as a foreign connection\n" );
			/**
			 * This can happen in code like:
			 *   foreach ( $dbs as $db ) {
			 *     $conn = $lb->getConnection( DB_SLAVE, array(), $db );
			 *     ...
			 *     $lb->reuseConnection( $conn );
			 *   }
			 * When a connection to the local DB is opened in this way, reuseConnection()
			 * should be ignored
			 */
			return;
		}
		if ( $this->mConns['foreignUsed'][$serverIndex][$wiki] !== $conn ) {
			throw new MWException( __METHOD__.": connection not found, has the connection been freed already?" );
		}
		$conn->setLBInfo( 'foreignPoolRefCount', --$refCount );
		if ( $refCount <= 0 ) {
			$this->mConns['foreignFree'][$serverIndex][$wiki] = $conn;
			unset( $this->mConns['foreignUsed'][$serverIndex][$wiki] );
			wfDebug( __METHOD__.": freed connection $serverIndex/$wiki\n" );
		} else {
			wfDebug( __METHOD__.": reference count for $serverIndex/$wiki reduced to $refCount\n" );
		}
	}

	/**
	 * Open a connection to the server given by the specified index
	 * Index must be an actual index into the array.
	 * If the server is already open, returns it.
	 *
	 * On error, returns false, and the connection which caused the
	 * error will be available via $this->mErrorConnection.
	 *
	 * @param $i Integer server index
	 * @param $wiki String|bool wiki ID to open
	 * @return DatabaseBase
	 */
	function openConnection( $i, $wiki = false ) {
		wfProfileIn( __METHOD__ );
		if ( $wiki !== false ) {
			$conn = $this->openForeignConnection( $i, $wiki );
			wfProfileOut( __METHOD__);
			return $conn;
		}
		if ( isset( $this->mConns['local'][$i][0] ) ) {
			$conn = $this->mConns['local'][$i][0];
		} else {
			$server = $this->mServers[$i];
			$server['serverIndex'] = $i;
			$conn = $this->reallyOpenConnection( $server, false );
			if ( $conn->isOpen() ) {
				$this->mConns['local'][$i][0] = $conn;
			} else {
				wfDebug( "Failed to connect to database $i at {$this->mServers[$i]['host']}\n" );
				$this->mErrorConnection = $conn;
				$conn = false;
			}
		}
		wfProfileOut( __METHOD__ );
		return $conn;
	}

	/**
	 * Open a connection to a foreign DB, or return one if it is already open.
	 *
	 * Increments a reference count on the returned connection which locks the
	 * connection to the requested wiki. This reference count can be
	 * decremented by calling reuseConnection().
	 *
	 * If a connection is open to the appropriate server already, but with the wrong
	 * database, it will be switched to the right database and returned, as long as
	 * it has been freed first with reuseConnection().
	 *
	 * On error, returns false, and the connection which caused the
	 * error will be available via $this->mErrorConnection.
	 *
	 * @param $i Integer: server index
	 * @param $wiki String: wiki ID to open
	 * @return DatabaseBase
	 */
	function openForeignConnection( $i, $wiki ) {
		wfProfileIn(__METHOD__);
		list( $dbName, $prefix ) = wfSplitWikiID( $wiki );
		if ( isset( $this->mConns['foreignUsed'][$i][$wiki] ) ) {
			// Reuse an already-used connection
			$conn = $this->mConns['foreignUsed'][$i][$wiki];
			wfDebug( __METHOD__.": reusing connection $i/$wiki\n" );
		} elseif ( isset( $this->mConns['foreignFree'][$i][$wiki] ) ) {
			// Reuse a free connection for the same wiki
			$conn = $this->mConns['foreignFree'][$i][$wiki];
			unset( $this->mConns['foreignFree'][$i][$wiki] );
			$this->mConns['foreignUsed'][$i][$wiki] = $conn;
			wfDebug( __METHOD__.": reusing free connection $i/$wiki\n" );
		} elseif ( !empty( $this->mConns['foreignFree'][$i] ) ) {
			// Reuse a connection from another wiki
			$conn = reset( $this->mConns['foreignFree'][$i] );
			$oldWiki = key( $this->mConns['foreignFree'][$i] );

			if ( !$conn->selectDB( $dbName ) ) {
				$this->mLastError = "Error selecting database $dbName on server " .
					$conn->getServer() . " from client host " . wfHostname() . "\n";
				$this->mErrorConnection = $conn;
				$conn = false;
			} else {
				$conn->tablePrefix( $prefix );
				unset( $this->mConns['foreignFree'][$i][$oldWiki] );
				$this->mConns['foreignUsed'][$i][$wiki] = $conn;
				wfDebug( __METHOD__.": reusing free connection from $oldWiki for $wiki\n" );
			}
		} else {
			// Open a new connection
			$server = $this->mServers[$i];
			$server['serverIndex'] = $i;
			$server['foreignPoolRefCount'] = 0;
			$conn = $this->reallyOpenConnection( $server, $dbName );
			if ( !$conn->isOpen() ) {
				wfDebug( __METHOD__.": error opening connection for $i/$wiki\n" );
				$this->mErrorConnection = $conn;
				$conn = false;
			} else {
				$conn->tablePrefix( $prefix );
				$this->mConns['foreignUsed'][$i][$wiki] = $conn;
				wfDebug( __METHOD__.": opened new connection for $i/$wiki\n" );
			}
		}

		// Increment reference count
		if ( $conn ) {
			$refCount = $conn->getLBInfo( 'foreignPoolRefCount' );
			$conn->setLBInfo( 'foreignPoolRefCount', $refCount + 1 );
		}
		wfProfileOut(__METHOD__);
		return $conn;
	}

	/**
	 * Test if the specified index represents an open connection
	 *
	 * @param $index Integer: server index
	 * @access private
	 * @return bool
	 */
	function isOpen( $index ) {
		if( !is_integer( $index ) ) {
			return false;
		}
		return (bool)$this->getAnyOpenConnection( $index );
	}

	/**
	 * Really opens a connection. Uncached.
	 * Returns a Database object whether or not the connection was successful.
	 * @access private
	 *
	 * @param $server
	 * @param $dbNameOverride bool
	 * @return DatabaseBase
	 */
	function reallyOpenConnection( $server, $dbNameOverride = false ) {
		if( !is_array( $server ) ) {
			throw new MWException( 'You must update your load-balancing configuration. ' .
				'See DefaultSettings.php entry for $wgDBservers.' );
		}

		$host = $server['host'];
		$dbname = $server['dbname'];

		if ( $dbNameOverride !== false ) {
			$server['dbname'] = $dbname = $dbNameOverride;
		}

		# Create object
		wfDebug( "Connecting to $host $dbname...\n" );
		try {
			$db = DatabaseBase::factory( $server['type'], $server );
		} catch ( DBConnectionError $e ) {
			// FIXME: This is probably the ugliest thing I have ever done to
			// PHP. I'm half-expecting it to segfault, just out of disgust. -- TS
			$db = $e->db;
		}

		$db->setLBInfo( $server );

		/**
		 * Wikia change
		 *
		 * Manually apply https://github.com/wikimedia/mediawiki/commit/52010e6d21d8bdefa1c89fbc9421850185cc5011
		 *
		 * Thanks to this we can call $db->getLBInfo( 'readOnlyReason' )
		 *
		 * @see SUS-108
		 * @author macbre
		 */
		$db->setLBInfo( 'readOnlyReason', $this->readOnlyReason );

		if ( isset( $server['fakeSlaveLag'] ) ) {
			$db->setFakeSlaveLag( $server['fakeSlaveLag'] );
		}
		if ( isset( $server['fakeMaster'] ) ) {
			$db->setFakeMaster( true );
		}

		// Wikia change - begin
		if ( $db->getSampler()->shouldSample() ) {
			$db->getWikiaLogger()->info( "LoadBalancer::reallyOpenConnection", [
				'caller'  => wfGetCallerClassMethod( __CLASS__ ),
				'host'    => $server['hostName'] ?? $server['host'], // eg. db-archive-s7
				'db_name' => $dbname,
				'db_user' => $server['user'],
			] );
		}
		// Wikia change - end

		return $db;
	}

	/**
	 * @param $conn
	 * @throws DBConnectionError
	 */
	function reportConnectionError( &$conn ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $conn ) ) {
			// No last connection, probably due to all servers being too busy
			wfLogDBError( "LB failure with no last connection. Connection error: {$this->mLastError}\n" );
			$conn = new DatabaseMysqli;
			// If all servers were busy, mLastError will contain something sensible
			throw new DBConnectionError( $conn, $this->mLastError );
		} else {
			$server = $conn->getProperty( 'mServer' );
			wfLogDBError( "Connection error: {$this->mLastError} ({$server})\n" );
			$conn->reportConnectionError( "{$this->mLastError} ({$server})" );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @return int
	 */
	function getWriterIndex() {
		return 0;
	}

	/**
	 * Returns true if the specified index is a valid server index
	 *
	 * @param $i
	 * @return bool
	 */
	function haveIndex( $i ) {
		return array_key_exists( $i, $this->mServers );
	}

	/**
	 * Returns true if the specified index is valid and has non-zero load
	 *
	 * @param $i
	 * @return bool
	 */
	function isNonZeroLoad( $i ) {
		return array_key_exists( $i, $this->mServers ) && $this->mLoads[$i] != 0;
	}

	/**
	 * Get the number of defined servers (not the number of open connections)
	 *
	 * @return int
	 */
	function getServerCount() {
		return count( $this->mServers );
	}

	/**
	 * Get the host name or IP address of the server with the specified index
	 * Prefer a readable name if available.
	 * @param $i
	 * @return string
	 */
	function getServerName( $i ) {
		if ( isset( $this->mServers[$i]['hostName'] ) ) {
			return $this->mServers[$i]['hostName'];
		} elseif ( isset( $this->mServers[$i]['host'] ) ) {
			return $this->mServers[$i]['host'];
		} else {
			return '';
		}
	}

	/**
	 * Return the server info structure for a given index, or false if the index is invalid.
	 * @param $i
	 * @return array|bool
	 */
	function getServerInfo( $i ) {
		if ( isset( $this->mServers[$i] ) ) {
			return $this->mServers[$i];
		} else {
			return false;
		}
	}

	/**
	 * Sets the server info structure for the given index. Entry at index $i is created if it doesn't exist
	 * @param $i
	 * @param $serverInfo
	 */
	function setServerInfo( $i, $serverInfo ) {
		$this->mServers[$i] = $serverInfo;
	}

	/**
	 * Get the current master position for chronology control purposes
	 * @return mixed
	 */
	function getMasterPos() {
		# If this entire request was served from a slave without opening a connection to the
		# master (however unlikely that may be), then we can fetch the position from the slave.
		$masterConn = $this->getAnyOpenConnection( 0 );
		if ( !$masterConn ) {
			for ( $i = 1; $i < count( $this->mServers ); $i++ ) {
				$conn = $this->getAnyOpenConnection( $i );
				if ( $conn ) {
					wfDebug( "Master pos fetched from slave\n" );
					return $conn->getSlavePos();
				}
			}
		} else {
			wfDebug( "Master pos fetched from master\n" );
			return $masterConn->getMasterPos();
		}
		return false;
	}

	/**
	 * Close all open connections
	 */
	function closeAll() {
		foreach ( $this->mConns as $conns2 ) {
			foreach  ( $conns2 as $conns3 ) {
				foreach ( $conns3 as $conn ) {
					$conn->close();
				}
			}
		}
		$this->mConns = array(
			'local' => array(),
			'foreignFree' => array(),
			'foreignUsed' => array(),
		);
	}

	/**
	 * Deprecated function, typo in function name
	 *
	 * @deprecated in 1.18
	 * @param $conn
	 */
	function closeConnecton( $conn ) {
		wfDeprecated( __METHOD__, '1.18' );
		$this->closeConnection( $conn );
	}

	/**
	 * Close a connection
	 * Using this function makes sure the LoadBalancer knows the connection is closed.
	 * If you use $conn->close() directly, the load balancer won't update its state.
	 * @param $conn DatabaseBase
	 */
	function closeConnection( $conn ) {
		$done = false;
		foreach ( $this->mConns as $i1 => $conns2 ) {
			foreach ( $conns2 as $i2 => $conns3 ) {
				foreach ( $conns3 as $i3 => $candidateConn ) {
					if ( $conn === $candidateConn ) {
						$conn->close();
						unset( $this->mConns[$i1][$i2][$i3] );
						$done = true;
						break;
					}
				}
			}
		}
		if ( !$done ) {
			$conn->close();
		}
	}

	/**
	 * Commit transactions on all open connections
	 */
	function commitAll() {
		foreach ( $this->mConns as $conns2 ) {
			foreach ( $conns2 as $conns3 ) {
				foreach ( $conns3 as $conn ) {
					$conn->commit();
				}
			}
		}
	}

	/**
	 *  Issue COMMIT only on master, only if queries were done on connection
	 */
	function commitMasterChanges() {
		// Always 0, but who knows.. :)
		$masterIndex = $this->getWriterIndex();
		foreach ( $this->mConns as $conns2 ) {
			if ( empty( $conns2[$masterIndex] ) ) {
				continue;
			}
			foreach ( $conns2[$masterIndex] as $conn ) {
				if ( $conn->doneWrites() ) {
					$conn->commit( __METHOD__ );
				}
			}
		}
	}

	/**
	 * @param $value null
	 * @return Mixed
	 */
	function waitTimeout( $value = null ) {
		return wfSetVar( $this->mWaitTimeout, $value );
	}

	/**
	 * @return bool
	 */
	function getLaggedSlaveMode() {
		return $this->mLaggedSlaveMode;
	}

	/**
	 * @return string|bool Reason the master is read-only or false if it is not
	 * @since 1.27
	 */
	public function getReadOnlyReason() {
		if ( $this->readOnlyReason !== false ) {
			return $this->readOnlyReason;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	function pingAll() {
		$success = true;
		foreach ( $this->mConns as $conns2 ) {
			foreach ( $conns2 as $conns3 ) {
				foreach ( $conns3 as $conn ) {
					/* @var DatabaseMysqlBase $conn */
					if ( !$conn->ping() ) {
						$success = false;
					}
				}
			}
		}
		return $success;
	}

	/**
	 * Call a function with each open connection object
	 * @param $callback
	 * @param array $params
	 */
	function forEachOpenConnection( $callback, $params = array() ) {
		foreach ( $this->mConns as $conns2 ) {
			foreach ( $conns2 as $conns3 ) {
				foreach ( $conns3 as $conn ) {
					$mergedParams = array_merge( array( $conn ), $params );
					call_user_func_array( $callback, $mergedParams );
				}
			}
		}
	}

	/**
	 * Get the lag in seconds for a given connection, or zero if this load
	 * balancer does not have replication enabled.
	 *
	 * This should be used in preference to Database::getLag() in cases where
	 * replication may not be in use, since there is no way to determine if
	 * replication is in use at the connection level without running
	 * potentially restricted queries such as SHOW SLAVE STATUS. Using this
	 * function instead of Database::getLag() avoids a fatal error in this
	 * case on many installations.
	 *
	 * @param $conn DatabaseBase
	 *
	 * @return int
	 */
	function safeGetLag( $conn ) {
		if ( $this->getServerCount() == 1 ) {
			return 0;
		} else {
			return $conn->getLag();
		}
	}

	/**
	 * Wikia change: return true if this load balancer has slave nodes config powered by Consul
	 *
	 * @see PLATFORM-1489
	 * @return bool
	 */
	function hasConsulConfig() {
		$firstSlaveInfo = $this->getServerInfo( 1 ); // e.g. slave.db-g.service.consul
		return is_array( $firstSlaveInfo ) && Wikia\Consul\Client::isConsulAddress( $firstSlaveInfo['hostName'] );
	}
}
