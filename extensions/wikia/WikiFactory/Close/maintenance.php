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

	private $mTarget, $mOptions;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $options ) {
		global $wgDevelEnvironment;
		if( !empty( $wgDevelEnvironment ) ) {
			$this->mTarget = "root@127.0.0.1:/tmp/dumps";
		}
		else {
			$this->mTarget = "root@file-i6:/raid/dumps";
		}
		$this->mOptions = $options;
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
		$sleep     = isset( $this->mOptions[ "sleep" ] ) ? $this->mOptions[ "sleep" ] : 1;
		$condition = array( "ORDER BY" => "city_id" );

		/**
		 * if $first is set skip limit checking
		 */
		if( !$first ) {
			if( isset( $this->mOptions[ "limit" ] ) && is_numeric( $this->mOptions[ "limit" ] ) )  {
				$condition[ "LIMIT" ] = $this->mOptions[ "limit" ];
			}
		}

		$timestamp = wfTimestamp(TS_DB,strtotime(sprintf("-%d days",self::CLOSE_WIKI_DELAY)));
		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select(
			array( "city_list" ),
			array( "city_id", "city_flags", "city_dbname", "city_url", "city_public" ),
			array(
				"city_public" => array( 0, -1 ),
				"city_flags <> 0 && city_flags <> 32",
				"city_last_timestamp < '{$timestamp}'",
			),
			__METHOD__,
			$condition
		);

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
			$this->log( "city_id={$row->city_id} city_url={$row->city_url} city_dbname={$dbname} city_flags={$row->city_flags} city_public={$row->city_public}" );

			/**
			 * request for dump on remote server (now hardcoded for Iowa)
			 */
			if( $row->city_flags & WikiFactory::FLAG_HIDE_DB_IMAGES)  {
				$hide = true;
			}
			if( $row->city_flags & WikiFactory::FLAG_CREATE_DB_DUMP ) {
				$this->log( "Dumping database on remote host" );
				list ( $remote  ) = explode( ":", $this->mTarget, 2 );

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
					$source = $this->tarFiles( $folder, $dbname, $cityid );
					if( $source ) {
                        $retval = DumpsOnDemand::putToAmazonS3( $source, !$hide,  MimeMagic::singleton()->guessMimeType( $source ) );
						if( $retval > 0 ) {
							$this->log( "putToAmazonS3 command failed." );
							echo "Can't copy images to remote host. Please, fix that and rerun";
							die( 1 );
						} else {
							$this->log( "{$source} copied to S3 Amazon" );
							unlink( $source );
							$newFlags = $newFlags | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE | WikiFactory::FLAG_HIDE_DB_IMAGES;
						}
					}
					else {
						/**
						 * actually it's better to die than remove
						 * images later without backup
						 */
						echo "Can't copy images to remote host. Source {$source} is not defined";
					}
				}
			}
			if( $row->city_flags & WikiFactory::FLAG_DELETE_DB_IMAGES ||
			$row->city_flags & WikiFactory::FLAG_FREE_WIKI_URL ) {

				/**
				 * clear wikifactory tables, condition for city_public should
				 * be always true there but better safe than sorry
				 */
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

				/**
				 * remove records from dataware
				 */
				global $wgExternalDatawareDB;
				$datawareDB = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
				$datawareDB->delete( "pages", array( "page_wikia_id" => $row->city_id ), __METHOD__ );
				$this->log( "{$row->city_id} removed from pages table" );

				/**
				 * remove images from D.I.R.T.
				 */
				$datawareDB->delete( "image_review", array( "wiki_id" => $row->city_id ), __METHOD__  );
				$this->log( "{$row->city_id} removed from image_review table" );

				$datawareDB->delete( "image_review_stats", array( "wiki_id" => $row->city_id ), __METHOD__  );
				$this->log( "{$row->city_id} removed from image_review_stats table" );

				$datawareDB->delete( "image_review_wikis", array( "wiki_id" => $row->city_id ), __METHOD__  );
				$this->log( "{$row->city_id} removed from image_review_wikis table" );

				$datawareDB->commit();

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
				$dbw = new DatabaseMysql( $server, $wgDBadminuser, $wgDBadminpassword, $centralDB );
				$dbw->begin();
				$dbw->query( "DROP DATABASE `{$row->city_dbname}`");
				$dbw->commit();
				$this->log(  "{$row->city_dbname} dropped from cluster {$cluster}" );

				/**
				 * update search index
				 */
				$indexer = new Wikia\Search\Indexer();
				$indexer->deleteWikiDocs( $row->city_id );
				$this->log( "Wiki documents removed from index" );

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

			/**
			 * just one?
			 */
			if( $first ) {
				break;
			}
			sleep( $sleep );
		}
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
	 * @return string path to created archive or false if not created
	 */
	public function tarFiles( $directory, $dbname, $cityid ) {
		$swiftEnabled = WikiFactory::getVarValueByName( 'wgEnableSwiftFileBackend', $cityid );
		$wgUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $cityid );

		if ( $swiftEnabled ) {
			// sync Swift container to the local directory
			$directory = sprintf( "/tmp/images/{$dbname}/" );

			$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' );
			$container = substr( $path, 0, -7 ); // eg. poznan/pl

			$this->log( sprintf( 'Rsyncing images from "%s" Swift storage to "%s"...', $container, $directory ) );

			wfMkdirParents( $directory );
			$time = wfTime();

			// s3cmd sync --dry-run s3://dilbert ~/images/dilbert/ --exclude "/thumb/*" --exclude "/temp/*"
			$cmd = sprintf(
				'sudo /usr/bin/s3cmd -c %s sync s3://%s/images "%s" --exclude "/thumb/*" --exclude "/temp/*"',
				'/etc/s3cmd/sjc_prod.cfg', // s3cmd config for Swift storage
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
			$result = false;
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
