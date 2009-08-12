<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );
require_once( "Archive/Tar.php" );

class WikiFactoryTarAndCopyImages {

	/**
	 * @access public
	 */
	public function execute() {
		global $wgUploadDirectory, $wgDBname;
		$this->tarFiles( $wgUploadDirectory, $wgDBname );
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
		Wikia::log( __CLASS__, "info", "Packing images from {$directory} to {$tarfile}" );

		$tar = new Archive_Tar( $tarfile );

		if( ! $tar ) {
			Wikia::log( __CLASS__, "tar", "Cannot open {$tarfile}" );
			wfDie( "Cannot open {$tarfile}" );
		}
		$files = $this->getDirTree( $directory );
		print_r( $files );

		if( is_array( $files ) && count( $files ) ) {
			Wikia::log( __CLASS__, "info", sprintf( "Packing %d images", count( $files ) ) );
			return $tar->create( $files );
		}
		else {
			Wikia::log( __CLASS__, "info", "List of images is empty" );
			return true;
		}
		return true;
	}

	/**
	 * Get images list from folder, recursive, skip thumbnails
	 *
	 * @return array
	 */
	private function getDirTree( $dir ) {

		$files = array();

		wfProfileIn( __METHOD__ );

		$dirs = array_diff( scandir( $dir ), array( ".", ".." ) );
	    foreach( $dirs as $d ) {
			$path = $dir . "/" . $d;
	        if( is_dir( $path ) ) {
				$files = array_merge( $files, $this->getDirTree( $path, $files ) );
			}
	        else {
				if( strpos( $path, "/images/thumb/") === false ) {
					$files[] = $path;
				}
			}
	    }

		wfProfileOut( __METHOD__ );

		return $files;
	}

}

$maintenance = new WikiFactoryTarAndCopyImages;
$maintenance->execute();
