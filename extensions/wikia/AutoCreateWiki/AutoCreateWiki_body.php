<?php
/**
 * Main part of Special:AutoCreateWiki
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

class AutoCreateWikiPage extends SpecialPage {

	private
		$mTitle,
		$mAction,
		$mSubpage,
		$mWikiData,
		$mMYSQLdump,
		$mMYSQLbin,
		$mPHPbin,
		$mImagesDir,
		$mCurrTime;

	/**
	 * test database, CAUTION! content will be destroyed during tests
	 */
	const TESTDB = "testdb";
	const GAMING = 2;
	const ENTERTAINMENT = 3;
	const LOG = "autocreatewiki";

	/**
	 * constructor
	 */
	public function  __construct() {
		parent::__construct( "AutoCreateWiki" /*class*/ );

		/**
		 * initialize some data
		 */
		$this->mWikiData = array();
		$this->mImagesDir = "/images/";

		/**
		 * set paths for external tools
		 */
		$this->mPHPbin =
			( file_exists("/usr/bin/php") && is_executable( "/usr/bin/php" ))
			? "/usr/bin/php" : "/opt/wikia/php/bin/php";

		$this->mMYSQLdump =
			( file_exists("/usr/bin/mysqldump") && is_executable( "/usr/bin/mysqldump" ))
			? "/usr/bin/mysqldump" : "/opt/wikia/bin/mysqldump";

		$this->mMYSQLbin =
			( file_exists("/usr/bin/mysql") && is_executable("/usr/bin/mysql") )
			? "/usr/bin/mysql" : "/opt/wikia/bin/mysql";
	}

	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		global $wgRequest;
		wfLoadExtensionMessages( "AutoCreateWiki" );

		$this->setHeaders();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AutoCreateWiki" );
		$this->mAction = $wgRequest->getVal( "action", false );
		$this->mSubpage = $subpage;

		$this->create();
	}

	/**
	 * main function for extension -- create wiki in wikifactory cluster
	 */
	private function create() {

		global $wgDebugLogGroups;
		$wgDebugLogGroups[ self::LOG ] = "/tmp/autocreatewiki.log";

		wfProfileIn( __METHOD__ );

		/**
		 * this will clean test database and fill mWikiData with test data
		 */
		$this->prepareTest();
		print_pre( $this->mWikiData );

		$this->mCurrTime = wfTime();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * prepareTest, clear test database
	 */
	private function prepareTest() {

		global $wgContLang;

		$languages = array( "de", "en", "pl", "fr", "es" );
		shuffle( $languages );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->query( sprintf( "DROP DATABASE IF EXISTS %s", self::TESTDB ) );

		$this->mWikiData[ "hub" ]		= rand( 1, 19 );
        $this->mWikiData[ "name"]       = strtolower( trim( self::TESTDB ) );
        $this->mWikiData[ "title" ]     = trim( $wgContLang->ucfirst( self::TESTDB ) . " Wiki" );
        $this->mWikiData[ "language" ]  = array_shift( $languages );
        $this->mWikiData[ "subdomain" ] = $this->mWikiData[ "name"];
        $this->mWikiData[ "redirect"]   = $this->mWikiData[ "name"];
		$this->mWikiData[ "dir_part"]   = $this->mWikiData[ "name"];
		$this->mWikiData[ "dbname"]     = substr( $this->mWikiData[ "name"], 0, 64);
		$this->mWikiData[ "path"]       = "/usr/wikia/docroot/wiki.factory";
        $this->mWikiData[ "images"]     = $this->mImagesDir . $this->mWikiData[ "name"];
        $this->mWikiData[ "testWiki"]   = true;

        if( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" ) {
			$this->mWikiData[ "subdomain"] = strtolower( $this->mWikiData[ "language"] ) . "." . $this->mWikiData[ "name"];
			$this->mWikiData[ "redirect"] = strtolower( $this->mWikiData[ "language" ] ) . "." . ucfirst( $this->mWikiData[ "name"] );
			$this->mWikiData[ "images"] .= "/" . strtolower( $this->mWikiData[ "language" ] );
			$this->mWikiData[ "dbname"] = strtolower(str_replace("-","", $this->mWikiData[ "language" ] ). $this->mWikiData[ "dbname"] );
			$this->mWikiData[ "dir_part"] .= "/".strtolower( $this->mWikiData[ "language" ] );
		}

		/**
		 * clear wikifactory tables: city_list, city_variables, city_domains
		 */
		$city_id = WikiFactory::DBtoID( self::TESTDB );
		if( $city_id ) {
			$dbw->begin();
			$dbw->delete(
				wfSharedTable( "city_domains" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);
			$dbw->delete(
				wfSharedTable( "city_variables" ),
				array( "cv_city_id" => $city_id ),
				__METHOD__
			);
			$dbw->delete(
				wfSharedTable( "city_cat_mapping" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);
			$dbw->commit();

		}
	}

	/**
	 * common log function
	 */
	private function log( $info ) {
		global $wgOut;

		$info = sprintf( "%s: %F", $info, wfTime() - $this->mCurrTime );
		wfDebugLog( self::log, $info );
		Wikia::log( self::log, $info );
		$wgOut->addHtml( $info ."<br />" );

		$this->mCurrTime = wfTime();
	}
}
