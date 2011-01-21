<?php
/**
 * CreateWiki class
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia Inc.
 * @author Adrian Wieczorek <adi@wikia-inc.com> for Wikia Inc.
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia Inc.
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

class CreateWiki {

	private $mName, $mDomain, $mLanguage, $mHub, $mType, $mStarters,
		$mPHPbin, $mMYSQLbin, $mMYSQLdump, $mNewWiki, $mFounder,
		$mLangSubdomain;

	const ERROR_BAD_EXECUTABLE_PATH      = 1;
	const ERROR_DOMAIN_NAME_TAKEN        = 2;
	const ERROR_DOMAIN_BAD_NAME          = 3;
	const ERROR_DOMAIN_IS_EMPTY          = 4;
	const ERROR_DOMAIN_TOO_LONG          = 5;
	const ERROR_DOMAIN_TOO_SHORT	     = 6;
	const ERROR_DOMAIN_POLICY_VIOLATIONS = 7;
	const ERROR_SQL_FILE_BROKEN          = 8;
	const ERROR_DATABASE_ALREADY_EXISTS  = 9;
	const ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN = 10;


	const IMGROOT           = "/images/";
	const IMAGEURL          = "http://images.wikia.com/";
	const CREATEWIKI_LOGO   = "/images/c/central/images/2/22/Wiki_Logo_Template.png";
	const CREATEWIKI_ICON   = "/images/c/central/images/6/64/Favicon.ico";
	const DEFAULT_STAFF     = "Angela";
	const DEFAULT_USER      = 'Default';
	const DEFAULT_DOMAIN    = "wikia.com";
	const ACTIVE_CLUSTER    = "c3";
	const DEFAULT_NAME      = "Wiki";
	const DEFAULT_WIKI_TYPE = "";


	/**
	 * constructor
	 *
	 * @param string $name - name of wiki (set later as $wgSiteinfo)
	 * @param string $domain - domain part without '.wikia.com'
	 * @param string $language - language code
	 * @param integer $hub - category/hub which should be set for created wiki
	 * @param mixed $type - type of wiki, currently 'answers' for answers or false for others
	 * @param mixed $founder - creator of wiki, by default false which means $wgUser
	 */
	public function __construct( $name, $domain, $language, $hub, $type = self::DEFAULT_WIKI_TYPE, $founder = false ) {
		global $wgUser;

		// wiki containter
		$this->mNewWiki = new stdClass();

		$this->mDomain = $domain;
		$this->mName = $name;
		$this->mLanguage = $language;
		$this->mHub = $hub;
		$this->mType = $type;

		// founder of wiki
		if( $founder === false ) {
			$this->mFounder = $wgUser;
		}
		else {
			if( ! $founder instanceof User ) {
				throw new MWException( "Founder in constructor is not instance of User class" );
			}
			else {
				$this->mFounder = $founder;
			}
		}

		/**
		 * starters map: langcode => database name
		 *
		 * "*" is default
		 * "answers" when $mType = "answers"
		 */
		$this->mStarters = array(
			"*" => array(
				"*"  => "aastarter",
				"en" => "starter",
				"ja" => "jastarter",
				"de" => "destarter",
				"fr" => "frstarter",
				"nl" => "nlstarter",
				"es" => "esstarter",
				"pl" => "plstarter"
			),
			"answers" => array(
				"*"  => "genericstarteranswers",
				"en" => "newstarteranswers",
				"de" => "deuanswers",
				"es" => "esstarteranswers",
				"fr" => "frstarteranswers",
				"he" => "hestarteranswers",
				"ar" => "arstarteranswers",
				"nl" => "nlstarteranswers",
			)
		);
	}


	/**
	 * main entry point, create wiki with given parameters
	 *
	 * @return integer status of operation, 0 for success, non 0 for error
	 */
	public function create() {

		global $wgWikiaLocalSettingsPath, $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		// check executables
		$status = $this->checkExecutables();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			return $status;
		}

		// check domains
		$status = $this->checkDomain();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			return 0;
		}

		// prepare all values needed for creating wiki
		$this->prepareValues( $this->mDomain, $this->mLanguage, $this->mType );

		print_r( $this->mNewWiki );

		if( strpos( $wgWikiaLocalSettingsPath, "central") !== false ) {
			$wgWikiaLocalSettingsPath = str_replace( "central", "wiki.factory", $wgWikiaLocalSettingsPath );
		}


		// start counting time
		$this->mCurrTime = wfTime();
		$startTime = $this->mCurrTime;

		// check and create database
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); # central

		///
		// local database handled is handler to cluster we create new wiki.
		// It doesn't have to be the same like wikifactory cluster or db cluster
		// where Special:CreateWiki exists.
		//
		// @todo do not use hardcoded name, code below is only for test
		//
		// set $activeCluster to false if you want to create wikis on first
		// cluster
		//
		$clusterdb = ( self::ACTIVE_CLUSTER ) ? "wikicities_" . self::ACTIVE_CLUSTER : "wikicities";
		$this->mNewWiki->dbw = wfGetDB( DB_MASTER, array(), $clusterdb ); // database handler, old $dbwTarget

		// check if database is creatable
		// @todo move all database creation checkers to canCreateDatabase
		if( !$this->canCreateDatabase() ) {
			wfDebugLog( "createwiki", "Database {$this->mNewWiki->dbname} exists\n", true );
			wfProfileOut( __METHOD__ );
			return self::ERROR_DATABASE_ALREADY_EXISTS;
		}
		else {
			$this->mNewWiki->dbw->query( sprintf( "CREATE DATABASE `%s`", $this->mNewWiki->dbname ) );
			wfDebugLog( "createwiki", "Database {$this->mNewWiki->dbname} created\n", true );
		}


		/**
		 * create position in wiki.factory
		 * (I like sprintf construction, so sue me)
		 */
		$insertFields = array(
			'city_title'          => $this->mNewWiki->sitename,
			'city_dbname'         => $this->mNewWiki->dbname,
			'city_url'            => $this->mNewWiki->url,
			'city_founding_user'  => $this->mNewWiki->founderId,
			'city_founding_email' => $this->mNewWiki->founderEmail,
			'city_path'           => $this->mNewWiki->path,
			'city_description'    => $this->mNewWiki->sitename,
			'city_lang'           => $this->mNewWiki->language,
			'city_created'        => wfTimestamp( TS_DB, time() ),
		);
		if( self::ACTIVE_CLUSTER ) {
			$insertFields[ "city_cluster" ] = self::ACTIVE_CLUSTER;
		}


		$res = $dbw->insert( "city_list", $insertFields, __METHOD__ );
		if( empty( $res ) ) {
			wfDebugLog( "createwiki", __METHOD__ .": Cannot set data in city_list table\n", true );
			return self::ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN;
		}

		// get city id
		$this->mNewWiki->city_id = $dbw->insertId();
		if( empty( $this->mNewWiki->city_id ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Cannot set data in city_list table. city_id is empty after insert\n", true );
			return self::ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN;
		}

		wfDebugLog( "createwiki", __METHOD__ . ": Creating row in city_list table, city_id = {$this->mNewWiki->city_id}\n", true );

		$res = $dbw->insert(
			"city_domains",
			array(
				array(
					'city_id'     => $this->mNewWiki->city_id,
					'city_domain' => $this->mWikiData[ "domain" ]
				),
				array(
					'city_id'     => $this->mNewWiki->city_id,
					'city_domain' => sprintf( "www.%s", $this->mWikiData[ "domain" ] )
				)
			),
			__METHOD__
		);

		if( empty( $res ) ) {
			$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step3') );
			$this->log( "Cannot set data in city_domains table" );
			$wgOut->addHTML(wfMsg('autocreatewiki-step3-error'));
			return;
		}

		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step3') );
		$this->log( "Populating city_domains" );

		/**
		 * create image folder
		 */
		wfMkdirParents( "{$this->mWikiData[ "images_dir"]}" );
		$this->log( "Create {$this->mWikiData[ "images_dir"]} folder" );
		$this->setInfoLog('OK', wfMsg('autocreatewiki-step1'));
		/**
		 * copy defaul logo & favicon
		 */
		wfMkdirParents("{$this->mWikiData[ "images_logo" ]}");
		wfMkdirParents("{$this->mWikiData[ "images_icon" ]}");

		if (file_exists(self::CREATEWIKI_LOGO)) {
			copy(self::CREATEWIKI_LOGO, "{$this->mWikiData[ "images_logo" ]}/Wiki.png");
		}
		if (file_exists(self::CREATEWIKI_ICON)) {
			copy(self::CREATEWIKI_ICON, "{$this->mWikiData[ "images_icon" ]}/Favicon.ico");
		}
		$this->log( "Coping favicon and logo" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step4') );

		/**
		 * wikifactory variables
		 */
		$this->setWFVariables();
		$this->log( "Populating city_variables" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step5') );

		/**
		 * we got empty database created, now we have to create tables and
		 * populate it with some default values
		 */
		$tmpSharedDB = $wgSharedDB;
		$wgSharedDB = $this->mWikiData[ "dbname"];
		$dbwTarget->selectDB( $this->mWikiData[ "dbname"] );
		$this->log( "Creating tables in database" );

		$sqlfiles = array(
			"{$IP}/maintenance/tables.sql",
			"{$IP}/maintenance/interwiki.sql",
			"{$IP}/maintenance/wikia/city_interwiki_links.sql",
			"{$IP}/extensions/CheckUser/cu_changes.sql",
			"{$IP}/extensions/CheckUser/cu_log.sql",
			"{$IP}/maintenance/archives/wikia/patch-watchlist-improvements.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-blog_listing_relation.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-page_vote.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-page_visited.sql",
		);

		/**
		 * tables which maybe exists or maybe not, better safe than sorry
		 */
		$extrafiles = array(
			"{$IP}/extensions/wikia/AjaxPoll/patch-create-poll_info.sql",
			"{$IP}/extensions/wikia/AjaxPoll/patch-create-poll_vote.sql",
			"{$IP}/extensions/wikia/ImageServing/sql/table.sql"
		);
		foreach( $extrafiles as $file ) {
			if( is_readable( $file ) ) {
				$sqlfiles[] = $file;
			}
		}

		/**
		 * additional tables per type
		 */
		switch( $this->mType ) {
			case "answers":
				$sqlfiles[] = "{$IP}/maintenance/answers-additional-tables.sql";
				break;
		}

		foreach( $sqlfiles as $file ) {
			$error = $dbwTarget->sourceFile( $file );
			$this->log("populating database with $file" );
			if ( $error !== true ) {
				wfProfileOut( __METHOD__ );
				return self::ERROR_SQL_FILE_BROKEN;
			}
		}

		/**
		 * import language starter
		 */
		$starter = $this->getStarter();
		if( $starter !== false ) {
			switch( $this->mType ) {
				case "answers":
					$tables = "categorylinks externallinks image imagelinks langlinks page pagelinks revision templatelinks text user_profile";
					break;

				default:
					$tables = "categorylinks externallinks image imagelinks langlinks page pagelinks revision templatelinks text";
			}
			$cmd = sprintf(
				"%s -h%s -u%s -p%s %s %s | %s -h%s -u%s -p%s %s",
				$this->mMYSQLdump,
				$starter[ "host"      ],
				$starter[ "user"      ],
				$starter[ "password"  ],
				$starter[ "dbStarter" ],
				$tables,
				$this->mMYSQLbin,
				$dbwTarget->getLBInfo( 'host' ),
				$wgDBadminuser,
				$wgDBadminpassword,
				$this->mWikiData[ "dbname"]
			);
			wfShellExec( $cmd );

			$error = $dbwTarget->sourceFile( "{$IP}/maintenance/cleanupStarter.sql" );
			wfDebugLog( "createwiki", __METHOD__ . ": {$IP}/maintenance/cleanupStarter.sql" );

			if ($error !== true) {
				wfProfileOut( __METHOD__ );
				return self::ERROR_SQL_FILE_BROKEN;
			}

			/**
			 * @todo move copying images from local database changes section
			 * use wikifactory variable to determine proper path to images
			 */
			$startupImages = $starter[ "uploadDir" ];

			if (file_exists( $startupImages ) && is_dir( $startupImages ) ) {
				wfShellExec("/bin/cp -af {$startupImages}/* {$this->mWikiData[ "images_dir" ]}/");
				$this->log("/bin/cp -af {$startupImages}/* {$this->mWikiData[ "images_dir" ]}/");
			}
			$cmd = sprintf(
				"SERVER_ID=%d %s %s/maintenance/updateArticleCount.php --update --conf %s",
				$this->mNewWiki->city_id,
				$this->mPHPbin,
				$IP,
				$wgWikiaLocalSettingsPath
			);
			wfShellExec( $cmd );

			$this->log( "Copying starter database" );
		}
		/**
		 * making the wiki founder a sysop/bureaucrat
		 */
		if ( $this->mWikiData[ "founder" ] ) {
			$dbwTarget->replace( "user_groups", array( ), array( "ug_user" => $this->mWikiData[ "founder" ], "ug_group" => "sysop" ) );
			$dbwTarget->replace( "user_groups", array( ), array( "ug_user" => $this->mWikiData[ "founder" ], "ug_group" => "bureaucrat" ) );
		}
		$this->log( "Create user sysop/bureaucrat" );

		/**
		 * set images timestamp to current date (see: #1687)
		 */
		$dbwTarget->update("image", array( "img_timestamp" => date('YmdHis') ), "*", __METHOD__ );
		$this->log( "Set images timestamp to current date" );

		/**
		 * init site_stats table (add empty row)
		 */
		$dbwTarget->insert( "site_stats", array( "ss_row_id" => "1"), __METHOD__ );

		/**
		 * add local job
		 */
		$localJob = new AutoCreateWikiLocalJob(	Title::newFromText( NS_MAIN, "Main" ), $this->mWikiData );
		$localJob->WFinsert( $this->mNewWiki->city_id, $this->mWikiData[ "dbname" ] );

		/**
		 * destroy connection to newly created database
		 */
		$dbwTarget->commit();
		$wgSharedDB = $tmpSharedDB;

		/**
		 * set hub/category
		 */
		$hub = WikiFactoryHub::getInstance();
		$hub->setCategory( $this->mNewWiki->city_id, $this->mWikiData[ "hub" ] );
		$this->log( "Wiki added to the category hub " . $this->mWikiData[ "hub" ] );

		/**
		 * define wiki type
		 */
		$wiki_type = ( !empty($this->mType) ) ? $this->mType : self::DEFAULT_WIKI_TYPE;

		/**
		 * modify variables
		 */
		$this->addCustomSettings( 0, $wgUniversalCreationVariables[$wiki_type], "universal" );

		/**
		 * set variables per language
		 */
		$this->addCustomSettings(
			$this->mWikiData[ "language" ],
			isset($wgLangCreationVariables[$wiki_type]) ? $wgLangCreationVariables[$wiki_type] : $wgLangCreationVariables,
			"language"
		);

		/**
		 * move main page
		 */
		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/wikia/moveMain.php -t '%s' --conf %s",
			$this->mNewWiki->city_id,
			$this->mPHPbin,
			$IP,
			$this->mNewWiki->sitename,
			$wgWikiaLocalSettingsPath
		);
		$output = wfShellExec( $cmd );

		/**
		 * show congratulation message
		 */

		/**
		 * inform task manager
		 */
		$Task = new LocalMaintenanceTask();
		$Task->createTask(
			array(
				"city_id" 	=> $this->mNewWiki->city_id,
				"command" 	=> "maintenance/runJobs.php",
				"type" 		=> "ACWLocal",
				"data" 		=> $this->mWikiData
			),
			TASK_QUEUED
		);
		$this->log( "Add local maintenance task" );

		wfProfileOut( __METHOD__ );

		/**
		 * return success
		 */
		return 0;
	}


	/**
	 * check for executables needed for creating wiki
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return integer status of check, 0 for success, non 0 otherwise
	 */
	private function checkExecutables( ) {
		/**
		 * set paths for external tools
		 */
		$this->mPHPbin = "/usr/bin/php";
		if( !file_exists( $this->mPHPbin ) && !is_executable( $this->mPHPbin ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": {$this->mPHPbin} doesn't exists or is not executable\n", true );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}

		$this->mMYSQLdump = "/usr/bin/mysqldump";
		if( !file_exists( $this->mMYSQLdump ) && !is_executable( $this->mMYSQLdump ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": {$this->mMYSQLdump} doesn't exists or is not executable\n", true );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}

		$this->mMYSQLbin = "/usr/bin/mysql";
		if( !file_exists( $this->mMYSQLbin ) && !is_executable( $this->mMYSQLbin ) ) {
			wfDebug( __METHOD__ . ": {$this->mMYSQLbin} doesn't exists or is not executable\n" );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}
		return 0;
	}

	/**
	 * check if domain is not taken or is creatable
	 */
	private function checkDomain() {

		global $wgUser;

		$status = 0;

		wfProfileIn(__METHOD__);

		if( strlen( $this->mDomain ) === 0 ) {
			// empty field
			$status = self::ERROR_DOMAIN_IS_EMPTY;
		}
		elseif ( strlen( $this->mDomain ) < 3 ) {
			// too short
			$status = self::ERROR_DOMAIN_TOO_SHORT;
		}
		elseif ( strlen( $this->mDomain ) > 50 ) {
			// too long
			$status = self::ERROR_DOMAIN_TOO_LONG;
		}
		elseif (preg_match('/[^a-z0-9-]/i', $this->mDomain ) ) {
			// invalid name
			$status = self::ERROR_DOMAIN_BAD_NAME;
		}
		elseif ( in_array( $this->mDomain, array_keys( Language::getLanguageNames() ) ) ) {
			// invalid name (name is used language)
			$status = self::ERROR_DOMAIN_POLICY_VIOLATIONS;
		}
		elseif ( !$wgUser->isAllowed( "staff" ) && ( AutoCreateWiki::checkBadWords( $this->mDomain, "domain" ) === false ) ) {
			// invalid name (bad words)
			$status = self::ERROR_DOMAIN_POLICY_VIOLATIONS;
		}
		else {
			if( AutoCreateWiki::domainExists( $this->mDomain, $this->mLanguage, $this->mType ) ) {
				$status = self::ERROR_DOMAIN_NAME_TAKEN;
			}
		}

		return 0;
	}

	/**
	 * prepare default values
	 *
	 * @access private
	 *
	 * @author Piotr Molski
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @param
	 */
	private function prepareValues() {
		global $wgUser, $wgContLang;

		wfProfileIn( __METHOD__ );

		$this->fixSubdomains( $this->mLanguage );

		// sitename
		$fixedTitle = trim( $this->mName );
		$fixedTitle = preg_replace("/\s+/", " ", $fixedTitle );
		$fixedTitle = preg_replace("/ (w|W)iki$/", "", $fixedTitle );
		$fixedTitle = $wgContLang->ucfirst( $fixedTitle );
		$this->mNewWiki->sitename = wfMsgExt( 'autocreatewiki-title-template', array( 'language' => $this->mLanguage ), $fixedTitle );

		// domain part
		$this->mDomain = preg_replace( "/(\-)+$/", "", $this->mDomain );
		$this->mDomain = preg_replace( "/^(\-)+/", "", $this->mDomain );
		$this->mNewWiki->domain = strtolower( trim( $this->mDomain ) );

		// hub
		$this->mNewWiki->hub = $this->mHub;

		// name
		$this->mNewWiki->name = strtolower( trim( $this->mDomain ) );

		switch( $this->mType ) {
			case "answers":
				$this->mNewWiki->sitename = $fixedTitle . " " . $this->mDefSitename;
				break;
		}

		$this->mNewWiki->language  = $this->mLanguage;
		$this->mNewWiki->subdomain = $this->mNewWikiname->name;
		$this->mNewWiki->redirect  = $this->mNewWikiname->name;

		$this->mNewWiki->path = "/usr/wikia/docroot/wiki.factory";

		$this->mNewWiki->images_url = $this->prepareDirValue( $this->mNewWiki->name, $this->mNewWiki->language );
		$this->mNewWiki->images_dir = sprintf("%s/%s", strtolower( substr( $this->mNewWiki->name, 0, 1 ) ), $this->mNewWiki->images_url );

		if ( isset( $this->mNewWiki->language ) && $this->mNewWiki->language !== "en" ) {
			if ( $this->mLangSubdomain ) {
				$this->mNewWiki->subdomain  = strtolower( $this->mNewWiki->language ) . "." . $this->mNewWiki->name;
				$this->mNewWiki->redirect  = strtolower( $this->mNewWiki->language ) . "." . ucfirst( $this->mNewWiki->name );
			}
			$this->mNewWiki->images_url .= "/" . strtolower( $this->mNewWiki->language );
			$this->mNewWiki->images_dir .= "/" . strtolower( $this->mNewWiki->language );
		}

		switch( $this->mType ) {
			case "answers":
				$this->mNewWiki->images_url .= "/" . $this->mType;
				$this->mNewWiki->images_dir .= "/" . $this->mType;
				break;
		}

		$this->mNewWiki->images_dir = self::IMGROOT  . $this->mNewWiki->images_dir . "/images";
		$this->mNewWiki->images_url = self::IMAGEURL . $this->mNewWiki->images_url . "/images";
		$this->mNewWiki->images_logo = sprintf("%s/%s", $this->mNewWiki->images_dir, "b/bc" );
		$this->mNewWiki->images_icon = sprintf("%s/%s", $this->mNewWiki->images_dir, "6/64" );
		$this->mNewWiki->domain = sprintf("%s.%s", $this->mNewWiki->subdomain, $this->mDefSubdomain);
		$this->mNewWiki->url = sprintf( "http://%s.%s/", $this->mNewWiki->subdomain, $this->mDefSubdomain );
		$this->mNewWiki->dbname = $this->prepareDatabaseName( $this->mNewWiki->name, $this->mLanguage );
		$this->mNewWiki->founderName = $this->mFounder->getName();
		$this->mNewWiki->founderEmail = $this->mFounder->getEmail();
		$this->mNewWiki->founderId = $this->mFounder->getId();
		$this->mNewWiki->type = $this->mType;

		wfProfileOut( __METHOD__ );

		return $this->mNewWiki;
	}

	/**
	 * set subdomain name
	 *
	 * @access private
	 * @author Piotr Molski (moli)
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return
	 */
	private function fixSubdomains( $lang ) {

		global $wgContLang;

		wfProfileIn( __METHOD__ );
		switch( $this->mType ) {
			case "answers":
				$this->mDomains = Wikia::getAnswersDomains();
				print_r( $this->mDomains );
				$this->mSitenames = Wikia::getAnswersSitenames();
				if( isset($this->mDomains[ $lang ] ) && !empty( $this->mDomains[ $lang ] ) ) {
					$this->mDefSubdomain = sprintf( "%s.%s", $this->mDomains[$lang], self::DEFAULT_DOMAIN );
					$this->mLangSubdomain = false;
				}
				else {
					$this->mDefSubdomain = sprintf( "%s.%s", $this->mDomains[ "default"], self::DEFAULT_DOMAIN );
					$this->mLangSubdomain = true;
				}

				if( isset( $this->mSitenames[ $lang ] ) ) {
					$this->mDefSitename = $this->mSitenames[ $lang ];
				}
				elseif ( isset( $this->mDomains[ $lang ] ) && !empty( $this->mDomains[ $lang ] ) ) {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains[ $lang ] );
				}
				else {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains[ 'default' ] );
				}
				break;

			default:
				$this->mDefSubdomain = self::DEFAULT_DOMAIN;
				$this->mDefSitename = self::DEFAULT_NAME;
				$this->mDomains = array('default' => '');
				$this->mSitenames = array();
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * check folder exists
	 *
	 * @access private
	 * @author Piotr Molski (Moli)
	 *
	 * @param
	 */
	private function prepareDirValue( $name, $language ) {
		wfProfileIn( __METHOD__ );

		wfDebug( __METHOD__ . ": Checking {$name} folder" );

		$isExist = false; $suffix = "";
		$prefix = strtolower( substr( $name, 0, 1 ) );
		$dir_base = $name;
		$dir_lang = ( isset( $language ) && $language !== "en" )
				? "/" . strtolower( $language )
				: "";

		while ( $isExist == false ) {
			switch( $this->mType ) {
				case "answers":
					$dirName = self::IMGROOT . $prefix . "/" . $dir_base . $suffix . $dir_lang . "/answers/images";
					break;
				default:
					$dirName = self::IMGROOT . $prefix . "/" . $dir_base . $suffix . $dir_lang . "/images";
			}

			if ( file_exists( $dirName ) ) {
				$suffix = rand(1, 9999);
			}
			else {
				$dir_base = $dir_base . $suffix;
				$isExist = true;
			}
		}

		wfProfileOut( __METHOD__ );
		return $dir_base;
	}

	/**
	 * prepareDatabaseName
	 *
	 * check if database name is used, if it's used prepare another one
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 * @param string	$dbname -- name of DB to check
	 * @param string	$lang   -- language for wiki
	 *
	 * @todo when second cluster will come this function has to changed
	 *
	 * @return string: fixed name of DB
	 */
	private function prepareDatabaseName( $dbname, $lang ) {

		wfProfileIn( __METHOD__ );

		$dbwf = WikiFactory::db( DB_SLAVE );
		$dbr  = wfGetDB( DB_MASTER );

		wfDebugLog( "createwiki", __METHOD__, ": checking database name for dbname=$dbname, language={$lang} type={$this->mType}\n", true );
		/**
		 * for other types add type name in database
		 */
		if( $this->mType ) {
			$dbname = $dbname . $this->mType;
		}

		if( $lang !== "en" ) {
			$dbname = $lang . $dbname;
		}

		$dbname = substr( str_replace( "-", "", $dbname ), 0 , 50 );

		/**
		 * check city_list
		 */
		$exists = 1;
		$suffix = "";
		while( $exists == 1 ) {
			$dbname = sprintf("%s%s", $dbname, $suffix);
			wfDebugLog( "createwiki", __METHOD__, ": Checking if database {$dbname} already exists in city_list\n", true );
			$row = $dbwf->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbname ),
				__METHOD__
			);
			$exists = 0;
			if( $row->count > 0 ) {
				wfDebugLog( "createwiki", __METHOD__, ": Database {$dbname} exists in city_list!\n", true );
				$exists = 1;
			}
			else {
				wfDebugLog( "createwiki", __METHOD__, ": Checking if database {$dbname} already exists in database", true );
				$sth = $dbr->query( sprintf( "show databases like '%s'", $dbname) );
				if ( $dbr->numRows( $sth ) > 0 ) {
					wfDebugLog( "createwiki", __METHOD__, ": Database {$dbname} exists on cluster!", true );
					$exists = 1;
				}
			}
			# add suffix
			if( $exists == 1 ) {
				$suffix = rand( 1, 999 );
			}
		}
		wfProfileOut( __METHOD__ );

		return $dbname;
	}

	/**
	 * can create database?
	 * @todo this code is probably duplication of other checkers
	 */
	private function canCreateDatabase() {

		// default response
		$can = true;

		// check local cluster
		$row = $this->mNewWiki->dbw->selectRow(
			"INFORMATION_SCHEMA.SCHEMATA",
			array( "SCHEMA_NAME as name" ),
			array( 'SCHEMA_NAME' => $this->mNewWiki->dbname ),
			__METHOD__
		);

		if( isset( $row->name ) && $row->name === $this->mNewWiki->dbname ) {
			wfDebugLog( "createwiki", __METHOD__ . ": database {$this->mNewWiki->dbname} already exists on active cluster\n" );
			$can = false;
		}
		else {
			// check city_list
			$dbw = WikiFactory::db( DB_MASTER );
			$row = $dbw->selectRow(
				"city_list",
				array( "count(*) as count" ),
				array( "city_dbname" => $this->mNewWiki->dbname ),
				__METHOD__
			);

			if( $row->count > 0 ) {
				wfDebugLog( "createwiki", __METHOD__ . ": database {$this->mNewWiki->dbname} already used in city_list\n" );
				$can = false;
			} else {
				// check domain
				$row = $dbw->selectRow(
					"city_list",
					array( "count(*) as count" ),
					array( "city_url" => $this->mNewWiki->url ),
					__METHOD__
				);
				if( $row->count > 0 ) {
					wfDebugLog( "createwiki", __METHOD__ . ": domain {$this->mNewWiki->url} already used in city_list\n" );
					$can = false;
				}
			}
		}
		return $can;
	}
}
