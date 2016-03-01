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

use Wikia\CreateNewWiki\Starters;

class CreateWiki {

	use \Wikia\Logger\Loggable;

	/* @var $mDBw DatabaseMysql */
	/* @var $mClusterDB string */
	private $mName, $mDomain, $mLanguage, $mVertical, $mCategories, $mIP,
		$mPHPbin, $mMYSQLbin, $mMYSQLdump, $mNewWiki, $mFounder,
		$mLangSubdomain, $mDBw, $mWFSettingVars, $mWFVars,
		$mDefaultTables, $mAdditionalTables,
		$sDbStarter, $mFounderIp,
		$mCurrTime,
		$mClusterDB; // eg. "wikicities_c7"

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
	const ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN     = 15;

	const IMGROOT              = "/images/";
	const IMAGEURL             = "http://images.wikia.com/";
	const CREATEWIKI_LOGO      = "http://images.wikia.com/central/images/2/22/Wiki_Logo_Template.png";
	const DEFAULT_STAFF        = "Wikia";
	const DEFAULT_USER         = 'Default';
	const DEFAULT_DOMAIN       = "wikia.com";
	const ACTIVE_CLUSTER       = "c7";
	const DEFAULT_SLOT         = "slot1";
	const DEFAULT_NAME         = "Wiki";
	const DEFAULT_WIKI_TYPE    = "";
	const DEFAULT_WIKI_LOGO    = '$wgUploadPath/b/bc/Wiki.png';

	const SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH = 55;

	/**
	 * constructor
	 *
	 * @param string $name - name of wiki (set later as $wgSiteinfo)
	 * @param string $domain - domain part without '.wikia.com'
	 * @param string $language - language code
	 */
	public function __construct( $name, $domain, $language, $vertical, $categories ) {
		global $wgUser, $IP, $wgAutoloadClasses, $wgRequest;

		// wiki containter
		$this->mNewWiki = new stdClass();

		$this->mDomain = $domain;
		$this->mName = $name;
		$this->mLanguage = $language;
		$this->mVertical = $vertical;
		$this->mCategories = $categories;
		$this->mIP = $IP;

		// founder of wiki
		$this->mFounder = $wgUser;
		$this->mFounderIp = $wgRequest->getIP();

		wfDebugLog( "createwiki", "founder: " . print_r($this->mFounder, true) . "\n", true );

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
	 * Add more context to messages sent to LogStash
	 *
	 * @return array
	 */
	protected function getLoggerContext() {
		return [
			'cityid'   => $this->mNewWiki->city_id,
			'domain'   => $this->mDomain,
			'dbname'   => $this->mNewWiki->dbname,
			'logGroup' => 'createwiki',
		];
	}

	/**
	 * Wait for shared DB and the current DB cluster slaves
	 *
	 * @param string $fname
	 * @see PLATFORM-1219
	 */
	private function waitForSlaves( $fname ){
		global $wgExternalSharedDB;
		$then = microtime( true );

		// commit the changes
		$res = $this->mNewWiki->dbw->commit( $fname );

		# PLATFORM-1219 - wait for slaves to catch up (shared DB, cluster's shared DB and the new wiki DB)
		wfWaitForSlaves( $wgExternalSharedDB );     // wikicities (shared DB)
		wfWaitForSlaves( $this->mClusterDB );       // wikicities_c7
		wfWaitForSlaves( $this->mNewWiki->dbname ); // new_wiki_db

		$this->info( __METHOD__, [
			'commit_res' => $res,
			'cluster'    => $this->mClusterDB,
			'fname'      => $fname,
			'took'       => microtime( true ) - $then,
		] );
	}

	/**
	 * main entry point, create wiki with given parameters
	 *
	 * @throw CreateWikiException an exception with status of operation set
	 */
	public function create() {
		global $wgExternalSharedDB, $wgSharedDB, $wgUser;

		$then = microtime( true );

		// Set this flag to ensure that all select operations go against master
		// Slave lag can cause random errors during wiki creation process
		global $wgForceMasterDatabase;
		$wgForceMasterDatabase = true;

		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('DB is read only', self::ERROR_READONLY);
		}

		// check founder
		if ( $this->mFounder->isAnon() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Founder is anon', self::ERROR_USER_IN_ANON);
		}

		// check executables
		$status = $this->checkExecutables();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('checkExecutables() failed', $status);
		}

		// check domains
		$status = $this->checkDomain();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Check domain failed', $status);
		}

		// prepare all values needed for creating wiki
		$this->prepareValues();

		// prevent domain to be registered more than once
		if ( !AutoCreateWiki::lockDomain($this->mDomain) ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Domain name taken', self::ERROR_DOMAIN_NAME_TAKEN);
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
		$this->mClusterDB = ( self::ACTIVE_CLUSTER ) ? "wikicities_" . self::ACTIVE_CLUSTER : "wikicities";
		$this->mNewWiki->dbw = wfGetDB( DB_MASTER, array(), $this->mClusterDB ); // database handler, old $dbwTarget

		// SUS-108: check read-only state of ACTIVE_CLUSTER before performing any DB-related actions
		$readOnlyReason = $this->mNewWiki->dbw->getLBInfo( 'readOnlyReason' );
		if ( $readOnlyReason !== false ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException( sprintf( '%s is in read-only mode: %s', self::ACTIVE_CLUSTER, $readOnlyReason ), self::ERROR_READONLY );
		}

		// check if database is creatable
		// @todo move all database creation checkers to canCreateDatabase
		if( !$this->canCreateDatabase() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('DB exists - ' . $this->mNewWiki->dbname, self::ERROR_DATABASE_ALREADY_EXISTS);
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
			throw new CreateWikiException('Cannot add wiki to city_list', self::ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN);
		}

		// set new city_id
		$this->mNewWiki->city_id = $this->mDBw->insertId();
		if ( empty( $this->mNewWiki->city_id ) ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Cannot set data in city_list table. city_id is empty after insert', self::ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN);
		}

		wfDebugLog( "createwiki", __METHOD__ . ": Row added added into city_list table, city_id = {$this->mNewWiki->city_id}\n", true );

		/**
		 * add domain and www.domain to the city_domains table
		 */
		if ( ! $this->addToCityDomains() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Cannot set data in city_domains table', self::ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN);
		}

		wfDebugLog( "createwiki", __METHOD__ . ": Row added into city_domains table, city_id = {$this->mNewWiki->city_id}\n", true );

		// Force initialize uploader user from correct shared db
		$uploader = User::newFromName( 'CreateWiki script' );
		$uploader->getId();
		$oldUser = $wgUser;
		$wgUser = $uploader;

		/**
		 * wikifactory variables
		 */
		wfDebugLog( "createwiki", __METHOD__ . ": Populating city_variables\n", true );
		$this->setWFVariables();

		$tmpSharedDB = $wgSharedDB;
		$wgSharedDB = $this->mNewWiki->dbname;

		$this->mDBw->commit( __METHOD__ ); // commit shared DB changes

		/**
		 * we got empty database created, now we have to create tables and
		 * populate it with some default values
		 */
		wfDebugLog( "createwiki", __METHOD__ . ": Creating tables in database\n", true );

		$this->mNewWiki->dbw = wfGetDB( DB_MASTER, array(), $this->mNewWiki->dbname );

		if ( !$this->createTables() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Creating tables not finished', self::ERROR_SQL_FILE_BROKEN);
		}

		/**
		 * import language starter
		 */
		if ( !$this->importStarter() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Starter import failed', self::ERROR_SQL_FILE_BROKEN);
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
		 * destroy connection to newly created database
		 */
		$this->waitForSlaves( __METHOD__ );
		$wgSharedDB = $tmpSharedDB;


		$oHub = WikiFactoryHub::getInstance();
		$oHub->setVertical( $this->mNewWiki->city_id, $this->mNewWiki->vertical, "CW Setup" );
		wfDebugLog( "createwiki", __METHOD__ . ": Wiki added to the vertical: {$this->mNewWiki->vertical} \n", true );
		for($i = 0; $i < count($this->mNewWiki->categories); $i++) {
			$oHub->addCategory( $this->mNewWiki->city_id, $this->mNewWiki->categories[$i] );
			wfDebugLog( "createwiki", __METHOD__ . ": Wiki added to the category: {$this->mNewWiki->categories[$i]} \n", true );
		}

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

		/**
		 * move main page -> this code exists in CreateWikiLocalJob - so it is not needed anymore
		 */

		/**
		 * Unset database from mNewWiki, because database objects cannot be serialized from MW1.19
		 */
		unset($this->mNewWiki->dbw);

		// Restore wgUser
		$wgUser = $oldUser;
		unset($oldUser);

		/**
		 * Schedule an async task
		 */
		$creationTask = new \Wikia\Tasks\Tasks\CreateNewWikiTask();

		$job_params = new stdClass();
		foreach ( $this->mNewWiki as $id => $value ) {
			if ( !is_object($value) ) {
				$job_params->$id = $value;
			}
		}
		// BugId:15644 - I need to pass this to CreateWikiLocalJob::changeStarterContributions
		$job_params->sDbStarter = $this->sDbStarter;

		$task_id = (new \Wikia\Tasks\AsyncTaskList())
			->wikiId($this->mNewWiki->city_id)
			->prioritize()
			->add($creationTask->call('postCreationSetup', $job_params))
			->add($creationTask->call('maintenance', rtrim($this->mNewWiki->url, "/")))
			->queue();

		wfDebugLog( "createwiki", __METHOD__ . ": Local maintenance task added as {$task_id}\n", true );

		wfRunHooks( "AfterWikiCreated", [ $this->mNewWiki->city_id, $this->sDbStarter ] );

		$this->info( __METHOD__ . ': done', [
			'task_id' => $task_id,
			'took' => microtime( true ) - $then,
		] );

		wfProfileOut( __METHOD__ );
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

		$this->mNewWiki->vertical = $this->mVertical;

		// Map new verticals to old categories while in transition so that "hub" code still works
		// If a user selects a vertical we will also add the old category that matches best with it
		// This code can be removed after we are fully using the new verticals (PLATFORM-403)

		// uses array_unshift to make sure hub category is first, because we take the first cat from SQL
		if ( $this->mVertical == 2 ) array_unshift($this->mCategories, 2);	// Video games
		if ( in_array( $this->mVertical, [1,3,4,6,7] ) ) array_unshift($this->mCategories, 3); // Entertainment
		if ( $this->mVertical == 5 ) array_unshift($this->mCategories, 9);	// Lifestyle

		$this->mNewWiki->categories = $this->mCategories;

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
	 * Check if the given upload directory name is available for use.
	 *
	 * @access public
	 * @author Michał Roszka <michal@wikia-inc.com>
	 *
	 * @param $sDirectoryName the path to check
	 */
	public static function wgUploadDirectoryExists( $sDirectoryName ) {
		wfProfileIn( __METHOD__ );
		$iVarId = WikiFactory::getVarIdByName( 'wgUploadDirectory' );

		// Crash immediately if $iVarId is not a positive integer!
		\Wikia\Util\Assert::true( $iVarId );

		$aCityIds = WikiFactory::getCityIDsFromVarValue( $iVarId, $sDirectoryName, '=' );
		wfProfileOut( __METHOD__ );
		return !empty( $aCityIds );
	}

	/**
	 * "calculates" the value for wgUploadDirectory
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
		$dir_base = self::sanitizeS3BucketName($name);
		$prefix = strtolower( substr( $dir_base, 0, 1 ) );
		$dir_lang = ( isset( $language ) && $language !== "en" )
				? "/" . strtolower( $language )
				: "";

		while ( $isExist == false ) {
			$dirName = self::IMGROOT . $prefix . "/" . $dir_base . $suffix . $dir_lang . "/images";

			if ( self::wgUploadDirectoryExists($dirName) ) {
				$suffix = rand(1, 9999);
			}
			else {
				$dir_base = $dir_base . $suffix;
				$isExist = true;
			}
		}

		wfDebug( __METHOD__ . ": Returning '{$dir_base}'\n" );
		wfProfileOut( __METHOD__ );
		return $dir_base;
	}

	/**
	 * Sanitizes a name to be a valid S3 bucket name. It means it can contain only letters and numbers
	 * and optionally hyphens in the middle. Maximum length is 63 characters, we're trimming it to 55
	 * characters here as some random suffix may be added to solve duplicates.
	 *
	 * Note that different arguments may lead to the same results so the conflicts need to be solved
	 * at a later stage of processing.
	 *
	 * @see http://docs.aws.amazon.com/AmazonS3/latest/dev/BucketRestrictions.html
	 *      Wikia change: We accept underscores wherever hyphens are allowed.
	 *
	 * @param $name string Directory name
	 * @return string Sanitized name
	 */
	private static function sanitizeS3BucketName( $name ) {
		if ( $name == 'admin' ) {
			$name .= 'x';
		}

		$RE_VALID = "/^[a-z0-9](?:[-_a-z0-9]{0,53}[a-z0-9])?(?:[a-z0-9](?:\\.[-_a-z0-9]{0,53}[a-z0-9])?)*\$/";
		# check if it's already valid
		$name = mb_strtolower($name);
		if ( preg_match( $RE_VALID, $name ) && strlen($name) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
			return $name;
		}

		# try fixing the simplest and most popular cases
		$check_name = str_replace(['.',' ','(',')'],'_',$name);
		if ( in_array( substr($check_name,-1), [ '-', '_' ] ) ) {
			$check_name .= '0';
		}
		if ( preg_match( $RE_VALID, $check_name ) && strlen($check_name) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
			return $check_name;
		}

		# replace invalid ASCII characters with their hex values
		$s = '';
		for ($i=0;$i<strlen($name);$i++) {
			$c = $name[$i];
			if ( $c >= 'a' && $c <= 'z' || $c >= '0' && $c <= '9' ) {
				$s .= $c;
			} else {
				$s .= bin2hex($c);
			}
			if ( strlen($s) >= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
				break;
			}
		}
		$name = substr($s, 0, self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH);

		return $name;
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

		// we need to wait for slaves to catch up
		// the next method called (importStarter) connects to the newly created wiki using slave DB
		$this->waitForSlaves( __METHOD__ );

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

		$this->mWFSettingVars['wgSitename']               = $this->mNewWiki->sitename;
		$this->mWFSettingVars['wgLogo']                   = self::DEFAULT_WIKI_LOGO;
		$this->mWFSettingVars['wgUploadPath']             = $this->mNewWiki->images_url;
		$this->mWFSettingVars['wgUploadDirectory']        = $this->mNewWiki->images_dir;
		$this->mWFSettingVars['wgDBname']                 = $this->mNewWiki->dbname;
		$this->mWFSettingVars['wgLocalInterwiki']         = $this->mNewWiki->sitename;
		$this->mWFSettingVars['wgLanguageCode']           = $this->mNewWiki->language;
		$this->mWFSettingVars['wgServer']                 = rtrim( $this->mNewWiki->url, "/" );
		$this->mWFSettingVars['wgEnableSectionEdit']      = true;
		$this->mWFSettingVars['wgEnableSwiftFileBackend'] = true;
		$this->mWFSettingVars['wgOasisLoadCommonCSS']     = true;

		if ( $this->getInitialNjordExtValue() ) {
			$this->mWFSettingVars['wgEnableNjordExt'] = true;
		}

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
	 * @author macbre
	 */
	private function importStarter() {
		global $IP;

		// BugId:15644 - I need to pass $this->sDbStarter to CreateWikiLocalJob::changeStarterContributions
		$starterDatabase = $this->sDbStarter = Starters::getStarterByLanguage( $this->mNewWiki->language );

		// import a starter database XML dump from DFS
		$then = microtime( true );

		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/importStarter.php",
			$this->mNewWiki->city_id,
			$this->mPHPbin,
			"{$IP}/extensions/wikia/CreateNewWiki"
		);
		wfShellExec( $cmd, $retVal );

		if ($retVal > 0) {
			$this->error( 'starter dump import failed', [
				'starter' => $starterDatabase,
				'retval'  => $retVal
			] );
			return false;
		}

		$this->info( 'importStarter: from XML dump', [
			'retval'  => $retVal,
			'starter' => $starterDatabase,
			'took'    => microtime( true ) - $then,
		] );

		$this->waitForSlaves( __METHOD__ );

		wfDebugLog( "createwiki", __METHOD__ . ": Starter database imported \n", true );
		return true;
	}

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

	/**
	 * gets initial value for wgEnableNjordExt for new created wiki
	 * Set to false to stop beta version progression.
	 * @see DAT-2752
	 *
	 * @return bool
	 */
	private function getInitialNjordExtValue() {
		return false;
	}
}
