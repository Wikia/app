<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @group cronjobs
 * @see wiki-factory-close-marked-wikis.yaml
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\Factory\ServiceFactory;

// make Wikia\Logger\Loggable trait available at a run-time
require_once( __DIR__ . '/../../../../lib/composer/autoload.php' );
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
require_once __DIR__ . '/gcs_bucket_remover.php';

class CloseWikiMaintenance extends Maintenance {

	use Wikia\Logger\Loggable;

	// delete wikis after X days when we marked them to be deleted
	const CLOSE_WIKI_DELAY = 30;

	const IMAGE_ARCHIVE_SIZE_LIMIT_BYTES = 50 * 1024 * 1024 * 1024;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'first', 'Run only once for first wiki in queue' );
		$this->addOption( 'from', 'Starting offset for wiki to be closed' );
		$this->addOption( 'dry-run', 'List wikis that will be removed and quit' );
		$this->addOption( 'limit', 'Limit how many wikis will be processed', false, true );
		$this->addOption( 'sleep', 'How long to wait before processing the next wiki', false, true );
		$this->addOption( 'cluster', 'Run for a given cluster only', false, true );
	}

	/**
	 * 1. go through all wikis which are marked for closing and check which one
	 *    want to have images packed.
	 *
	 * 2. pack images, send them via rsync to  target server,
	 *
	 * 3. mark in city_list.city_flags that images are sent,
	 *
	 * 4. remove images
	 *
	 * @access public
	 * @throws DBUnexpectedError
	 */
	public function execute() {
		global $IP;

		// process script command line arguments
		$first = $this->hasOption( 'first' );
		$sleep = $this->getOption( 'sleep', 15 );
		$limit = $this->getOption( 'limit', false );
		$from = $this->getOption( 'from', 0 );
		$cluster = $this->getOption( 'cluster', false ); // eg. c6

		$this->info( 'start', [
			'cluster' => $cluster,
			'first' => $first,
			'limit' => $limit,
			'from' => $from,
		] );

		// build database query
		$opts = [
			"ORDER BY" => "city_id",
		];

		/**
		 * if $first is set skip limit checking
		 */
		if ( !$first ) {
			if ( is_numeric( $limit ) ) {
				$opts['LIMIT'] = $limit;
			}
			if ( is_numeric( $from ) && $from > 0 ) {
				$opts['OFFSET'] = $from;
			}
		}

		$timestamp = wfTimestamp( TS_DB, strtotime( sprintf( "-%d days", self::CLOSE_WIKI_DELAY ) ) );
		$where = [
			"city_public" => [ WikiFactory::CLOSE_ACTION, WikiFactory::HIDE_ACTION ],
			"city_flags <> 0",
			sprintf( "city_flags <> %d", WikiFactory::FLAG_REDIRECT ),
			"city_last_timestamp < '{$timestamp}'",
		];

		if ( $cluster !== false ) {
			$where["city_cluster"] = $cluster;
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select( [ "city_list" ], [
			"city_id",
			"city_flags",
			"city_dbname",
			"city_cluster",
			"city_url",
			"city_public",
			"city_last_timestamp",
			"city_additional",
		], $where, __METHOD__, $opts );

		$this->info( 'wikis to remove', [
			'wikis' => $sth->numRows(),
			'query' => $dbr->lastQuery(),
		] );

		while ( $row = $dbr->fetchObject( $sth ) ) {
			/**
			 * reasonable defaults for wikis and some presets
			 */
			$hide = false;
			$newFlags = 0;
			$dbname = $row->city_dbname;
			$cityid = intval( $row->city_id );
			$cluster = $row->city_cluster;
			$folder = WikiFactory::getVarValueByName( "wgUploadDirectory", $cityid );

			if ( $this->hasOption( 'dry-run' ) ) {
				$this->output( sprintf( "DRY-RUN: Wiki #%d (%s) is marked to be removed - %s\n", $cityid, $dbname,
					$row->city_additional ?: 'n/a' ) );
				continue;
			}

			$this->debug( "city_id={$row->city_id} city_cluster={$cluster} city_url={$row->city_url} city_dbname={$dbname} city_flags={$row->city_flags} city_public={$row->city_public} city_last_timestamp={$row->city_last_timestamp}" );

			/**
			 * request for dump on remote server (now hardcoded for Iowa)
			 */
			if ( $row->city_flags & WikiFactory::FLAG_HIDE_DB_IMAGES ) {
				// "Hide Database and Image Dump
				$this->info( "Images and DB dump should be hidden" );
				$hide = true;
			}
			if ( $row->city_flags & WikiFactory::FLAG_CREATE_DB_DUMP ) {
				$script =
					( $hide ) ? "php {$IP}/extensions/wikia/WikiFactory/Dumps/runBackups.php --both --id={$cityid} --s3"
						: "php {$IP}/extensions/wikia/WikiFactory/Dumps/runBackups.php --both --id={$cityid} --hide --s3";

				$this->info( "Dumping database on remote host", [
					'script' => $script,
				] );
				wfShellExec( $script, $retval, [ 'SERVER_ID' => Wikia::COMMUNITY_WIKI_ID ] );
				/**
				 * reset flag
				 */
				$newFlags = $newFlags | WikiFactory::FLAG_CREATE_DB_DUMP | WikiFactory::FLAG_HIDE_DB_IMAGES;
			}
			if ( $row->city_flags & WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE ) {
				if ( $dbname && $folder ) {
					$this->info( "Dumping images on remote host" );
					try {
						foreach( $this->tarFiles( $dbname, $cityid ) as $source ) {
							if ( is_string( $source ) ) {
								try {
									DumpsOnDemand::putToAmazonS3( $source, !$hide,
										MimeMagic::singleton()->guessMimeType( $source ) );
								}
								catch ( S3Exception $ex ) {
									$this->error( "putToAmazonS3 command failed - Can't copy images to remote host. Please, fix that and rerun",
										[
											'exception' => $ex->getMessage(),
											'dump_size_bytes' => filesize( $source ),
										] );
									unlink( $source );

									// SUS-6077 | move to a next wiki instead of failing the entire process
									continue 2;
								}

								$this->info( "{$source} copied to S3 Amazon" );
								unlink( $source );
							}
						}

						$newFlags =
							$newFlags | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE | WikiFactory::FLAG_HIDE_DB_IMAGES;
					} catch ( ConfigException $e ) {
						$this->info( 'Skipping image archive creation', [
							'exception' => $e->getMessage(),
							'city_id' => $cityid,
						] );
					} catch ( Exception $e ) {
						$this->error( "Can't create tar archive with images", [
							'exception' => $e->getMessage(),
							'city_id' => $cityid,
						] );

						// SUS-6077 | move to a next wiki instead of failing the entire process
						continue;
					}
				}
			}
			if ( $row->city_flags & WikiFactory::FLAG_DELETE_DB_IMAGES ||
				 $row->city_flags & WikiFactory::FLAG_FREE_WIKI_URL ) {
				$where["city_id"] = $cityid;
				$sth = $dbr->select( [ "city_list" ], [
					"city_id",
				], $where, __METHOD__, $opts );
				if ( $sth->numRows() != 0 ) {

					( new GcsBucketRemover() )->remove( $cityid );

					/**
					 * clear wikifactory tables, condition for city_public should
					 * be always true there but better safe than sorry
					 */
					$this->info( "Cleaning the shared database" );
					if ( !WikiFactory::isInArchive( $row->city_id ) ){
						WikiFactory::copyToArchive( $row->city_id );
					} else {
						$this->error( 'Wiki was already in archive', [
							'wiki_id' => (int)$row->city_id,
						] );
					}
					$dbw = WikiFactory::db( DB_MASTER );
					$dbw->delete( "city_list", [
						"city_public" => [ 0, - 1 ],
						"city_id" => $row->city_id,
					], __METHOD__ );
					// SUS-2374
					$dbw->delete( "city_variables", [
						"cv_city_id" => $row->city_id,
					], __METHOD__ );
					$this->info( "{$row->city_id} removed from WikiFactory tables" );

					$this->cleanupSharedData( intval( $row->city_id ) );

					/**
					 * drop database, get db handler for proper cluster
					 */ global $wgDBadminuser, $wgDBadminpassword;
					$centralDB = empty( $cluster ) ? "wikicities" : "wikicities_{$cluster}";

					/**
					 * get connection but actually we only need info about host
					 */
					$local = wfGetDB( DB_MASTER, [], $centralDB );
					$server = $local->getLBInfo( 'host' );

					try {
						$dbw = new DatabaseMysqli( [
							'host' => $server,
							'user' => $wgDBadminuser,
							'password' => $wgDBadminpassword,
							'dbname' => $centralDB,
						] );
						$dbw->begin( __METHOD__ );
						$dbw->query( "DROP DATABASE `{$row->city_dbname}`" );
						$dbw->commit( __METHOD__ );
						$this->info( "{$row->city_dbname} dropped from cluster {$cluster}" );
					}
					catch ( Exception $e ) {
						$this->error( 'drop database failed', [
							'cluster' => $cluster,
							'dbname' => $row->city_dbname,
							'exception' => $e,
							'server' => $server,
						] );
					}

					/**
					 * update search index
					 */
					$indexer = new Wikia\Search\Indexer();
					$indexer->deleteWikiDocs( $row->city_id );
					$this->info( "Wiki documents removed from index" );

					/**
					 * let other extensions remove entries for closed wiki
					 */
					try {
						Hooks::run( 'WikiFactoryDoCloseWiki', [ $row ] );
					}
					catch ( Exception $ex ) {
						// SUS-4606 | catch exceptions instead of stopping the script
						$this->error( 'WikiFactoryDoCloseWiki hook processing returned an error', [
							'exception' => $ex,
							'wiki_id' => (int)$row->city_id,
						] );
					}

					/**
					 * there is nothing to set because row in city_list doesn't
					 * exists
					 */
					$newFlags = false;

				} else {
					$this->error( 'Wiki shouldn\'t be deleted', [
						'wiki_id' => (int)$row->city_id,
					] );
				}
			}
			/**
			 * reset flags, if database was dropped and data were removed from
			 * WikiFactory tables it will return false anyway
			 */
			if ( $newFlags ) {
				WikiFactory::resetFlags( $row->city_id, $newFlags );
			}

			$this->info( 'closed', [
				'cluster' => $cluster,
				'city_id' => (int)$cityid,
				'dbname' => $dbname,
			] );

			$this->info( "$dbname: completed" );

			$this->removeDiscussions( $cityid );

			/**
			 * just one?
			 */
			if ( $first ) {
				break;
			}
			sleep( $sleep );
		}

		$this->info( 'Done' );
	}

	private function createTarFile( string $sourceDir, string $targetFile ) {
		$tar = new Archive_Tar( $targetFile );

		if ( !$tar ) {
			$this->error( "Cannot open {$targetFile}" );
			echo "Cannot open {$targetFile}";
			die( 1 );
		}

		$files = $this->getDirTree( $sourceDir );

		if ( is_array( $files ) && count( $files ) ) {
			$this->info( sprintf( "Packing %d files from {$sourceDir} to {$targetFile}", count( $files ) ) );
			$res = $tar->create( $files );

			if ( $res !== true ) {
				throw new WikiaException( "Archive_Tar::create failed" );
			}
		} else {
			$this->info( "List of files in {$sourceDir} is empty" );

			// SUS-6077 | sub-bucket is empty, e.g. foo bucket is not empty,
			// but bucket/<lang>  can be
			return false;
		}

		// SUS-4325 | CloseWikiMaintenance should remove directories with images after tar file is created
		$this->info( "Removing '{$sourceDir}' directory" );
		wfRecursiveRemoveDir( $sourceDir );

		return true;
	}

	/**
	 * pack all images, use PEAR Archive_Tar for archive.
	 *
	 * @access public
	 *
	 * @param string $dbname database name
	 * @param int $cityId city ID
	 *
	 * @return Generator list of paths to created archive or false if there are no files to backup (S3 bucket does not
	 * exist /
	 * is empty)
	 * @throws ConfigException
	 * @throws MWException
	 * @throws WikiaException
	 */
	private function tarFiles( $dbname, $cityId ) {
		$wgUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $cityId );

		if ( empty( $wgUploadPath ) ) {
			$this->info( sprintf( "Upload path is empty for city %s, leave early", $cityId ) );

			throw new ConfigException( "upload path is empty for city {$cityId}" );
		}

		/** @var GcsFileBackend $backend */
		$backend = FileBackendGroup::singleton()->get( 'gcs-backend' );

		$this->info( sprintf( "Preparing image backup using upload path %s", $wgUploadPath ) );

		// local backup path
		$directory = sprintf( "/tmp/images/{$dbname}/" );

		$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' );

		wfMkdirParents( $directory );
		$time = wfTime();

		$path = StringUtils::escapeRegexReplacement( "mwstore://{$backend->getName()}/" . $path );

		$objects = iterator_to_array( $backend->getFileList( [ 'dir' => $path ] ) );

		if ( count( $objects ) === 0 ) {
			$this->info( sprintf( "'%s' path is empty, leave early\n", $path ) );

			throw new ConfigException( "no files to copy" );
		}

		$this->info( sprintf( 'Copying images from "%s" to "%s"...', $path, $directory ) );

		$partSize = 0;
		$fileCount = 0;
		foreach ( $objects as $object ) {
			$this->output( sprintf( "Copying file %s", $object ) );
			// do not backup thumbnails and temporary files
			// --exclude "/thumb/*" --exclude "/temp/*"
			if ( strpos( $object, 'images/thumb/' ) !== false || strpos( $object, 'images/temp/' ) !== false ) {
				continue;
			}

			// prepare a destination directory for this file
			wfMkdirParents( dirname( $directory . $object ) );

			$targetPath = $directory . basename( $object );

			$backend->bucket()->object( $object )->downloadToFile( $targetPath );

			$this->output( sprintf( "Copied %s to %s", $object, $targetPath ) );

			$partSize += filesize( $targetPath );

			if ( $partSize > self::IMAGE_ARCHIVE_SIZE_LIMIT_BYTES ) {
				$tarfile = sprintf( "/tmp/{$dbname}_images_%d.tar", ++$fileCount );
				if ( file_exists( $tarfile ) ) {
					@unlink( $tarfile );
				}

				$res = $this->createTarFile( $directory, $tarfile );
				if ( $res ) {
					$partSize = 0;
					yield $tarfile;
				}
			}
		}

		$time = Wikia::timeDuration( wfTime() - $time );
		$this->debug( "Copied from {$path} to {$directory} in time: {$time}" );

		$tarfile = sprintf( "/tmp/{$dbname}_images_%d.tar", ++$fileCount );
		if ( file_exists( $tarfile ) ) {
			@unlink( $tarfile );
		}

		$res = $this->createTarFile( $directory, $tarfile );
		if ( $res ) {
			yield $tarfile;
		}
	}

	/**
	 * Get images list from folder, recursive, skip thumbnails directory
	 *
	 * @param string $dir
	 * @return array
	 */
	private function getDirTree( $dir ) {

		$files = [];

		if ( is_dir( $dir ) ) {
			$dirs = array_diff( scandir( $dir ), [ ".", ".." ] );
			foreach ( $dirs as $d ) {
				$path = $dir . "/" . $d;
				if ( is_dir( $path ) ) {
					$files = array_merge( $files, $this->getDirTree( $path ) );
				} else {
					$include =
						strpos( $path, "/images/thumb/" ) === false && strpos( $path, "/images/temp/" ) === false;
					if ( $include ) {
						$files[] = $path;
					}
				}
			}
		}

		return $files;
	}

	/**
	 * Clean up the shared data for a given wiki ID
	 *
	 * @param int $city_id
	 * @throws DBUnexpectedError
	 * @throws MWException
	 * @see PLATFORM-1204
	 * @see PLATFORM-1849
	 *
	 * @author Macbre
	 *
	 * @see PLATFORM-1173
	 */
	private function cleanupSharedData( $city_id ) {
		global $wgExternalDatawareDB, $wgSpecialsDB;
		$dataware = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		/**
		 * remove records from stats-related tables
		 */
		$this->doTableCleanup( $dataware, 'pages', $city_id, 'page_wikia_id' );
		$this->doTableCleanup( $specials, 'events_local_users', $city_id );
		$this->doTableCleanup( $specials, 'local_user_groups', $city_id );
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

		$this->info( sprintf( "#%d: removed %d rows from %s.%s table", $city_id, $db->affectedRows(), $db->getDBname(),
			$table ) );

		// throttle delete queries
		if ( $db->affectedRows() > 0 ) {
			wfWaitForSlaves( $db->getDBname() );
		}
	}

	private function removeDiscussions( int $cityId ) {
		global $wgTheSchwartzSecretToken;

		try {
			$this->getSitesApi()->hardDeleteSite( $cityId, $wgTheSchwartzSecretToken );
		}
		catch ( ApiException $e ) {
			$this->error( "Failed to hard delete Discussion site", [
				'exception' => $e,
				'city_id' => $cityId,
			] );
		}
	}

	/**
	 * @return SitesApi
	 */
	private function getSitesApi() {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();

		/** @var SitesApi $api */
		$api = $apiProvider->getApi( 'discussion', SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( 5 );

		return $api;
	}

}

$maintClass = CloseWikiMaintenance::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
