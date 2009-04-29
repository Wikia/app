<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

include( $IP . "/maintenance/backup.inc" );

class CloseWikiMaintenace {

	private
		$mDumpDirectory,
		$mImgDirectory,
		$mAction,
		$mCityID;

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
		$this->mCityID = $wgCityId;

		if( !wfReadOnly() ) {
			/**
			 * check what we have to do with this wikia
			 */
			if( $wgCityId ) {
				$Wiki = WikiFactory::getWikiByID( $wgCityId );
				$this->mAction = $Wiki->city_public;
			}
			switch( $this->mAction ) {
				case WikiFactory::STATUS_CLOSED:
					$this->dumpXMl();
					$this->compressImages();
					break;

				case WikiFactory::STATUS_DELETE:
					$this->dumpXMl();
					$this->compressImages();
					$this->removeImageDirectory();
					$this->cleanWikiFactory();
					// $this->dropDB();
					break;
			}
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

	/**
	 * zip all images from image table
	 *
	 * @access public
	 *
	 * @return integer status of zip operation
	 */
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
				wfDie( "Path {$directory} exists and it is file" );
			}
		}
		Wikia::log( __METHOD__, "", "Zipping images from {$wgUploadDirectory} to {$zipfile}" );

		$zip = new ZipArchive();

		if ($zip->open( $zipfile, ZIPARCHIVE::CREATE ) !== true ) {
			Wikia::log( __METHOD__, "zip", "Cannot open {$zipfile}" );
			wfDie( "Cannot open {$zipfile}" );
		}

		foreach( $this->getFilesList() as $file ) {
			if( is_file( $file ) ) {
				Wikia::log( __METHOD__, "zip", "Adding {$file}" );
				$zip->addFile( $file, ltrim( $file, "/" ) );
			}
		}
		$status = $zip->status;
		Wikia::log( __METHOD__, "zip", "Added {$zip->numFiles} files, {$tatus}" );
		$zip->close();

		return $status;
	}

	/**
	 * drop database. Danger! Use with caution
	 *
	 * @access public
	 */
	public function dropDB() {

		global $wgSharedDB, $wgDBname;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB();
		$dbw->selectDB( $wgSharedDB );
		$dbw->begin();
		$dbw->query( "DROP DATABASE `$wgDBname`");
		$dbw->commit();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * remove image folder from public view. Make sure that you have them zipped
	 *
	 * @access public
	 */
	public function removeImageDirectory() {
		wfProfileIn( __METHOD__ );
		wfProfileOut( __METHOD__ );
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

	/**
	 * clean wikifactory tables:
	 *
	 *  remove rows from city_variables
	 *  remove rows from city_categories
	 *  remove row from city_list
	 *
	 *  old values will be stored in archive database
	 *
	 *  eventually all tables which use city_id should have foreign key to
	 *  city_list( city_id )
	 */
	public function cleanWikiFactory() {

		// so far return();
		return;

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );

		$dba = wfGetDBExt( DB_MASTER );
		$dba->selectDb( "archive" );

		/**
		 * move city_variables to archive
		 */
		$sth = $dbw->select(
			array( WikiFactory::table( "city_variables" ) ),
			array( "cv_city_id", "cv_variable_id", "cv_value" ),
			array( "cv_city_id" => $this->mCityID ),
			__METHOD__
		);
		$timestamp = wfTimestampNow();
		while( $row = $dbw->fetchObject( $sth ) ) {
			$dba->insert(
				"city_variables",
				array(
					"cv_city_id"     => $row->cv_city_id,
					"cv_variable_id" => $row->cv_variable_id,
					"cv_value"       => $row->cv_value,
					"cv_timestamp"   => $timestamp
				),
				__METHOD__
			);
		}
		$dbw->freeResult( $sth );

		$dbw->begin();
		$dbw->delete(
			WikiFactory::table( "city_variables" ),
			array( "cv_city_id" => $this->mCityID ),
			__METHOD__
		);

		$dbw->commit();
		wfProfileOut( __METHOD__ );
	}
}
