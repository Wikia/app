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
		$mErrors;
	/**
	 * test database, CAUTION! content will be destroyed during tests
	 */
	const TESTDB = "testdb";
	const STARTER_GAME = 2; /** gaming **/
	const STARTER_ENTE = 3; /** enter. **/
	const LOG = "autocreatewiki";
	const IMGROOT = "/images/";
    const CREATEWIKI_LOGO = "/images/central/images/2/22/Wiki_Logo_Template.png";
    const CREATEWIKI_ICON = "/images/central/images/6/64/Favicon.ico";

	/**
	 * constructor
	 */
	public function  __construct() {
		parent::__construct( "AutoCreateWiki" /*class*/ );

		/**
		 * initialize some data
		 */
		$this->mWikiData = array();

		/**
		 * hub starters
		 */
		$this->mStarters = array(
			self::STARTER_GAME => 3578,
			self::STARTER_ENTE => 3711
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
		global $wgRequest, $wgAuth, $wgUser;
		
		wfLoadExtensionMessages( "AutoCreateWiki" );

		$this->setHeaders();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AutoCreateWiki" );
		$this->mAction = $wgRequest->getVal( "action", false );
		$this->mSubpage = $subpage;
		$this->mPosted = $wgRequest->wasPosted();
		$this->mPostedErrors = array();
		$this->mErrors = 0;

		if( $subpage === "test" ) {
			#---
			$this->create();
		} else {
			if ($this->mPosted) {
				if ( $wgUser->isAnon() ) {
					$this->makeRequestParams();
					$oUser = $this->addNewAccount();
					if ( !is_null($oUser) ) {
						$wgAuth->updateUser( $oUser );
						$wgUser = $oUser;
					} 
				}
				#-- user logged in or just create
				if ( ( !$wgUser->isAnon() ) && ( $wgUser->getID() > 0 ) ) {
					// to do - redirect to create wiki 
				}
			} 
			/*echo "number of errors = " . $this->mErrors . "<br />";
			echo "errors = <pre>" . print_r($this->mPostedErrors, true) . "</pre><br/>";
			exit;*/
			$this->createWikiForm();
		}
	}

	/**
	 * main function for extension -- create wiki in wikifactory cluster
	 * we are assumming that data is valid!
	 *
	 */
	private function create() {

		global $wgDebugLogGroups, $wgOut, $wgUser, $IP, $wgDBname, $wgSharedDB,
			$wgDBserver, $wgDBuser,	$wgDBpassword, $wgWikiaLocalSettingsPath,
			$wgHubCreationVariables, $wgLangCreationVariables, $wgUniversalCreationVariables;

		# $wgDebugLogGroups[ self::LOG ] = "/tmp/autocreatewiki.log";
		wfProfileIn( __METHOD__ );

		/**
		 * this will clean test database and fill mWikiData with test data
		 */
		$this->prepareTest();
		$wgOut->addHtml( print_pre( $this->mWikiData, 1 ) );

		$this->mCurrTime = wfTime();
		$startTime = $this->mCurrTime;

		/**
		 * create image folder
		 */
		wfMkdirParents( $this->mWikiData[ "images"] );
		$this->log( "Create {$this->mWikiData[ "images"]} folder" );

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
		if( $Row->count > 0 ) {
			#error
		}
		$dbw->query( sprintf( "CREATE DATABASE %s", $this->mWikiData[ "dbname"]) );
		$this->log( "Creating database {$this->mWikiData[ "dbname"]}" );

		/**
		 * create position in wiki.factory
		 * (I like sprintf construction, so sue me)
		 */
		$dbw->insert(
			wfSharedTable("city_list"),
			array(
				'city_title'          => $this->mWikiData[ "title" ],
				'city_dbname'         => $this->mWikiData[ "dbname"],
				'city_url'            => sprintf( "http://%s.wikia.com/", $this->mWikiData[ "subdomain" ] ),
				'city_founding_user'  => $wgUser->getID(),
				'city_founding_email' => $wgUser->getEmail(),
				'city_path'           => $this->mWikiData[ "path" ],
				'city_description'    => $this->mWikiData[ "title" ],
				'city_lang'           => $this->mWikiData[ "language" ],
				'city_created'        => wfTimestamp( TS_DB, time() ),
			),
			__METHOD__
		);
		$this->mWikiId = $dbw->insertId();
		$this->log( "Creating row in city_list table, city_id = {$this->mWikiId}" );

		$dbw->insert(
			wfSharedTable("city_domains"),
			array(
				array(
					'city_id'     =>  $this->mWikiId,
					'city_domain' => sprintf("%s.wikia.com", $this->mWikiData[ "subdomain" ] )
				),
				array(
					'city_id'     =>  $this->mWikiId,
					'city_domain' => sprintf("www.%s.wikia.com", $this->mWikiData[ "subdomain" ] )
				)
			),
			__METHOD__
		);
		$this->log( "Populating city_domains" );


		/**
		 * copy defaul logo & favicon
		 */
		wfMkdirParents("{$this->mWikiData[ "images" ]}/images/b/bc");
		wfMkdirParents("{$this->mWikiData[ "images" ]}/images/6/64");

		if (file_exists(self::CREATEWIKI_LOGO)) {
			copy(self::CREATEWIKI_LOGO, "{$this->mWikiData[ "images" ]}/images/b/bc/Wiki.png");
		}
		if (file_exists(self::CREATEWIKI_ICON)) {
			copy(self::CREATEWIKI_ICON, "{$this->mWikiData[ "images" ]}/images/6/64/Favicon.ico");
		}
		$this->log( "Coping favicon and logo" );

		/**
		 * wikifactory variables
		 */
		$WFSettingsVars = array(
			'wgSitename'				=> $this->mWikiData[ 'title' ],
			'wgScriptPath'				=> '',
			'wgScript'					=> '/index.php',
			'wgRedirectScript'			=> '/redirect.php',
			'wgArticlePath'				=> '/wiki/$1',
			'wgLogo'					=> '$wgUploadPath/b/bc/Wiki.png',
			'wgUploadPath'				=> "http://images.wikia.com/{$this->mWikiData[ "dir_part" ]}/images",
			'wgUploadDirectory'			=> "/images/{$this->mWikiData[ "dir_part" ]}/images",
			'wgDBname'					=> $this->mWikiData[ "dbname" ],
			'wgSharedDB'				=> 'wikicities',
			'wgLocalInterwiki'			=> $this->mWikiData[ 'title' ],
			'wgLanguageCode'			=> $this->mWikiData['language'],
			'wgServer'					=> "http://{$this->mWikiData["subdomain"]}.wikia.com",
			'wgFavicon'					=> '$wgUploadPath/6/64/Favicon.ico',
			'wgDefaultSkin'				=> 'monaco',
			'wgDefaultTheme'			=> 'sapphire',
			'wgEnableNewParser'			=> true,
			'wgEnableEditEnhancements'	=> true,
			'wgEnableSectionEdit'	    => true,
		);

		if( $WFSettingsVars[ "wgLanguageCode" ] === "en" ) {
			$WFSettingsVars[ "wgEnableWysiwygExt" ] = true;
		}

		foreach( $WFSettingsVars as $variable => $value ) {
			/**
			 * first, get id of variable
			 */
			$Row = $dbw->selectRow(
				wfSharedTable("city_variables_pool"),
				array( "cv_id" ),
				array( "cv_name" => $variable ),
				__METHOD__
			);

			/**
			 * then, insert value for wikia
			 */
			if( isset( $Row->cv_id ) && $Row->cv_id ) {
				$dbw->insert(
					wfSharedTable( "city_variables" ),
					array(
						"cv_value"       => serialize( $value ),
						"cv_city_id"     => $this->mWikiId,
						"cv_variable_id" => $Row->cv_id
					),
					__METHOD__
				);
			}
		}
		$this->log( "Populating city_variables" );

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
			$dbw->sourceFile( $file );
		}
		$wgSharedDB = $tmpSharedDB;
		$this->log( "Creating tables in database" );

		/**
		 * import language starter
		 */
		if( in_array( $this->mWikiData[ "language" ], array("en", "ja", "de", "fr") ) ) {
			$prefix = ( $this->mWikiData[ "language" ] !== "en") ? "" : $this->mWikiData[ "language" ];
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
				wfShellExec( $cmd );

				$dbw->sourceFile( "{$IP}/maintenance/cleanupStarter.sql" );

				$startupImages = sprintf( "%s/starter/%s/images/", self::IMGROOT, $prefix );
				if (file_exists( $startupImages ) && is_dir( $startupImages ) ) {
					wfShellExec("/bin/cp -af $startupImages {$this->mWikiData[ "images" ]}/");
				}
				$cmd = sprintf(
					"SERVER_ID=%d %s %s/maintenance/updateArticleCount.php --update --conf %s",
					$this->mWikiId,
					$this->mPHPbin,
					$IP,
					$wgWikiaLocalSettingsPath
				);
				wfShellExec( $cmd );

				$this->log( "Copying starter database" );
			}
			else {
				$this->log( "No starter database for this language" );
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
		if( isset( $this->mStarters[ $this->mWikiData[ "hub" ] ] )&&
			$this->mStarters[ $this->mWikiData[ "hub" ] ] ) {
			$wikiMover = WikiMover::newFromIDs(
				$this->mStarters[ $this->mWikiData[ "hub" ] ], /** source **/
				$this->mWikiId /** target **/
			);
			$wikiMover->setOverwrite( true );
			$wikiMover->mMoveUserGroups = false;
			$wikiMover->load();
			$wikiMover->move();

			/**
			 * WikiMove has internal log engine
			 */
            foreach( $oWikiMover->getLog( true ) as $log ) {
                $this->log( $log["info"] );
            }

			$this->addCustomSettings( $this->mWikiData[ "hub" ], $wgHubCreationVariables, 'hub' );
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
		$dbw->commit();


		/**
		 * show total time
		 */
		$info = sprintf( "Total: %F", wfTime() - $startTime );
		wfDebugLog( self::LOG, $info );
		Wikia::log( self::LOG, $info );
		$wgOut->addHtml( $info ."<br />" );


		wfProfileOut( __METHOD__ );
	}

	/**
	 * prepareTest, clear test database
	 */
	private function prepareTest() {

		global $wgContLang;

		$languages = array( "de", "en", "pl", "fr", "es" );
		shuffle( $languages );

		$this->mWikiData[ "hub" ]		= rand( 1, 19 );
        $this->mWikiData[ "name"]       = strtolower( trim( self::TESTDB ) );
        $this->mWikiData[ "title" ]     = trim( $wgContLang->ucfirst( self::TESTDB ) . " Wiki" );
        $this->mWikiData[ "language" ]  = array_shift( $languages );
        $this->mWikiData[ "subdomain" ] = $this->mWikiData[ "name"];
        $this->mWikiData[ "redirect"]   = $this->mWikiData[ "name"];
		$this->mWikiData[ "dir_part"]   = $this->mWikiData[ "name"];
		$this->mWikiData[ "dbname"]     = substr( str_replace( "-", "", $this->mWikiData[ "name"] ), 0, 64);
		$this->mWikiData[ "path"]       = "/usr/wikia/docroot/wiki.factory";
        $this->mWikiData[ "images"]     = self::IMGROOT . $this->mWikiData[ "name"];
        $this->mWikiData[ "testWiki"]   = true;

        if( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" ) {
			$this->mWikiData[ "subdomain" ] = strtolower( $this->mWikiData[ "language"] ) . "." . $this->mWikiData[ "name"];
			$this->mWikiData[ "redirect" ]  = strtolower( $this->mWikiData[ "language" ] ) . "." . ucfirst( $this->mWikiData[ "name"] );
			$this->mWikiData[ "dbname" ]    = strtolower( str_replace( "-", "", $this->mWikiData[ "language" ] ). $this->mWikiData[ "dbname"] );
			$this->mWikiData[ "images" ]   .= "/" . strtolower( $this->mWikiData[ "language" ] );
			$this->mWikiData[ "dir_part" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
		}

		/**
		 * drop test table
		 */
		$dbw = wfGetDB( DB_MASTER );
		$dbw->query( sprintf( "DROP DATABASE IF EXISTS %s", $this->mWikiData[ "dbname"] ) );

		/**
		 * clear wikifactory tables: city_list, city_variables, city_domains
		 */
		$city_id = WikiFactory::DBtoID( $this->mWikiData[ "dbname"] );
		if( $city_id ) {
			$dbw->begin();
			$dbw->delete(
				wfSharedTable( "city_domains" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);
			$dbw->delete(
				wfSharedTable( "city_domains" ),
				array( "city_domain" => sprintf("%s.wikia.com", $this->mWikiData[ "subdomain" ] ) ),
				__METHOD__
			);
			$dbw->delete(
				wfSharedTable( "city_domains" ),
				array( "city_domain" => sprintf("www.%s.wikia.com", $this->mWikiData[ "subdomain" ] ) ),
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

		/**
		 * remove image directory
		 */
		if( file_exists( $this->mWikiData[ "images" ] ) && is_dir( $this->mWikiData[ "images" ] ) ) {
			exec( "rm -rf {$this->mWikiData[ "images" ]}" );
		}
	}

	/**
	 * create wiki form
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function createWikiForm() {
		global $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion, $wgScriptPath;
		global $wgCaptchaTriggers;
		#-
		$aLanguages = Language::getLanguageNames();
		#-
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
		#-

		$f = new FancyCaptcha();
		#--		
		/* run template */
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser" => $wgUser,
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion" => $wgStyleVersion,
			"aLanguages" => $aLanguages,
			"aCategories" => $aCategories,
			"wgScriptPath" => $wgScriptPath,
			"mTitle" => $this->mTitle,
			"mPostedErrors" => $this->mPostedErrors,
			"captchaForm" => $f->getForm()
		));

		#---
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml($oTmpl->execute("create-wiki-form"));
		wfProfileOut( __METHOD__ );
		return;
	}

	/**
	 * make local version of request parameters
	 */
	private function makeRequestParams() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$aValues = $wgRequest->getValues();
		if ( !empty($aValues) && is_array($aValues) ) {
			foreach ($aValues as $key => $value) {
				$k = trim($key);	
				if ( strpos($key, "wiki-") !== false ) {
					$this->mPostedErrors[$k] = "";
					$key = str_replace("wiki-", "", $key);
					$key = str_replace("-", "_", "m".ucfirst($key));
					$this->$key = $value;
				}
			}
		}
		#echo "<pre>".print_r($this, true)."</pre>";
		wfProfileOut( __METHOD__ );
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

		# Now create a dummy user ($u) and check if it is valid
		$name = trim( $this->mUsername );
		$u = User::newFromName( $name, 'creatable' );
		if ( is_null( $u ) ) {
			$this->makeError( "wiki-username", wfMsg( 'noname' ) );
		} else {
			if ( 0 != $u->idForName() ) {
				$this->makeError( "wiki-username", wfMsg( 'userexists' ) );
			}
		}
		
		if ( $u instanceof User) {
			# Set some additional data so the AbortNewAccount hook can be
			# used for more than just username validation
			$u->setEmail( $this->mEmail );
			$u->setRealName( $this->mRealname );

			$abortError = '';
			if ( !wfRunHooks( 'AbortNewAccount', array( $u, &$abortError ) ) ) {
				// Hook point to add extra creation throttles and blocks
				wfDebug( "LoginForm::addNewAccountInternal: a hook blocked creation\n" );
				$this->makeError( "wiki-username", $abortError . "(1)" );
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

			if ( !$wgAuth->addUser( $u, $this->mPassword, $this->mEmail, $this->mRealname ) ) {
				$this->makeError( "wiki-username", wfMsg('externaldberror') );
			}
		} else {
			$this->makeError( "wiki-username", wfMsg('autocreatewiki-blocked-username') );
		}

		if ( $this->mErrors > 0 ) {
			#-- some errors 
			$u = null;
		} else {
			/*
			 * test
			 */
			/*$userBirthDay = strtotime("{$this->mUser_year}-{$this->mUser_month}-{$this->mUser_day}");
			$u = $this->initUser( $u, false );
			$user_id = $u->getID();
			if (!empty($user_id)) {
				$dbw = wfGetDB(DB_MASTER);
				$dbw->update(
					'user',
					array( 'user_birthdate' => date('Y-m-d', $userBirthDay) ),
					array( 'user_id' => $user_id ),
					__METHOD__
				);
			}*/
			$u = null;
		}

		wfProfileOut( __METHOD__ );
		return $u;		
	}
	
	/**
	 * @param object user
	 * @param bool throttle
	 * @param string message name of email title
	 * @param string message name of email text
	 * @return mixed true on success, WikiError on failure
	 * @private
	 */
	private function mailPasswordInternal( $u, $throttle = true, $emailTitle = 'passwordremindertitle', $emailText = 'passwordremindertext' ) {
		global $wgCookiePath, $wgCookieDomain, $wgCookiePrefix, $wgCookieSecure;
		global $wgServer, $wgScript;

		if ( $u->getEmail() == '' ) {
			return new WikiError( wfMsg( 'noemail', $u->getName() ) );
		}

		$np = $u->randomPassword();
		$u->setNewpassword( $np, $throttle );
		$u->saveSettings();

		$ip = wfGetIP();
		if ( '' == $ip ) { $ip = '(Unknown)'; }

		$m = wfMsg( $emailText, $ip, $u->getName(), $np, $wgServer . $wgScript );
		$result = $u->sendMail( wfMsg( $emailTitle ), $m );

		return $result;
	}
	
	/**
	 * Actually add a user to the database.
	 * Give it a User object that has been initialised with a name.
	 *
	 * @param $u User object.
	 * @param $autocreate boolean -- true if this is an autocreation via auth plugin
	 * @return User object.
	 * @private
	 */
	function initUser( $u, $autocreate ) {
		global $wgAuth;

		$u->addToDatabase();

		if ( $wgAuth->allowPasswordChange() ) {
			$u->setPassword( $this->mPassword );
		}

		$u->setEmail( $this->mEmail );
		$u->setRealName( $this->mRealname );
		$u->setToken();

		$wgAuth->initUser( $u, $autocreate );

		$u->setOption( 'rememberpassword', isset($this->mRemember) ? 1 : 0 );
		$u->setOption('skinoverwrite', 1);

		$u->saveSettings();

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		return $u;
	}
	
	/**
	 * create account function (see SpecialUserLogin.php to compare)
	 */
	private function makeError( $key, $msg ) {
		if ( array_key_exists($key, $this->mPostedErrors) ) {
			if ( empty( $this->mPostedErrors[$key] ) ) {
				$this->mPostedErrors[$key]= $msg;
			}
			$this->mErrors++;
		}
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

        if (!empty($match) && is_array($settings[$match])) {
            $this->log("Found '$match' in $type settings array.");

            /**
			 * switching user for correct logging
			 */
            $oldUser = $wgUser;
            $wgUser = User::newFromName( 'CreateWiki script' );

            foreach( $settings[$match] as $key => $value ) {
                $success = WikiFactory::setVarById($key, $this->mWikiID, $value);
                if( $success ) {
                    $this->log("Successfully added setting: $key = $value");
                } else {
                    $this->addLog("Failed to add setting: $key = $value");
                }
            }
			$wgUser = $oldUser;

			$this->log("Finished adding $type settings.");
        } else {
            $this->log("'$match' not found in $type settings array. Skipping this step.");
		}

	}

	/**
	 * common log function
	 */
	private function log( $info ) {
		global $wgOut;

		$info = sprintf( "%s: %F", $info, wfTime() - $this->mCurrTime );
		wfDebugLog( self::LOG, $info );
		Wikia::log( self::LOG, $info );
		$wgOut->addHtml( $info ."<br />" );

		$this->mCurrTime = wfTime();
	}
}
