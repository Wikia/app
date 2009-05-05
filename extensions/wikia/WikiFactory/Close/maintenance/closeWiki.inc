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
	 *
	 * @param boolean $setupif true just create directory tree and HTML index
	 */
	public function execute( $setup ) {
		global $wgCityId, $wgDBname, $wgServer;

		$this->mCityID = $wgCityId;

		if( $setup ) {
			$this->setupDirectories();
		}
		elseif( !wfReadOnly() ) {
			/**
			 * check what we have to do with this wikia
			 */
			if( $wgCityId ) {
				$Wiki = WikiFactory::getWikiByID( $wgCityId );
				$this->mAction = $Wiki->city_public;
			}
			switch( $this->mAction ) {

				case WikiFactory::STATUS_OPEN:
					$this->dumpXMl();
					$this->compressImages();
					$this->createIndex( $wgDBname, $wgServer );
					break;

				case WikiFactory::STATUS_CLOSED:
					$this->dumpXMl();
					$this->compressImages();
					$this->createIndex( $wgDBname, $wgServer );
					$this->removeImageDirectory();
					break;

				case WikiFactory::STATUS_DELETE:
					$this->dumpXMl();
					$this->compressImages();
					$this->removeImageDirectory();
					$this->cleanWikiFactory();
					$this->dropDB();
					break;
			}
		}
		return true;
	}

	public function dumpXMl() {
		global $wgDBname, $wgDBuser, $wgDBpassword;
		Wikia::log( __CLASS__, "$wgDBuser : $wgDBpassword" );
		/**
		 * @name dumpfile
		 */
		$dumpfile = sprintf("%s/full.xml.gz", $this->getDirectory( $wgDBname ) );
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
		$zipfile = sprintf("%s/images.zip", $this->getDirectory( $wgDBname ) );
		if( is_file( $zipfile ) ) {
			unlink( $zipfile );
		}
		Wikia::log( __CLASS__, "", "Zipping images from {$wgUploadDirectory} to {$zipfile}" );

		$zip = new ZipArchive();

		if ($zip->open( $zipfile, ZIPARCHIVE::CREATE ) !== true ) {
			Wikia::log( __CLASS__, "zip", "Cannot open {$zipfile}" );
			wfDie( "Cannot open {$zipfile}" );
		}

		foreach( $this->getFilesList() as $file ) {
			if( is_file( $file ) ) {
				Wikia::log( __METHOD__, "zip", "Adding {$file}" );
				$zip->addFile( $file, ltrim( $file, "/" ) );
			}
		}
		$status = $zip->status;
		Wikia::log( __CLASS__, "zip", "Added {$zip->numFiles} files, {$status}" );
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

		/**
		 * get archived images too
		 */

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

		wfProfileIn( __METHOD__ );

		/**
		 * do only on inactive wikis
		 */
		$wiki = WikiFactory::getWikiByID( $this->mCityID );
		if( isset( $wiki->city_id ) && $wiki->city_public != 1 ) {

			$timestamp = wfTimestampNow();
			$dbw = wfGetDB( DB_MASTER );
			$dba = wfGetDBExt( DB_MASTER );
			$dba->selectDb( "archive" );

			$dba->begin();

			/**
			 * copy city_list to archive
			 */
			$dba->insert(
				"city_list",
				array(
					"city_id"                => $wiki->city_id,
					"city_path"              => $wiki->city_path,
					"city_dbname"            => $wiki->city_dbname,
					"city_sitename"          => $wiki->city_sitename,
					"city_url"               => $wiki->city_url,
					"city_created"           => $wiki->city_created,
					"city_founding_user"     => $wiki->city_founding_user,
					"city_adult"             => $wiki->city_adult,
					"city_public"            => $wiki->city_public,
					"city_additional"        => $wiki->city_additional,
					"city_description"       => $wiki->city_description,
					"city_title"             => $wiki->city_title,
					"city_founding_email"    => $wiki->city_founding_email,
					"city_lang"              => $wiki->city_lang,
					"city_special_config"    => $wiki->city_special_config,
					"city_umbrella"          => $wiki->city_umbrella,
					"city_ip"                => $wiki->city_ip,
					"city_google_analytics"  => $wiki->city_google_analytics,
					"city_google_search"     => $wiki->city_google_search,
					"city_google_maps"       => $wiki->city_google_maps,
					"city_indexed_rev"       => $wiki->city_indexed_rev,
					"city_deleted_timestamp" => $timestamp,
					"city_factory_timestamp" => $timestamp,
					"city_useshared"         => $row->city_useshared,
					"ad_cat"                 => $row->ad_cat,
				),
				__METHOD__
			);
			$dba->commit();

			/**
			 * move city_variables to archive
			 */
			$sth = $dbw->select(
				array( WikiFactory::table( "city_variables" ) ),
				array( "cv_city_id", "cv_variable_id", "cv_value" ),
				array( "cv_city_id" => $this->mCityID ),
				__METHOD__
			);
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

			$dbw->delete(
				WikiFactory::table( "city_list_log" ),
				array( "cv_city_id" => $this->mCityID ),
				__METHOD__
			);

			$dbw->delete(
				WikiFactory::table( "city_list" ),
				array( "city_id" => $this->mCityID ),
				__METHOD__
			);

			$dbw->commit();
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * go trough *ALL* city_list and crete directories for dump
	 *
	 * @access private
	 *
	 * @param string $database city_dbname  in city_list
	 * @param string $url city_url in city_list
	 */
	private function createIndex( $database, $url ) {

		$directory = $this->getDirectory( $database );
		$haveXml = is_file( "{$directory}/full.xml.gz" ) ? true : false;
		$haveZip = is_file( "{$directory}/images.zip" ) ? true : false;

		$Tmpl = new EasyTemplate( dirname( __FILE__) . "/../templates/" );
		$Tmpl->set( "directory", $directory );
		$Tmpl->set( "haveXml", $haveXml );
		$Tmpl->set( "haveZip", $haveZip );
		$Tmpl->set( "database", $database );
		$Tmpl->set( "url", $url );
		if( file_put_contents( "{$directory}/index.html", $Tmpl->render( "index-html" ) ) ) {
			Wikia::log( __CLASS__, "index", "create {$directory}/index.html" );
		}
	}

	/**
	 * go trough *ALL* city_list and crete directories for dump
	 */
	public function setupDirectories() {

		$dbr = wfGetDB( DB_SLAVE );
		$sth = $dbr->select(
			WikiFactory::table( "city_list" ),
			array( "city_id", "city_dbname", "city_url" ),
			false,
			__METHOD__
		);
		while( $row = $dbr->fetchObject( $sth ) ) {
			$this->createIndex( $row->city_dbname, $row->city_url );
		}
	}

	/**
	 * dump directory is created as
	 *
	 * <root>/<first letter>/<two first letters>/<database>
	 */
	private function getDirectory( $database ) {
		$database = strtolower( $database );
		$directory = sprintf(
			"%s/%s/%s/%s",
			$this->mDumpDirectory,
			substr( $database, 0, 1),
			substr( $database, 0, 2),
			$database
		);
		if( !is_dir( $directory ) ) {
			Wikia::log( __CLASS__ , "dir", "create {$directory}" );
			wfMkdirParents( $directory );
		}

		return $directory;
	}
}
