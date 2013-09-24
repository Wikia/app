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

	/* @var $mDBw DatabaseMysql */
	private $mName, $mDomain, $mLanguage, $mHub, $mStarters, $mIP,
		$mPHPbin, $mMYSQLbin, $mMYSQLdump, $mNewWiki, $mFounder,
		$mLangSubdomain, $mDBw, $mWFSettingVars, $mWFVars,
		$mDefaultTables, $mAdditionalTables,
		$mStarterTables, $sDbStarter, $mFounderIp,
		$mCurrTime;

	const ERROR_BAD_EXECUTABLE_PATH                    = 1;
	const ERROR_DOMAIN_NAME_TAKEN                      = 2;
	const ERROR_DOMAIN_BAD_NAME                        = 3;
	const ERROR_DOMAIN_IS_EMPTY                        = 4;
	const ERROR_DOMAIN_TOO_LONG                        = 5;
	const ERROR_DOMAIN_TOO_SHORT	                   = 6;
	const ERROR_DOMAIN_POLICY_VIOLATIONS               = 7;
	const ERROR_SQL_FILE_BROKEN                        = 8;
	const ERROR_DATABASE_ALREADY_EXISTS                = 9;
	const ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN    = 10;
	const ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN  = 11;
	const ERROR_USER_IN_ANON                           = 12;
	const ERROR_READONLY                               = 13;
	const ERROR_DBLIGHTMODE                            = 14;
	const ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN     = 15;

	const IMGROOT              = "/images/";
	const IMAGEURL             = "http://images.wikia.com/";
	const CREATEWIKI_LOGO      = "http://images.wikia.com/central/images/2/22/Wiki_Logo_Template.png";
	const CREATEWIKI_ICON      = "http://images.wikia.com/central/images/6/64/Favicon.ico";
	const DEFAULT_STAFF        = "Angela";
	const DEFAULT_USER         = 'Default';
	const DEFAULT_DOMAIN       = "wikia.com";
	const ACTIVE_CLUSTER       = "c5";
	const DEFAULT_SLOT         = "slot1";
	const DEFAULT_NAME         = "Wiki";
	const DEFAULT_WIKI_TYPE    = "";
	const DEFAULT_WIKI_LOGO    = '$wgUploadPath/b/bc/Wiki.png';
	const DEFAULT_WIKI_FAVICON = '$wgUploadPath/6/64/Favicon.ico';


	/**
	 * constructor
	 *
	 * @param string $name - name of wiki (set later as $wgSiteinfo)
	 * @param string $domain - domain part without '.wikia.com'
	 * @param string $language - language code
	 * @param integer $hub - category/hub which should be set for created wiki
	 */
	public function __construct( $name, $domain, $language, $hub ) {
		global $wgUser, $IP, $wgAutoloadClasses, $wgRequest;

		// wiki containter
		$this->mNewWiki = new stdClass();

		$this->mDomain = $domain;
		$this->mName = $name;
		$this->mLanguage = $language;
		$this->mHub = $hub;
		$this->mIP = $IP;

		// founder of wiki
		$this->mFounder = $wgUser;
		$this->mFounderIp = $wgRequest->getIP();

		wfDebugLog( "createwiki", "founder: " . print_r($this->mFounder, true) . "\n", true );
		/**
		 * starters map: langcode => database name
		 *
		 * "*" is default
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
				"pl" => "plstarter",
				"ru" => "rustarter",
			)
		);

		$this->mStarterTables = array(
			"*" => array(
				'categorylinks',
				'externallinks',
				'langlinks',
				'page',
				'pagelinks',
				'revision',
				'templatelinks',
				'text'
			)
		);

		/* default tables */
		$this->mDefaultTables = array(
			"{$this->mIP}/maintenance/tables.sql",
			"{$this->mIP}/maintenance/interwiki.sql",
			"{$this->mIP}/maintenance/wikia/city_interwiki_links.sql",
			"{$this->mIP}/extensions/CheckUser/cu_changes.sql",
			"{$this->mIP}/extensions/CheckUser/cu_log.sql",
			"{$this->mIP}/maintenance/archives/wikia/patch-watchlist-improvements.sql",
			"{$this->mIP}/maintenance/archives/wikia/patch-create-blog_listing_relation.sql",
			"{$this->mIP}/maintenance/archives/wikia/patch-create-page_vote.sql",
			"{$this->mIP}/maintenance/archives/wikia/patch-create-page_visited.sql",
			//article comments list use by wall/forum
			"{$this->mIP}/extensions/wikia/ArticleComments/patch-create-comments_index.sql",
			//wall history table
			"{$this->mIP}/extensions/wikia/Wall/sql/wall_history_local.sql",
			"{$this->mIP}/extensions/wikia/VideoHandlers/sql/video_info.sql",
			"{$this->mIP}/maintenance/wikia/wikia_user_properties.sql",
		);

		/**
		 * tables which maybe exists or maybe not, better safe than sorry
		 */
		$this->mAdditionalTables = array(
			"{$this->mIP}/extensions/wikia/AjaxPoll/patch-create-poll_info.sql",
			"{$this->mIP}/extensions/wikia/AjaxPoll/patch-create-poll_vote.sql",
			"{$this->mIP}/extensions/wikia/ImageServing/sql/table.sql",
		);

		/**
		 * local job
		 */
		$wgAutoloadClasses[ "CreateWikiLocalJob" ] = __DIR__ . "/CreateWikiLocalJob.php";
	}


	/**
	 * main entry point, create wiki with given parameters
	 *
	 * @return integer status of operation, 0 for success, non 0 for error
	 */
	public function create() {
		global $wgWikiaLocalSettingsPath, $wgExternalSharedDB, $wgSharedDB, $wgUser;

		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return self::ERROR_READONLY;
		}

		if ( wfIsDBLightMode() ) {
			wfProfileOut( __METHOD__ );
			return self::ERROR_DBLIGHTMODE;
		}

		// check founder
		if ( $this->mFounder->isAnon() ) {
			wfProfileOut( __METHOD__ );
			return self::ERROR_USER_IN_ANON;
		}

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
			return $status;
		}

		// prepare all values needed for creating wiki
		$this->prepareValues();

		// prevent domain to be registered more than once
		if ( !AutoCreateWiki::lockDomain($this->mDomain) ) {
			wfProfileOut( __METHOD__ );
			return self::ERROR_DOMAIN_NAME_TAKEN;
		}

		// start counting time
		$this->mCurrTime = wfTime();

		// check and create database
		$this->mDBw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); # central

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
		if ( ! $this->addToCityList() ) {
			wfDebugLog( "createwiki", __METHOD__ .": Cannot set data in city_list table\n", true );
			wfProfileOut( __METHOD__ );
			return self::ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN;
		}

		// set new city_id
		$this->mNewWiki->city_id = $this->mDBw->insertId();
		if ( empty( $this->mNewWiki->city_id ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Cannot set data in city_list table. city_id is empty after insert\n", true );
			wfProfileOut( __METHOD__ );
			return self::ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN;
		}

		wfDebugLog( "createwiki", __METHOD__ . ": Row added added into city_list table, city_id = {$this->mNewWiki->city_id}\n", true );

		/**
		 * add domain and www.domain to the city_domains table
		 */
		if ( ! $this->addToCityDomains() ) {
			wfDebugLog( "createwiki", __METHOD__ .": Cannot set data in city_domains table\n", true );
			wfProfileOut( __METHOD__ );
			return self::ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN;
		}

		wfDebugLog( "createwiki", __METHOD__ . ": Row added into city_domains table, city_id = {$this->mNewWiki->city_id}\n", true );

		/**
		 * create image folder
		 */
		global $wgEnableSwiftFileBackend;
		if (empty($wgEnableSwiftFileBackend)) {
			wfMkdirParents( "{$this->mNewWiki->images_dir}" );
			wfDebugLog( "createwiki", __METHOD__ . ": Folder {$this->mNewWiki->images_dir} created\n", true );
		}

		/**
		 * copy default logo & favicon
		 */
		$uploader = User::newFromName( 'CreateWiki script' );

		$res = ImagesService::uploadImageFromUrl( self::CREATEWIKI_LOGO, (object) ['name' => 'Wiki.png'], $uploader );
		if ( $res['status'] === true ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Default logo has been uploaded\n", true );
		} else {
			wfDebugLog( "createwiki", __METHOD__ . ": Default logo has not been uploaded - " . print_r($res['errors'], true) . "\n", true );
		}

		$res = ImagesService::uploadImageFromUrl( self::CREATEWIKI_ICON, (object) ['name' => 'Favicon.ico'], $uploader );
		if (  $res['status'] == true  ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Default favicon has been uploaded\n", true );
		} else {
			wfDebugLog( "createwiki", __METHOD__ . ": Default favicon has not been uploaded - " . print_r($res['errors'], true) . "\n", true );
		}

		/**
		 * wikifactory variables
		 */
		wfDebugLog( "createwiki", __METHOD__ . ": Populating city_variables\n", true );
		$this->setWFVariables();

		$tmpSharedDB = $wgSharedDB;
		$wgSharedDB = $this->mNewWiki->dbname;

		/**
		 * we got empty database created, now we have to create tables and
		 * populate it with some default values
		 */
		wfDebugLog( "createwiki", __METHOD__ . ": Creating tables in database\n", true );

		$this->mNewWiki->dbw = wfGetDB( DB_MASTER, array(), $this->mNewWiki->dbname );

		if ( !$this->createTables() ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Creating tables not finished\n", true );
			wfProfileOut( __METHOD__ );
			return self::ERROR_SQL_FILE_BROKEN;
		}

		/**
		 * import language starter
		 */
		if ( !$this->importStarter() ) {
			wfProfileOut( __METHOD__ );
			return self::ERROR_SQL_FILE_BROKEN;
		}

		/**
		 * making the wiki founder a sysop/bureaucrat
		 */
		wfDebugLog( "createwiki", __METHOD__ . ": Create user sysop/bureaucrat for user: {$this->mNewWiki->founderId} \n", true );
		if ( !$this->addUserToGroups() ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Create user sysop/bureaucrat for user: {$this->mNewWiki->founderId} failed \n", true );
		}


		/**
		 * init site_stats table (add empty row)
		 */
		$this->mNewWiki->dbw->insert( "site_stats", array( "ss_row_id" => "1"), __METHOD__ );

		/**
		 * add local job
		 */
		$job_params = new stdClass();
		foreach ( $this->mNewWiki as $id => $value ) {
			if ( !is_object($value) ) {
				$job_params->$id = $value;
			}
		}
		// BugId:15644 - I need to pass this to CreateWikiLocalJob::changeStarterContributions
		$job_params->sDbStarter = $this->sDbStarter;
		$localJob = new CreateWikiLocalJob( Title::newFromText( NS_MAIN, "Main" ), $job_params );
		$localJob->WFinsert( $this->mNewWiki->city_id, $this->mNewWiki->dbname );
		wfDebugLog( "createwiki", __METHOD__ . ": New createWiki local job created \n", true );

		/**
		 * destroy connection to newly created database
		 */
		$this->mNewWiki->dbw->commit();
		wfDebugLog( "createwiki", __METHOD__ . ": Database changes commited \n", true );
		$wgSharedDB = $tmpSharedDB;

		/**
		 * set hub/category
		 */
		$oldUser = $wgUser;
		$wgUser = User::newFromName( 'CreateWiki script' );
		$oHub = WikiFactoryHub::getInstance();
		$oHub->setCategory( $this->mNewWiki->city_id, $this->mNewWiki->hub, "CW Setup" );
		wfDebugLog( "createwiki", __METHOD__ . ": Wiki added to the category hub: {$this->mNewWiki->hub} \n", true );
		$wgUser = $oldUser;
		unset($oldUser);

		/**
		 * define wiki type
		 */
		$wiki_type = 'default';

		/**
		 * modify variables
		 */
		global $wgUniversalCreationVariables;
		if ( !empty($wgUniversalCreationVariables) && !empty($wiki_type) && isset( $wgUniversalCreationVariables[$wiki_type] ) ) {
			$this->addCustomSettings( 0, $wgUniversalCreationVariables[$wiki_type], "universal" );
			wfDebugLog( "createwiki", __METHOD__ . ": Custom settings added for wiki_type: {$wiki_type} \n", true );
		}

		/**
		 * set variables per language
		 */
		global $wgLangCreationVariables;
		$langCreationVar = isset($wgLangCreationVariables[$wiki_type]) ? $wgLangCreationVariables[$wiki_type] : $wgLangCreationVariables;
		$this->addCustomSettings( $this->mNewWiki->language, $langCreationVar, "language" );
		wfDebugLog( "createwiki", __METHOD__ . ": Custom settings added for wiki_type: {$wiki_type} and language: {$this->mNewWiki->language} \n", true );

		/**
		 * set tags per language and per hub
		 * @FIXME the switch is !@#$ creazy, but I didn't find a core function
		 */
		$tags = new WikiFactoryTags( $this->mNewWiki->city_id );
		$langTag = $this->mNewWiki->language;
		if ( $langTag !== 'en' ) {
			switch ( $langTag ) {
				case 'pt-br':
					$langTag = 'pt';
					break;
				case 'zh-tw':
				case 'zh-hk':
				case 'zh-clas':
				case 'zh-class':
				case 'zh-classical':
				case 'zh-cn':
				case 'zh-hans':
				case 'zh-hant':
				case 'zh-min-':
				case 'zh-min-n':
				case 'zh-mo':
				case 'zh-sg':
				case 'zh-yue':
					$langTag = 'zh';
					break;
			}

			$tags->addTagsByName( $langTag );
		}

		$tags->addTagsByName( $this->mNewWiki->hub );

		/**
		 * move main page
		 */
		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/wikia/moveMain.php -t '%s' --conf %s",
			$this->mNewWiki->city_id,
			$this->mPHPbin,
			$this->mIP,
			$this->mNewWiki->sitename,
			$wgWikiaLocalSettingsPath
		);
		wfShellExec( $cmd );
		wfDebugLog( "createwiki", __METHOD__ . ": Main page moved \n", true );

		/**
		 * show congratulation message
		 */

		/**
		 * Unset database from mNewWiki, because database objects cannot be serialized from MW1.19
		 */
		unset($this->mNewWiki->dbw);

		/**
		 * inform task manager
		 */
		$Task = new LocalMaintenanceTask();
		$Task->createTask(
			array(
				"city_id" => $this->mNewWiki->city_id,
				"command" => "maintenance/runJobs.php",
				"type"    => "CWLocal",
				"data"    => $this->mNewWiki,
				"server"  => rtrim( $this->mNewWiki->url, "/" )
			),
			TASK_QUEUED,
			BatchTask::PRIORITY_HIGH
		);
		wfDebugLog( "createwiki", __METHOD__ . ": Local maintenance task added\n", true );

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
			if( AutoCreateWiki::domainExists( $this->mDomain, $this->mLanguage ) ) {
				$status = self::ERROR_DOMAIN_NAME_TAKEN;
			}
		}

		wfProfileOut(__METHOD__);

		return $status;
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
		global $wgContLang;

		wfProfileIn( __METHOD__ );

		$this->fixSubdomains();

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

		// umbrella
		$this->mNewWiki->umbrella = $this->mNewWiki->name;

		$this->mNewWiki->language  = $this->mLanguage;
		$this->mNewWiki->subdomain = $this->mNewWiki->name;
		$this->mNewWiki->redirect  = $this->mNewWiki->name;

		$this->mNewWiki->path = self::DEFAULT_SLOT;

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

		$this->mNewWiki->images_dir = self::IMGROOT  . $this->mNewWiki->images_dir . "/images";
		$this->mNewWiki->images_url = self::IMAGEURL . $this->mNewWiki->images_url . "/images";
		$this->mNewWiki->domain = sprintf("%s.%s", $this->mNewWiki->subdomain, $this->mDefSubdomain);
		$this->mNewWiki->url = sprintf( "http://%s.%s/", $this->mNewWiki->subdomain, $this->mDefSubdomain );
		$this->mNewWiki->dbname = $this->prepareDatabaseName( $this->mNewWiki->name, $this->mLanguage );
		$this->mNewWiki->founderName = $this->mFounder->getName();
		$this->mNewWiki->founderEmail = $this->mFounder->getEmail();
		$this->mNewWiki->founderId = $this->mFounder->getId();
		$this->mNewWiki->founderIp = $this->mFounderIp;

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
	private function fixSubdomains() {
		$this->mDefSubdomain = self::DEFAULT_DOMAIN;
		$this->mDefSitename = self::DEFAULT_NAME;
		$this->mDomains = array('default' => '');
		$this->mSitenames = array();
		$this->mLangSubdomain = true;
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
			$dirName = self::IMGROOT . $prefix . "/" . $dir_base . $suffix . $dir_lang . "/images";

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

		wfDebugLog( "createwiki", __METHOD__, ": checking database name for dbname=$dbname, language={$lang}\n", true );

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

	/**
	 * addToCityList
	 *
	 * add record to the city_list table
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function addToCityList() {
		$insertFields = array(
			'city_title'          => $this->mNewWiki->sitename,
			'city_dbname'         => $this->mNewWiki->dbname,
			'city_url'            => $this->mNewWiki->url,
			'city_founding_user'  => $this->mNewWiki->founderId,
			'city_founding_email' => $this->mNewWiki->founderEmail,
			'city_founding_ip'    => ip2long($this->mNewWiki->founderIp),
			'city_path'           => $this->mNewWiki->path,
			'city_description'    => $this->mNewWiki->sitename,
			'city_lang'           => $this->mNewWiki->language,
			'city_created'        => wfTimestamp( TS_DB, time() ),
			'city_umbrella'       => $this->mNewWiki->umbrella,
		);
		if ( self::ACTIVE_CLUSTER ) {
			$insertFields[ "city_cluster" ] = self::ACTIVE_CLUSTER;
		}

		$res = $this->mDBw->insert( "city_list", $insertFields, __METHOD__ );

		return $res;
	}

	/**
	 * addToCityDomains
	 *
	 * add records to the city_domain table
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function addToCityDomains() {
		$res = $this->mDBw->insert(
			"city_domains",
			array(
				array(
					'city_id'     => $this->mNewWiki->city_id,
					'city_domain' => $this->mNewWiki->domain
				),
				array(
					'city_id'     => $this->mNewWiki->city_id,
					'city_domain' => sprintf( "www.%s", $this->mNewWiki->domain )
				)
			),
			__METHOD__
		);

		return $res;
	}

	/**
	 * createTables
	 *
	 * create default tables and populate with default values
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function createTables() {

		$mSqlFiles = $this->mDefaultTables;

		if ( !empty( $this->mAdditionalTables ) ) {
			foreach ( $this->mAdditionalTables as $file ) {
				if( is_readable( $file ) ) {
					$mSqlFiles[] = $file ;
				}
			}
		}

		foreach( $mSqlFiles as $file ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Populating database with {$file}\n", true );

			$error = $this->mNewWiki->dbw->sourceFile( $file );
			if ( $error !== true ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * setWFVariables
	 *
	 * add all default variables into city_variables table
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function setWFVariables() {
		// WF Variables containter
		$this->mWFSettingVars = array();

		$this->mWFSettingVars['wgSitename'] 		        = $this->mNewWiki->sitename;
		$this->mWFSettingVars['wgLogo']                   	= self::DEFAULT_WIKI_LOGO;
		$this->mWFSettingVars['wgUploadPath']             	= $this->mNewWiki->images_url;
		$this->mWFSettingVars['wgUploadDirectory']        	= $this->mNewWiki->images_dir;
		$this->mWFSettingVars['wgDBname']                 	= $this->mNewWiki->dbname;
		$this->mWFSettingVars['wgLocalInterwiki']         	= $this->mNewWiki->sitename;
		$this->mWFSettingVars['wgLanguageCode']	            = $this->mNewWiki->language;
		$this->mWFSettingVars['wgServer']                	= rtrim( $this->mNewWiki->url, "/" );
		$this->mWFSettingVars['wgFavicon']               	= self::DEFAULT_WIKI_FAVICON;
		$this->mWFSettingVars['wgEnableEditEnhancements'] 	= true;
		$this->mWFSettingVars['wgEnableSectionEdit']	    = true;

		// rt#60223: colon allowed in sitename, breaks project namespace
		if( mb_strpos( $this->mWFSettingVars['wgSitename'], ':' ) !== false ) {
			$this->mWFSettingVars['wgMetaNamespace'] = str_replace( array( ':', ' ' ), array( '', '_' ), $this->mWFSettingVars['wgSitename'] );
		}

		if ( self::ACTIVE_CLUSTER ) {
			wfGetLBFactory()->sectionsByDB[ $this->mNewWiki->dbname ] = $this->mWFSettingVars['wgDBcluster'] = self::ACTIVE_CLUSTER;
		}

		$oRes = $this->mDBw->select(
			"city_variables_pool",
			array( "cv_id, cv_name" ),
			array( "cv_name in ('" . implode( "', '", array_keys( $this->mWFSettingVars ) ) . "')"),
			__METHOD__
		);

		$this->mWFVars = array();
		while ( $oRow = $this->mDBw->fetchObject( $oRes ) ) {
			$this->mWFVars[ $oRow->cv_name ] = $oRow->cv_id;
		}
		$this->mDBw->freeResult( $oRes );

		foreach( $this->mWFSettingVars as $variable => $value ) {
			/**
			 * first, get id of variable
			 */
			$cv_id = 0;
			if ( isset( $this->mWFVars[$variable] ) ) {
				$cv_id = $this->mWFVars[$variable];
			}

			/**
			 * then, insert value for wikia
			 */
			if( !empty($cv_id) ) {
				$this->mDBw->insert(
					"city_variables",
					array(
						"cv_value"       => serialize( $value ),
						"cv_city_id"     => $this->mNewWiki->city_id,
						"cv_variable_id" => $cv_id
					),
					__METHOD__
				);
			}
		}
	}

	/**
	 * importStarter
	 *
	 * get starter data for current parameters
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function importStarter() {
		global $wgDBadminuser, $wgDBadminpassword, $wgWikiaLocalSettingsPath;

		$dbStarter = ( isset( $this->mStarters[ "*" ][ $this->mNewWiki->language ] ) )
					? $this->mStarters[ "*" ][ $this->mNewWiki->language ]
					: $this->mStarters[ "*" ][ "*" ];

		/**
		 * determine if exists
		 */
		$starter = null;
		try {
			$dbr = wfGetDB( DB_SLAVE, array(), $dbStarter );
			/**
			 * read info about connection
			 */
			$starter = $dbr->getLBInfo();

			/**
			 * get UploadDirectory
			 */
			$starter[ "dbStarter" ] = $dbStarter;

			// BugId:15644 - I need to pass this to CreateWikiLocalJob::changeStarterContributions
			$this->sDbStarter = $dbStarter;

			wfDebugLog( "createwiki", __METHOD__ . ": starter $dbStarter exists\n", true );
		}
		catch( DBConnectionError $e ) {
			/**
			 * well, it means that starter doesn't exists
			 */
			wfDebugLog( "createwiki", __METHOD__ . ": starter $dbStarter doesn't exist\n", true );
		}

		if ( $starter ) {
			$tables = $this->mStarterTables[ "*" ];

			$cmd = sprintf(
				"%s -h%s -u%s -p%s %s %s | %s -h%s -u%s -p%s %s",
				$this->mMYSQLdump,
				$starter[ "host"      ],
				$starter[ "user"      ],
				$starter[ "password"  ],
				$starter[ "dbStarter" ],
				implode( " ", $tables ),
				$this->mMYSQLbin,
				$this->mNewWiki->dbw->getLBInfo( 'host' ),
				$wgDBadminuser,
				$wgDBadminpassword,
				$this->mNewWiki->dbname
			);
			wfShellExec( $cmd );

			wfDebugLog( "createwiki", __METHOD__ . ": Import {$this->mIP}/maintenance/cleanupStarter.sql \n", true );
			$error = $this->mNewWiki->dbw->sourceFile( "{$this->mIP}/maintenance/cleanupStarter.sql" );
			if ($error !== true) {
				wfDebugLog( "createwiki", __METHOD__ . ": Import starter failed\n", true );
				return false;
			}

			$cmd = sprintf(
				"SERVER_ID=%d %s %s/maintenance/updateArticleCount.php --update --conf %s",
				$this->mNewWiki->city_id,
				$this->mPHPbin,
				$this->mIP,
				$wgWikiaLocalSettingsPath
			);
			wfShellExec( $cmd );

			wfDebugLog( "createwiki", __METHOD__ . ": Starter database copied \n", true );
		}

		return true;
	}

	/**
	 * importStarter
	 *
	 * get starter data for current parameters
	 *
	 * @author Krzysztof Krzyzaniak <eloy@wikia-inc.com>
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 */
	private function addUserToGroups() {
		if ( !$this->mNewWiki->founderId ) {
			return false;
		}

		$this->mNewWiki->dbw->replace( "user_groups", array( ), array( "ug_user" => $this->mNewWiki->founderId, "ug_group" => "sysop" ) );
		$this->mNewWiki->dbw->replace( "user_groups", array( ), array( "ug_user" => $this->mNewWiki->founderId, "ug_group" => "bureaucrat" ) );

		return true;
	}

	/**
	 * addCustomSettings
	 *
	 * @author tor@wikia-inc.com
	 * @param  string $match
	 * @param  array  $settings
	 * @param  string $type
	 */
	public function addCustomSettings( $match, $settings, $type = 'unknown' ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		if( ( !empty( $match ) || $type == 'universal' ) && isset( $settings[ $match ] ) && is_array( $settings[ $match ] ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Found '$match' in {$type} settings array \n", true );

			/**
			 * switching user for correct logging
			 */
			$oldUser = $wgUser;
			$wgUser = User::newFromName( 'CreateWiki script' );

			foreach( $settings[$match] as $key => $value ) {
				$success = WikiFactory::setVarById( $key, $this->mNewWiki->city_id, $value );
				if( $success ) {
					wfDebugLog( "createwiki", __METHOD__ . ": Successfully added setting for {$this->mNewWiki->city_id}: {$key} = {$value}\n", true );
				} else {
					wfDebugLog( "createwiki", __METHOD__ . ": Failed to add setting for {$this->mNewWiki->city_id}: {$key} = {$value}\n", true );
				}
			}
			$wgUser = $oldUser;

			wfDebugLog( "createwiki", __METHOD__ . ": Finished adding {$type} settings\n", true );
		} else {
			wfDebugLog( "createwiki", __METHOD__ . ": '{$match}' not found in {$type} settings array. Skipping this step.\n", true );
		}

		wfProfileOut( __METHOD__ );
		return 1;
	}

	public function getWikiInfo($key) {
		$ret = $this->mNewWiki->$key;
		return $ret;
	}
}
