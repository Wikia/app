<?php
/**
 * Main part of Special:AutoCreateWiki
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
		$mWikiId,
		$mMYSQLdump,
		$mMYSQLbin,
		$mPHPbin,
		$mStarters,
		$mCurrTime,
		$mPosted,
		$mPostedErrors,
		$mErrors,
		$mUserLanguage;

	/**
	 * test database, CAUTION! content will be destroyed during tests
	 */
	const TESTDB = "testdb";
	const STARTER_GAME = 2; /** gaming **/
	const STARTER_ENTE = 3; /** enter. **/
	const STARTER_SPRT = 15; /** sport **/
	const LOG = "autocreatewiki";
	const IMGROOT = "/images/";
    const CREATEWIKI_LOGO = "/images/central/images/2/22/Wiki_Logo_Template.png";
    const CREATEWIKI_ICON = "/images/central/images/6/64/Favicon.ico";
    const SESSION_TIME = 60;
    const DAILY_LIMIT = 200;
    const DAILY_USER_LIMIT = 10;
    const DEFAULT_STAFF = "Angela";
    const CACHE_LOGIN_KEY = 'awc_beforelog';

	/**
	 * constructor
	 */
	public function  __construct() {
		parent::__construct( "CreateWiki" /*class*/ );

		/**
		 * initialize some data
		 */
		$this->mWikiData = array();

		/**
		 * hub starters
		 */
		$this->mStarters = array(
			self::STARTER_GAME => 3578,
			self::STARTER_ENTE => 3711,
			self::STARTER_SPRT => 12698
		);

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
		global $wgRequest, $wgAuth, $wgUser, $wgOut, $wgDevelEnvironment,
			$wgContLanguageCode;

		wfLoadExtensionMessages( "AutoCreateWiki" );

		$this->setHeaders();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "CreateWiki" );
		$this->mAction = $wgRequest->getVal( "action", false );
		$this->mSubpage = $subpage;
		$this->mPosted = $wgRequest->wasPosted();
		$this->mPostedErrors = array();
		$this->mErrors = 0;


		if( $wgDevelEnvironment ) {
			global $wgDevelDomains;
			$this->mDefSubdomain = array_shift( $wgDevelDomains );
		}
		else {
			$this->mDefSubdomain = "wikia.com";
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->mUserLanguage = $wgUser->getOption( 'language', $wgContLanguageCode );
		$this->mNbrCreated = $this->countCreatedWikis();

		if ( !in_array('staff', $wgUser->getGroups()) && ($this->mNbrCreated >= self::DAILY_LIMIT) ) {
			$wgOut->addHTML(
				wfMsgExt( "autocreatewiki-limit-day",
					array( "language" => $this->mUserLanguage ), array( $this->mNbrCreated )
			));
			return;
		}

		if ( $subpage === "Caching" ) {
			$this->setValuesToSession();
			exit;
		}
		elseif ( $subpage === "Processing" ) {
			$this->log (" session: " . print_r($_SESSION, true). "\n");
			#--- restriction
			if ( $wgUser->isAnon() ) {
				$this->displayRestrictionError();
				return;
			} elseif ( $wgUser->isBlocked() ) {
				$wgOut->blockedPage();
				return;
			}
			if ( isset( $_SESSION['mAllowToCreate'] ) && ( $_SESSION['mAllowToCreate'] >= wfTimestamp() ) ) {
				$this->mNbrUserCreated = $this->countCreatedWikisByUser();
				if ( !in_array('staff', $wgUser->getGroups()) && ($this->mNbrUserCreated >= self::DAILY_USER_LIMIT) ) {
					$wgOut->addHTML(
						wfMsgExt( "autocreatewiki-limit-creation",
							array( "language" => $this->mUserLanguage ), array( $this->mNbrUserCreated )
					));
					return;
				}
				if ( $this->setVarsFromSession() > 0 ) {
					$this->createWiki();
				}
			} else {
				$this->log ("restriction error\n");
				$this->displayRestrictionError();
				return;
			}
		}
		elseif ( $subpage === "Wiki_create" ) {
			#--- restriction
			if ( $wgUser->isAnon() ) {
				$this->displayRestrictionError();
				return;
			} elseif ( $wgUser->isBlocked() ) {
				$wgOut->blockedPage();
				return;
			}
			if ( isset( $_SESSION['mAllowToCreate'] ) && ( $_SESSION['mAllowToCreate'] >= wfTimestamp() ) ) {
				/**
				 * Limit of user creation
				 */
				$this->mNbrUserCreated = $this->countCreatedWikisByUser();
				if ( !in_array('staff', $wgUser->getGroups()) && ($this->mNbrUserCreated >= self::DAILY_USER_LIMIT) ) {
					$wgOut->addHTML(
						wfMsgExt( "autocreatewiki-limit-creation",
							array( "language" => $this->mUserLanguage ), array(	$this->mNbrUserCreated )
					));
					return;
				}
				if ( $this->setVarsFromSession() > 0 ) {
					$this->processCreatePage();
				}
			} else {
				$this->clearSessionKeys();
				$wgOut->redirect( $this->mTitle->getLocalURL() );
			}
		}
		else {
			if ($this->mPosted) {
				#---
				$this->clearSessionKeys();
				$this->makeRequestParams();
				$this->checkWikiCreationParams();
				if ( $wgUser->isAnon() ) {
					$oUser = $wgUser;
					if ( empty($this->mLoggedin) ) {
						// create account form
						$oUser = $this->addNewAccount();
						if ( !is_null($oUser) ) {
							# user ok - so log in
							$wgAuth->updateUser( $oUser );
						}
					}
					# log in
					if ( !empty($oUser) && ($oUser instanceof User) && ($this->mErrors == 0) ) {
						$isLoggedIn = $this->loginAfterCreateAccount( );
						if ( empty($isLoggedIn) ) {
							wfDebug( "Login (api) failed - so use " . $oUser->getName() . "\n" );
							$oUser->loadFromDatabase();
							$wgUser = $oUser;
							$wgUser->setCookies();
						}
						# check after logged in
						if ( $wgUser->isAnon() ) {
							$this->makeError( "wiki-username", wfMsg('autocreatewiki-user-notloggedin') );
						} else {
							if ( !empty($this->mRemember) ) {
								$wgUser->setOption( 'rememberpassword', 1 );
								$wgUser->saveSettings();
							}
						}
					}
				}

				#-- restriction
				if ( $wgUser->isBlocked() ) {
					$wgOut->blockedPage();
					return;
				}
				#-- user logged in or just create
				if ( empty( $this->mErrors ) && ( $wgUser->getID() > 0 ) ) {
					#--- save values to session and redirect
					$this->makeRequestParams(true);
					$_SESSION['mAllowToCreate'] = wfTimestamp() + self::SESSION_TIME;
					$wgOut->redirect($this->mTitle->getLocalURL() . '/Wiki_create');
				} else {
					#--- some errors
					if ( isset($_SESSION['mAllowToCreate']) ) {
						unset($_SESSION['mAllowToCreate']);
					}
				}
			}
			$this->createWikiForm();
		}
	}

	/**
	 * main function for extension -- create wiki in wikifactory cluster
	 * we are assumming that data is valid!
	 *
	 */
	private function createWiki() {
		global $wgDebugLogGroups, $wgOut, $wgUser, $IP, $wgDBname, $wgSharedDB;
		global $wgDBserver, $wgDBuser,	$wgDBpassword, $wgWikiaLocalSettingsPath;
		global $wgHubCreationVariables, $wgLangCreationVariables, $wgUniversalCreationVariables;

		# $wgDebugLogGroups[ self::LOG ] = "/tmp/autocreatewiki.log";
		wfProfileIn( __METHOD__ );

		/**
		 * this will clean test database and fill mWikiData with test data
		 */
		$this->prepareValues();

		$this->mCurrTime = wfTime();
		$startTime = $this->mCurrTime;
		$this->mFounder = $wgUser;

		/**
		 * create image folder
		 */
		wfMkdirParents( $this->mWikiData[ "images"] );
		$this->log( "Create {$this->mWikiData[ "images"]} folder" );
		$this->setInfoLog('OK', wfMsg('autocreatewiki-step1'));

		/**
		 * check and create database
		 */
		$dbw = wfGetDB( DB_MASTER );
		$Row = $dbw->selectRow(
			wfSharedTable("city_list"),
			array( "count(*) as count" ),
			array( "city_dbname" => $this->mWikiData[ "dbname"] ),
			__METHOD__
		);
		$this->log( "Checking if database {$this->mWikiData[ "dbname"]} already exists");
		$error = 0;
		if( $Row->count > 0 ) {
			#error
			$this->log( "Database {$this->mWikiData[ "dbname"]} exists!" );
			$error = 1;
		} else {
			$dbw->query( sprintf( "CREATE DATABASE `%s`", $this->mWikiData[ "dbname"]) );
			$this->log( "Creating database {$this->mWikiData[ "dbname"]}" );
		}

		$msgType = ($error == 1) ? 'ERROR' : 'OK';
		$this->setInfoLog( $msgType, wfMsg('autocreatewiki-step2') );
		if ($error) {
			return;
		}
		/**
		 * create position in wiki.factory
		 * (I like sprintf construction, so sue me)
		 */
		$insertFields = array(
			'city_title'          => $this->mWikiData[ "title" ],
			'city_dbname'         => $this->mWikiData[ "dbname"],
			'city_url'            => sprintf( "http://%s.%s/", $this->mWikiData[ "subdomain" ], "wikia.com" ),
			'city_founding_user'  => $wgUser->getID(),
			'city_founding_email' => $wgUser->getEmail(),
			'city_path'           => $this->mWikiData[ "path" ],
			'city_description'    => $this->mWikiData[ "title" ],
			'city_lang'           => $this->mWikiData[ "language" ],
			'city_created'        => wfTimestamp( TS_DB, time() ),
		);

		$bIns = $dbw->insert( wfSharedTable("city_list"),$insertFields, __METHOD__ );
		if ( empty($bIns) ) {
			$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step3') );
			$this->log( "Cannot set data in city_list table" );
			$wgOut->addHTML(wfMsg('autocreatewiki-step3-error'));
			return;
		}
		/*
		 * get Wiki ID
		 */
		$this->mWikiId = $dbw->insertId();
		$this->mWikiData[ "city_id" ] = $this->mWikiId;

		if ( empty($this->mWikiId) ) {
			$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step3') );
			$this->log( "Empty city_id = {$this->mWikiId}" );
			$wgOut->addHTML(wfMsg('autocreatewiki-step3-error'));
			return;
		}
		$this->mWikiData[ "city_id" ] = $this->mWikiId;
		$this->mWikiData[ "founder" ] = $this->mFounder->getId();
		$this->mWikiData[ "founder-name" ] = $this->mFounder->getName();
		$this->log( "Creating row in city_list table, city_id = {$this->mWikiId}" );

		$bIns = $dbw->insert(
			wfSharedTable("city_domains"),
			array(
				array(
					'city_id'     =>  $this->mWikiId,
					'city_domain' => sprintf("%s.%s", $this->mWikiData[ "subdomain" ], "wikia.com" )
				),
				array(
					'city_id'     =>  $this->mWikiId,
					'city_domain' => sprintf("www.%s.%s", $this->mWikiData[ "subdomain" ], "wikia.com" )
				)
			),
			__METHOD__
		);
		if ( empty($bIns) ) {
			$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step3') );
			$this->log( "Cannot set data in city_domains table" );
			$wgOut->addHTML(wfMsg('autocreatewiki-step3-error'));
			return;
		}
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step3') );

		$this->log( "Populating city_domains" );

		/**
		 * copy defaul logo & favicon
		 */
		wfMkdirParents("{$this->mWikiData[ "images" ]}/b/bc");
		wfMkdirParents("{$this->mWikiData[ "images" ]}/6/64");

		if (file_exists(self::CREATEWIKI_LOGO)) {
			copy(self::CREATEWIKI_LOGO, "{$this->mWikiData[ "images" ]}/b/bc/Wiki.png");
		}
		if (file_exists(self::CREATEWIKI_ICON)) {
			copy(self::CREATEWIKI_ICON, "{$this->mWikiData[ "images" ]}/6/64/Favicon.ico");
		}
		$this->log( "Coping favicon and logo" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step4') );

		/**
		 * wikifactory variables
		 */
		$WFSettingsVars = array(
			'wgSitename'				=> $this->mWikiData[ "title" ],
			'wgScriptPath'				=> '',
			'wgScript'					=> '/index.php',
			'wgArticlePath'				=> '/wiki/$1',
			'wgLogo'					=> '$wgUploadPath/b/bc/Wiki.png',
			'wgUploadPath'				=> "http://images.wikia.com/{$this->mWikiData[ "dir_part" ]}/images",
			'wgUploadDirectory'			=> "/images/{$this->mWikiData[ "dir_part" ]}/images",
			'wgDBname'					=> $this->mWikiData[ "dbname" ],
			'wgSharedDB'				=> 'wikicities',
			'wgLocalInterwiki'			=> $this->mWikiData[ 'title' ],
			'wgLanguageCode'			=> $this->mWikiData['language'],
			'wgServer'					=> "http://{$this->mWikiData["subdomain"]}." . "wikia.com",
			'wgFavicon'					=> '$wgUploadPath/6/64/Favicon.ico',
			'wgDefaultSkin'				=> 'monaco',
			'wgDefaultTheme'			=> 'sapphire',
			'wgEnableNewParser'			=> true,
			'wgEnableEditEnhancements'	=> true,
			'wgEnableSectionEdit'	    => true,
		);
		$this->mWikiData[ "founder" ] = $wgUser->getId();

		if( $WFSettingsVars[ "wgLanguageCode" ] === "en" ) {
			$WFSettingsVars[ "wgEnableWysiwygExt" ] = true;
		}

		$oRes = $dbw->select(
			wfSharedTable("city_variables_pool"),
			array( "cv_id, cv_name" ),
			array( "cv_name in ('" . implode( "', '", array_keys($WFSettingsVars) ) . "')"),
			__METHOD__
		);
		$WFVariables = array();
		while ( $oRow = $dbw->fetchObject( $oRes ) ) {
			$WFVariables[ $oRow->cv_name ] = $oRow->cv_id;
		}
		$dbw->freeResult( $oRes );

		foreach( $WFSettingsVars as $variable => $value ) {
			/**
			 * first, get id of variable
			 */
			$cv_id = 0;
			if ( isset( $WFVariables[$variable] ) ) {
				$cv_id = $WFVariables[$variable];
			}

			/**
			 * then, insert value for wikia
			 */
			if( !empty($cv_id) ) {
				$dbw->insert(
					wfSharedTable( "city_variables" ),
					array(
						"cv_value"       => serialize( $value ),
						"cv_city_id"     => $this->mWikiId,
						"cv_variable_id" => $cv_id
					),
					__METHOD__
				);
			}
		}
		$this->log( "Populating city_variables" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step5') );

		/**
		 * we got empty database created, now we have to create tables and
		 * populate it with some default values
		 */
		$tmpSharedDB = $wgSharedDB;
		$wgSharedDB = $this->mWikiData[ "dbname"];

		$dbw->selectDb( $this->mWikiData[ "dbname"] );
		$sqlfiles = array(
			"{$IP}/maintenance/tables.sql",
			"{$IP}/maintenance/interwiki.sql",
			"{$IP}/maintenance/wikia/default_userrights.sql",
			"{$IP}/maintenance/wikia/city_interwiki_links.sql",
			"{$IP}/maintenance/wikia-additional-tables.sql",
			"{$IP}/extensions/CheckUser/cu_changes.sql",
			"{$IP}/extensions/CheckUser/cu_log.sql",
		);

		foreach ($sqlfiles as $file) {
			$error = $dbw->sourceFile( $file );
			if ($error !== true) {
				$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step6') );
				$wgOut->addHTML(wfMsg('autocreatewiki-step6-error'));
				return;
			}
		}
		$wgSharedDB = $tmpSharedDB;
		$this->log( "Creating tables in database" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step6') );

		/**
		 * import language starter
		 */
		if( in_array( $this->mWikiData[ "language" ], array("en", "ja", "de", "fr") ) ) {
			$prefix = ( $this->mWikiData[ "language" ] === "en") ? "" : $this->mWikiData[ "language" ];
			$starterDB = $prefix. "starter";

			/**
			 * first check whether database starter exists
			 */
			$sql = sprintf( "SHOW DATABASES LIKE '%s';", $starterDB );
			$Res = $dbw->query( $sql, __METHOD__ );
			$numRows = $Res->numRows();
			if ( !empty( $numRows ) ) {
				$cmd = sprintf(
					"%s -h%s -u%s -p%s %s categorylinks externallinks image imagelinks langlinks page pagelinks revision templatelinks text | %s -h%s -u%s -p%s %s",
					$this->mMYSQLdump,
					$wgDBserver,
					$wgDBuser,
					$wgDBpassword,
					$starterDB,
					$this->mMYSQLbin,
					$wgDBserver,
					$wgDBuser,
					$wgDBpassword,
					$this->mWikiData[ "dbname"]
				);
				$this->log($cmd);
				wfShellExec( $cmd );

				$error = $dbw->sourceFile( "{$IP}/maintenance/cleanupStarter.sql" );
				if ($error !== true) {
					$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step7') );
					$wgOut->addHTML(wfMsg('autocreatewiki-step7-error'));
					return;
				}

				$startupImages = sprintf( "%s/starter/%s/images/", self::IMGROOT, $prefix );

				if (file_exists( $startupImages ) && is_dir( $startupImages ) ) {
					wfShellExec("/bin/cp -af {$startupImages} /images/{$this->mWikiData[ "dir_part" ]}/");
					$this->log("/bin/cp -af {$startupImages} /images/{$this->mWikiData[ "dir_part" ]}/");
				}
				$cmd = sprintf(
					"SERVER_ID=%d %s %s/maintenance/updateArticleCount.php --update --conf %s",
					$this->mWikiId,
					$this->mPHPbin,
					$IP,
					$wgWikiaLocalSettingsPath
				);
				$this->log($cmd);
				wfShellExec( $cmd );

				$this->log( "Copying starter database" );
				$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step7') );
			}
			else {
				$this->log( "No starter database for this language, {$starterDB}" );
			}
		}

		/**
		 * making the wiki founder a sysop/bureaucrat
		 */
		if ( $wgUser->getID() ) {
			$dbw->replace( "user_groups", array( ), array( "ug_user" => $wgUser->getID(), "ug_group" => "sysop" ) );
			$dbw->replace( "user_groups", array( ), array( "ug_user" => $wgUser->getID(), "ug_group" => "bureaucrat" ) );
		}
		$this->log( "Create user sysop/bureaucrat" );

		/**
		 * set hub/category
		 */
		$hub = WikiFactoryHub::getInstance();
		$hub->setCategory( $this->mWikiId, $this->mWikiData[ "hub" ] );
		$this->log( "Wiki added to the category hub " . $this->mWikiData[ "hub" ] );

		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step8') );

		/**
		 * modify variables
		 */
		$this->addCustomSettings( 0, $wgUniversalCreationVariables, "universal" );

		/**
		 * set variables per language
		 */
		$this->addCustomSettings( $this->mWikiData[ "language" ], $wgLangCreationVariables, "language" );

		/**
		 * use starter when wikia in proper hub
		 */
		if( isset( $this->mStarters[ $this->mWikiData[ "hub" ] ] )
			&& $this->mStarters[ $this->mWikiData[ "hub" ] ]
			&& $this->mWikiData[ "language" ] === "en" ) {

			$wikiMover = WikiMover::newFromIDs(
				$this->mStarters[ $this->mWikiData[ "hub" ] ], /** source **/
				$this->mWikiId /** target **/
			);
			$wikiMover->setOverwrite( true );
			$wikiMover->mMoveUserGroups = false;
			$wikiMover->load();
			$wikiMover->setRunJobs( false );
			$wikiMover->setTargetUploadDirectory( $this->mWikiData[ "images" ] );
			$wikiMover->move();

			$this->addCustomSettings( $this->mWikiData[ "hub" ], $wgHubCreationVariables, 'hub' );
		}
		else {
			$this->log( sprintf( "There's not starters for category %d and language %s",
				$this->mWikiData[ 'hub' ], $this->mWikiData[ "language" ] ) );
		}

		/**
		 * set images timestamp to current date (see: #1687)
		 */
		$dbw->update(
			"image",
			array( "img_timestamp" => date('YmdHis') ),
			"*",
			__METHOD__
		);
		$this->log( "Set images timestamp to current date" );

		/**
		 * commit all in new database
		 */
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step9') );

		$dbw->commit();
		/**
		 * add local job
		 */
		$localJob = new AutoCreateWikiLocalJob(	Title::newFromText( NS_MAIN, "Main" ), $this->mWikiData );
		$localJob->WFinsert( $this->mWikiId, $this->mWikiData[ "dbname" ] );

		$dbw->selectDB( $wgDBname );

		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step10') );

		/**
		 * show congratulation message
		 */
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-congratulation')  );

		/**
		 * inform task manager
		 */
		$Task = new LocalMaintenanceTask();
		$Task->createTask(
			array(
				"city_id" => $this->mWikiId,
				"command" => "maintenance/runJobs.php",
				"type" => "ACWLocal",
				"data" => $this->mWikiData
			),
			TASK_QUEUED
		);
		$this->log( "Add local maintenance task" );

		/**
		 * show total time
		 */
		$this->log( sprintf( "Total: %F", wfTime() - $startTime ) );

		$sSubdomain = ( $this->awcLanguage === 'en' ) ? strtolower( trim( $this->awcDomain ) ) : $this->awcLanguage . "." . strtolower( trim( $this->awcDomain ) );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"domain" => sprintf("%s.%s", $sSubdomain, $this->mDefSubdomain),
		));

		$sFinishText = $oTmpl->execute("finish");
		$this->setInfoLog('END', $sFinishText);

		wfProfileOut( __METHOD__ );
	}

	private function prepareValues() {
		global $wgContLang;
		wfProfileIn( __METHOD__ );

		$this->mWikiData[ "hub" ]		= $this->awcCategory;
        $this->mWikiData[ "name" ]      = strtolower( trim( $this->awcDomain ) );
        $this->mWikiData[ "title" ]     = trim( $wgContLang->ucfirst( $this->awcName ) . " Wiki" );
        $this->mWikiData[ "language" ]  = $this->awcLanguage;
        $this->mWikiData[ "subdomain" ] = $this->mWikiData[ "name"];
        $this->mWikiData[ "redirect" ]  = $this->mWikiData[ "name"];
		$this->mWikiData[ "dir_part" ]  = $this->mWikiData[ "name"];
		$this->mWikiData[ "dbname" ]    = substr( str_replace( "-", "", $this->mWikiData[ "name"] ), 0, 64);
		$this->mWikiData[ "path" ]      = "/usr/wikia/docroot/wiki.factory";
        $this->mWikiData[ "images" ]    = self::IMGROOT . $this->mWikiData[ "name"] . "/images";
        $this->mWikiData[ "testWiki" ]  = false;

        if ( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" ) {
			$this->mWikiData[ "subdomain" ] = strtolower( $this->mWikiData[ "language"] ) . "." . $this->mWikiData[ "name"];
			$this->mWikiData[ "redirect" ]  = strtolower( $this->mWikiData[ "language" ] ) . "." . ucfirst( $this->mWikiData[ "name"] );
			$this->mWikiData[ "dbname" ]    = strtolower( str_replace( "-", "", $this->mWikiData[ "language" ] ). $this->mWikiData[ "dbname"] );
			$this->mWikiData[ "dir_part" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
			$this->mWikiData[ "images" ]    = self::IMGROOT . $this->mWikiData[ "dir_part"] . "/images";
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * create wiki form
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function createWikiForm() {
		global $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion, $wgScriptPath, $wgStylePath;
		global $wgCaptchaTriggers, $wgRequest, $wgDBname, $wgMemc;
		wfProfileIn( __METHOD__ );
		#-
		$aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
		$aLanguages = $this->getFixedLanguageNames();
		asort($aLanguages);
		#-
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
		#--
		$params = $this->fixSessionKeys();
		if ( empty($params) && empty($this->mPosted) ) {
			$ip = wfGetIP();
			$key = wfMemcKey( self::CACHE_LOGIN_KEY, $wgDBname, $ip );
			$params = $wgMemc->get($key);
		}
		#--
		$f = new FancyCaptcha();
		#--
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgStylePath}/common/form.js?{$wgStyleVersion}\"></script>" );
		/* run template */
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser" => $wgUser,
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion" => $wgStyleVersion,
			"aLanguages" => $aLanguages,
			"aTopLanguages" => $aTopLanguages,
			"aCategories" => $aCategories,
			"wgScriptPath" => $wgScriptPath,
			"mTitle" => $this->mTitle,
			"mPostedErrors" => $this->mPostedErrors,
			"wgStylePath" => $wgStylePath,
			"captchaForm" => $f->getForm(),
			"params" => $params
		));

		#---
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml($oTmpl->execute("create-wiki-form"));
		wfProfileOut( __METHOD__ );
		return;
	}

	/**
	 * create wiki form
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function processCreatePage() {
		global $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion, $wgScriptPath, $wgStylePath;
		global $wgCaptchaTriggers, $wgRequest;
		wfProfileIn( __METHOD__ );
		#-
		$aLanguages = $this->getFixedLanguageNames();
		#-
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
		#--
		/* run template */
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgStylePath}/common/form.js?{$wgStyleVersion}\"></script>" );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion" => $wgStyleVersion,
			"mTitle" => $this->mTitle,
			"awcName" => $this->awcName,
			"awcDomain" => $this->awcDomain,
			"awcCategory" => $this->awcCategory,
			"awcLanguage" => $this->awcLanguage,
			"subdomain" => ( $this->awcLanguage === 'en' ) ? strtolower( trim( $this->awcDomain ) ) : $this->awcLanguage . "." . strtolower( trim( $this->awcDomain ) ),
			"domain" => $this->mDefSubdomain,
		));

		#---
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml($oTmpl->execute("process-create-form"));
		wfProfileOut( __METHOD__ );
		return;
	}

	/**
	 * set request parameters
	 */
	private function makeRequestParams( $toSession = false) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$aValues = $wgRequest->getValues();
		if ( !empty($aValues) && is_array($aValues) ) {
			foreach ($aValues as $key => $value) {
				$k = trim($key);
				if ( strpos($key, "wiki-") !== false ) {
					$key = str_replace("wiki-", "", $key);
					if ( $toSession === true ) {
						$key = str_replace("-", "_", "awc".ucfirst($key));
						$_SESSION[$key] = strip_tags($value);
					} else {
						$key = str_replace("-", "_", "m".ucfirst($key));
						$this->mPostedErrors[$k] = "";
						$this->$key = strip_tags($value);
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/*
	 *
	 */
	private function fixSessionKeys() {
		global $wgRequest;
		$__params = $wgRequest->getValues();
		$params = array();
		if ( !empty($__params) && is_array($__params) ) {
			foreach ($__params as $key => $value) {
				$k = trim($key);
				if ( strpos($key, "wiki-") !== false ) {
					$params[$key] = htmlspecialchars($value);
				}
			}
		}
		return $params;
	}

	/**
	 * clear session parameters
	 */
	private function clearSessionKeys() {
		wfProfileIn( __METHOD__ );
		$res = 0;
		if ( !empty($_SESSION) && is_array($_SESSION) ) {
			foreach ($_SESSION as $key => $value) {
				if ( preg_match('/^awc/', $key, $m) ) {
					unset($_SESSION[$key]);
					$res++;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * set local variables from session
	 */
	private function setVarsFromSession() {
		wfProfileIn( __METHOD__ );
		$res = 0;
		foreach ($_SESSION as $key => $value) {
			if ( preg_match('/^awc/', $key) !== false ) {
				$this->$key = $value;
				$res++;
			}
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * check wiki creation form
	 */
	private function checkWikiCreationParams() {
		global $wgUser;
		$res = true;
		wfProfileIn( __METHOD__ );

		#-- check Wiki's name
		$sResponse = AutoCreateWiki::checkWikiNameIsCorrect($this->mName);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-name", $sResponse );
			$res = false;
		}

		#-- check Wiki's domain
		$sResponse = AutoCreateWiki::checkDomainIsCorrect($this->mDomain, $this->mLanguage);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-domain", $sResponse );
			$res = false;
		}

		#-- check Wiki's category
		$sResponse = AutoCreateWiki::checkCategoryIsCorrect($this->mCategory);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-category", $sResponse );
			$res = false;
		}

		#-- check Wiki's language
		$sResponse = AutoCreateWiki::checkLanguageIsCorrect($this->mLanguage);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-language", $sResponse );
			$res = false;
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * create account function (see SpecialUserLogin.php to compare)
	 */
	private function addNewAccount() {
		global $wgUser, $wgOut;
		global $wgEnableSorbs, $wgProxyWhitelist;
		global $wgMemc, $wgAccountCreationThrottle;
		global $wgAuth, $wgMinimalPasswordLength;
		global $wgEmailConfirmToEdit;

		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		$ip = wfGetIP();

		#-- check username
		$sResponse = AutoCreateWiki::checkUsernameIsCorrect($this->mUsername);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-username", $sResponse );
		}

		#-- check email
		$sResponse = AutoCreateWiki::checkEmailIsCorrect($this->mEmail);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-email", $sResponse );
		}

		#-- check if the date has been choosen
		$sResponse = AutoCreateWiki::checkBirthdayIsCorrect($this->mUser_year, $this->mUser_month, $this->mUser_day);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-birthday", $sResponse );
		}

		# Check permissions
		if ( !$wgUser->isAllowed( 'createaccount' ) ) {
			$this->makeError( "wiki-username", wfMsg('autocreatewiki-blocked-username') );
		} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
			$blocker = User::whoIs( $wgUser->mBlock->mBy );
			$block_reason = $wgUser->mBlock->mReason;
			if ( strval( $block_reason ) === '' ) {
				$block_reason = wfMsg( 'blockednoreason' );
			}
			$this->makeError( "wiki-username", wfMsg('autocreatewiki-blocked-username', $ip, $block_reason, $blocker) );
		}

		$ip = wfGetIP();
		if ( $wgEnableSorbs && !in_array( $ip, $wgProxyWhitelist ) && $wgUser->inSorbsBlacklist( $ip ) ) {
			$this->makeError( "wiki-username", wfMsg( 'sorbs_create_account_reason' ) . ' (' . htmlspecialchars( $ip ) . ')' );
		}

		$sResponse = AutoCreateWiki::checkPasswordIsCorrect($this->mUsername, $this->mPassword);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-password", $sResponse );
		}

		$sResponse = AutoCreateWiki::checkRetypePasswordIsCorrect($this->mPassword, $this->mRetype_password);
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-retype-password", $sResponse );
		}

		# Now create a dummy user ($oUser) and check if it is valid
		$name = trim( $this->mUsername );
		$oUser = User::newFromName( $name, 'creatable' );
		if ( is_null( $oUser ) ) {
			$this->makeError( "wiki-username", wfMsg( 'noname' ) );
		} else {
			if ( 0 != $oUser->idForName() ) {
				$this->makeError( "wiki-username", wfMsg( 'userexists' ) );
			}
		}

		if ( $oUser instanceof User) {
			# Set some additional data so the AbortNewAccount hook can be
			# used for more than just username validation
			$oUser->setEmail( $this->mEmail );

			$abortError = '';
			if ( !wfRunHooks( 'AbortNewAccount', array( $oUser, &$abortError ) ) ) {
				// Hook point to add extra creation throttles and blocks
				wfDebug( "LoginForm::addNewAccountInternal: a hook blocked creation\n" );
				$this->makeError( "wiki-blurry-word", $abortError );
			}

			if ( $wgAccountCreationThrottle && $wgUser->isPingLimitable() ) {
				$key = wfMemcKey( 'acctcreate', 'ip', $ip );
				$value = $wgMemc->incr( $key );
				if ( !$value ) {
					$wgMemc->set( $key, 1, 86400 );
				}
				if ( $value > $wgAccountCreationThrottle ) {
					$this->makeError( "wiki-username", wfMsgExt('acct_creation_throttle_hit', $wgAccountCreationThrottle) );
				}
			}

			if ( !$wgAuth->addUser( $oUser, $this->mPassword, $this->mEmail, "" ) ) {
				$this->makeError( "wiki-username", wfMsg('externaldberror') );
			}
		} else {
			$this->makeError( "wiki-username", wfMsg('autocreatewiki-blocked-username') );
		}

		if ( $this->mErrors > 0 ) {
			$oUser = null;
		} else {
			$userBirthDay = strtotime("{$this->mUser_year}-{$this->mUser_month}-{$this->mUser_day}");
			$oUser = $this->initUser( $oUser, false );
			$user_id = $oUser->getID();
			if (!empty($user_id)) {
				$dbw = wfGetDB(DB_MASTER);
				$dbw->update(
					'user',
					array( 'user_birthdate' => date('Y-m-d', $userBirthDay) ),
					array( 'user_id' => $user_id ),
					__METHOD__
				);
			}
			$result = $oUser->sendConfirmationMail();
		}

		wfProfileOut( __METHOD__ );
		return $oUser;
	}

	/**
	 * Actually add a user to the database.
	 * Give it a User object that has been initialised with a name.
	 *
	 * @param $oUser User object.
	 * @param $autocreate boolean -- true if this is an autocreation via auth plugin
	 * @return User object.
	 * @private
	 */
	function initUser( $oUser, $autocreate ) {
		global $wgAuth;
		wfProfileIn( __METHOD__ );

		$oUser->addToDatabase();

		if ( $wgAuth->allowPasswordChange() ) {
			$oUser->setPassword( $this->mPassword );
		}

		$oUser->setEmail( $this->mEmail );
		$oUser->setToken();

		$wgAuth->initUser( $oUser, $autocreate );

		$oUser->setOption( 'rememberpassword', isset($this->mRemember) ? 1 : 0 );
		$oUser->setOption('skinoverwrite', 1);

		$oUser->saveSettings();

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		wfProfileOut( __METHOD__ );
		return $oUser;
	}

	/*
	 * Login after create account
	 */
	private function loginAfterCreateAccount() {
		wfProfileIn( __METHOD__ );
		$apiParams = array(
			"action" => "login",
			"lgname" => $this->mUsername,
			"lgpassword" => $this->mPassword,
		);
		$oApi = new ApiMain( new FauxRequest( $apiParams ) );
		$oApi->execute();
		$aResult = &$oApi->GetResultData();
		wfProfileOut( __METHOD__ );

		return ( isset($aResult['login']['result']) && ( $aResult['login']['result'] == 'Success' ) );
	}

	/**
	 * create account function (see SpecialUserLogin.php to compare)
	 */
	private function makeError( $key, $msg ) {
		if ( array_key_exists($key, $this->mPostedErrors) ) {
			if ( empty( $this->mPostedErrors[$key] ) ) {
				$this->mPostedErrors[$key]= $msg;
			}
		}
		$this->mErrors++;
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

        if( !empty( $match ) && isset( $settings[ $match ] ) && is_array( $settings[ $match ] ) ) {
            $this->log("Found '$match' in $type settings array.");

            /**
			 * switching user for correct logging
			 */
            $oldUser = $wgUser;
            $wgUser = User::newFromName( 'CreateWiki script' );

            foreach( $settings[$match] as $key => $value ) {
                $success = WikiFactory::setVarById( $key, $this->mWikiId, $value );
                if( $success ) {
                    $this->log("Successfully added setting for {$this->mWikiId}: {$key} = {$value}");
                } else {
                    $this->log("Failed to add setting for {$this->mWikiId}: {$key} = {$value}");
                }
            }
			$wgUser = $oldUser;

			$this->log("Finished adding $type settings.");
        } else {
            $this->log("'$match' not found in $type settings array. Skipping this step.");
		}

		wfProfileOut( __METHOD__ );
		return 1;
	}


	/**
	 * common log function
	 */
	private function log( $info ) {
		global $wgOut, $wgUser, $wgErrorLog;

		$oldValue = $wgErrorLog;
		$wgErrorLog = true;
		$info = sprintf( "%s: %F", $info, wfTime() - $this->mCurrTime );
		Wikia::log( __METHOD__, "", $info );
		$wgErrorLog = $oldValue;
		$this->mCurrTime = wfTime();
	}

	/**
	 * set log to display info by js AJAX functions
	 */
	private function setInfoLog($msgType, $sInfo) {
		wfProfileIn( __METHOD__ );
		$aParams = 	array (
			'awcName' => $this->awcName,
			'awcDomain' => $this->awcDomain,
			'awcCategory' => $this->awcCategory,
			'awcLanguage' => $this->awcLanguage
		);
		$aInfo = array( 'type' => $msgType, 'info' => $sInfo );
		$key = AutoCreateWiki::logMemcKey ("set", $aParams, $aInfo);
		wfProfileOut( __METHOD__ );
		return $key;
	}

	/**
	 * set form fields values to memc
	 */
	private function setValuesToSession() {
		global $wgDBname, $wgRequest,$wgMemc;
		$params = $this->fixSessionKeys();
		if (!empty($params)) {
			$ip = wfGetIP();
			$key = wfMemcKey( self::CACHE_LOGIN_KEY, $wgDBname, $ip );
			$wgMemc->set( $key, $params, 30);
		}
	}

	/**
	 * get number of created Wikis for current day
	 */
	private function countCreatedWikis($iUser = 0) {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );
		$where = array( "date_format(city_created, '%Y%m%d') = date_format(now(), '%Y%m%d')" );
		if ( !empty($iUser) ) {
			$where[] = "city_founding_user = '{$iUser}' ";
		}
		$oRow = $dbr->selectRow(
			wfSharedTable("city_list"),
			array( "count(*) as count" ),
			$where,
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return intval($oRow->count);
	}

	/**
	 * get number of created Wikis by user today
	 */
	private function countCreatedWikisByUser() {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$iUser = $wgUser->getId();
		$iCount = $this->countCreatedWikis($iUser);

		wfProfileOut( __METHOD__ );
		return $iCount;
	}

	/*
	 * get a list of language names available for wiki request
	 * (possibly filter some)
	 *
	 * @author nef@wikia-inc.com
	 * @return array
	 *
	 * @see Language::getLanguageNames()
	 * @see RT#11870
	 */
	private function getFixedLanguageNames() {
		$languages = Language::getLanguageNames();

		$filter_languages = explode(',', wfMsg('requestwiki-filter-language'));
		foreach ($filter_languages as $key) {
			unset($languages[$key]);
		}
		return $languages;
	}

}
