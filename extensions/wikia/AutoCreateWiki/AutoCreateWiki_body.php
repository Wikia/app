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
		$mLang,
		$mWikiId,
		$mMYSQLdump,
		$mMYSQLbin,
		$mPHPbin,
		$mCurrTime,
		$mPosted,
		$mPostedErrors,
		$mErrors,
		$mUserLanguage,
		$mDefaultUser,
		$mType,            // type of form: answers, recipes; default not set
		$mStarters;

	/**
	 * test database, CAUTION! content will be destroyed during tests
	 */
	const TESTDB            = "testdb";
	const STARTER_GAME      = 2; /** gaming **/
	const STARTER_ENTE      = 3; /** enter. **/
	const STARTER_SPRT      = 15; /** sport **/
	const LOG               = "autocreatewiki";
	const IMGROOT           = "/images/";
	const IMAGEURL          = "http://images.wikia.com/";
	const CREATEWIKI_LOGO   = "/images/c/central/images/2/22/Wiki_Logo_Template.png";
	const CREATEWIKI_ICON   = "/images/c/central/images/6/64/Favicon.ico";
	const SESSION_TIME      = 60;
	const DAILY_LIMIT       = 1000;
	const DAILY_USER_LIMIT  = 2;
	const DEFAULT_STAFF     = "Angela";
	const DEFAULT_USER      = 'Default';
	const DEFAULT_DOMAIN    = "wikia.com";
	const CACHE_LOGIN_KEY   = 'awc_beforelog';
	const ACTIVE_CLUSTER    = "c2";
	const DEFAULT_NAME      = "Wiki";
	const DEFAULT_WIKI_TYPE = "default";

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
	 * set title of page, override default method in parent class
	 * @access public
	 *
	 * @author Krzysztof Krzyżaniak (eloy)
	 */
	public function getDescription() {
		switch( $this->mType ) {
			case "answers":
				$key = "autocreatewiki-page-title-answers";
				break;
			default:
				$key = "autocreatewiki-page-title-default";
		}
		return wfMsg( $key );
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
			$wgContLanguageCode, $wgContLang;

		wfLoadExtensionMessages( "AutoCreateWiki" );

		$this->mTitle        = Title::makeTitle( NS_SPECIAL, "CreateWiki" );
		$this->mLang         = $wgRequest->getVal( "uselang", $wgUser->getOption( 'language' ) );
		$this->mAction       = $wgRequest->getVal( "action", false );
		$this->mType         = $wgRequest->getVal( "type", false );
		$this->mSubpage      = $subpage;
		$this->mPosted       = $wgRequest->wasPosted();
		$this->mPostedErrors = array();
		$this->mErrors       = 0;

		$this->setHeaders();

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}


		/**
		 * other AWC version changes, so far answers only
		 */
		$this->fixSubdomains($this->mLang);
		
		$this->mUserLanguage = $wgUser->getOption( 'language', $wgContLanguageCode );
		$this->mNbrCreated = $this->countCreatedWikis();

		if( !$wgUser->isAllowed( 'createwikilimitsexempt' ) && ($this->mNbrCreated >= self::DAILY_LIMIT) ) {
			$wgOut->addHTML(
				wfMsgExt( "autocreatewiki-limit-day",
					array( "language" => $this->mUserLanguage ), array( $this->mNbrCreated )
			));
			return;
		}

		switch ( $subpage ) {
			case "Caching": {
					$this->setValuesToSession();
					break;
			}
			case "Processing" : {
					$this->log (" session: " . print_r($_SESSION, true). "\n");
					#--- restriction
					if ( $wgUser->isAnon() ) {
						$this->displayRestrictionError();
					} elseif ( $wgUser->isBlocked() ) {
						$wgOut->blockedPage();
					}
					if ( isset( $_SESSION['mAllowToCreate'] ) /*&& ( $_SESSION['mAllowToCreate'] >= wfTimestamp() )*/ ) {
						$this->mNbrUserCreated = $this->countCreatedWikisByUser();
						if ( !$wgUser->isAllowed( 'createwikilimitsexempt' ) && ($this->mNbrUserCreated >= self::DAILY_USER_LIMIT) ) {
							$wgOut->addHTML(
								wfMsgExt( "autocreatewiki-limit-creation",
									array( "language" => $this->mUserLanguage ), array( $this->mNbrUserCreated )
							));
						}
						if ( $this->setVarsFromSession() > 0 ) {
							$this->createWiki();
						} else {
							unset($_SESSION['mAllowToCreate']);
						}
					} else {
						$this->log ("restriction error\n");
						$this->displayRestrictionError();
					}
					break;
			}
			case "Wiki_create" : {
					#--- restriction
					if ( $wgUser->isAnon() ) {
						$this->displayRestrictionError();
						return;
					} elseif ( $wgUser->isBlocked() ) {
						$wgOut->blockedPage();
						return;
					}
					if( isset( $_SESSION['mAllowToCreate'] ) ) {
						/**
						 * Limit of user creation
						 */
						$this->mNbrUserCreated = $this->countCreatedWikisByUser();
						if ( !$wgUser->isAllowed( 'createwikilimitsexempt' ) && ($this->mNbrUserCreated >= self::DAILY_USER_LIMIT) ) {
							$wgOut->addHTML(
								wfMsgExt( "autocreatewiki-limit-creation",
									array( "language" => $this->mUserLanguage ), array(	$this->mNbrUserCreated )
							));
							return;
						} else {
							if( $this->setVarsFromSession( ) > 0 ) {
								$this->processCreatePage();
							}
						}
					} else {
						$this->clearSessionKeys();
						$query = ( $this->mLang != 'en' ) ? 'uselang=' . $this->mLang : '';
						$wgOut->redirect( $this->mTitle->getLocalURL($query) );
					}
					break;
			}
			default: {
					if ( ($this->mPosted) && ($this->mAction != "reload") ) {
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
						} else {
							#-- user logged in or just create
							if ( empty( $this->mErrors ) && ( $wgUser->getID() > 0 ) ) {
								#--- save values to session and redirect
								$user_id = $wgUser->getID();
								$this->makeRequestParams(true);
								if ( !isset($_SESSION['mAllowToCreate']) ) {
									$aToken = array(
										$_SESSION['awcName'],
										$_SESSION['awcDomain'],
										$_SESSION['awcCategory'],
										$_SESSION['awcLanguage']
									);
									#wfTimestamp() + self::SESSION_TIME;
									$_SESSION['mAllowToCreate'] = md5(implode("_", $aToken) . "_" . $user_id);
									$query = array();
									if ( $this->mLang != 'en' ) $query[ "uselang" ] = $this->mLang;
									if ( !empty(  $this->mType ) ) $query[ "type" ] = $this->mType;
									$wgOut->redirect( $this->mTitle->getLocalURL() . '/Wiki_create?' . wfArrayToCGI( $query ) );
								}
							} else {
								#--- some errors
								if ( isset($_SESSION['mAllowToCreate']) ) {
									unset($_SESSION['mAllowToCreate']);
								}
							}
						}
					} else {
						if (isset($_SESSION['mAllowToCreate'])) {
							unset($_SESSION['mAllowToCreate']);
						}
					}
					$this->createWikiForm();
					break;
			}
		}
	}

	/**
	 * main function for extension -- create wiki in wikifactory cluster
	 * we are assumming that data is valid!
	 *
	 */
	private function createWiki() {
		global $wgOut, $wgUser, $IP, $wgDBname, $wgDevelDomains;
		global $wgSharedDB, $wgExternalSharedDB, $wgDBcluster, $wgDevelEnvironment;
		global $wgDBserver, $wgDBuser,	$wgDBpassword, $wgWikiaLocalSettingsPath;
		global $wgHubCreationVariables, $wgLangCreationVariables, $wgUniversalCreationVariables;

		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, "type", "type={$this->mType}" );
		/**
		 * don't allow to create the same Wiki after page refresh
		 */
		if ( isset($_SESSION['mAllowToCreate']) ) {
			unset($_SESSION['mAllowToCreate']);
		}

		if( strpos( $wgWikiaLocalSettingsPath, "central") !== false ) {
			$wgWikiaLocalSettingsPath = str_replace( "central", "wiki.factory", $wgWikiaLocalSettingsPath );
		}

		/**
		 * this will clean test database and fill mWikiData with test data
		 */
		$this->prepareValues();

		if ( $this->mFounder->getId() == 0 ) {
			$query = ( $this->mLang != 'en' ) ? 'uselang=' . $this->mLang : '';
			$wgOut->redirect( $this->mTitle->getLocalURL($query) );
		}

		/*
		 * time of process begin
		 */
		$this->mCurrTime = wfTime();
		$startTime = $this->mCurrTime;

		/**
		 * check and create database
		 */
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); # central

		/**
		 * local database handled is handler to cluster we create new wiki.
		 * It doesn't have to be the same like wikifactory cluster or db cluster
		 * where Special:CreateWiki exists.
		 *
		 * @todo do not use hardcoded name, code below is only for test
		 *
		 * set $activeCluster to false if you want to create wikis on first
		 * cluster
		 */
		$dbname = ( self::ACTIVE_CLUSTER ) ? "wikicities_" . self::ACTIVE_CLUSTER : "wikicities";

		/*
		 * connect to the local database
		 */
		$dbwTarget = wfGetDB( DB_MASTER, array(), $dbname );

		$msgType = 'OK';
		if ( !$this->canCreateDatabase() ) {
			$this->log( "Database {$this->mWikiData[ "dbname"]} exists" );
			$msgType = 'ERROR';
		} else {
			$row = $dbwTarget->selectRow(
				"INFORMATION_SCHEMA.SCHEMATA",
				array( "SCHEMA_NAME as name" ),
				array( 'SCHEMA_NAME' => $this->mWikiData[ "dbname"]),
				__METHOD__
			);

			if( isset( $row->name ) && $row->name === $this->mWikiData[ "dbname"] ) {
				$this->log( "Database {$this->mWikiData[ "dbname"]} exists" );
				$msgType = 'ERROR';
			}
			else {
				$dbwTarget->query( sprintf( "CREATE DATABASE `%s`", $this->mWikiData[ "dbname"]) );
				$this->log( "Creating database {$this->mWikiData[ "dbname"]}" );
			}
		}

		$this->setInfoLog( $msgType, wfMsg('autocreatewiki-step2') );
		if( $msgType == 'ERROR' ) {
			return;
		}

		/**
		 * create position in wiki.factory
		 * (I like sprintf construction, so sue me)
		 */
		$insertFields = array(
			'city_title'          => $this->mWikiData[ "title" ],
			'city_dbname'         => $this->mWikiData[ "dbname"],
			'city_url'            => $this->mWikiData[ "url" ],
			'city_founding_user'  => $this->mWikiData[ "founder" ],
			'city_founding_email' => $this->mWikiData[ "founder-email" ],
			'city_path'           => $this->mWikiData[ "path" ],
			'city_description'    => $this->mWikiData[ "title" ],
			'city_lang'           => $this->mWikiData[ "language" ],
			'city_created'        => wfTimestamp( TS_DB, time() ),
		);
		if( self::ACTIVE_CLUSTER ) {
			$insertFields[ "city_cluster" ] = self::ACTIVE_CLUSTER;
		}


		$bIns = $dbw->insert( "city_list", $insertFields, __METHOD__ );
		if ( empty($bIns) ) {
			#----
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
			#----
			$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step3') );
			$this->log( "Empty city_id = {$this->mWikiId}" );
			$wgOut->addHTML(wfMsg('autocreatewiki-step3-error'));
			return;
		}

		$this->log( "Creating row in city_list table, city_id = {$this->mWikiId}" );

		$res = $dbw->insert(
			"city_domains",
			array(
				array(
					'city_id'     => $this->mWikiId,
					'city_domain' => $this->mWikiData[ "domain" ]
				),
				array(
					'city_id'     => $this->mWikiId,
					'city_domain' => sprintf( "www.%s", $this->mWikiData[ "domain" ] )
				)
			),
			__METHOD__
		);

		if ( empty( $res ) ) {
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

		$sqlfiles = array(
			"{$IP}/maintenance/tables.sql",
			"{$IP}/maintenance/interwiki.sql",
			"{$IP}/maintenance/wikia/default_userrights.sql",
			"{$IP}/maintenance/wikia/city_interwiki_links.sql",
			"{$IP}/maintenance/wikia-additional-tables.sql",
			"{$IP}/extensions/CheckUser/cu_changes.sql",
			"{$IP}/extensions/CheckUser/cu_log.sql",
		);

		/**
		 * additional tables per type
		 */
		switch( $this->mType ) {
			case "answers":
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/SystemGifts/systemgifts.sql";
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/UserGifts/usergifts.sql";
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/UserProfile/user_profile.sql";
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/UserBoard/user_board.sql";
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/UserRelationship/user_relationship.sql";
				$sqlfiles[] = "{$IP}/extensions/SocialProfile/UserStats/user_stats.sql";
				$sqlfiles[] = "{$IP}/maintenance/answers-additional-tables.sql";
				break;
		}

		foreach ($sqlfiles as $file) {
			$error = $dbwTarget->sourceFile( $file );
			if ( $error !== true ) {
				$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step6') );
				$wgOut->addHTML(wfMsg('autocreatewiki-step6-error'));
				return;
			}
		}
		$this->log( "Creating tables in database" );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step6') );

		/**
		 * import language starter
		 */
		$starter = $this->getStarter();
		if( $starter !== false ) {
			/**
			 * @fixme we should not assume that dbw in this place is to first
			 * cluster
			 */
			$cmd = sprintf(
				"%s -h%s -u%s -p%s %s categorylinks externallinks image imagelinks langlinks page pagelinks revision templatelinks text | %s -h%s -u%s -p%s %s",
				$this->mMYSQLdump,
				$starter[ "host"      ],
				$starter[ "user"      ],
				$starter[ "password"  ],
				$starter[ "dbStarter" ],
				$this->mMYSQLbin,
				$dbwTarget->getLBInfo( 'host' ),
				$wgDBuser,
				$wgDBpassword,
				$this->mWikiData[ "dbname"]
			);
			$this->log($cmd);
			wfShellExec( $cmd );

			$error = $dbwTarget->sourceFile( "{$IP}/maintenance/cleanupStarter.sql" );
			if ($error !== true) {
				$this->setInfoLog( 'ERROR', wfMsg('autocreatewiki-step7') );
				$wgOut->addHTML(wfMsg('autocreatewiki-step7-error'));
				return;
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
		 * commit all in new database
		 */
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step9') );

		/**
		 * add local job
		 */
		$localJob = new AutoCreateWikiLocalJob(	Title::newFromText( NS_MAIN, "Main" ), $this->mWikiData );
		$localJob->WFinsert( $this->mWikiId, $this->mWikiData[ "dbname" ] );
		$this->setInfoLog( 'OK', wfMsg('autocreatewiki-step10') );

		/**
		 * destroy connection to newly created database
		 */
		$dbwTarget->commit();
		$wgSharedDB = $tmpSharedDB;

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
		$wiki_type = ( !empty($this->mType) ) ? $this->mType : self::DEFAULT_WIKI_TYPE;
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
			$this->mWikiId,
			$this->mPHPbin,
			$IP,
			$this->mWikiData[ "title" ],
			$wgWikiaLocalSettingsPath
		);
		$this->log($cmd);
		$output = wfShellExec( $cmd );
		$this->log( $output );

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
				"city_id" 	=> $this->mWikiId,
				"command" 	=> "maintenance/runJobs.php",
				"type" 		=> "ACWLocal",
				"data" 		=> $this->mWikiData
			),
			TASK_QUEUED
		);
		$this->log( "Add local maintenance task" );


		/**
		 * show total time
		 */
		$this->log( sprintf( "Total: %F", wfTime() - $startTime ) );

		/**
		 * show template with url to new created Wiki
		 */
		if( !empty( $wgDevelEnvironment ) ) {
			$domain = array_shift( $wgDevelDomains );
			$domain = str_replace( self::DEFAULT_DOMAIN, $domain, $this->mWikiData[ "url" ] );
		}
		else {
			$domain = $this->mWikiData[ "url" ];
		}
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"domain" => $domain,
			"type"   => $this->mType
		) );

		// New Wiki Builder isn't supported by all languages yet
		$NewWikiBuilderLanguages = array('en', 'de', 'es', 'nl');
		if( in_array($this->mWikiData[ "language" ], $NewWikiBuilderLanguages ) ){
			$sFinishText = $oTmpl->render("finish");
		} else {
			$sFinishText = $oTmpl->render("finish_old");
		}
		$this->log( "return " . $this->mWikiData[ "url" ] );
		$this->setInfoLog('END', $sFinishText);

		wfProfileOut( __METHOD__ );
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
		global $wgContLang, $wgUser;
		wfProfileIn( __METHOD__ );

		$this->mLangSubdomain = true;
		$this->mFounder = $wgUser;
		$this->mDefaultUser = User::newFromName( self::DEFAULT_USER );
		$this->mDefaultUser->load();

		$this->fixSubdomains($this->awcLanguage);

		#-- for other users -> for staff only
		if ( $wgUser->isAllowed( 'createwikimakefounder' ) && !empty($this->awcStaff_username) ) {
			$this->mFounder = User::newFromName($this->awcStaff_username);
		}

		$fixedTitle = trim( $this->awcName );
		$fixedTitle = preg_replace("/\s+/", " ", $fixedTitle );
		$fixedTitle = preg_replace("/ (w|W)iki$/", "", $fixedTitle );
		$fixedTitle = $wgContLang->ucfirst( $fixedTitle );
		$this->awcDomain = preg_replace( "/(\-)+$/", "", $this->awcDomain );
		$this->awcDomain = preg_replace( "/^(\-)+/", "", $this->awcDomain );

		$this->mWikiData[ "type"       ] = $this->mType;
		$this->mWikiData[ "hub"        ] = $this->awcCategory;
		$this->mWikiData[ "name"       ] = strtolower( trim( $this->awcDomain ) );
		$this->mWikiData[ "title"      ] = $fixedTitle . " Wiki";

		switch( $this->mType ) {
			case "answers":
				$this->mWikiData[ "title"      ] = $fixedTitle . " " . $this->mDefSitename;
				break;
		}

		$this->mWikiData[ "language"   ] = $this->awcLanguage;
		$this->mWikiData[ "subdomain"  ] = $this->mWikiData[ "name"];
		$this->mWikiData[ "redirect"   ] = $this->mWikiData[ "name"];

		$this->mWikiData[ "path"       ] = "/usr/wikia/docroot/wiki.factory";
		$this->mWikiData[ "testWiki"   ] = false;

		$this->mWikiData[ "images_url" ] = $this->prepareDirValue();
		$this->mWikiData[ "images_dir" ] = sprintf("%s/%s", strtolower( substr( $this->mWikiData[ "name"], 0, 1 ) ), $this->mWikiData[ "images_url" ]);

		if ( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" ) {
			if ( $this->mLangSubdomain ) {
				$this->mWikiData[ "subdomain"  ]  = strtolower( $this->mWikiData[ "language"] ) . "." . $this->mWikiData[ "name"];
				$this->mWikiData[ "redirect"   ]  = strtolower( $this->mWikiData[ "language" ] ) . "." . ucfirst( $this->mWikiData[ "name"] );
			}
			$this->mWikiData[ "images_url" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
			$this->mWikiData[ "images_dir" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
		}

		switch( $this->mType ) {
			case "answers":
				$this->mWikiData[ "images_url" ] .= "/" . $this->mType;
				$this->mWikiData[ "images_dir" ] .= "/" . $this->mType;
				break;
		}

		$this->mWikiData[ "images_dir"    ] = self::IMGROOT  . $this->mWikiData[ "images_dir" ] . "/images";
		$this->mWikiData[ "images_url"    ] = self::IMAGEURL . $this->mWikiData[ "images_url" ] . "/images";
		$this->mWikiData[ "images_logo"   ]	= sprintf("%s/%s", $this->mWikiData[ "images_dir" ], "b/bc" );
		$this->mWikiData[ "images_icon"   ]	= sprintf("%s/%s", $this->mWikiData[ "images_dir" ], "6/64" );

		$this->mWikiData[ "domain"        ] = sprintf("%s.%s", $this->mWikiData[ "subdomain" ], $this->mDefSubdomain);
		$this->mWikiData[ "url"           ] = sprintf( "http://%s.%s/", $this->mWikiData[ "subdomain" ], $this->mDefSubdomain );
		$this->mWikiData[ "dbname"        ] = $this->prepareDBName( $this->mWikiData[ "name"], $this->awcLanguage );
		$this->mWikiData[ "founder"       ] = $this->mFounder->getId();
		$this->mWikiData[ "founder-name"  ] = $this->mFounder->getName();
		$this->mWikiData[ "founder-email" ] = $this->mFounder->getEmail();
		$this->mWikiData[ "type"          ] = $this->mType;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * check folder exists
	 *
	 * @access private
	 *
	 * @param
	 */
	private function prepareDirValue() {
		wfProfileIn( __METHOD__ );
		#---
		$this->log( "Checking {$this->mWikiData[ "name"]} folder" );

		$isExist = false; $suffix = "";
		$prefix = strtolower( substr( $this->mWikiData[ "name"], 0, 1 ) );
		$dir_base = $this->mWikiData[ "name"];
		$dir_lang = ( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" )
				? "/" . strtolower( $this->mWikiData[ "language" ] )
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
		$aLanguages = wfGetFixedLanguageNames();
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
		$f = new FancyCaptcha();
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<!--[if IE 7]><link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.ie7.css?{$wgStyleVersion}\" /><![endif]-->" ); // RT #19245
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgStylePath}/common/form.js?{$wgStyleVersion}\"></script>" );

		/**
		 * run template
		 */
		$this->mAction = $wgRequest->getVal( "action", false );

		if( $this->mAction == "reload" ){
			$params['wiki-name'] = $wgRequest->getVal( 'wiki-name', false );
			$params['wiki-domain'] = $wgRequest->getVal( 'wiki-domain', false );
			$params['wiki-category'] = $wgRequest->getVal( 'wiki-category', false );
			$params['wiki-language'] = $wgRequest->getVal( 'wiki-language', false );
			$params['wiki-type'] = $wgRequest->getVal( 'wiki-type', false );
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"subDomain"        => $this->mDefSubdomain,
			"wgUser"           => $wgUser,
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion"   => $wgStyleVersion,
			"aLanguages"       => $aLanguages,
			"aTopLanguages"    => $aTopLanguages,
			"aCategories"      => $aCategories,
			"wgScriptPath"     => $wgScriptPath,
			"mTitle"           => $this->mTitle,
			"mType"            => $this->mType,
			"mLanguage"        => $this->mLang,
			"mPostedErrors"    => $this->mPostedErrors,
			"wgStylePath"      => $wgStylePath,
			"captchaForm"      => $f->getForm(),
			"params"           => $params,
			"subName"          => $this->mDefSitename,
			"defaultDomain"    => self::DEFAULT_DOMAIN,
			"mDomains"         => $this->mDomains,
			"mSitenames"       => $this->mSitenames
		));

		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml( $oTmpl->render("create-wiki-form") );

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

		$aLanguages  = wfGetFixedLanguageNames();
		$hubs        = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();

		/**
		 * run template
		 */
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgStylePath}/common/form.js?{$wgStyleVersion}\"></script>" );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$query = array();
		if ( $this->mLang != 'en' ) $query[ "uselang" ] = $this->mLang;
		if ( !empty(  $this->mType ) ) $query[ "type" ] = $this->mType;

		$oTmpl->set_vars( array(
			"mQuery"           => wfArrayToCGI( $query ),
			"mType"            => $this->mType,
			"mTitle"           => $this->mTitle,
			"mLanguage"        => $this->mLang,
			"awcName"          => $this->awcName,
			"awcDomain"        => $this->awcDomain,
			"awcCategory"      => $this->awcCategory,
			"awcLanguage"      => $this->awcLanguage,
			"domain"           => $this->mDefSubdomain,
			"subdomain"        => ( $this->awcLanguage === 'en' && $this->mLangSubdomain ) ? strtolower( trim( $this->awcDomain ) ) : $this->awcLanguage . "." . strtolower( trim( $this->awcDomain ) ),
			"ajaxToken"        => md5($this->mTitle . "_" . $this->awcName . "_" . $this->awcDomain . "_" . $this->awcCategory . "_" . $this->awcLanguage ),
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion"   => $wgStyleVersion,
		));

		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml( $oTmpl->render( "process-create-form" ) );

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
					if( $toSession === true ) {
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

	/**
	 * update session keys from request data
	 *
	 * @access private
	 * @author Piotr Molski <moli@wikia-inc.com>
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
			if(!isset($params['wiki-marketing'])) {
				$params['wiki-marketing-unchecked'] = true;
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
		foreach( $_SESSION as $key => $value) {
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
		$sResponse = AutoCreateWiki::checkWikiNameIsCorrect($this->mName, $this->mLanguage, $this->mType );
		if ( !empty($sResponse) ) {
			$this->makeError( "wiki-name", $sResponse );
			$res = false;
		}

		#-- check Wiki's domain
		$sResponse = AutoCreateWiki::checkDomainIsCorrect($this->mDomain, $this->mLanguage, $this->mType );
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

		#-- check username given by staff
		if ( $wgUser->isAllowed( 'createwikimakefounder' ) && !empty($this->mStaff_username) ) {
			$user_id = User::idFromName($this->mStaff_username);
			if ( empty($user_id) ) {
				$this->makeError( "wiki-staff-username", wfMsg('autocreatewiki-invalid-username') );
				$res = false;
			} else {
				$u = User::newFromId($user_id);
				if ( $u->isBlocked() ) {
					$this->makeError( "wiki-staff-username", wfMsg('autocreatewiki-invalid-username') );
					$res = false;
				}
			}
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
					$this->makeError( "wiki-username", wfMsgExt('acct_creation_throttle_hit', array("parse"), $wgAccountCreationThrottle) );
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
				global $wgExternalSharedDB;
				$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
				$dbw->update(
					'`user`',
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
		$oUser->setOption( 'marketingallowed', isset($this->mMarketing) ? 1 : 0 );
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
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$where = array( "date_format(city_created, '%Y%m%d') = date_format(now(), '%Y%m%d')" );
		if ( !empty($iUser) ) {
			$where[] = "city_founding_user = '{$iUser}' ";
		}
		$oRow = $dbr->selectRow(
			"city_list",
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
	 * can create database?
	 */
	private function canCreateDatabase() {
		global $wgExternalSharedDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); # central

		$Row = $dbw->selectRow(
			"city_list",
			array( "count(*) as count" ),
			array( "city_dbname" => $this->mWikiData[ "dbname"] ),
			__METHOD__
		);
		$this->log( "Checking if database {$this->mWikiData[ "dbname"]} already exists");
		$error = 1;
		if( $Row->count > 0 ) {
			#error
			$this->log( "Database {$this->mWikiData[ "dbname"]} exists!" );
			$error = 0;
		} else {
			$this->log( "Checking if domain {$this->mWikiData[ "url" ]} already exists");
			$Row = $dbw->selectRow(
				"city_list",
				array( "count(*) as count" ),
				array( "city_url" => $this->mWikiData[ "url" ] ),
				__METHOD__
			);
			if( $Row->count > 0 ) {
				#error
				$this->log( "Domain {$this->mWikiData[ "url" ]} exists!" );
				$error = 0;
			}
		}

		return $error;
	}

	/***
	 * set variables in WF
	 */
	public function setWFVariables() {
		global $wgExternalSharedDB;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); # central

		$WFSettingsVars = array(
			'wgSitename'                => $this->mWikiData[ "title" ],
			'wgScriptPath'              => '',
			'wgScript'                  => '/index.php',
			'wgArticlePath'             => '/wiki/$1',
			'wgLogo'                    => '$wgUploadPath/b/bc/Wiki.png',
			'wgUploadPath'              => $this->mWikiData[ "images_url" ],
			'wgUploadDirectory'         => $this->mWikiData[ "images_dir" ],
			'wgDBname'                  => $this->mWikiData[ "dbname" ],
			'wgLocalInterwiki'          => $this->mWikiData[ "title" ],
			'wgLanguageCode'            => $this->mWikiData[ "language" ],
			'wgServer'                  => rtrim( $this->mWikiData[ "url" ], "/" ),
			'wgFavicon'                 => '$wgUploadPath/6/64/Favicon.ico',
			'wgDefaultSkin'             => 'monaco',
			'wgDefaultTheme'            => 'sapphire',
			'wgEnableNewParser'         => true,
			'wgEnableEditEnhancements'  => true,
			'wgEnableSectionEdit'	    => true,
		);

		if( self::ACTIVE_CLUSTER ) {
			$WFSettingsVars[ "wgDBcluster" ] = self::ACTIVE_CLUSTER;
			wfGetLBFactory()->sectionsByDB[ $this->mWikiData[ "dbname" ] ] = self::ACTIVE_CLUSTER;
		}

		switch( $this->mType ) {
			case "answers":
				$WFSettingsVars[ "wgRateLimits" ] = array (
					'move' => array (
						'ip'     => array ( 0 => 1, 1 => 300 ),
						'newbie' => array ( 0 => 6, 1 => 300 ),
						'user'   => array ( 0 => 15,1 => 300 ),
					)
				);
				$WFSettingsVars[ "wgGroupPermissionsLocal"           ] = '*|move|1,*|createaccount|1,user|createaccount|0,sysop|createaccount|0';
				$WFSettingsVars[ "wgDefaultTheme"                    ] = 'sapphire';
				$WFSettingsVars[ "wgEnableAnswers"                   ] = true;
				$WFSettingsVars[ "wgEnableCategoryBlueLinks"         ] = true;
				$WFSettingsVars[ "wgAnswersEnableSocial"             ] = true;
				$WFSettingsVars[ "AutoFriendOnRegisterUsername"      ] = $this->mWikiData[ "founder-name" ];
				$WFSettingsVars[ "wgEnableRandomUsersWithAvatarsExt" ] = true;
				$WFSettingsVars[ "wgEnableRandomInCategoryExt"       ] = true;
				$WFSettingsVars[ "wgEnableMagicAnswer"               ] = false;
				$WFSettingsVars[ "wgUseNewAnswersSkin"               ] = true;
				$WFSettingsVars[ "wgAdslot_LEFT_NAV_205x400"         ] = "Null";
				$WFSettingsVars[ "wgEnableMagCloudExt"               ] = false;
				$WFSettingsVars[ "wgEnableAnswersMonacoWidget"       ] = false;
				$WFSettingsVars[ "wgEnableMagicAnswer"               ] = false;
				$WFSettingsVars[ "wgEnableCategoryHubsExt"           ] = false;
				$WFSettingsVars[ "wgEnableEditingTipsExt"            ] = false;
				$WFSettingsVars[ "wgAdslot_HOME_TOP_LEADERBOARD"     ] = "Null";
				$WFSettingsVars[ "wgAdslot_HOME_LEFT_SKYSCRAPER_1"   ] = "Null";
				$WFSettingsVars[ "wgAdslot_TOP_LEADERBOARD"          ] = "Null";

				if (Wikia::langToSomethingMap($this->mWikiData["language"], array("ar" => true, "he" => true, "ja" => true, "th" => true, "zh" => true), false)) {
					$WFSettingsVars[ "wgDisableAnswersShortQuestionsRedirect" ] = true;
				}
				break;
		}

		$oRes = $dbw->select(
			"city_variables_pool",
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
					"city_variables",
					array(
						"cv_value"       => serialize( $value ),
						"cv_city_id"     => $this->mWikiId,
						"cv_variable_id" => $cv_id
					),
					__METHOD__
				);
			}
		}
	}

	/**
	 * prepareDBName
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
	private function prepareDBName( $dbname, $lang ) {

		wfProfileIn( __METHOD__ );

		$dbwf = WikiFactory::db( DB_SLAVE );
		$dbr  = wfGetDB( DB_MASTER );

		Wikia::log( __METHOD__, "info", "dbname=$dbname, language={$lang} type={$this->mType}" );
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
			Wikia::log( __METHOD__, "info", "Checking if database {$dbname} already exists in city_list" );
			$Row = $dbwf->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbname ),
				__METHOD__
			);
			$exists = 0;
			if( $Row->count > 0 ) {
				Wikia::log( __METHOD__, "", "Database {$dbname} exists in city_list!" );
				$exists = 1;
			}
			else {
				Wikia::log( __METHOD__, "", "Checking if database {$dbname} already exists in database" );
				$oRes = $dbr->query( sprintf( "show databases like '%s'", $dbname) );
				if ( $dbr->numRows( $oRes ) > 0 ) {
					Wikia::log( __METHOD__, "", "Database {$dbname} exists on cluster!" );
					$exists = 1;
				}
			}
			# add suffix
			if( $exists == 1 ) {
				$suffix = rand(1,999);
			}
		}
		wfProfileOut( __METHOD__ );
		return $dbname;
	}

	/**
	 * get starter data for current parameters
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return mixed -- array if there's starter, false otherwise
	 */
	private function getStarter() {

		wfProfileIn( __METHOD__ );
		$result = false;

		/**
		 * determine database name, set default match
		 */
		$dbStarter = $this->mStarters[ "*" ][ "*" ];
		switch( $this->mType ) {
			case "answers":
				$dbStarter = $this->mStarters[ "answers" ][ "*" ];
				if( isset( $this->mStarters[ "answers" ][ $this->mWikiData[ "language" ] ] ) ) {
					$dbStarter = $this->mStarters[ "answers" ][ $this->mWikiData[ "language" ] ];
				}
				break;

			default:
				if( isset( $this->mStarters[ "*" ][ $this->mWikiData[ "language" ] ] ) ) {
					$dbStarter = $this->mStarters[ "*" ][ $this->mWikiData[ "language" ] ];
				}
		}

		/**
		 * determine if exists
		 */
		try {
			$dbr = wfGetDB( DB_SLAVE, array(), $dbStarter );
			/**
			 * read info about connection
			 */
			$result = $dbr->getLBInfo();

			/**
			 * get UploadDirectory
			 */
			$result[ "dbStarter" ] = $dbStarter;
			$result[ "uploadDir" ] = WikiFactory::getVarValueByName( "wgUploadDirectory", WikiFactory::DBtoID( $dbStarter ) );
			$this->log( "starter $dbStarter exists" );
		}
		catch( DBConnectionError $e ) {
			/**
			 * well, it means that starter doesn't exists
			 */
			$this->log( "starter $dbStarter does not exists" );
		}
		wfProfileOut( __METHOD__ );

		return $result;
	}
	
	/**
	 * set subdomain name
	 *
	 * @access private
	 * @author moli
	 *
	 * @return 
	 */
	private function fixSubdomains($lang) {
		global $wgContLang;
		wfProfileIn( __METHOD__ );
		switch( $this->mType ) {
			case "answers":
				$this->mDomains = Wikia::getAnswersDomains();
				$this->mSitenames = Wikia::getAnswersSitenames();
				if ( isset($this->mDomains[$lang]) && !empty($this->mDomains[$lang]) ) {
					$this->mDefSubdomain = sprintf("%s.%s", $this->mDomains[$lang], self::DEFAULT_DOMAIN);
					$this->mLangSubdomain = false;
				} else {
					$this->mDefSubdomain = sprintf("%s.%s", $this->mDomains["default"], self::DEFAULT_DOMAIN);
					$this->mLangSubdomain = true;
				}

				if ( isset( $this->mSitenames[$lang] ) ) {
					$this->mDefSitename = $this->mSitenames[$lang];
				} elseif ( isset($this->mDomains[$lang]) && !empty($this->mDomains[$lang]) ) {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains[$lang] );
				} else {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains['default'] );
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
}
