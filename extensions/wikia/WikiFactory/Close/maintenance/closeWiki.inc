<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

/**
 * @todo how to check if dump is already done?
 */
include( $IP . "/maintenance/backup.inc" );

class CloseWikiMaintenace {

	private
		$mDumpDirectory,
		$mImgDirectory,
		$mAction;

	public function __construct() {
		global $wgDevelEnvironment;

		if( !$wgDevelEnvironment ) {
			$this->mDumpDirectory = "/opt/dbdumps";
			$this->mZipDirectory = "/opt/dbdumps";
		}
		else {
			$this->mDumpDirectory = "/tmp/dumps";
			$this->mZipDirectory = "/tmp/dumps";
		}

	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function execute() {

		global $wgCityId;

		if( !wfReadOnly() ) {
			/**
			 * check what we have to do with this wikia
			 */
			if( $wgCityId ) {
				$Wiki = WikiFactory::getWikiByID( $wgCityId );
				$this->mAction = $Wiki->city_public;
			}
			switch( $this->mAction ) {

			}
			#$this->dumpXMl();
			$this->compressImages();
		}
		return true;
	}

	public function dumpXMl() {
		global $wgDBname;

		/**
		 * @name dumpfile
		 */
		$dumpfile = sprintf("/%s/%s/full.gz", ltrim( $this->mDumpDirectory, "/" ), $wgDBname );
		$directory = dirname( $dumpfile );
		if( !is_dir( $directory ) ) {
			if( ! is_file( $directory ) ) {
				wfMkdirParents( $directory );
			}
			else {
				Wikia::log( __METHOD__, "dir", "Path {$directory} exists and it is file" );
			}
		}
		$args = array(
			"--full",
			"--quiet",
			"--output=gzip:{$dumpfile}",
			"--xml"
		);
		Wikia::log( __METHOD__, "". "dumping {$wgDBname} to {$dumpfile}");
		$dumper = new BackupDumper( $args );
		$dumper->dump( WikiExporter::FULL, WikiExporter::TEXT );
	}

	public function compressImages() {
		global $wgUploadDirectory, $wgDBname;

		/**
		 * @name dumpfile
		 */
		$zipfile = sprintf("/%s/%s/images.zip", ltrim( $this->mZipDirectory, "/" ), $wgDBname );
		$directory = dirname( $zipfile );
		if( !is_dir( $directory ) ) {
			if( ! is_file( $directory ) ) {
				wfMkdirParents( $directory );
			}
			else {
				Wikia::log( __METHOD__, "dir", "Path {$directory} exists and it is file" );
			}
		}
		Wikia::log( __METHOD__, "", "Zipping images from {$wgUploadDirectory} to {$zipfile}" );

		$zip = new ZipArchive();

		if ($zip->open( $zipfile, ZIPARCHIVE::CREATE ) !== true ) {
			Wikia::log( __METHOD__, "zip", "Cannot open {$zipfile}" );
			exit(1);
		}

		foreach( $this->getFilesList() as $file ) {
			if( is_file( $file ) ) {
				Wikia::log( __METHOD__, "zip", "Adding {$file}" );
				$zip->addFile( $file, ltrim( $file, "/" ) );
			}
		}
		Wikia::log( __METHOD__, "zip", "Added {$zip->numFiles} files, {$zip->status}" );
		$zip->close();
	}

	public function dropDB() {

	}

	public function removeImageDirectory() {

	}

	/**
	 * Get images list from database
	 *
	 * @return array
	 */
	private function getFilesList() {

		$images = array();

		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );
		$sth = $dbr->select(
			array( "image" ),
			array( "img_name", "img_media_type" ),
			false,
			__METHOD__
		);
		while( $row = $dbr->fetchObject( $sth ) ) {
			$images[] = wfLocalFile( $row->img_name )->getPath();
		}
		$dbr->freeResult( $sth );

		wfProfileOut( __METHOD__ );

		return $images;
	}
}
