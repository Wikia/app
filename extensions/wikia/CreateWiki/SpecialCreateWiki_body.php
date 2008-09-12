<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}
#--- Add messages
global $wgMessageCache, $wgCreateWikiMessages, $wgDevelEnvironment;
foreach( $wgCreateWikiMessages as $key => $value ) {
    $wgMessageCache->addMessages( $wgCreateWikiMessages[$key], $key );
}


class CreateWikiForm extends SpecialPage {

    //const CREATEWIKI_LOGO = "/images/central/images/b/bc/Wiki.png";
    const CREATEWIKI_LOGO = "/images/central/images/2/22/Wiki_Logo_Template.png";
    const CREATEWIKI_ICON = "/images/central/images/6/64/Favicon.ico";

    public $mName, $mPosted, $mAction, $mTitle, $mRequest, $mParams;
    public $mMYSQLdump, $mMYSQLbin, $mPHPbin;

    /**
     * __construct
     */
    function  __construct()
    {
        #--- we use 'createwiki' restriction
        parent::__construct( "CreateWiki"  /*class*/, 'createwiki' /*restriction*/);
        $this->mParams = array();

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
     * execute
     *
     * main entry point for SpecialPage
     *
     * @author eloy@wikia
     * @access public
     *
     * @param string $subpage: sub page name
     *
     * @return nothing
     */
				function execute()
    {
        global $wgUser, $wgOut, $wgRequest, $wgShowAds;

        if( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }

        if( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }

        if( !$wgUser->isAllowed( 'createtwiki' ) ) {
            $this->displayRestrictionError();
            return;
        }

        // simple hack to make Angela happy :) (doesn't really change anything.. yes, I know that)
        $wgShowAds = false;

        #--- initial output
        $this->mTitle = Title::makeTitle( NS_SPECIAL, 'CreateWiki' );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
        $wgOut->setPageTitle( wfMsg("createwikipagetitle") );
        $wgOut->setArticleRelated( false );

        $this->mPosted = $wgRequest->wasPosted();
        $this->mRequest = $wgRequest->getIntOrNull( 'request' );

        if( $wgRequest->getVal("wpRejectSubmit") ) {
            $this->mAction = "reject";
        }
        else {
            $this->mAction = $wgRequest->getVal( "action" );
        }

//        $wgOut->addHTML( print_pre( $wgRequest->getValues(), 1 ));
        #--- parameters from form
        if ($this->mPosted) {
            $this->mParams["wpRequestID"] = $wgRequest->getVal("wpRequestID");
            $this->mParams["wpWikiCategory"] = $wgRequest->getVal("wpWikiCategory", 0);
            $this->mParams["wpFounderUserID"] = $wgRequest->getIntOrNull("wpFounderUserID");
            $this->mParams["wpCreateWikiName"] = $wgRequest->getVal("wpCreateWikiName");
            $this->mParams["wpCreateWikiTitle"] = $wgRequest->getVal("wpCreateWikiTitle");
            $this->mParams["wpCreateWikiLang"] = $wgRequest->getVal("wpCreateWikiLang");
            $this->mParams["wpCreateWikiLangPrefix"] = $wgRequest->getCheck("wpCreateWikiLangPrefix");
            $this->mParams["wpCreateWikiImportStarter"] = $wgRequest->getCheck("wpCreateWikiImportStarter");
            $this->mParams["wpCreateWikiDesc"] = $wgRequest->getText("wpCreateWikiDesc");
            $this->mParams["wpCreateWikiDescEn"] = $wgRequest->getText("wpCreateWikiDescEn");
            $this->mParams["wpCreateWikiDescPage"] = $wgRequest->getText("wpCreateWikiDescPage");
            $this->mParams["wpCreateWikiCategory"] = $wgRequest->getVal("wpCreateWikiCategory");
												$this->mParams["wpCreateWikiDescPageTitle"] = $wgRequest->getVal("wpCreateWikiDescPageTitle");
            $this->mParams["wpCreateWikiCategoryStarter"] = $wgRequest->getVal("wpCreateWikiCategoryStarter");
            $this->mParams["wpCreateWikiDomains"] = $wgRequest->getVal("wpCreateWikiDomains");
        }

        $wgOut->setPageTitle( wfMsg("createwikipagetitle").wfMsg("createwikistep")."1" );
        switch( $this->mAction ) {
												case "unlock":
																$this->doUnlock();
																break;
            case "load":
                $this->selectRequestForm();
                $wgOut->setPageTitle( wfMsg("createwikipagetitle").wfMsg("createwikistep")."2" );
                $this->loadRequest();
                break;
            case "process":
                #--- first check errors, maybe we should back to form
                $aErrors = $this->parseParams();
                if ( $aErrors === true ) {
                    $wgOut->setPageTitle( wfMsg("createwikipagetitle").wfMsg("createwikistep")."3" );
                    $wgOut->addHTML($this->processCreation());
                }
                else {
                    $this->loadRequest( $aErrors );
                }
                break;
            case "reject":
                $doit = $wgRequest->getIntOrNull("doit");
                $wgOut->setPageTitle( wfMsg("createwikirejectpagetitle") );
                $this->rejectRequest($doit);
                break;
            case "delete":
                $doit = $wgRequest->getIntOrNull("doit");
                $wgOut->setPageTitle( wfMsg("createwikipagetitle").wfMsg("createwikistep")."2" );
                $this->deleteRequest($doit);
                break;
            case "req_more_info":
            				$this->requestMoreInfoAction($this->mRequest);
            				break;
            default: #--- do nothing
                $this->selectRequestForm();
        }
        return;
	}

    /**
     * parse request params, if params are valid return true
     * if params are invalid return errors with set values and params
     */
    private function parseParams()
    {
        $sName = strtolower(trim($this->mParams["wpCreateWikiName"]));

        $aFormData = array();
        $aFormData["errors"] = array();
        $aFormData["values"] = array(
           "wpCreateWikiName" => $sName
        );

								if(!$this->mParams["wpWikiCategory"]) {
												$aFormData["errors"]["wpWikiCategory"] = "You have to select HUB for this wiki.";
								}

        if (!preg_match("/^[\w\.\-]+$/", $sName)) {
            $aFormData["errors"]["wpCreateWikiName"] = "Name has invalid format. Only letters and digits are allowed.";
        }

								return (count($aFormData["errors"])) ? $aFormData : true;
    }

    /**
     * "request more info" action method
     */
    public static function requestMoreInfoAction($requestId, $page = null) {
				    global $wgOut;

				    // load request from database
				    $dbr = wfGetDB(DB_SLAVE);
				    $dbr->selectDB('wikicities');

				    $request = $dbr->selectRow("city_list_requests", array( "*" ), array( "request_id" => $requestId ), __METHOD__);

								if($page != null) {
												if(!isset($_SESSION['founderId'])) {
																// call from hook
																$predefinedResponseText = "{{I|" . $request->request_language . "}}\n\n~~~~";
																$page->textbox1 .= ($page->textbox1 ? "\n" : "") . $predefinedResponseText;

																$_SESSION['founderId'] = $request->request_user_id;
												}
												return true;
								}
								else {
								    // normal call
								    if(!empty($request->request_user_id)) {
																$oRequestPageTitle = wfRequestTitle($request->request_name, $request->request_language);
																$_SESSION['requestId'] = $requestId;
																$_SESSION['requestPageTitle'] = $oRequestPageTitle;
																$_SESSION['requestName'] = $request->request_name . '.wikia.com';
																unset($_SESSION['founderId']);

																$wgOut->redirect($oRequestPageTitle->getTalkPage()->getFullUrl('action=edit'));
								    }
								    return true;
								}

    }

    /**
     * notifyFounder
     *
     * notify founder about "more info" request on talk page
     *
     * @author Adrian Wieczorek <adi@wikia.com>
     * @access public
     * @static
     *
     */
    public static function notifyFounder($founderId, $staffUser) {
        global $wgUser, $wgDevelEnvironment, $wgPasswordSender;

        if( !empty( $wgDevelEnvironment ) ) {
            $oReceiver = $wgUser;
        }
        else {
            $oReceiver = User::newFromId($founderId);
            $oReceiver->load();
        }

        $sFrom = new MailAddress( $wgPasswordSender, "The Wikia Community Team" );
        $sTo = $oReceiver->getEmail();

        $sWikiaName = $_SESSION['requestName'];
        $oRequestTitle = $_SESSION['requestPageTitle'];

        $sSubject = wfMsg("createwiki-info-needed-email-subject", array($sWikiaName));
        $sBody = wfMsg("createwiki-info-needed-email",
            array(
            	$oReceiver->mName,
                $oRequestTitle->getFullUrl(),
                $staffUser->getRealName(),
            )
        );

        if(!empty($sTo)) {
            $bStatus = $oReceiver->sendMail($sSubject, $sBody, "community@wikia.com");
            if($bStatus === true ) {
                // TODO: log it, "Mail to founder {$sTo} sent."
            }
            else {
                // TODO: log it, "Mail to founder {$sTo} probably not sent. sendMail returned false."
            }
        }
        else {
            // TODO: log it, "Founder email is not set, email is not sent"
        }

        unset($_SESSION['requestId']);
        unset($_SESSION['founderId']);
        unset($_SESSION['requestPageTitle']);
        unset($_SESSION['requestName']);
        return true;
    }

    /**
     * @method selectRequestForm, show selector with not created wikia
     */
    public function selectRequestForm( ) {
        global $wgOut, $wgDBname;

        #--- get all not done requests
        $dbr = wfGetDB( DB_SLAVE );
        $dbr->selectDB( "wikicities" );

        $requests = array();
        $oRes = $dbr->select("city_list_requests",
                array( "request_id", "request_language", "request_name", "request_title" ),
                array( "request_status" => 0 ), __METHOD__, array("ORDER BY request_name"));
        while ($oRow = $dbr->fetchObject( $oRes )) {
            $requests[] = $oRow;
        }
        $dbr->freeResult( $oRes );

        #--- back to current wiki database
        $dbr->selectDB( $wgDBname );
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "title"     => $this->mTitle,
            "request"   => $this->mRequest,
            "requests"  => $requests,
        ));
        $wgOut->addHTML( $oTmpl->execute("selector") );
    }

    /**
     * loadRequest
     *
     * Load request from database using request_id, create & display HTML
     * form
     *
     * @access private
     * @author eloy@wikia
     *
     * @param mixed $formData default null - data from HTML form
     *
	 * @return void
	 */
	private function loadRequest( $formData = null ) {
        global $wgUser, $wgOut, $wgDBname, $wgContLang, $wgParser, $wgRequest;

        $request = null;
        $founder = null;

        #--- load request from database
        $dbr = wfGetDB( DB_SLAVE );
        $dbr->selectDB( "wikicities" );

        $request = $dbr->selectRow("city_list_requests", array( "*" ),
                array( "request_id" => $this->mRequest ), __METHOD__);

	#--- stop if request has been already rejected
	if($request->request_status == 2) {
    	    $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	    $oTmpl->set_vars( array( "message" => "This request has been rejected already." ));

	    $wgOut->addHTML( $oTmpl->execute("request-error") );
	    return;
	}

        if (!empty($request->request_user_id)) {
            $founder = User::newFromId($request->request_user_id);
            $founder->load();
            $founderpage = $founder->getSkin()->makeUrlDetails( $founder->getUserPage()->getPrefixedText() );
        }

        #--- check name availability
        $sName = strtolower($request->request_name.".wikia.com");
        $aDomains = wfRequestLikeOrExact($request->request_name);

        #--- set prefix
        if ($request->request_language != "en") {
            $request_prefix = 1;
            $sName = strtolower($request->request_language.".".$sName);
        }
        else {
            $request_prefix = 0;
        }

		if( $request->request_language == 'en' ) {
			$sWikiDescription = $request->request_description_international;
			$sWikiDescriptionInternational = '';
		}
		else {
			$sWikiDescription = $request->request_description_international;
			$sWikiDescriptionInternational = $request->request_description_international;
			if( !empty($request->request_description_english) ) {
				$sWikiDescription = $request->request_description_english;
			}
		}

		#--- back to current wiki database
		$dbr->selectDB( $wgDBname );

		/**
		 * get hub selector
		 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
		 */
        $hub = WikiFactoryHub::getInstance();
		$iHubID = $wgRequest->getVal("wpWikiCategory", 0);
		if(!$iHubID) {
			$iHubID = $hub->getIdByName( $request->request_category );
		}
		$sHubs =  $hub->getSelect( $iHubID );

        #--- get Talk page for requests
        $oTitle = wfRequestTitle( $request->request_name, $request->request_language );
        $oTalkPage = new Article( $oTitle->getTalkPage() /*title*/, 0 /*current id*/ );

        $sTalkPage = $wgParser->parse( $oTalkPage->getContent(), $oTitle, new ParserOptions() );

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
												"wgRequest"         => $wgRequest,
            "data"              => $formData,
            "name"              => $sName,
            "talk"              => $sTalkPage,
            "hubs"              => $sHubs,
            "title"             => $this->mTitle,
            "domains"           => $aDomains,
            "request"           => $request,
            "founder"           => $founder,
            "languages"         => Language::getLanguageNames(),
            "lock_info"         => $this->getLockInfo( CreateWikiLock::newFromID( $this->mRequest ) ),
            "founderpage"       => $founderpage,
            "description"       => $sWikiDescription,
            "descriptionIntl"   => $sWikiDescriptionInternational,
            "languages"         => Language::getLanguageNames(),
            "request_prefix"    => $request_prefix,
            "request_starter"   => in_array($request->request_language, array("en", "ja", "de")) ? 1 : 0
        ));
        $wgOut->addHTML( $oTmpl->execute("request") );
	}

    #--- getLock ------------------------------------------------------------
				function getLock($numAttempts = 3)
    {
        global $wgUser;

        $sUserName = $wgUser->getName();

        foreach(range(0,$numAttempts) as $i) {
            if (!file_exists( CREATEWIKI_LOCKFILE )) {
                $file = fopen( CREATEWIKI_LOCKFILE, "x");
                if($file) {
                    $i=$numAttempts;
            		fwrite($file,"{$sUserName} has the creation script locked");
            		fclose($file);
            		return true;
                }
                else {
                    sleep(1);
                }
    	    }
    	    else{
    	      sleep(1);
    	    }
        }
        return false;
	}

    #--- releaseLock --------------------------------------------------------
    function releaseLock($requestId)
    {
        $oLock = CreateWikiLock::newFromID( $requestId );
        $oLock->release();
    }

	/**
	 * processCreation
	 *
	 * ... And God said, Let there be a wiki
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @return void
	 */
	private function processCreation() {
		global $wgUser, $wgOut, $wgSharedDB, $IP, $wgDBname, $wgDevelEnvironment;
		global $wgContLang, $wgDBserver, $wgDBserver, $wgDBuser, $wgDBpassword;
		global $wgWikiaLocalSettingsPath, $wgDebugLogGroups;
		global $wgServer, $wgScript;

		//$wgDebugLogGroups["createwiki"] = "/tmp/createwiki.log";

		$tmpDBname = $wgDBname;
		$tmpSharedDB = $wgSharedDB;

		$today = wfTimeStampNow();

		$fExecTime = wfTime(); // for profilling
		wfDebugLog( "createwiki", "===== Create wiki (" . strtolower(trim($this->mParams["wpCreateWikiName"])) . ") started: {$fExecTime} =====" );

		/**
		 * lock request
		 */
		$oLock = CreateWikiLock::newFromID( $this->mParams["wpRequestID"] );
		if( $oLock->isLocked() === true ) {
			return $this->getLockInfo( $oLock );
		}

		$oFounder = User::newFromId($this->mParams["wpFounderUserID"]);
		$oFounder->load();

		wfDebugLog( "createwiki", sprintf( "Getting founder data: %F", wfTime() - $fExecTime ));
		$fExecTimeCur = wfTime();

		// We're gathering together all info about the wiki
		$WikiImagesDir = '/images/';

		$aWiki = array();

		$aWiki["hub"]       = $this->mParams["wpWikiCategory"];
		$aWiki["name"]      = strtolower(trim($this->mParams["wpCreateWikiName"]));
		$aWiki["title"]     = trim($this->mParams["wpCreateWikiTitle"]);
		$aWiki["language"]  = trim($this->mParams["wpCreateWikiLang"]);
		$aWiki["subdomain"] = $aWiki["name"];
		$aWiki["redirect"]  = $aWiki["name"];
		$aWiki["dir_part"]  = $aWiki["name"];
		$aWiki["dbname"]    = $aWiki["name"];
		$aWiki["path"]      = "/usr/wikia/docroot/wiki.factory";
		$aWiki["images"]    = $WikiImagesDir . $aWiki["name"];

		if (!empty($this->mParams["wpCreateWikiLangPrefix"]) && $this->mParams["wpCreateWikiLang"] != "") {
			$aWiki["subdomain"] = strtolower($this->mParams["wpCreateWikiLang"]) . "." . $aWiki["name"];
			$aWiki["redirect"] = strtolower($this->mParams["wpCreateWikiLang"]) . "." . ucfirst($aWiki["name"]);
			$aWiki["images"] .= "/".strtolower($this->mParams["wpCreateWikiLang"]);
			$aWiki["dbname"] = strtolower(str_replace("-","", $this->mParams["wpCreateWikiLang"]).$aWiki["dbname"]);
			$aWiki["dir_part"] .= "/".strtolower($this->mParams["wpCreateWikiLang"]);
		}
		wfDebugLog( "createwiki", sprintf( "Getting new wiki data: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		if (file_exists($aWiki["images"].'/images')) {
			$this->releaseLock($this->mParams["wpRequestID"]);
			return "{$aWiki["images"]}/images already exists";
		}
		wfDebugLog( "createwiki", sprintf( "Creating image directory: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		$aWiki["dbname"] = str_replace("-", "_", $aWiki["dbname"]);
		if (preg_match("/[^0-9a-zA-Z_]+/", $aWiki["dbname"])) {
			$this->releaseLock($this->mParams["wpRequestID"]);
			return "name <strong>{$aWiki["dbname"]}</strong> contains non-alphanumeric characters";
		}
		wfDebugLog( "createwiki", sprintf("Checking database name: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		$dbw = wfGetDB(DB_MASTER);
		$dbw->selectDB("wikicities");
		#--- check last time if wiki is not already created (by checking dbname)
		$oRow = $dbw->selectRow(
			wfSharedTable("city_list"),
			array("count(*) as count"),
			array("city_dbname" => $aWiki["dbname"])
		);
		if ($oRow->count > 0) {
			$this->releaseLock($this->mParams["wpRequestID"]);
			return "database <strong>{$aWiki["dbname"]}</strong> exists!";
  }
		wfDebugLog( "createwiki", sprintf("Checking database existence: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		if ( empty($aWiki["hub"])) {
			// deprecated, it's now checked during form validation
			$this->releaseLock($this->mParams["wpRequestID"]);
			return "You have to select HUB for this wiki!";
		}

		$sTimeStamp = wfTimestamp( TS_DB, time() );
		#--- create wiki in wiki.factory
		$dbw->insert(
			wfSharedTable("city_list"),
			array(
				'city_title'          => $aWiki["title"],
				'city_dbname'         => $aWiki["dbname"],
				'city_url'            => "http://{$aWiki["subdomain"]}.wikia.com/",
				'city_founding_user'  => $oFounder->getID(),
				'city_founding_email' => $oFounder->getEmail(),
				'city_path'           => $aWiki["path"],
				'city_description'    => $this->mParams["wpCreateWikiDesc"],
				'city_lang'           => $aWiki["language"],
				'city_created'        => $sTimeStamp,
				'city_title'          => $aWiki["title"],
				'city_additional'     => $this->mParams["wpCreateWikiDescEn"],
			),
			__METHOD__
		);
		$iInsertId = $dbw->insertId();
		$dbw->insert(
			wfSharedTable("city_domains"),
			array(
				0 => array(
					'city_id'     =>  $iInsertId,
					'city_domain' => "{$aWiki["subdomain"]}.wikia.com"
				),
				1 => array(
					'city_id'     =>  $iInsertId,
					'city_domain' => "www.{$aWiki["subdomain"]}.wikia.com"
				)
			),
			__METHOD__
		);
		wfDebugLog( "createwiki", sprintf("Populating city_list and city_domains: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		#--- parents for logo & favicon
		wfMkdirParents("{$aWiki["images"]}/images/b/bc");
		wfMkdirParents("{$aWiki["images"]}/images/6/64");

		if (file_exists(self::CREATEWIKI_LOGO)) {
			copy(self::CREATEWIKI_LOGO, "{$aWiki["images"]}/images/b/bc/Wiki.png");
		}
		if (file_exists(self::CREATEWIKI_ICON)) {
			copy(self::CREATEWIKI_ICON, "{$aWiki["images"]}/images/6/64/Favicon.ico");
		}
		wfDebugLog( "createwiki", sprintf("Coping favicon and logo: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		$aLocalSettingsVars = array(
			"wgSitename"            => $aWiki["title"],
			"wgScriptPath"          => '',
			"wgScript"              => '/index.php',
			"wgRedirectScript"      => '/redirect.php',
			"wgArticlePath"         => '/wiki/$1',
			"wgLogo"                => '$wgUploadPath/b/bc/Wiki.png',
			"wgUploadPath"          => "http://images.wikia.com/{$aWiki["dir_part"]}/images",
			"wgUploadDirectory"     => "/images/{$aWiki["dir_part"]}/images",
			"wgDBname"              => $aWiki["dbname"],
			"wgSharedDB"            => "wikicities",
			"wgMathPath"            => "http://images.wikia.com/{$aWiki["dir_part"]}/images/math",
			"wgMathDirectory"       => "/images/{$aWiki["dir_part"]}/images/math",
			"wgTmpDirectory"        => "/images/{$aWiki["dir_part"]}/images/tmp",
			"wgLocalInterwiki"      => $aWiki["title"],
			"wgLanguageCode"        => $aWiki["language"],
			"wgServer"              => "http://{$aWiki["subdomain"]}.wikia.com",
			"wgReadOnlyFile"        => "/images/{$aWiki["dir_part"]}/images/lock_yBgMBwiR",
			"wgFavicon"             => '$wgUploadPath/6/64/Favicon.ico',
			"wgDefaultSkin"         => 'monaco',
			"wgDefaultTheme"        => 'sapphire',
			"wgEnableNewParser"     => true
		);

		#--- change default skin to monobook when RTL wiki
		if (in_array($aWiki["language"], array( "he", "ar", "fa", "ur", "yi", "ku", "dv", "ps", "ks", "arc", "ha"))) {
			$aLocalSettingsVars["wgDefaultSkin"] = "monobook";
		}

		#--- insert all wiki variables into city_variables table
		foreach ($aLocalSettingsVars as $tVariable => $tValue) {
			// first, get id of variable
			$oRow = $dbw->selectRow(
				wfSharedTable("city_variables_pool"),
				array("cv_id"),
				array("cv_name" => $tVariable),
				__METHOD__
			);
			$iVariableId = $oRow->cv_id;

			// then, insert value for wikia
			$dbw->insert(
				wfSharedTable("city_variables"),
				array(
					"cv_value"       => serialize( $tValue ),
					"cv_city_id"     => $iInsertId,
					"cv_variable_id" => $iVariableId
				),
				__METHOD__
			);
		}
		wfDebugLog( "createwiki", sprintf("Populating city_variables: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		#--- creating database for new wiki
		$dbw->query("create database `{$aWiki["dbname"]}`;");
		$dbw->selectDB($aWiki["dbname"]);
		wfDebugLog( "createwiki", sprintf("Creating database: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		#--- executing sql files on new database
		$sqlfiles = array(
			"{$IP}/maintenance/tables.sql",
			"{$IP}/maintenance/interwiki.sql",
			"{$IP}/maintenance/wikia/default_userrights.sql",
			"{$IP}/maintenance/wikia/city_interwiki_links.sql",
			"{$IP}/maintenance/wikia-additional-tables.sql",
			"{$IP}/maintenance/wikia/gifts.sql"
		);

		$wgSharedDB = $aWiki["dbname"];
		foreach ($sqlfiles as $file) {
			$dbw->sourceFile( $file );
		}
		wfDebugLog( "createwiki", sprintf("Populating database with sql files: %F", wfTime() - $fExecTimeCur));
		$fExecTimeCur = wfTime();

		#--- insert a blank entry in the site_stats table, so the sitestats page works
		$dbw->replace(
			'site_stats',
			array('ss_row_id'),
			array(
				'ss_row_id'        => 1,
				'ss_total_views'   => 0,
				'ss_total_edits'   => 0,
				'ss_good_articles' => 0
			),
			__METHOD__
		);
		wfDebugLog( "createwiki", sprintf("Initialize database stats: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		#--- importing content from starter.wikia.com (language starter)
		if ($this->mParams["wpCreateWikiImportStarter"]) {
			$prefix = "";
		 if ($aWiki["language"] != "en") {
				$prefix = $aWiki["language"];
			}

		 $sDBstarter = "{$prefix}starter";

			#--- first check whether database starter exists
			$sql = sprintf( "SHOW DATABASES LIKE '%s';", $sDBstarter );
			$oRes = $dbw->query( $sql, __METHOD__ );
			$iNumRows = $oRes->numRows();
			if ( !empty( $iNumRows ) ) {
				$cmd = sprintf(
					"%s -h%s -u%s -p%s %s categorylinks externallinks image imagelinks langlinks page pagelinks revision templatelinks text | %s -h%s -u%s -p%s %s",
					$this->mMYSQLdump,
					$wgDBserver,
					$wgDBuser,
					$wgDBpassword,
					$sDBstarter,
					$this->mMYSQLbin,
					$wgDBserver,
					$wgDBuser,
					$wgDBpassword,
					$aWiki["dbname"]
				);
				wfShellExec( $cmd );

				$dbw->sourceFile( "{$IP}/maintenance/cleanupStarter.sql" );

				$sStartupImgDir = "{$WikiImagesDir}/starter/{$prefix}/images/";
				if (file_exists( $sStartupImgDir ) && is_dir($sStartupImgDir)) {
					wfShellExec("/bin/cp -af $sStartupImgDir {$aWiki["images"]}/");
				}
				$cmd = sprintf(
					"SERVER_ID=%d %s %s/maintenance/updateArticleCount.php --update --conf %s",
					$iInsertId,
					$this->mPHPbin,
					$IP,
					$wgWikiaLocalSettingsPath
				);
				wfShellExec( $cmd );
				
				wfDebugLog( "createwiki", sprintf("Copying starter database: %F", wfTime() - $fExecTimeCur ));
				$fExecTimeCur = wfTime();
			}
			else {
				error_log("no starter database");
			}
		}

		#--- making the wiki founder a sysop/bureaucrat
		if ( $oFounder->getID() ) {
			$dbw->replace('user_groups',array(),array('ug_user' => $oFounder->getID(), 'ug_group' => 'sysop'));
			$dbw->replace('user_groups',array(),array('ug_user' => $oFounder->getID(), 'ug_group' => 'bureaucrat'));
		}
		wfDebugLog( "createwiki", sprintf( "create user sysop/bureaucrat: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		$wgSharedDB = $tmpSharedDB;

		#--- get requets data (to check if name of requests was changed)
		$oRequest = $dbw->selectRow(
			wfSharedTable("city_list_requests"),
			array( "*" ),
			array( "request_id" => $this->mParams["wpRequestID"] ),
			__METHOD__
		);

		#--- change request status to "created"
		$dbw->update(
			wfSharedTable("city_list_requests"),
			array( "request_status" => 1 ),
			array( "request_id" => $this->mParams["wpRequestID"] ),
			__METHOD__
		);
		$dbw->immediateCommit();

		wfDebugLog( "createwiki", sprintf("change request status to created: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		#--- add newly created wiki to the category hub if aplicable
		if ( !empty($iInsertId) && !empty($aWiki["hub"]) ) {
			$hub = WikiFactoryHub::getInstance();
			$hub->setCategory( $iInsertId, $aWiki["hub"] );

			wfDebugLog( "createwiki", sprintf("added wiki to the category hub: %F", wfTime() - $fExecTimeCur ));
			$fExecTimeCur = wfTime();
		}

		#--- updating Request page
		$dbw->selectDB( $tmpDBname );
		$oRequestTitle = wfRequestTitle( $oRequest->request_name, $oRequest->request_language );

		// if title was changed get the old page, save as new and then make old page redirected to newly created
		if ( strtolower($oRequest->request_name) != strtolower( $aWiki["name"] ) || strtolower($aWiki["language"]) != strtolower($oRequest->request_language)) {
			$bTitleChanged = true;

			$oNewTitle = wfRequestTitle( $aWiki["name"], $aWiki["language"] );
			$oRequestTitle->moveTo( $oNewTitle, false, "request name was changed" );

			#--- move talk page as well
			$oRequestTalkTitle = $oRequestTitle->getTalkPage();
			$oRequestNewTalkTitle = $oNewTitle->getTalkPage();

			$oRequestTalkTitle->moveTo( $oRequestNewTalkTitle, false, "request name was changed" );

			$oArticle = new Article( $oNewTitle, 0 );
		}
		else {
			// title hasn't been changed
			$oArticle = new Article( $oRequestTitle, 0 );
  }

  $oArticle->loadContent();

		if( $oArticle->exists() ) {
			$sPage = $oArticle->getContent();
			$sATemplate = "{{a|".$aWiki["subdomain"]."|".$aWiki["language"]."}}";

			// check, maybe a template is already added
			if( strpos($sPage, "{{a|") === false ) {
				$sPage = "{$sATemplate}\n".$sPage;
			}
			$sPage = str_ireplace("[[Category:Open requests]]", "[[Category:Closed requests]]", $sPage);
			$sPage = str_ireplace("RequestForm3", "RequestForm2a", $sPage);
			$sPage = str_ireplace("RequestForm4", "RequestForm4a", $sPage);
			$sPage = str_ireplace("###REQUEST_CLOSED###", date('YmdHis'), $sPage);

			$oArticle->doEdit( $sPage, "request accepted", EDIT_UPDATE );
		}
		wfDebugLog( "createwiki", sprintf( "update request page: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		$this->releaseLock($this->mParams["wpRequestID"]);

		#--- add task to TaskManager
		$oTask = new CreateWikiTask();
		$oTask->createTask(
			array(
				"data"       => $aWiki,
				"params"     => $this->mParams,
				"wikia_id"   => $iInsertId,
				"staff_id"   => $wgUser->getID(),
				"founder_id" => $oFounder->getID()
			),
			TASK_QUEUED
		);
		wfDebugLog( "createwiki", sprintf( "create task in task manager: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();

		# Main part done! Now, just garnish...


		#--- format output for result page (old copy&paste step)
		$sCategories = $this->mParams["wpCreateWikiCategory"]; // should contains strings divided by coma
		//$aCategories = wfRequestCategoryCheck( $sCategories, 1 );

		$sTitleOut = ($this->mParams["wpCreateWikiDescPageTitle"] === $aWiki["name"]
			&& !empty($this->mParams["wpCreateWikiDescPageTitle"]))
			? $aWiki["name"]
			: $this->mParams["wpCreateWikiDescPageTitle"];

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"link"      => $sTitleOut,
				"title"     => $oRequestTitle,
				"params"    => $aWiki,
				"pageUrl"   => ($wgServer . $wgScript)
			)
		);
		$sPageOut = $oTmpl->execute( "page-output" );
		$wgOut->addHTML( $sPageOut );

		$wgDBname = $tmpDBname;
		$wgSharedDB = $tmpSharedDB;

		wfDebugLog( "createwiki", sprintf( "prepare output page: %F", wfTime() - $fExecTimeCur ));
		$fExecTimeCur = wfTime();


		$fExecTime = wfTime() - $fExecTime; #--- for profilling
		wfDebugLog( "createwiki", "===== Create wiki finished. Total {$fExecTime} =====" );
 }

	/**
	 * rejectRequest
	 *
	 * reject request, first step is confirming choice, second - real reject
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param integer $doit default 0: real update/insert
	 *
	 */
	private function rejectRequest($doit=0) {
		global $wgContLang, $wgDBname, $wgOut, $wgRequest, $wgUser;

		#--- load request from database
		$dbw = wfGetDB( DB_MASTER );
		$dbw->selectDB( "wikicities" );

		$request = $dbw->selectRow("city_list_requests",
			array( "*" ),
			array( "request_id" => $this->mRequest ),
			__METHOD__
		);
		$sName = $wgContLang->ucfirst( $request->request_name );

		if( $doit == 1 ) {
			$dbw->update( "city_list_requests",
				array( "request_status" => 2 ),
				array( "request_id" => $request->request_id ),
				__METHOD__
			);

			#--- send rejection email
			$sRejectEmailBody = $wgRequest->getVal("wpRejectEmail");
			if( !empty( $sRejectEmailBody ) ) {
				// get founder object
				$oFounder = User::newFromId($request->request_user_id);
				$oFounder->load();

				// set apropriate staff member object
				$oStaffUser = CreateWikiTask::getStaffUserByLang($request->request_language);
				$oStaffUser = is_object($oStaffUser) ? $oStaffUser : $wgUser;

				$aEmailArgs = array(
								0 => $oFounder->getName(),
								1 => wfRequestTitle($request->request_name, $request->request_language)->getFullURL(),
								2 => 'http://' . $request->request_name . '.wikia.com',
								3 => 'http://www.wikia.com/wiki/' . $sName,
								4 => $oStaffUser->getRealName()
				);

				$sBody = wfMsgReplaceArgs($sRejectEmailBody, $aEmailArgs);
				$sSubject = wfMsg('createwiki-reject-email-subject');

				$sTo = $oFounder->getEmail();
				if(!empty($sTo)) {
					$result = $oFounder->sendMail($sSubject, $sBody, "community@wikia.com");
				}
			}

			$sReason = $wgRequest->getVal("wpRejectInfo");

			#--- set Request page edit summary
			$sSummary = $wgRequest->getVal("wpRejectSummary");
			$aSummary = explode("|", $sSummary);
			$sSummary = $aSummary[0];

			$matches = null;
			$sFormattedSummary = "Request rejected: ";
			switch( $sSummary ) {
				case 'goto':
					preg_match('/\{\{goto\|([^\|]*)\|/i', $sReason, $matches);
					$sFormattedSummary .= "Please go to " . $matches[1];
				break;

				case 'adopted':
					preg_match('/\{\{adopted\|([^\|]*)\|/i', $sReason, $matches);
					$sFormattedSummary .= "Now admin on " . $matches[1];
				break;

				case 'focus':
					preg_match('/\{\{focus\|([^\|]*)\|/i', $sReason, $matches);
					$sFormattedSummary .= "Please focus on " . $matches[1];
				break;

				default:
						$sFormattedSummary .= $sSummary;
			}

			#--- update Request page
			$dbw->selectDB( $wgDBname );

			if( strlen($sName) ) {

				$oTitle = wfRequestTitle( $request->request_name, $request->request_language );

				$oArticle = new Article( $oTitle /*title*/, 0 /*actual id*/);
				$sPage = $oArticle->getContent();

				#-- check, maybe a template is already added
				if (strpos($sPage, $sReason) === false) {
					$sPage = "{$sReason}\n".$sPage;
				}
				$sPage = str_ireplace("[[Category:Open requests]]", "[[Category:Closed requests]]", $sPage);
				$sPage = str_ireplace("RequestForm3", "RequestForm2a", $sPage);
				$sPage = str_ireplace("RequestForm4", "RequestForm4a", $sPage);
				$sPage = str_ireplace("###REQUEST_CLOSED###", date('YmdHis'), $sPage);

				$oArticle->doEdit($sPage, $sFormattedSummary);

				return $wgOut->redirect( $oTitle->getLocalUrl() );
			}
			else {
				return $wgOut->redirect( $this->mTitle->getLocalUrl() );
			}
		}
		else {
			#--- confirm rejection
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"title" => $this->mTitle,
				"request" => $request,
			));
			$wgOut->addHTML( $oTmpl->execute("confirm-reject") );
		}
	}

	#--- deleteRequest ------------------------------------------------------
	/**
	 * delete request, first step is confirming choice, second - real delete
	 *
	 */
	private function deleteRequest($doit = false) {
		global $wgContLang, $wgDBname, $wgOut;

		$request = $this->getRequestBy('request_id', $this->mRequest);

		if($doit) {
			$this->deleteRequestById($request->request_id);

			#--- update Request page
			$dbw = wfGetDB( DB_MASTER );
			$dbw->selectDB( $wgDBname );

			if (strlen($request->request_name)) {
				$oTitle = wfRequestTitle( $request->request_name, $request->request_language );
				return $wgOut->redirect( $oTitle->getLocalUrl( "action=delete&submitdelete=true&wpReason=auto-deleting_unneeded_request" ));
			}
			else {
				return $wgOut->redirect( $this->mTitle->getLocalUrl() );
			}
		}
		else {
			#--- confirm deleting
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
				array(
					"title" => $this->mTitle,
					"request" => $request,
				)
			);
			$wgOut->addHTML( $oTmpl->execute("confirm-delete") );
		}
	}

	/**
	 * get request object by given field value
	 * @param string $sFieldName field name
	 * @param string $sFieldValue field value
	 * @return stdClass request object
	 */
	public static function getRequestBy($sFieldName, $sFieldValue) {
		$dbw = wfGetDB( DB_MASTER );

		$request = $dbw->selectRow(
			wfSharedTable("city_list_requests"),
			array( "*" ),
			array( $sFieldName => strtolower($sFieldValue) ),
			__METHOD__
		);

		return $request;
	}

	/**
	 * remove request from database
	 * @param int request id
	 */
	private function deleteRequestById($iRequestId) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete(
			wfSharedTable("city_list_requests"),
			array( "request_id" => $iRequestId ),
			__METHOD__
		);

		$dbw->immediateCommit();
	}

    /**
     * getLockInfo
     *
     * just HTML div with whole information about lock
     *
     * @access private
     * @author eloy@wikia
     *
     * @param CreateWikiLock $lock: lock object
     *
     * @return string: HTML code
     */
    private function getLockInfo( $lock )
    {
        $aLocksInfo = array();
        $aLocks = $lock->getLocks();
        if( is_array( $aLocks ) ) {
            foreach( $aLocks as $oLock ) {
                $oLocker = User::newFromId( $oLock->user_id );
                $oLocker->load();
                $aLocksInfo[] = array(
                    "user" => $oLocker->getName(),
                    "time" => wfTimestamp( TS_DB,  $oLock->timestamp ),
                    "locked" =>  $oLock->locked
                );
            }
        }
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "lock" => $lock,
            "info" => $aLocksInfo,
            "title" => $this->mTitle
        ));
        return $oTmpl->execute("lock-info");
    }

	/**
	 * doUnlock
	 *
	 * simple unlocking method
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @return void
     */
	private function doUnlock()
	{
		global $wgOut, $wgRequest;

        $status = false;
        $iId = $wgRequest->getVal("id", null);
        if( !is_null( $iId ) ) {
            $oLock = CreateWikiLock::newFromID( $iId );
            if( $oLock->isLocked() === true ) {
                $status = $oLock->release();
            }

            $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
            $oTmpl->set_vars( array(
                "lock" => $oLock,
                "title" => $this->mTitle,
                "status" => $status
            ));
            $wgOut->addHTML( $oTmpl->execute("lock-removed") );
        }

	}

};
