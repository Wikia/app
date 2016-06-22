<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array( "limit", "sleep" );

require_once( "commandLine.inc" );
require_once( "Archive/Tar.php" );

class CloseWikiMaintenance {

	const CLOSE_WIKI_DELAY = 30;

	/**
	 * s3cmd + config for DFS storage
	 *
	 * This maintenance script needs to be run as root due to permissions set for /etc/s3cmd
	 */
	const S3_COMMAND = '/usr/bin/s3cmd -c /etc/s3cmd/sjc_prod.cfg';

	private $mOptions;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $options ) {
		$this->mOptions = $options;
	}

	/**
	 * @param string $msg
	 * @param array $context
	 */
	private function info( $msg, Array $context = [] ) {
		\Wikia\Logger\WikiaLogger::instance()->info( $msg, $context );
	}

	/**
	 * 1. go through all wikis which are marked for closing and check which one
	 * 	want to have images packed.
	 *
	 * 2. pack images, send them via rsync to  target server,
	 *
	 * 3. mark in city_list.city_flags that images are sent,
	 *
	 * 4. remove images
	 *
	 * @access public
	 */
	public function execute() {
        
		global $wgUploadDirectory, $wgDBname, $IP;

		$first     = isset( $this->mOptions[ "first" ] ) ? true : false;
		$sleep     = isset( $this->mOptions[ "sleep" ] ) ? $this->mOptions[ "sleep" ] : 15;
		$cluster   = isset( $this->mOptions[ "cluster" ] ) ? $this->mOptions[ "cluster" ] : false; // eg. c6
		$opts      = array( "ORDER BY" => "city_id" );

		$this->info( 'start', [
			'cluster' => $cluster,
			'first'   => $first,
			'limit'   => isset( $this->mOptions[ "limit" ] ) ? $this->mOptions[ "limit" ] : false
		] );

		/**
		 * if $first is set skip limit checking
		 */
		if( !$first ) {
			if( isset( $this->mOptions[ "limit" ] ) && is_numeric( $this->mOptions[ "limit" ] ) )  {
				$opts[ "LIMIT" ] = $this->mOptions[ "limit" ];
			}
		}

		$timestamp = wfTimestamp(TS_DB,strtotime(sprintf("-%d days",self::CLOSE_WIKI_DELAY)));
		$where = array(
			"city_public" => array( WikiFactory::CLOSE_ACTION, WikiFactory::HIDE_ACTION ),
			"city_flags <> 0",
			sprintf( "city_flags <> %d", WikiFactory::FLAG_REDIRECT ),
			"city_last_timestamp < '{$timestamp}'",
		);

		if ($cluster !== false) {
			$where[ "city_cluster" ] = $cluster;
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select(
			array( "city_list" ),
			array( "city_id", "city_flags", "city_dbname", "city_url", "city_public" ),
			$where,
			__METHOD__,
			$opts
		);

		$this->info( 'wikis to remove', [
			'wikis' => $sth->numRows()
		] );

		$this->log( 'Wikis to remove: ' . $sth->numRows() );
		$this->log( $dbr->lastQuery() );

		$this->log( 'Will start in 5 seconds...' );
		sleep(5);

		while( $row = $dbr->fetchObject( $sth ) ) {
			/**
			 * reasonable defaults for wikis and some presets
			 */
			$hide     = false;
			$xdumpok  = true;
			$newFlags = 0;
			$dbname   = $row->city_dbname;
			$cityid   = $row->city_id;
			$folder   = WikiFactory::getVarValueByName( "wgUploadDirectory", $cityid );
			$cluster  = WikiFactory::getVarValueByName( "wgDBcluster", $cityid );

			/**
			 * safety check, if city_dbname is not unique die with message
			 */
			$check = $dbr->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbname ),
				__METHOD__,
				array( "GROUP BY" => "city_dbname" )
			);
			if( $check->count > 1 ) {
				echo "{$dbname} is not unique. Check city_list and rerun script";
				die( 1 );
			}
			$this->log( "city_id={$row->city_id} city_cluster={$cluster} city_url={$row->city_url} city_dbname={$dbname} city_flags={$row->city_flags} city_public={$row->city_public}" );

			/**
			 * request for dump on remote server (now hardcoded for Iowa)
			 */
			if( $row->city_flags & WikiFactory::FLAG_HIDE_DB_IMAGES)  {
				// "Hide Database and Image Dump
				$this->log( "Images and DB dump should be hidden" );
				$hide = true;
			}
			if( $row->city_flags & WikiFactory::FLAG_CREATE_DB_DUMP ) {
				$this->log( "Dumping database on remote host" );

				$script = ( $hide )
					? "--script='../extensions/wikia/WikiFactory/Dumps/runBackups.php --both --id={$cityid} --tmp --s3'"
					: "--script='../extensions/wikia/WikiFactory/Dumps/runBackups.php --both --id={$cityid} --hide --tmp --s3'";

				$cmd  = array(
					"/usr/wikia/backend/bin/run_maintenance",
					"--id=177",
					$script
				);

                $cmd = '/usr/wikia/backend/bin/run_maintenance --id=177 ' . wfEscapeShellArg( $script );
				$this->log( $cmd );
				$output = wfShellExec( $cmd, $retval );
				$xdumpok = empty( $retval ) ? true : false;
				/**
				 * reset flag
				 */
				$newFlags = $newFlags | WikiFactory::FLAG_CREATE_DB_DUMP | WikiFactory::FLAG_HIDE_DB_IMAGES;
			}
			if( $row->city_flags & WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE ) {
				if( $dbname && $folder ) {
					$this->log( "Dumping images on remote host" );
					try {
						$source = $this->tarFiles( $folder, $dbname, $cityid );

						if( is_string( $source ) ) {
							$retval = DumpsOnDemand::putToAmazonS3( $source, !$hide,  MimeMagic::singleton()->guessMimeType( $source ) );
							if( $retval > 0 ) {
								$this->log( "putToAmazonS3 command failed." );
								echo "Can't copy images to remote host. Please, fix that and rerun";
								die( 1 );
							} else {
								$this->log( "{$source} copied to S3 Amazon" );
								unlink( $source );
							}
						}

						$newFlags = $newFlags | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE | WikiFactory::FLAG_HIDE_DB_IMAGES;
					}
					catch( WikiaException $e ) {
						/**
						 * actually it's better to die than remove
						 * images later without backup
						 */
						$this->log( $e->getMessage() );
						echo "Can't copy images to remote host. Source {$source} is not defined";
					}
				}
			}
			if( $row->city_flags & WikiFactory::FLAG_DELETE_DB_IMAGES || $row->city_flags & WikiFactory::FLAG_FREE_WIKI_URL ) {

				// PLATFORM-1700: Remove wiki's DFS bucket
				$this->removeBucket( $cityid );

				/**
				 * clear wikifactory tables, condition for city_public should
				 * be always true there but better safe than sorry
				 */
				$this->log( "Cleaning the shared database" );

				WikiFactory::copyToArchive( $row->city_id );
				$dbw = WikiFactory::db( DB_MASTER );
				$dbw->delete(
					"city_list",
					array(
						"city_public" => array( 0, -1 ),
						"city_id" => $row->city_id
					),
					__METHOD__
				);
				$this->log( "{$row->city_id} removed from WikiFactory tables" );

				$this->cleanupSharedData( intval( $row->city_id ) );

				/**
				 * drop database, get db handler for proper cluster
				 */
				global $wgDBadminuser, $wgDBadminpassword;
				$centralDB = empty( $cluster) ? "wikicities" : "wikicities_{$cluster}";

				/**
				 * get connection but actually we only need info about host
				 */
				$local = wfGetDB( DB_MASTER, array(), $centralDB );
				$server = $local->getLBInfo( 'host' );

				try {
					$dbw = new DatabaseMysqli($server, $wgDBadminuser, $wgDBadminpassword, $centralDB);
					$dbw->begin( __METHOD__ );
					$dbw->query("DROP DATABASE `{$row->city_dbname}`");
					$dbw->commit( __METHOD__ );
					$this->log("{$row->city_dbname} dropped from cluster {$cluster}");
				}
				catch (Exception $e) {
					$this->log("{$row->city_dbname} database drop failed! {$e->getMessage()}");
					$this->info( 'drop database', [
						'cluster'   => $cluster,
						'dbname'    => $row->city_dbname,
						'exception' => $e,
						'server'    => $server
					] );
				}

				/**
				 * update search index
				 */
				$indexer = new Wikia\Search\Indexer();
				$indexer->deleteWikiDocs( $row->city_id );
				$this->log( "Wiki documents removed from index" );

				/**
				 * let other extensions remove entries for closed wiki
				 */
				wfRunHooks( 'WikiFactoryDoCloseWiki', [ $row ] );

				/**
				 * there is nothing to set because row in city_list doesn't
				 * exists
				 */
				$newFlags = false;
			}
			/**
			 * reset flags, if database was dropped and data were removed from
			 * WikiFactory tables it will return false anyway
			 */
			if(  $newFlags ) {
				WikiFactory::resetFlags( $row->city_id, $newFlags );
			}

			$this->info( 'closed', [
				'cluster' => $cluster,
				'city_id' => (int) $cityid,
				'dbname'  => $dbname,
			] );

			$this->log( "$dbname: completed" );

			/**
			 * just one?
			 */
			if( $first ) {
				break;
			}
			sleep( $sleep );
		}

		$this->log( 'Done' );
	}

	/**
	 * pack all images, use PEAR Archive_Tar for archive.
	 *
	 * @access public
	 *
	 * @param string $uploadDirectory path to images
	 * @param string $dbname database name
	 * @param int $cityid city ID
	 *
	 * @return string path to created archive or false if there are no files to backup (S3 bucket does not exist / is empty)
	 * @throws WikiaException thrown on failed backups
	 */
	private function tarFiles( $directory, $dbname, $cityid ) {
		$swiftEnabled = WikiFactory::getVarValueByName( 'wgEnableSwiftFileBackend', $cityid );
		$wgUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $cityid );

		if ( $swiftEnabled ) {
			// check that S3 bucket for this wiki exists (PLATFORM-1199)
			$swiftStorage = \Wikia\SwiftStorage::newFromWiki( $cityid );
			$isEmpty = intval( $swiftStorage->getContainer()->object_count ) === 0;

			if ( $isEmpty ) {
				$this->log( sprintf( "'%s' S3 bucket is empty, leave early\n", $swiftStorage->getContainerName() ) );
				return false;
			}

			// sync Swift container to the local directory
			$directory = sprintf( "/tmp/images/{$dbname}/" );

			$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' );
			$container = substr( $path, 0, -7 ); // eg. poznan/pl

			$this->log( sprintf( 'Rsyncing images from "%s" Swift storage to "%s"...', $container, $directory ) );

			wfMkdirParents( $directory );
			$time = wfTime();

			// s3cmd sync --dry-run s3://dilbert ~/images/dilbert/ --exclude "/thumb/*" --exclude "/temp/*"
			$cmd = sprintf(
				'%s sync s3://%s/images "%s" --exclude "/thumb/*" --exclude "/temp/*"',
				self::S3_COMMAND,
				$container,
				$directory
			);

			wfShellExec( $cmd, $iStatus );
			$time = Wikia::timeDuration( wfTime() - $time );
			Wikia::log( __METHOD__, "info", "Rsync to {$directory} from {$container} Swift storage: status: {$iStatus}, time: {$time}", true, true );
		}

		/**
		 * @name dumpfile
		 */
		$tarfile = sprintf( "/tmp/{$dbname}_images.tar" );
		if( file_exists( $tarfile ) ) {
			@unlink( $tarfile );
		}

		$tar = new Archive_Tar( $tarfile );

		if( ! $tar ) {
			$this->log( "Cannot open {$tarfile}" );
			echo "Cannot open {$tarfile}";
			die( 1 );
		}
		$files = $this->getDirTree( $directory );

		if( is_array( $files ) && count( $files ) ) {
			$this->log( sprintf( "Packing %d files from {$directory} to {$tarfile}", count( $files ) ) );
			$tar->create( $files );
			$result = $tarfile;
		}
		else {
			$this->log( "List of files in {$directory} is empty" );
			throw new WikiaException( "List of files in {$directory} is empty" );
		}
		return $result;
	}

	/**
	 * Get images list from folder, recursive, skip thumbnails directory
	 *
	 * @return array
	 */
	private function getDirTree( $dir ) {

		$files = array();

		wfProfileIn( __METHOD__ );

		if( is_dir( $dir ) ) {
			$dirs = array_diff( scandir( $dir ), array( ".", ".." ) );
		    foreach( $dirs as $d ) {
				$path = $dir . "/" . $d;
				if( is_dir( $path ) ) {
					$files = array_merge( $files, $this->getDirTree( $path, $files ) );
				}
				else {
					$include =
						strpos( $path, "/images/thumb/") === false &&
						strpos( $path, "/images/temp/") === false
						;
					if( $include ) {
						$files[] = $path;
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );

		return $files;
	}

	/**
	 * Remove DFS bucket of a given wiki
	 *
	 * @see PLATFORM-1700
	 * @param int $cityId
	 */
	private function removeBucket( $cityid ) {
		try {
			$swift = \Wikia\SwiftStorage::newFromWiki( $cityid );
			$this->log( sprintf( "Removing DFS bucket /%s%s", $swift->getContainerName(), $swift->getPathPrefix() ) );

			// s3cmd --recursive del s3://BUCKET/OBJECT / Recursively delete files from bucket
			$cmd = sprintf(
				'%s --recursive del s3://%s%s/',
				self::S3_COMMAND,
				$swift->getContainerName(),  # e.g. 'nordycka'
				$swift->getPathPrefix()      # e.g. '/pl/images'
			);
			$this->log( $cmd );
			$out = wfShellExec( $cmd, $iStatus );

			if ( $iStatus !== 0 ) {
				throw new Exception( 'Failed to remove a bucket content - ' . $cmd, $iStatus );
			}
		} catch ( Exception $ex ) {
			$this->log( __METHOD__ . ' - ' . $ex->getMessage() );

			Wikia\Logger\WikiaLogger::instance()->error( 'Removing DFS bucket failed', [
				'exception' => $ex,
				'city_id' => $cityid
			] );
		}
	}

	/**
	 * Clean up the shared data for a given wiki ID
	 *
	 * @see PLATFORM-1173
	 * @see PLATFORM-1204
	 * @see PLATFORM-1849
	 *
	 * @author Macbre
	 *
	 * @param int $city_id
	 */
	private function cleanupSharedData( $city_id ) {
		global $wgExternalDatawareDB, $wgSpecialsDB, $wgStatsDB;
		$dataware = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$stats    = wfGetDB( DB_MASTER, [], $wgStatsDB );

		/**
		 * remove records from image_review
		 */
		$this->doTableCleanup( $dataware, 'image_review',       $city_id );
		$this->doTableCleanup( $dataware, 'image_review_stats', $city_id );
		$this->doTableCleanup( $dataware, 'image_review_wikis', $city_id );

		/**
		 * remove records from stats-related tables
		 */
		$this->doTableCleanup( $dataware, 'pages',              $city_id, 'page_wikia_id' );
		$this->doTableCleanup( $specials, 'events_local_users', $city_id );
		$this->doTableCleanup( $specials, 'user_groups',        $city_id );
		$this->doTableCleanup( $stats,    'events',             $city_id );
	}

	/**
	 * Perform a database cleanup for a given wiki
	 *
	 * This method waits for slaves to catch up after every DELETE query that affected at least one row
	 *
	 * @param DatabaseBase $db database handler
	 * @param string $table name of table to clean up
	 * @param int $city_id ID of wiki to remove from the table
	 * @param string $wiki_id_column table column name to use when querying for wiki ID (defaults to "wiki_id")
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	private function doTableCleanup( DatabaseBase $db, $table, $city_id, $wiki_id_column = 'wiki_id' ) {
		$db->delete( $table, [ $wiki_id_column => $city_id ], __METHOD__ );

		$this->log( sprintf( "#%d: removed %d rows from %s.%s table", $city_id, $db->affectedRows(), $db->getDBname(), $table ) );

		// throttle delete queries
		if ( $db->affectedRows() > 0 ) {
			wfWaitForSlaves( $db->getDBname() );
		}
	}

	/**
	 * just helper for logging
	 */
	private function log( $message ) {
		Wikia::log( "CloseWiki", false, $message, true, true );
	}

}

/**
 * used options:
 *
 * --first			-- run only once for first wiki in queue
 * --limit=<limit>	-- run for <limit> wikis
 */
$wgAutoloadClasses[ "DumpsOnDemand" ] = "$IP/extensions/wikia/WikiFactory/Dumps/DumpsOnDemand.php";
$maintenance = new CloseWikiMaintenance( $options );
$maintenance->execute();
