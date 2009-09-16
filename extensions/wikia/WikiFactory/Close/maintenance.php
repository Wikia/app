<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array( "limit" );

require_once( "commandLine.inc" );
require_once( "Archive/Tar.php" );

class CloseWikiTarAndCopyImages {

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
			$this->mTarget = "root@10.6.10.39:/backup/dumps";
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
		global $wgUploadDirectory, $wgDBname;

		$first     = isset( $this->mOptions[ "first" ] ) ? true : false;
		$condition = array( "ORDER BY" => "city_id" );
		/**
		 * if $first is set skip limit checking
		 */
		if( !$first ) {
			if( isset( $this->mOptions[ "limit" ] ) && is_numeric( $this->mOptions[ "limit" ] ) )  {
				$condition[ "LIMIT" ] = $this->mOptions[ "limit" ];
			}
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select(
			array( "city_list" ),
			array( "city_id", "city_flags", "city_dbname", "city_url", "city_public" ),
			array( "city_public" => array( 0, -1 ) ),
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
			$folder   = WikiFactory::getVarValueByName( "wgUploadDirectory", $row->city_id );
			$cluster  = WikiFactory::getVarValueByName( "wgDBcluster", $row->city_id );

			Wikia::log( __CLASS__, "info", "city_id={$row->city_id} city_url={$row->city_url} city_dbname={$dbname} city_public={$row->city_public}");

			/**
			 * request for dump on remote server (now hardcoded for Iowa)
			 */
			if( $row->city_flags & WikiFactory::FLAG_HIDE_DB_IMAGES)  {
				$hide = true;
			}
			if( $row->city_flags & WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE ) {
				Wikia::log( __CLASS__, "info", "Dumping database on remote host" );
				list ( $remote  ) = explode( ":", $this->mTarget, 2 );
				$cmd  = array(
					"SERVER_ID=177",
					"php",
					"/usr/wikia/source/trunk/extensions/wikia/WikiFactory/Dumps/runBackups.php",
					"--conf /usr/wikia/conf/current/qa.wiki.factory/LocalSettings.Iowa.php",
					"--both",
					"--id={$row->city_id}"
				);
				if( $hide ) {
					$cmd[] = "--hide";
				}
				$dump = wfEscapeShellArg(
					"/usr/bin/ssh",
					$remote,
					implode( " ", $cmd )
				);
				Wikia::log( __CLASS__, "info", $dump );
				$output = wfShellExec( $dump, $retval );
				$xdumpok = empty( $retval ) ? true : false;
				/**
				 * reset flag
				 */
				$newFlags = $newFlags &~ WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE;
			}
			if( $row->city_flags & WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE ) {
				if( $dbname && $folder ) {
					$source = $this->tarFiles( $folder, $dbname );

					$target = DumpsOnDemand::getUrl( $dbname, "images.tar", $this->mTarget );
					if( $hide ) {
						/**
						 * different path for hidden dumps
						 */
						$target = str_replace( "dumps", "dumps-hidden", $target );
					}

					if( $source && $target ) {
						$cmd = wfEscapeShellArg(
							"/usr/bin/rsync",
							"-axpr",
							"--quiet",
							"--owner",
							"--group",
							"--chmod=g+w",
							$source,
							escapeshellcmd( $target )
						);
						$output = wfShellExec( $cmd, $retval );
						if( $retval > 0 ) {
							Wikia::log( __CLASS__, "error", "{$cmd} command failed." );
							/**
							 * creating directory attempt
							 */
							list( $remote, $path ) = explode( ":", $target, 2 );
							$mkdir = wfEscapeShellArg(
								"/usr/bin/ssh",
								$remote,
								escapeshellcmd( "mkdir -p " . dirname( $path ) )
							);
							$output = wfShellExec( $mkdir, $retval );
							if( $retval == 0 ) {
								Wikia::log( __CLASS__, "info",  dirname( $path ) . " created on {$remote}" );
								$output = wfShellExec( $cmd, $retval );
								if( $retval == 0 ) {
									Wikia::log( __CLASS__, "info", "{$source} copied to {$target}" );
									unlink( $source );
									/**
									 * reset flag
									 */
									$newFlags = $newFlags &~ WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE;
								}
							}
							else {
								/**
								 * actually it's better to die than remove
								 * images later without backup
								 */
								wfDie( "Can't copy images to remote host. Please, fix that and rerun" );
							}
						}
						else {
							Wikia::log( __CLASS__, "info", "{$source} copied to {$target}" );
							unlink( $source );
							$newFlags = $newFlags &~ WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE;;
						}
					}
					else {
						/**
						 * actually it's better to die than remove
						 * images later without backup
						 */
						wfDie( "Can't copy images to remote host. Source {$source} and target {$target} is not defined" );
					}
				}
			}
			if( $row->city_flags & WikiFactory::FLAG_DELETE_DB_IMAGES ||
			$row->city_flags & WikiFactory::FLAG_FREE_WIKI_URL ) {

				Wikia::log( __CLASS__, "info", "removing folder {$folder}" );
				if( is_dir( $wgUploadDirectory ) ) {
			        /**
					 * what should we use here?
					 */
					$cmd = "rm -rf {$folder}";
					wfShellExec( $cmd, $retval );
					if( $retval ) {
						/**
						 * info removing folder was not possible
						 */
					}

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
					Wikia::log( __CLASS__, "info", "{$row->city_id} removed from WikiFactory tables" );

					/**
					 * drop database, get db handler for proper cluster
					 */
					$centralDb = empty( $cluster) ? "wikicities" : "wikicities_{$cluster}";
					$dbw = wfGetDB( DB_MASTER, array(), $centralDb );
					$dbw->begin();
					#echo "DROP DATABASE `{$row->city_dbname}`";
					$dbw->query( "DROP DATABASE `{$row->city_dbname}`");
					$dbw->commit();
					Wikia::log( __CLASS__, "info", "{$row->city_dbname} dropped from cluster {$cluster}" );

					/**
					 * there is nothing to set because row in city_list doesn't
					 * exists
					 */
					$newFlags = 0;
				}
			}
			/**
			 * reset flags, if database was dropped and data were removed from
			 * WikiFactory tables it will return false anyway
			 */
			if( !empty( $newFlags ) ) {
				WikiFactory::resetFlags( $row->city_id, $newFlags );
			}

			/**
			 * just one?
			 */
			if( $first ) {
				break;
			}
		}
	}

	/**
	 * pack all images from image table, use PEAR Archive_Tar for archive.
	 *
	 * @access public
	 *
	 * @param string $uploadDirectory path to images
	 * @param string $dbname database name
	 *
	 * @return string path to created archive or false if not created
	 */
	public function tarFiles( $directory, $dbname ) {

		/**
		 * @name dumpfile
		 */
		$tarfile = sprintf( "/tmp/{$dbname}-images.tar" );
		if( file_exists( $tarfile ) ) {
			@unlink( $tarfile );
		}

		$tar = new Archive_Tar( $tarfile );

		if( ! $tar ) {
			Wikia::log( __CLASS__, "tar", "Cannot open {$tarfile}" );
			wfDie( "Cannot open {$tarfile}" );
		}
		$files = $this->getDirTree( $directory );

		if( is_array( $files ) && count( $files ) ) {
			Wikia::log( __CLASS__, "info", sprintf( "Packing %d files from {$directory} to {$tarfile}", count( $files ) ) );
			$tar->create( $files );
			$result = $tarfile;
		}
		else {
			Wikia::log( __CLASS__, "info", "List of files in {$directory} is empty" );
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

}

/**
 * used options:
 *
 * --first -- run only once for first wiki in queue
 */
$wgAutoloadClasses[ "DumpsOnDemand" ] = "$IP/extensions/wikia/WikiFactory/Dumps/DumpsOnDemand.php";
$maintenance = new CloseWikiTarAndCopyImages( $options );
$maintenance->execute();
