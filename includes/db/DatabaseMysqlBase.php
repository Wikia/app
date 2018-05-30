<?php
/**
 * This is the MySQL database abstraction layer.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Database
 */

/**
 * Database abstraction object for MySQL.
 * Defines methods independent on used MySQL extension.
 *
 * @ingroup Database
 * @since 1.22
 * @see Database
 */
abstract class DatabaseMysqlBase extends DatabaseBase {
	/** @var MysqlMasterPos */
	protected $lastKnownSlavePos;
	/** @var string Method to detect slave lag */
	protected $lagDetectionMethod;

	/** @var BagOStuff cache */
	protected $srvCache;

	/**
	 * Additional $params include:
	 *   - lagDetectionMethod : set to one of (Seconds_Behind_Master,pt-heartbeat).
	 *                          pt-heartbeat assumes the table is at `mysql-pt-heartbeat`.heartbeat
	 *                          and uses UTC timestamps in the heartbeat.ts column.
	 *                          (https://www.percona.com/doc/percona-toolkit/2.2/pt-heartbeat.html)
	 * @param array $params
	 */
	function __construct( $params = null ) {
		parent::__construct( $params );

		// SUS-4805 | pt-heartbeat based lag support
		$this->lagDetectionMethod = isset( $params['lagDetectionMethod'] )
			? $params['lagDetectionMethod']
			: 'Seconds_Behind_Master';

		global $wgMemc;
		$this->srvCache = $wgMemc;
	}

	/**
	 * @return string
	 */
	function getType() {
		return 'mysql';
	}

	/**
	 * @param $server string
	 * @param $user string
	 * @param $password string
	 * @param $dbName string
	 * @return bool
	 * @throws DBConnectionError
	 */
	function open( $server, $user, $password, $dbName ) {
		global $wgAllDBsAreLocalhost, $wgDBmysql5, $wgSQLMode;
		wfProfileIn( __METHOD__ );

		# Debugging hack -- fake cluster
		if ( $wgAllDBsAreLocalhost ) {
			$realServer = 'localhost';
		} else {
			$realServer = $server;
		}
		$this->close();
		$this->mServer = $server;
		$this->mUser = $user;
		$this->mPassword = $password;
		$this->mDBname = $dbName;

		wfProfileIn( "dbconnect-$server" );

		# The kernel's default SYN retransmission period is far too slow for us,
		# so we use a short timeout plus a manual retry. Retrying means that a small
		# but finite rate of SYN packet loss won't cause user-visible errors.
		$this->mConn = false;
		$this->installErrorHandler();
		try {
			$this->mConn = $this->mysqlConnect( $realServer );
		} catch (Exception $ex) {
			wfProfileOut( "dbconnect-$server" );
			wfProfileOut( __METHOD__ );
			throw $ex;
		}
		$error = $this->restoreErrorHandler();

		wfProfileOut( "dbconnect-$server" );

		# Always log connection errors
		if ( !$this->mConn ) {
			if ( !$error ) {
				$error = $this->lastError();
			}
			wfLogDBError( "Error connecting to {$this->mServer}: $error\n" );
			wfDebug( "DB connection error\n" .
				"Server: $server, User: $user, Password: " .
				substr( $password, 0, 3 ) . "..., error: " . $error . "\n" );

			wfProfileOut( __METHOD__ );
			return $this->reportConnectionError( $error );
		}

		if ( $dbName != '' ) {
			wfSuppressWarnings();
			$success = $this->selectDB( $dbName );
			wfRestoreWarnings();
			if ( !$success ) {
				wfLogDBError( "Error selecting database $dbName on server {$this->mServer}\n" );
				wfDebug( "Error selecting database $dbName on server {$this->mServer} " .
					"from client host " . wfHostname() . "\n" );

				wfProfileOut( __METHOD__ );
				return $this->reportConnectionError( "Error selecting database $dbName" );
			}
		}

		// Tell the server we're communicating with it in UTF-8.
		// This may engage various charset conversions.
		if ( $wgDBmysql5 ) {
			$this->query( 'SET NAMES utf8', __METHOD__ );
		} else {
			# <Wikia>
			# Wikia databases use latin1 charset
			# $this->query( 'SET NAMES binary', __METHOD__ );
			# </Wikia>
		}
		// Set SQL mode, default is turning them all off, can be overridden or skipped with null
		if ( is_string( $wgSQLMode ) ) {
			$mode = $this->addQuotes( $wgSQLMode );
			$this->query( "SET sql_mode = $mode", __METHOD__ );
		}

		$this->mOpened = true;
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Open a connection to a MySQL server
	 *
	 * @param $realServer string
	 * @return mixed Raw connection
	 * @throws DBConnectionError
	 */
	abstract protected function mysqlConnect( $realServer );

	/**
	 * @param $res ResultWrapper
	 * @throws DBUnexpectedError
	 */
	function freeResult( $res ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		wfSuppressWarnings();
		$ok = $this->mysqlFreeResult( $res );
		wfRestoreWarnings();
		if ( !$ok ) {
			throw new DBUnexpectedError( $this, "Unable to free MySQL result" );
		}
	}

	/**
	 * Free result memory
	 *
	 * @param $res Raw result
	 * @return bool
	 */
	abstract protected function mysqlFreeResult( $res );

	/**
	 * @param $res ResultWrapper
	 * @return object|bool
	 * @throws DBUnexpectedError
	 */
	function fetchObject( $res ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		wfSuppressWarnings();
		$row = $this->mysqlFetchObject( $res );
		wfRestoreWarnings();

		$errno = $this->lastErrno();
		// Unfortunately, mysql_fetch_object does not reset the last errno.
		// Only check for CR_SERVER_LOST and CR_UNKNOWN_ERROR, as
		// these are the only errors mysql_fetch_object can cause.
		// See http://dev.mysql.com/doc/refman/5.0/en/mysql-fetch-row.html.
		if ( $errno == 2000 || $errno == 2013 ) {
			throw new DBUnexpectedError( $this, 'Error in fetchObject(): ' . htmlspecialchars( $this->lastError() ) );
		}
		return $row;
	}

	/**
	 * Fetch a result row as an object
	 *
	 * @param $res Raw result
	 * @return stdClass
	 */
	abstract protected function mysqlFetchObject( $res );

	/**
	 * @param $res ResultWrapper
	 * @return array|bool
	 * @throws DBUnexpectedError
	 */
	function fetchRow( $res ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		wfSuppressWarnings();
		$row = $this->mysqlFetchArray( $res );
		wfRestoreWarnings();

		$errno = $this->lastErrno();
		// Unfortunately, mysql_fetch_array does not reset the last errno.
		// Only check for CR_SERVER_LOST and CR_UNKNOWN_ERROR, as
		// these are the only errors mysql_fetch_array can cause.
		// See http://dev.mysql.com/doc/refman/5.0/en/mysql-fetch-row.html.
		if ( $errno == 2000 || $errno == 2013 ) {
			throw new DBUnexpectedError( $this, 'Error in fetchRow(): ' . htmlspecialchars( $this->lastError() ) );
		}
		return $row;
	}

	/**
	 * Fetch a result row as an associative and numeric array
	 *
	 * @param $res Raw result
	 * @return array
	 */
	abstract protected function mysqlFetchArray( $res );

	/**
	 * @throws DBUnexpectedError
	 * @param $res ResultWrapper
	 * @return int
	 */
	function numRows( $res ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		wfSuppressWarnings();
		$n = $this->mysqlNumRows( $res );
		wfRestoreWarnings();
		// Unfortunately, mysql_num_rows does not reset the last errno.
		// We are not checking for any errors here, since
		// these are no errors mysql_num_rows can cause.
		// See http://dev.mysql.com/doc/refman/5.0/en/mysql-fetch-row.html.
		// See https://bugzilla.wikimedia.org/42430
		return $n;
	}

	/**
	 * Get number of rows in result
	 *
	 * @param $res Raw result
	 * @return int
	 */
	abstract protected function mysqlNumRows( $res );

	/**
	 * @param $res ResultWrapper
	 * @return int
	 */
	function numFields( $res ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		return $this->mysqlNumFields( $res );
	}

	/**
	 * Get number of fields in result
	 *
	 * @param $res Raw result
	 * @return int
	 */
	abstract protected function mysqlNumFields( $res );

	/**
	 * @param $res ResultWrapper
	 * @param $n string
	 * @return string
	 */
	function fieldName( $res, $n ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		return $this->mysqlFieldName( $res, $n );
	}

	/**
	 * Get the name of the specified field in a result
	 *
	 * @param $res Raw result
	 * @param $n int
	 * @return string
	 */
	abstract protected function mysqlFieldName( $res, $n );

	/**
	 * mysqlFieldType wrapper
	 * @param $res
	 * @param $n
	 * @return string|int
	 */
	function fieldType( $res, $n ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}

		return $this->mysqlFieldType( $res, $n );
	}

	/**
	 * Get the type of the specified field in a result
	 *
	 * @param ResultWrapper|resource $res
	 * @param int $n
	 * @return string
	 */
	abstract protected function mysqlFieldType( $res, $n );

	/**
	 * @param $res ResultWrapper
	 * @param $row
	 * @return bool
	 */
	function dataSeek( $res, $row ) {
		if ( $res instanceof ResultWrapper ) {
			$res = $res->result;
		}
		return $this->mysqlDataSeek( $res, $row );
	}

	/**
	 * Move internal result pointer
	 *
	 * @param $res Raw result
	 * @param $row int
	 * @return bool
	 */
	abstract protected function mysqlDataSeek( $res, $row );

	/**
	 * @return string
	 */
	function lastError() {
		if ( $this->mConn ) {
			# Even if it's non-zero, it can still be invalid
			wfSuppressWarnings();
			$error = $this->mysqlError( $this->mConn );
			if ( !$error ) {
				$error = $this->mysqlError();
			}
			wfRestoreWarnings();
		} else {
			$error = $this->mysqlError();
		}
		if ( $error ) {
			$error .= ' (' . $this->mServer . ')';
		}
		return $error;
	}

	/**
	 * Returns the text of the error message from previous MySQL operation
	 *
	 * @param $conn Raw connection
	 * @return string
	 */
	abstract protected function mysqlError( $conn = null );

	/**
	 * @param $table string
	 * @param $uniqueIndexes
	 * @param $rows array
	 * @param $fname string
	 * @return ResultWrapper
	 */
	function replace( $table, $uniqueIndexes, $rows, $fname = __METHOD__ ) {
		return $this->nativeReplace( $table, $rows, $fname );
	}

	/**
	 * Estimate rows in dataset
	 * Returns estimated count, based on EXPLAIN output
	 * Takes same arguments as Database::select()
	 *
	 * @param $table string|array
	 * @param $vars string|array
	 * @param $conds string|array
	 * @param $fname string
	 * @param $options string|array
	 * @return int
	 */
	public function estimateRowCount( $table, $vars = '*', $conds = '', $fname = __METHOD__, $options = array() ) {
		$options['EXPLAIN'] = true;
		$res = $this->select( $table, $vars, $conds, $fname, $options );
		if ( $res === false ) {
			return false;
		}
		if ( !$this->numRows( $res ) ) {
			return 0;
		}

		$rows = 1;
		foreach ( $res as $plan ) {
			$rows *= $plan->rows > 0 ? $plan->rows : 1; // avoid resetting to zero
		}
		return $rows;
	}

	/**
	 * SUS-3239: Determines if a field exists in a given table, using a DESCRIBE query.
	 *
	 * @param String $table
	 * @param String $field
	 * @param string $fname
	 * @return bool
	 */
	function fieldExists( $table, $field, $fname = __METHOD__ ) {
		// This handles escaping and optionally resolving the table
		$tableName = $this->tableName( $table );
		$res = $this->query( "DESCRIBE $tableName", __METHOD__, true );

		if ( !$res ) {
			return false;
		}

		foreach ( $res as $row ) {
			if ( $row->Field === $field ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $table string
	 * @param $field string
	 * @return bool|MySQLField
	 */
	function fieldInfo( $table, $field ) {
		$table = $this->tableName( $table );
		$res = $this->query( "SELECT * FROM $table LIMIT 1", __METHOD__, true );
		if ( !$res ) {
			return false;
		}
		$n = $this->mysqlNumFields( $res->result );
		for ( $i = 0; $i < $n; $i++ ) {
			$meta = $this->mysqlFetchField( $res->result, $i );
			if ( $field == $meta->name ) {
				return new MySQLField( $meta );
			}
		}
		return false;
	}

	/**
	 * Get column information from a result
	 *
	 * @param $res Raw result
	 * @param $n int
	 * @return stdClass
	 */
	abstract protected function mysqlFetchField( $res, $n );

	/**
	 * Get information about an index into an object
	 * Returns false if the index does not exist
	 *
	 * @param $table string
	 * @param $index string
	 * @param $fname string
	 * @return bool|array|null False or null on failure
	 */
	function indexInfo( $table, $index, $fname = __METHOD__ ) {
		# SHOW INDEX works in MySQL 3.23.58, but SHOW INDEXES does not.
		# SHOW INDEX should work for 3.x and up:
		# http://dev.mysql.com/doc/mysql/en/SHOW_INDEX.html
		$table = $this->tableName( $table );
		$index = $this->indexName( $index );

		$sql = 'SHOW INDEX FROM ' . $table;
		$res = $this->query( $sql, $fname );

		if ( !$res ) {
			return null;
		}

		$result = array();

		foreach ( $res as $row ) {
			if ( $row->Key_name == $index ) {
				$result[] = $row;
			}
		}
		return empty( $result ) ? false : $result;
	}

	/**
	 * @param $s string
	 *
	 * @return string
	 */
	function strencode( $s ) {
		$sQuoted = $this->mysqlRealEscapeString( $s );

		if ( $sQuoted === false ) {
			$this->ping();
			$sQuoted = $this->mysqlRealEscapeString( $s );
		}
		return $sQuoted;
	}

	/**
	 * MySQL uses `backticks` for identifier quoting instead of the sql standard "double quotes".
	 *
	 * @param $s string
	 *
	 * @return string
	 */
	public function addIdentifierQuotes( $s ) {
		return "`" . $this->strencode( $s ) . "`";
	}

	/**
	 * @param $name string
	 * @return bool
	 */
	public function isQuotedIdentifier( $name ) {
		return strlen( $name ) && $name[0] == '`' && substr( $name, -1, 1 ) == '`';
	}

	/**
	 * @return bool
	 */
	function ping() {
		$ping = $this->mysqlPing();

		// Wikia change - begin
		// @see PLATFORM-949
		if ( $this->getSampler()->shouldSample() ) {
			$this->getWikiaLogger()->info( "mysql ping", [
				'server'      => $this->mServer,
				'db_name'     => $this->mDBname,
				'exception'   => new Exception(), // log the backtrace
				'res'         => (bool) $ping ? 1 : 0
			] );
		}
		// Wikia change - end

		if ( $ping ) {
			return true;
		}

		$this->close();
		$this->mOpened = false;
		$this->mConn = false;
		$this->open( $this->mServer, $this->mUser, $this->mPassword, $this->mDBname );
		return true;
	}

	/**
	 * Ping a server connection or reconnect if there is no connection
	 *
	 * @return bool
	 */
	abstract protected function mysqlPing();

	/**
	 * Returns slave lag.
	 *
	 * This will do a SHOW SLAVE STATUS
	 *
	 * @return int
	 */
	function getLag() {
		if ( !is_null( $this->mFakeSlaveLag ) ) {
			wfDebug( "getLag: fake slave lagged {$this->mFakeSlaveLag} seconds\n" );
			return $this->mFakeSlaveLag;
		}

		if ( $this->lagDetectionMethod === 'pt-heartbeat' ) {
			return $this->getLagFromPtHeartbeat();
		} else {
			return $this->getLagFromSlaveStatus();
		}
	}

	/**
	 * @return bool|int
	 */
	protected function getLagFromSlaveStatus() {
		$res = $this->query( 'SHOW SLAVE STATUS', __METHOD__ );
		$row = $res ? $res->fetchObject() : false;
		if ( $row && strval( $row->Seconds_Behind_Master ) !== '' ) {
			wfDebug( __METHOD__ . ": lag for {$this->getServer()} is {$row->Seconds_Behind_Master} seconds\n" );
			return intval( $row->Seconds_Behind_Master );
		}

		return false;
	}

	/**
	 * @see SUS-4805
	 *
	 * @return false|float
	 */
	protected function getLagFromPtHeartbeat() {
		$key = wfSharedMemcKey( 'mysql', 'master-server-id', $this->getServer() );
		$masterId = intval( $this->srvCache->get( $key ) );
		if ( !$masterId ) {
			$res = $this->query( 'SHOW SLAVE STATUS', __METHOD__ );
			$row = $res ? $res->fetchObject() : false;
			if ( $row && strval( $row->Master_Server_Id ) !== '' ) {
				$masterId = intval( $row->Master_Server_Id );
				$this->srvCache->set( $key, $masterId, 30 );
			}
		}

		if ( !$masterId ) {
			return false;
		}

		$res = $this->query(
			"SELECT TIMESTAMPDIFF(MICROSECOND,ts,UTC_TIMESTAMP(6)) AS Lag " .
			"FROM `mysql-pt-heartbeat`.heartbeat WHERE server_id = $masterId",
			__METHOD__
		);
		$row = $res ? $res->fetchObject() : false;
		if ( $row ) {
			$lag = max( floatval( $row->Lag ) / 1e6, 0.0 );

			wfDebug( __METHOD__ . ": lag for {$this->getServer()} is {$lag} seconds\n" );
			return $lag;
		}

		return false;
	}

	/**
	 * @deprecated in 1.19, use getLagFromSlaveStatus
	 *
	 * @return bool|int
	 */
	function getLagFromProcesslist() {
		wfDeprecated( __METHOD__, '1.19' );
		$res = $this->query( 'SHOW PROCESSLIST', __METHOD__ );
		if ( !$res ) {
			return false;
		}
		# Find slave SQL thread
		foreach ( $res as $row ) {
			/* This should work for most situations - when default db
			 * for thread is not specified, it had no events executed,
			 * and therefore it doesn't know yet how lagged it is.
			 *
			 * Relay log I/O thread does not select databases.
			 */
			if ( $row->User == 'system user' &&
				$row->State != 'Waiting for master to send event' &&
				$row->State != 'Connecting to master' &&
				$row->State != 'Queueing master event to the relay log' &&
				$row->State != 'Waiting for master update' &&
				$row->State != 'Requesting binlog dump' &&
				$row->State != 'Waiting to reconnect after a failed master event read' &&
				$row->State != 'Reconnecting after a failed master event read' &&
				$row->State != 'Registering slave on master'
				) {
				# This is it, return the time (except -ve)
				if ( $row->Time > 0x7fffffff ) {
					return false;
				} else {
					return $row->Time;
				}
			}
		}
		return false;
	}

	/**
	 * Wait for the slave to catch up to a given master position.
	 * @TODO: return values for this and base class are rubbish
	 *
	 * @param $pos DBMasterPos object
	 * @param $timeout Integer: the maximum number of seconds to wait for synchronisation
	 * @return bool|string
	 */
	function masterPosWait( DBMasterPos $pos, $timeout ) {
		if ( $this->lastKnownSlavePos && $this->lastKnownSlavePos->hasReached( $pos ) ) {
			return '0'; // http://dev.mysql.com/doc/refman/5.0/en/miscellaneous-functions.html
		}

		wfProfileIn( __METHOD__ );
		# Commit any open transactions
		$this->commit( __METHOD__ );

		if ( !is_null( $this->mFakeSlaveLag ) ) {
			$status = parent::masterPosWait( $pos, $timeout );
			wfProfileOut( __METHOD__ );
			return $status;
		}

		# Call doQuery() directly, to avoid opening a transaction if DBO_TRX is set
		$encFile = $this->addQuotes( $pos->file );
		$encPos = intval( $pos->pos );
		$sql = "SELECT MASTER_POS_WAIT($encFile, $encPos, $timeout)";

		wfDebug( sprintf( "Query %s %s %s\n", $this->getDBname(), __METHOD__, $sql ) );
		$res = $this->doQuery( $sql );

		$status = false;
		if ( $res && $row = $this->fetchRow( $res ) ) {
			$status = $row[0]; // can be NULL, -1, or 0+ per the MySQL manual
			if ( ctype_digit( $status ) ) { // success
				$this->lastKnownSlavePos = $pos;
			}
		}

		wfProfileOut( __METHOD__ );
		return $status;
	}

	/**
	 * Get the position of the master from SHOW SLAVE STATUS
	 *
	 * @return MySQLMasterPos|bool
	 */
	function getSlavePos() {
		if ( !is_null( $this->mFakeSlaveLag ) ) {
			return parent::getSlavePos();
		}

		$res = $this->query( 'SHOW SLAVE STATUS', 'DatabaseBase::getSlavePos' );
		$row = $this->fetchObject( $res );

		if ( $row ) {
			$pos = isset( $row->Exec_master_log_pos ) ? $row->Exec_master_log_pos : $row->Exec_Master_Log_Pos;
			return new MySQLMasterPos( $row->Relay_Master_Log_File, $pos );
		} else {
			return false;
		}
	}

	/**
	 * Get the position of the master from SHOW MASTER STATUS
	 *
	 * @return MySQLMasterPos|bool
	 */
	function getMasterPos() {
		if ( $this->mFakeMaster ) {
			return parent::getMasterPos();
		}

		$res = $this->query( 'SHOW MASTER STATUS', 'DatabaseBase::getMasterPos' );
		$row = $this->fetchObject( $res );

		if ( $row ) {
			return new MySQLMasterPos( $row->File, $row->Position );
		} else {
			return false;
		}
	}

	/**
	 * @param $index
	 * @return string
	 */
	function useIndexClause( $index ) {
		return "FORCE INDEX (" . $this->indexName( $index ) . ")";
	}

	/**
	 * @return string
	 */
	function lowPriorityOption() {
		return 'LOW_PRIORITY';
	}

	/**
	 * @return string
	 */
	public function getSoftwareLink() {
		return '[http://www.mysql.com/ MySQL]';
	}

	/**
	 * @param $options array
	 */
	public function setSessionOptions( array $options ) {
		if ( isset( $options['connTimeout'] ) ) {
			$timeout = (int)$options['connTimeout'];
			$this->query( "SET net_read_timeout=$timeout" );
			$this->query( "SET net_write_timeout=$timeout" );
		}
	}

	public function streamStatementEnd( &$sql, &$newLine ) {
		if ( strtoupper( substr( $newLine, 0, 9 ) ) == 'DELIMITER' ) {
			preg_match( '/^DELIMITER\s+(\S+)/', $newLine, $m );
			$this->delimiter = $m[1];
			$newLine = '';
		}
		return parent::streamStatementEnd( $sql, $newLine );
	}

	/**
	 * Check to see if a named lock is available. This is non-blocking.
	 *
	 * @param string $lockName name of lock to poll
	 * @param string $method name of method calling us
	 * @return Boolean
	 * @since 1.20
	 */
	public function lockIsFree( $lockName, $method ) {
		$lockName = $this->addQuotes( $lockName );
		$result = $this->query( "SELECT IS_FREE_LOCK($lockName) AS lockstatus", $method );
		$row = $this->fetchObject( $result );
		return ( $row->lockstatus == 1 );
	}

	/**
	 * @param $lockName string
	 * @param $method string
	 * @param $timeout int
	 * @return bool
	 */
	public function lock( $lockName, $method, $timeout = 5 ) {
		$lockName = $this->addQuotes( $lockName );
		$result = $this->query( "SELECT GET_LOCK($lockName, $timeout) AS lockstatus", $method );
		$row = $this->fetchObject( $result );

		if ( $row->lockstatus == 1 ) {
			return true;
		} else {
			wfDebug( __METHOD__ . " failed to acquire lock\n" );
			return false;
		}
	}

	/**
	 * FROM MYSQL DOCS: http://dev.mysql.com/doc/refman/5.0/en/miscellaneous-functions.html#function_release-lock
	 * @param $lockName string
	 * @param $method string
	 * @return bool
	 */
	public function unlock( $lockName, $method ) {
		$lockName = $this->addQuotes( $lockName );
		$result = $this->query( "SELECT RELEASE_LOCK($lockName) as lockstatus", $method );
		$row = $this->fetchObject( $result );
		return ( $row->lockstatus == 1 );
	}

	/**
	 * @param $read array
	 * @param $write array
	 * @param $method string
	 * @param $lowPriority bool
	 * @return bool
	 */
	public function lockTables( $read, $write, $method, $lowPriority = true ) {
		$items = array();

		foreach ( $write as $table ) {
			$tbl = $this->tableName( $table ) .
					( $lowPriority ? ' LOW_PRIORITY' : '' ) .
					' WRITE';
			$items[] = $tbl;
		}
		foreach ( $read as $table ) {
			$items[] = $this->tableName( $table ) . ' READ';
		}
		$sql = "LOCK TABLES " . implode( ',', $items );
		$this->query( $sql, $method );
		return true;
	}

	/**
	 * @param $method string
	 * @return bool
	 */
	public function unlockTables( $method ) {
		$this->query( "UNLOCK TABLES", $method );
		return true;
	}

	/**
	 * Get search engine class. All subclasses of this
	 * need to implement this if they wish to use searching.
	 *
	 * @return String
	 */
	public function getSearchEngine() {
		return 'SearchMySQL';
	}

	/**
	 * @param bool $value
	 * @return mixed
	 */
	public function setBigSelects( $value = true ) {
		if ( $value === 'default' ) {
			if ( $this->mDefaultBigSelects === null ) {
				# Function hasn't been called before so it must already be set to the default
				return;
			} else {
				$value = $this->mDefaultBigSelects;
			}
		} elseif ( $this->mDefaultBigSelects === null ) {
			$this->mDefaultBigSelects = (bool)$this->selectField( false, '@@sql_big_selects' );
		}
		$encValue = $value ? '1' : '0';
		$this->query( "SET sql_big_selects=$encValue", __METHOD__ );
	}

	/**
	 * DELETE where the condition is a join. MySql uses multi-table deletes.
	 * @param $delTable string
	 * @param $joinTable string
	 * @param $delVar string
	 * @param $joinVar string
	 * @param $conds array|string
	 * @param bool|string $fname bool
	 * @throws DBUnexpectedError
	 * @return bool|ResultWrapper
	 */
	function deleteJoin( $delTable, $joinTable, $delVar, $joinVar, $conds, $fname = __METHOD__ ) {
		if ( !$conds ) {
			throw new DBUnexpectedError( $this, 'DatabaseBase::deleteJoin() called with empty $conds' );
		}

		$delTable = $this->tableName( $delTable );
		$joinTable = $this->tableName( $joinTable );
		$sql = "DELETE $delTable FROM $delTable, $joinTable WHERE $delVar=$joinVar ";

		if ( $conds != '*' ) {
			$sql .= ' AND ' . $this->makeList( $conds, LIST_AND );
		}

		return $this->query( $sql, $fname );
	}

	/**
	 * @param string $table
	 * @param array $rows
	 * @param array $uniqueIndexes
	 * @param array $set
	 * @param string $fname
	 * @return bool
	 * @throws DBQueryError
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public function upsert(
		$table, array $rows, array $uniqueIndexes, array $set, $fname = __METHOD__
	) {
		if ( !count( $rows ) ) {
			return true; // nothing to do
		}
		$rows = is_array( reset( $rows ) ) ? $rows : array( $rows );

		$table = $this->tableName( $table );
		$columns = array_keys( $rows[0] );

		$sql = "INSERT INTO $table (" . implode( ',', $columns ) . ') VALUES ';
		$rowTuples = array();
		foreach ( $rows as $row ) {
			$rowTuples[] = '(' . $this->makeList( $row ) . ')';
		}
		$sql .= implode( ',', $rowTuples );
		$sql .= " ON DUPLICATE KEY UPDATE " . $this->makeList( $set, LIST_SET );

		return (bool)$this->query( $sql, $fname );
	}

	/**
	 * Determines how long the server has been up
	 *
	 * @return int
	 */
	function getServerUptime() {
		$vars = $this->getMysqlStatus( 'Uptime' );
		return (int)$vars['Uptime'];
	}

	/**
	 * Determines if the last failure was due to a deadlock
	 *
	 * @return bool
	 */
	function wasDeadlock() {
		return $this->lastErrno() == 1213;
	}

	/**
	 * Determines if the last failure was due to a lock timeout
	 *
	 * @return bool
	 */
	function wasLockTimeout() {
		return $this->lastErrno() == 1205;
	}

	/**
	 * Determines if the last query error was something that should be dealt
	 * with by pinging the connection and reissuing the query
	 *
	 * @return bool
	 */
	function wasErrorReissuable() {
		return $this->lastErrno() == 2013 || $this->lastErrno() == 2006;
	}

	/**
	 * Determines if the last failure was due to the database being read-only.
	 *
	 * @return bool
	 */
	function wasReadOnlyError() {
		return $this->lastErrno() == 1223 ||
			( $this->lastErrno() == 1290 && strpos( $this->lastError(), '--read-only' ) !== false );
	}

	/**
	 * @param $oldName
	 * @param $newName
	 * @param $temporary bool
	 * @param $fname string
	 */
	function duplicateTableStructure( $oldName, $newName, $temporary = false, $fname = __METHOD__ ) {
		$tmp = $temporary ? 'TEMPORARY ' : '';
		$newName = $this->addIdentifierQuotes( $newName );
		$oldName = $this->addIdentifierQuotes( $oldName );
		$query = "CREATE $tmp TABLE $newName (LIKE $oldName)";
		$this->query( $query, $fname );
	}

	/**
	 * List all tables on the database
	 *
	 * @param string $prefix Only show tables with this prefix, e.g. mw_
	 * @param string $fname calling function name
	 * @return array
	 */
	function listTables( $prefix = null, $fname = __METHOD__ ) {
		$result = $this->query( "SHOW TABLES", $fname );

		$endArray = array();

		foreach ( $result as $table ) {
			$vars = get_object_vars( $table );
			$table = array_pop( $vars );

			if ( !$prefix || strpos( $table, $prefix ) === 0 ) {
				$endArray[] = $table;
			}
		}

		return $endArray;
	}

	/**
	 * @param $tableName
	 * @param $fName string
	 * @return bool|ResultWrapper
	 */
	public function dropTable( $tableName, $fName = __METHOD__ ) {
		if ( !$this->tableExists( $tableName, $fName ) ) {
			return false;
		}
		return $this->query( "DROP TABLE IF EXISTS " . $this->tableName( $tableName ), $fName );
	}

	/**
	 * @return array
	 */
	protected function getDefaultSchemaVars() {
		$vars = parent::getDefaultSchemaVars();
		$vars['wgDBTableOptions'] = str_replace( 'TYPE', 'ENGINE', $GLOBALS['wgDBTableOptions'] );
		$vars['wgDBTableOptions'] = str_replace( 'CHARSET=mysql4', 'CHARSET=binary', $vars['wgDBTableOptions'] );
		return $vars;
	}

	/**
	 * Get status information from SHOW STATUS in an associative array
	 *
	 * @param $which string
	 * @return array
	 */
	function getMysqlStatus( $which = "%" ) {
		$res = $this->query( "SHOW STATUS LIKE '{$which}'" );
		$status = array();

		foreach ( $res as $row ) {
			$status[$row->Variable_name] = $row->Value;
		}

		return $status;
	}

}

class MySQLMasterPos implements DBMasterPos {
	/** @var string */
	public $file;
	/** @var int Position */
	public $pos;
	/** @var float UNIX timestamp */
	public $asOfTime = 0.0;

	function __construct( $file, $pos ) {
		$this->file = $file;
		$this->pos = $pos;
		$this->asOfTime = microtime( true );
	}

	function __toString() {
		// e.g db1034-bin.000976/843431247
		return "{$this->file}/{$this->pos}";
	}

	/**
	 * @return array|false (int, int)
	 */
	protected function getCoordinates() {
		$m = array();
		if ( preg_match( '!\.(\d+)/(\d+)$!', (string)$this, $m ) ) {
			return array( (int)$m[1], (int)$m[2] );
		}
		return false;
	}

	function hasReached( MySQLMasterPos $pos ) {
		$thisPos = $this->getCoordinates();
		$thatPos = $pos->getCoordinates();
		return ( $thisPos && $thatPos && $thisPos >= $thatPos );
	}
}

/**
 * Utility class.
 * @ingroup Database
 */
class MySQLField implements Field {
	private $name, $tablename, $default, $max_length, $nullable,
		$is_pk, $is_unique, $is_multiple, $is_key, $type, $binary;

	function __construct( $info ) {
		$this->name = $info->name;
		$this->tablename = $info->table;
		$this->default = $info->def;
		$this->max_length = $info->max_length;
		$this->nullable = !$info->not_null;
		$this->is_pk = $info->primary_key;
		$this->is_unique = $info->unique_key;
		$this->is_multiple = $info->multiple_key;
		$this->is_key = ( $this->is_pk || $this->is_unique || $this->is_multiple );
		$this->type = $info->type;
		$this->binary = isset( $info->binary ) ? $info->binary : false;
	}

	/**
	 * @return string
	 */
	function name() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	function tableName() {
		return $this->tableName;
	}

	/**
	 * @return string
	 */
	function type() {
		return $this->type;
	}

	/**
	 * @return bool
	 */
	function isNullable() {
		return $this->nullable;
	}

	function defaultValue() {
		return $this->default;
	}

	/**
	 * @return bool
	 */
	function isKey() {
		return $this->is_key;
	}

	/**
	 * @return bool
	 */
	function isMultipleKey() {
		return $this->is_multiple;
	}

	function isBinary() {
		return $this->binary;
	}
}
