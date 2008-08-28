<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#--- messages file
$wgExtensionMessagesFiles["CreateWikiTask"] = dirname(__FILE__) . '/CreateWikiTask/CreateWikiTask.i18n.php';

class CreateWikiTask extends BatchTask {
    public $mType, $mVisible, $mParams, $mFounder, $mStaff;
    public $mWikiParams, $mWikiID, $mTaskParams, $mTaskData;

	/**
	 * contructor
	 */
	function  __construct() {
		$this->mType = "createwiki";
		$this->mVisible = false;
		$this->mTTL = 1800;
		parent::__construct();
		$this->mDebug = true;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	function execute( $params = null ) {
		global $IP, $wgDevelEnvironment;
		global $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

		if( !isset( $wgWikiaAdminSettingsPath ) ) {
			$wgWikiaAdminSettingsPath = dirname( $wgWikiaLocalSettingsPath ) . "/../AdminSettings.php";
		}
		wfLoadExtensionMessages( "CreateWikiTask" );

		$this->mData = $params;

		/**
		 * set task id for future use (logs, for example)
		 */
		$this->mTaskID = $this->mData->task_id;

		/**
		 * debug switched always on when devel environmet
		 */
		if( isset( $wgDevelEnvironment ) && $wgDevelEnvironment ) {
			$this->mDebug = true;
		}

		$this->mParams = unserialize( $this->mData->task_arguments );
		$this->mTaskParams = $this->mParams["params"];
		$this->mTaskData = $this->mParams["data"];

		$this->mWikiID = $this->mParams["wikia_id"];

		$this->mFounder = User::newFromId( $this->mParams["founder_id"] );
		$this->mFounder->load();

		$this->mStaff = User::newFromId( $this->mParams["staff_id"] );
		$this->mStaff->load();

		/**
		 * maintenance tasks
		 */
		$cmd = sprintf("SERVER_ID={$this->mWikiID} php {$IP}/extensions/CheckUser/install.php --quick --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
		$this->addLog( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->addLog( $retval );

		$this->mWikiParams = WikiFactory::getWikiByID( $this->mWikiID );
		if( !isset( $this->mWikiParams->city_id ) ) {
			$this->addLog( "Cannot get Wiki data from city_list" );
			return false;
		}

		$success = $this->setCentralPages();
		if( !$success ) {
			echo "setCentralPages() method failed... task aborted.\n";
			return false;
		}

		/**
		 * A "welcome" message should be added to the founder's talk page on
		 * the new wiki
		 */
		$this->setWelcomeTalkPage();

		/**
		 * After the wiki is made, the founder should be sent an
		 *   "introduction to your wiki" page by email in the relevant language
		 *   (even if they don't have "Enable email from other users" set in
		 *   preferences). The return address is community@wikia.com.
		 */
		$this->sendWelcomeMail();

		# 8. Run WikiMover if there is starter for category choosen
		if ( !empty($this->mParams["params"]["wpCreateWikiCategoryStarter"])) {
			$oWikiMover = WikiMover::newFromIDs(
				$this->mParams["params"]["wpCreateWikiCategoryStarter"],
				$this->mParams["wikia_id"]
			);
			$oWikiMover->setOverwrite( true );
			$oWikiMover->load();
			$oWikiMover->move();

			#--- get log from WikiMover and write into database
			foreach( $oWikiMover->getLog( true ) as $log ) {
				$this->addLog( $log["info"], $log["timestamp"] );
			}

			#--- clear message cache, in case we ovewrote some MediaWiki ns pages
			$cmd = sprintf("SERVER_ID={$this->mWikiID} php {$IP}/maintenance/rebuildmessages.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
			$this->addLog( "Running {$cmd}");
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );
			
			#--- modify wiki's variables based on hub and $wgHubCreationVariables values
	                $this->addHubSettings( $this->mParams["params"]["wpCreateWikiCategory"]  );
		}

		/**
		 * setting images creation dates (bug: #1687)
		 */
		$this->resetImagesTimestamp();

		/**
		 * protect key pages, e.g. logo and favicon (bug: 3209)
		 */
		$cmd = sprintf("SERVER_ID={$this->mWikiID} php {$IP}/maintenance/wikia/protectKeyPages.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
		$this->addLog( "Running {$cmd}");
		$retval = wfShellExec( $cmd, $status );
		$this->addLog( $retval );

		/**
		 * Move Main_Page to $wgSitename page
		 */
		$cmd = sprintf("SERVER_ID={$this->mWikiID} php {$IP}/maintenance/wikia/moveMain.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
		$this->addLog( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->addLog( $retval );

		/**
		 * Add additional domains
		 */
		$this->addDomains( $this->mParams["params"]["wpCreateWikiDomains"] );

		echo "Hi! its ".__METHOD__." task_id={$this->mData->task_id}\n";

		/**
		 * we need some stuffs in recent changes so this one is run last
		 */
		$cmd = sprintf("SERVER_ID={$this->mWikiID} php {$IP}/extensions/CheckUser/install.php --quick --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
		$this->addLog( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->addLog( $retval );

		return true;
	}


    /**
     * getForm
     *
     * this task is not visible in selector so it doesn't have real HTML form
     *
     * @access public
     * @author eloy@wikia
     *
     * @param Title $title: Title struct
     * @param mixes $data: params from HTML form
     *
     * @return false
     */
    public function getForm( $title, $data = false ) {
        return false;
    }

    /**
     * getType
     *
     * return string with codename type of task
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string: unique name
     */
    public function getType() {
        return $this->mType;
    }

    /**
     * isVisible
     *
     * check if class is visible in TaskManager from dropdown
     *
     * @access public
     * @author eloy@wikia
     *
     * @return boolean: visible or not
     */
    public function isVisible() {
        return $this->mVisible;
    }

    /**
     * submitForm
     *
     * since this task is invisible for form selector we use this method for
     * saving request data in database
     *
     * @access public
     * @author eloy@wikia
     *
     * @return true
     */
    public function submitForm() {
        return true;
    }

    /**
     * setWelcomeTalkPage
     *
     * @author eloy@wikia
     * @access private
     *
     * @return boolean status
     */
    private function setWelcomeTalkPage() {
        global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

        $this->addLog( "Setting welcome talk page on new wiki..." );

        $oTalkPage = $this->mFounder->getTalkPage();
        $sWikiaName = WikiFactory::GetVarValueByName( "wgSitename", $this->mWikiID);
        $sWikiaLang = WikiFactory::GetVarValueByName( "wgLanguageCode", $this->mWikiID);

        // set apropriate staff member
        $oStaffUser = CreateWikiTask::getStaffUserByLang($sWikiaLang);
        $oStaffUser = is_object($oStaffUser) ? $oStaffUser : $this->mStaff;

		$aPageParams = array(
			0 => $this->mFounder->getName(),
			1 => htmlspecialchars( $oStaffUser->getName() ),
			2 => $oStaffUser->getRealName(),
			3 => $sWikiaName
		);
		$sBody = null;
		$sWelcomeTalkLang = $sWikiaLang;
		if(($sWikiaLang != 'en') && !empty($sWikiaLang)) {
			// custom lang translation
			$sBody = wfMsg("createwiki_welcometalk/$sWikiaLang", $aPageParams);
		}

        if(($sBody == null) || wfEmptyMsg( "createwiki_welcometalk/$sWikiaLang", $sBody)) {
        	/**
			 * default lang (english)
			 */
        	$sBody = wfMsg("createwiki_welcometalk", $aPageParams);
       		$sWelcomeTalkLang = 'en';
        }

        $sCommand = sprintf(
            "SERVER_ID=%d php %s/maintenance/wikia/edit.php -u '%s' '%s' --conf %s --aconf %s",
            $this->mWikiID,
            $IP,
            $oStaffUser->getName(),
            $oTalkPage->getPrefixedText(),
            $wgWikiaLocalSettingsPath,
			$wgWikiaAdminSettingsPath
        );

        $this->addLog( $sCommand );
        if(!empty($this->mWikiID)) {
            $oHandler = popen( $sCommand, "w" );
            fwrite( $oHandler, $sBody );
            pclose( $oHandler );
            $this->addLog( sprintf(
                "Founder talk page %s%s set (lang: $sWelcomeTalkLang).",
                rtrim($this->mWikiParams->city_url, "/"),
                $this->mFounder->getTalkPage()->getLocalURL()
            ));
        }
        else {
            $this->addLog( "Unknown wiki id. Founder talk page not set." );
        }

        return true;
    }

	/**
	 * set images timestamp to current date (see: #1687)
	 *
	 * @author Adrian Wieczorek <adi@wikia.com>
	 */
	private function resetImagesTimestamp() {
		global $wgDBname;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->selectDB( $this->mTaskData["dbname"] );
		$dbw->update(
			'image',
			array( 'img_timestamp' => date('YmdHis') ),
			'*',
			__METHOD__
		);
		$dbw->immediateCommit();
	}

    /**
     * sendWelcomeMail
     *
     * sensd welcome email to founder (if founder has set email address)
     *
     * @author eloy@wikia.com
     * @author adi@wikia.com
     * @access private
     *
     * @return boolean status
     */
    private function sendWelcomeMail() {
        global $wgDevelEnvironment, $wgUser, $wgPasswordSender;

        $oReceiver = $this->mFounder;
        if( !empty( $wgDevelEnvironment ) ) {
            $oReceiver = $wgUser;
        }

        $sWikiaName = WikiFactory::GetVarValueByName( "wgSitename", $this->mWikiID);
        $sWikiaLang = WikiFactory::GetVarValueByName( "wgLanguageCode", $this->mWikiID);

        // set apropriate staff member
        $oStaffUser = CreateWikiTask::getStaffUserByLang($sWikiaLang);
        $oStaffUser = is_object($oStaffUser) ? $oStaffUser : $this->mStaff;

        $from = new MailAddress( $wgPasswordSender, "The Wikia Community Team" );
        $sTo = $oReceiver->getEmail();

        $aBodyParams = array(
			0 => $this->mWikiParams->city_url,
			1 => $oReceiver->getName(),
			2 => $oStaffUser->getRealName(),
			3 => htmlspecialchars( $oStaffUser->getName() ),
			4 => sprintf( "%s%s",
				rtrim($this->mWikiParams->city_url, "/"),
				$oReceiver->getTalkPage()->getLocalURL()
			),
		);

        $sBody = null;
        $sSubject = null;
        if(($sWikiaLang != 'en') && !empty($sWikiaLang)) {
        	// custom lang translation
        	$sBody = wfMsg("createwiki_welcomebody/$sWikiaLang", $aBodyParams);
        	$sSubject = wfMsg("createwiki_welcomesubject/$sWikiaLang", array($sWikiaName));
        }

        if(($sBody == null) || wfEmptyMsg( "createwiki_welcomebody/$sWikiaLang", $sBody)) {
        	// default lang (english)
        	$sBody = wfMsg("createwiki_welcomebody", $aBodyParams);
        }
        if(($sSubject == null) || wfEmptyMsg( "createwiki_welcomesubject/$sWikiaLang", $sSubject)) {
        	// default lang (english)
        	$sSubject = wfMsg("createwiki_welcomesubject", array($sWikiaName));
        }

        if( !empty($sTo) ) {
            $bStatus = $oReceiver->sendMail($sSubject, $sBody, $from );
            if( $bStatus === true ) {
                $this->addLog( "Mail to founder {$sTo} sent.");
            }
            else {
                $this->addLog( "Mail to founder {$sTo} probably not sent. sendMail returned false.");
            }
        }
        else {
            $this->addLog( "Founder email is not set. Welcome email is not sent" );
        }
    }

	/**
	 * addDomains
	 *
	 * add additional domains to city_domains. $domains param is string
	 * with domain names splitted by space
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param string $domains: string from input field
	 */
	private function addDomains( $domains ) {
		$aDomains = array();
		if(!empty($domains)) {
			#--- split by space, then trim elements
			foreach( explode(" ", $domains) as $domain ) {
				if( true === WikiFactory::addDomain(  $this->mWikiID, trim($domain) ) ) {
					$this->addLog( "$domain added" );
				}
				else {
					$this->addLog( "$domain used" );
				}
			}
		}
		else {
			$this->addLog( "No additional domains for this wiki.");
		}
	}

	/**
	 * setCentralPage
	 *
	 * set central page with informations about created wiki
	 *
	 * @access private
	 * @author eloy@wikia
	 */
	private function setCentralPages() {
		global $wgDBname, $wgUser;

		/**
		 * do it only when run on central wikia
		*/
		if( $wgDBname != "wikicities" ) {
			$this->addLog( "Not run on central wikia. Cannot set wiki description page" );
			return false;
		}

		/**
		 * set user for all maintenance work on central
		 */
		$oldUser = $wgUser;
		$wgUser = User::newFromName( 'CreateWiki script' );
		$this->addLog( "Creating and modifing pages on Central Wikia (as user: " . $wgUser->getName() . ")..." );

		/**
		 * title of page
		 */
		$sCentralTitle =
			( $this->mTaskParams["wpCreateWikiDescPageTitle"] === $this->mTaskData["name"]
			&& !empty( $this->mTaskParams["wpCreateWikiDescPageTitle"]) )
			? $this->mTaskData["name"]
			: $this->mTaskParams["wpCreateWikiDescPageTitle"];

		#--- title for this page
		$oCentralTitle = Title::newFromText( $sCentralTitle, NS_MAIN );
		if($oCentralTitle instanceof Title) {
			#--- and article for for this title
			$this->addLog( sprintf("[debug] Got title object for page: %s", $oCentralTitle->getFullUrl()) );
		    $oCentralArticle = new Article( $oCentralTitle, 0);
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/CreateWikiTask/" );
			$oTmpl->set_vars( array(
				"data"          => $this->mTaskData,
				"wikid"         => $this->mWikiID,
				"param"         => $this->mTaskParams,
				"founder"       => $this->mFounder,
				"timestamp"     => $sTimeStamp = gmdate("j F, Y"),
				"categories"    => wfStringToArray( $this->mTaskParams["wpCreateWikiCategory"], ",", 5 )
			));

			if(!$oCentralArticle->exists()) {
				#--- create article
				$this->addLog( sprintf("[debug] Creating new article: %s", $oCentralTitle->getFullUrl()) );

				$sPage = $oTmpl->execute("central-maindescription");
				$sPage.= $oTmpl->execute("central");

				$this->addLog( "[debug] Page body formatted, launching doEdit() ..." );
				$oCentralArticle->doEdit( $sPage, "created by task manager" );
				$this->addLog( sprintf("Article %s added.", $oCentralTitle->getFullUrl()) );
			}
			else {
				#--- update article
				$this->addLog( sprintf("[debug] Updating existing article: %s", $oCentralTitle->getFullUrl()) );

				$sContent = $oCentralArticle->getContent();
				$sContent.= $oTmpl->execute("central");

				$oCentralArticle->doEdit( $sContent, "modified by task manager");
				$this->addLog( sprintf("Article %s already exists... content added", $oCentralTitle->getFullUrl()) );
			}
		}
		else {
			$this->addLog( "ERROR: Unable to create title object for page on Central Wikia: " . $sCentralTitle );
			return false;
		}


		#--- add to Template:List_of_Wikia_New
		$sCentralListTitle = 'Template:List_of_Wikia_New';
		$oCentralListTitle = Title::newFromText( $sCentralListTitle, NS_MAIN );
		if($oCentralListTitle instanceof Title) {
			$oCentralListArticle = new Article( $oCentralListTitle, 0);
			if( $oCentralListArticle->exists() ) {
				$sContent = $oCentralListArticle->getContent();
				$sContent.= "{{subst:nw|" . $this->mTaskData['subdomain'] . "|" . $sCentralTitle . "|" . $this->mTaskData['language'] . "}}";

				$oCentralListArticle->doEdit( $sContent, "modified by task manager");
				$this->addLog( sprintf("Article %s modified.", $oCentralListTitle->getFullUrl()) );
			}
			else {
				$this->addLog( sprintf("Article %s not exists.", $oCentralListTitle->getFullUrl()) );
			}

			#--- add to New_wikis_this_week/Draft
			$sCentralListTitle = 'New_wikis_this_week/Draft';
			$oCentralListTitle = Title::newFromText( $sCentralListTitle, NS_MAIN );
			$oCentralListArticle = new Article( $oCentralListTitle, 0);

			if($oCentralListArticle->exists()) {
				$oHub = WikiFactoryHub::getInstance();
				$aHubs = $oHub->getCategories();
				$sReplace = "{{nwtw|" . $this->mTaskData['language'] . "|" . $aHubs[$this->mTaskParams['wpWikiCategory']] . "|" . $sCentralTitle . "|http://" . $this->mTaskData['subdomain'] . ".wikia.com}}\n|}";
				$sContent = str_replace("|}", $sReplace, $oCentralListArticle->getContent());

				$oCentralListArticle->doEdit( $sContent, "modified by task manager");
				$this->addLog( sprintf("Article %s modified.", $oCentralListTitle->getFullUrl()) );
			}
			else {
				$this->addLog( sprintf("Article %s not exists.", $oCentralListTitle->getFullUrl()) );
			}
		}
		else {
			$this->addLog( "ERROR: Unable to create title object for page: " . $sCentralListTitle);
			return false;
		}

		if(strcmp(strtolower($this->mTaskData['redirect']), strtolower($sCentralTitle)) != 0) {
			#--- add redirect(s) on central
			$oCentralRedirectTitle = Title::newFromText( $this->mTaskData['redirect'], NS_MAIN );
			if( $oCentralRedirectTitle instanceof Title ) {
				$oCentralRedirectArticle = new Article( $oCentralRedirectTitle, 0);
				if( !$oCentralRedirectArticle->exists() ) {
					$sContent = "#Redirect [[" . $sCentralTitle . "]]";
					$oCentralRedirectArticle->doEdit( $sContent, "modified by task manager");
					$this->addLog( sprintf("Article %s added (redirect to: " . $sCentralTitle . ").", $oCentralRedirectTitle->getFullUrl()) );
				}
				else {
					$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
				}

				if( ($this->mTaskData['language'] == 'en') && (!eregi("^en.", $this->mTaskData['subdomain'])) ) {
					// extra redirect page: en.<subdomain>
					$sCentralRedirectTitle = 'en.' . $this->mTaskData['subdomain'];
					$oCentralRedirectTitle = Title::newFromText( $sCentralRedirectTitle, NS_MAIN );
					if( !$oCentralRedirectArticle->exists() ) {
						$sContent = "#Redirect [[" . $sCentralTitle . "]]";
						$oCentralRedirectArticle->doEdit( $sContent, "modified by task manager");
						$this->addLog( sprintf("Article %s added (extra redirect to: " . $sCentralTitle . ").", $oCentralRedirectTitle->getFullUrl()) );
					}
					else {
						$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
					}
				}
			}
			else {
				$this->addLog( "ERROR: Unable to create title object for redirect page: " . $this->mTaskData['redirect']);
				return false;
			}
		}

		#--- revert back to original User object, just in case
		$wgUser = $oldUser;

		$this->addLog( "Creating and modifing pages on Central Wikia finished." );
		return true;
	}

    /**
     * getDescription
     *
     * description of task, used in task listing.
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string: task description
     */
    public function getDescription() {
        $desc = $this->getType();
        if( !is_null( $this->mData ) ) {
            $args = unserialize( $this->mData->task_arguments );
            $oWiki = WikiFactory::getWikiByID( $args["wikia_id"] );
            $desc = sprintf(
                "createwiki id: %d<br />
                url: <a href=\"%s\">%s</a>",
                $oWiki->city_id,
                $oWiki->city_url,
                $oWiki->city_dbname
            );
        }
        return $desc;
    }

	/**
	 * get staff member signature for given lang code
	 */
	public static function getStaffUserByLang($langCode) {
		$staffSigs = wfMsgForContent('staffsigs');
		if( !empty($staffSigs) ) {
			$lines = explode("\n", $staffSigs);

			foreach( $lines as $line ) {
				if( strpos($line, '* ') === 0 ) {
					$sectLangCode = trim($line, '* ');
					continue;
				}
				if((strpos($line, '* ') == 1) && ($langCode == $sectLangCode)) {
					$sUser = trim($line, '** ');
				    $oUser = User::newFromName($sUser);
					$oUser->load();
					return $oUser;
				}
			}
		}
		else {
			return false;
		}
		return false;
	}

	/**
	 * addHubSettings
	 *
	 * @author tor@wikia-inc.com
	 * @param  string $hub
	 */
	public function addHubSettings( $hub ) {
		global $wgHubCreationVariables;

		if (!empty($hub) && is_array($wgHubCreationVariables[$hub])) {
			$this->addLog("Found hub \"$hub\" in HubCreationVariables.");
			foreach ($wgHubCreationVariables[$hub] as $key => $value) {
				$success = WikiFactory::setVarById($key, $this->mWikiID, $value);
				if ($success) {
	                                $this->addLog("Successfully added hub setting: $key = $value");
				} else {
					$this->addLog("Failed to add hub setting: $key = $value");
				}
			}
			$this->addLog("Finished adding hub settings.");
		} else {
			$this->addLog("Hub not found in HubCreationVariables. Skipping this step.");
		}
	}
}
