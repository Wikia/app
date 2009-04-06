<?php

/**
 * @file
 * @package MediaWiki
 * @ingroup BatchTask
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2009-03-17
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Generic Task, will run maintenance task for specified city_id
 */

class LocalMaintenanceTask extends BatchTask {

	private $mParams, $mWikiId;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {

		parent::__construct();
		$this->mType = "local-maintenance";
		$this->mVisible = false;
		$this->mTTL = 1800;
		$this->mDebug = false;
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
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath, $wgExtensionMessagesFiles;

		$wgExtensionMessagesFiles[ "LocalMaintenance" ] = dirname(__FILE__) . "/LocalMaintenanceTask/messages.i18n.php";
		wfLoadExtensionMessages( "LocalMaintenance" );

		$this->mTaskID = $params->task_id;
		$this->mParams = unserialize( $params->task_arguments );

		$city_id = $this->mParams[ "city_id" ];
		$command = $this->mParams[ "command" ];
		$type    = $this->mParams[ "type" ];

		wfWaitForSlaves( 2 );

		if( $city_id && $command ) {
			$this->mWikiId = $city_id;
			/**
			 * execute maintenance script
			 */
			$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/{$command} --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
			$this->addLog( "Running {$cmd}" );
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );

			if( $type == "ACWLocal" ) {
				$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/initStats.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
				$this->addLog( "Running {$cmd}" );
				$retval = wfShellExec( $cmd, $status );
				$this->addLog( $retval );

				$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/refreshLinks.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
				$this->addLog( "Running {$cmd}" );
				$retval = wfShellExec( $cmd, $status );
				$this->addLog( $retval );

				$this->mWikiData = $this->mParams[ "data" ];
				$this->mFounder = User::newFromId( $this->mWikiData[ "founder"] );
				$this->mFounder->load();
				$this->setCentralPages();
			}
		}

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
	 * set central pages, used in AutoCreateWiki task
	 *
	 */
	private function setCentralPages() {
		global $wgDBname, $wgUser;

		/**
		 * do it only when run on central wikia
		*/
		if ( $wgDBname != "wikicities" ) {
			$this->addLog( "Not run on central wikia. Cannot set wiki description page" );
			return false;
		}


		$oldUser = $wgUser;
		/**
		 * set user for all maintenance work on central
		 */
		$wgUser = User::newFromName( 'CreateWiki script' );
		$this->addLog( "Creating and modifing pages on Central Wikia (as user: " . $wgUser->getName() . ")..." );

		/**
		 * title of page
		 */
		$centralTitleName = $this->mWikiData[ "name"];

		#--- title for this page
		$centralTitle = Title::newFromText( $centralTitleName, NS_MAIN );
		$oHubs = WikiFactoryHub::getInstance();
		$aCategories = $oHubs->getCategories();

		if ( $centralTitle instanceof Title ) {
			/**
			 *  and article for for this title
			 */
			$this->addLog( sprintf("Have title object for page: %s", $centralTitle->getFullUrl( ) ) );
		    $oCentralArticle = new Article( $centralTitle, 0);

		    /**
			 * set category name
			 */
	    	$sCategory = $this->mWikiData[ "hub" ];
			if(!empty( $aCategories ) && isset( $aCategories[ $this->mWikiData[ "hub" ] ] ) ) {
		    	$sCategory = $aCategories[ $this->mWikiData[ "hub" ] ];
			}

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/LocalMaintenanceTask/" );
			$oTmpl->set_vars( array(
				"data"          => $this->mWikiData,
				"wikid"         => $this->mWikiId,
				"founder"       => $this->mFounder,
				"timestamp"     => $sTimeStamp = gmdate("j F, Y"),
				"category"		=> $sCategory
			));

			if( !$oCentralArticle->exists() ){
				/**
				 * create article
				 */
				$this->addLog( sprintf("Creating new article: %s", $centralTitle->getFullUrl( ) ) );
				$sPage = $oTmpl->execute("central");
				$oCentralArticle->doEdit( $sPage, "created by autocreate Wiki process", EDIT_FORCE_BOT );
				$this->addLog( sprintf("Article %s added.", $centralTitle->getFullUrl()) );
			}
			else {
				/**
				 * update article
				 */
				$this->addLog( sprintf("Updating existing article: %s", $centralTitle->getFullUrl()) );
				$sContent = $oCentralArticle->getContent();
				$sContent = $oTmpl->execute("central");
				$oCentralArticle->doEdit( $sContent, "modified by autocreate Wiki process", EDIT_FORCE_BOT );
				$this->addLog( sprintf("Article %s already exists... content added", $centralTitle->getFullUrl()) );
			}
		}
		else {
			$this->addLog( "ERROR: Unable to create title object for page on Central Wikia: " . $centralTitleName );
			return false;
		}

		/**
		 * add to Template:List_of_Wikia_New
		 */
		$oCentralListTitle = Title::newFromText( "Template:List_of_Wikia_New", NS_MAIN );
		if ( $oCentralListTitle instanceof Title ) {
			$oCentralListArticle = new Article( $oCentralListTitle, 0);
			if ( $oCentralListArticle->exists() ) {
				$sContent =  $oCentralListArticle->getContent();
				$sContent .= "{{subst:nw|" . $this->mWikiData['subdomain'] . "|";
				$sContent .= $centralTitleName . "|" . $this->mWikiData['language'] . "}}";

				$oCentralListArticle->doEdit( $sContent, "modified by autocreate Wiki process", EDIT_FORCE_BOT);
				$this->addLog( sprintf("Article %s modified.", $oCentralListTitle->getFullUrl()) );
			}
			else {
				$this->addLog( sprintf("Article %s not exists.", $oCentralListTitle->getFullUrl()) );
			}

			/**
			 * add to New_wikis_this_week/Draft
			 */
			$oCentralListTitle = Title::newFromText( "New_wikis_this_week/Draft", NS_MAIN );
			$oCentralListArticle = new Article( $oCentralListTitle, 0);

			if ( $oCentralListArticle->exists() ) {
				$sReplace =  "{{nwtw|" . $this->mWikiData['language']  . "|" ;
				$sReplace .= $aCategories[ $this->mWikiData[ "hub" ] ] . "|" ;
				$sReplace .= $centralTitleName . "|http://" . $this->mWikiData['subdomain'] . ".wikia.com}}\n|}";

				$sContent = str_replace("|}", $sReplace, $oCentralListArticle->getContent());

				$oCentralListArticle->doEdit( $sContent, "modified by autocreate Wiki process", EDIT_FORCE_BOT);
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

		if( strcmp( strtolower( $this->mWikiData['redirect'] ), strtolower( $centralTitleName ) ) != 0 ) {
			#--- add redirect(s) on central
			$oCentralRedirectTitle = Title::newFromText( $this->mWikiData['redirect'], NS_MAIN );
			if ( $oCentralRedirectTitle instanceof Title ) {
				$oCentralRedirectArticle = new Article( $oCentralRedirectTitle, 0);
				if ( !$oCentralRedirectArticle->exists() ) {
					$sContent = "#Redirect [[" . $centralTitleName . "]]";
					$oCentralRedirectArticle->doEdit( $sContent, "modified by autocreate Wiki process", EDIT_FORCE_BOT);
					$this->addLog( sprintf("Article %s added (redirect to: " . $centralTitleName . ").", $oCentralRedirectTitle->getFullUrl()) );
				}
				else {
					$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
				}

				if( ( $this->mWikiData['language'] == 'en' ) && ( !eregi("^en.", $this->mWikiData['subdomain']) ) ) {
					/**
					 * extra redirect page: en.<subdomain>
					 */
					$sCentralRedirectTitle = 'en.' . $this->mWikiData['subdomain'];
					$oCentralRedirectTitle = Title::newFromText( $sCentralRedirectTitle, NS_MAIN );
					if ( !$oCentralRedirectArticle->exists() ) {
						$sContent = "#Redirect [[" . $centralTitleName . "]]";
						$oCentralRedirectArticle->doEdit( $sContent, "modified by autocreate Wiki process", EDIT_FORCE_BOT);
						$this->addLog( sprintf("Article %s added (extra redirect to: " . $centralTitleName . ").", $oCentralRedirectTitle->getFullUrl()) );
					}
					else {
						$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
					}
				}
			} else {
				$this->addLog( "ERROR: Unable to create title object for redirect page: " . $this->mWikiData['redirect'] );
				return false;
			}
		}

		/**
		 * revert back to original User object, just in case
		 */
		$wgUser = $oldUser;

		$this->addLog( "Creating and modifing pages on Central Wikia finished." );
		return true;
	}
}
