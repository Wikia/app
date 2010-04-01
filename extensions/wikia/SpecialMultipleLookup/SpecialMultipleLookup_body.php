<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class MultipleLookupPage extends SpecialPage {
	private $mTitle;
	private $mCore;
	private $mUsername;
	private $numResults;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "MultiLookup"  /*class*/, 'multilookup' /*restriction*/);
		wfLoadExtensionMessages("MultiLookup");
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'multilookup' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'MultiLookup' );
		$wgOut->setPageTitle( wfMsg('multilookupstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$this->mUsername = $wgRequest->getVal ('target');
		if($this->mUsername !== null) { $this->mUsername = trim($this->mUsername); }

		/**
		 * show form
		 */
		$this->showForm();
		$this->showUserList();
	}

	/* draws the form itself  */
	function showForm ($error = "") {
		global $wgOut;
		wfProfileIn( __METHOD__ );
		$action = $this->mTitle->escapeLocalURL("");

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"error"		=> $error,
			"action"	=> $action,
			"username"  => $this->mUsername,
		));
		$wgOut->addHTML( $oTmpl->execute("main-form") );
		wfProfileOut( __METHOD__ );
	}
	
	function showUserList() {
		global $wgOut, $wgRequest ;
		wfProfileIn( __METHOD__ );

		/* no list when no user */
		if (empty($this->mUsername)) {
			wfProfileOut( __METHOD__ );
			return false ;
		}
		
		$this->mCore = new MultipleLookupCore($this->mUsername);
		#---
		$action = $this->mTitle->escapeLocalURL("");
		$this->numResults = 0;
		/* check user activity */
		$userActivity = $this->mCore->checkUserActivity($this->mUsername);
		$userActivityWikiaList = array();
		$userActivityWikiaListByCnt = array();
		if (!empty($userActivity)) {
			$userActivityWikiaList = explode(",",$userActivity);
			if (is_array($userActivityWikiaList)) {
				foreach ($userActivityWikiaList as $id => $wikisWithCnt) {
					$_temp = explode("<CNT>", $wikisWithCnt);
					if (is_array($_temp) && count($_temp) == 2) {
						$wikiName = $_temp[0]; 
						$cnt = $_temp[1];
						$userActivityWikiaListByCnt[$cnt][] = $wikiName;
					}
				}
			}
			/* sort array */
			unset($userActivityWikiaList);
			$userActivityWikiaList = array();
			if (!empty($userActivityWikiaListByCnt)) {
				$loop=0;
				krsort($userActivityWikiaListByCnt);
				foreach ($userActivityWikiaListByCnt as $cnt => $wikis) {
					if (is_array($wikis) && !empty($wikis)) {
						foreach ($wikis as $i => $wikiName) {
							$wikiRow = WikiFactory::getWikiByDB($wikiName);
							$userActivityWikiaList[$loop] = array( $wikiName, (!empty($wikiRow)) ? $wikiRow->city_url : "" );
							$loop++;
						}
					}
				}
			}
			
			//sort(&$userActivityWikiaList);
		}
				
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"		=> $action,
			"username"  	=> $this->mUsername,
			"userActivity" 	=> $userActivityWikiaList,
		));
		$wgOut->addHTML( $oTmpl->execute("user-activity") );
		wfProfileOut( __METHOD__ );
	}
	
	function getResults() {
		global $wgOut, $wgRequest ;
		wfProfileIn( __METHOD__ );

		/* no list when no user */
		if (empty($this->mUsername)) {
			wfProfileOut( __METHOD__ );
			return false ;
		}

		/* no list when user does not exist - may be a typo */
		if ($this->mCore->checkIp() === false) {
			$wgOut->addHTML( wfMsg('multilookupinvaliduser', $this->mUsername) );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* before, we need that numResults */
		wfProfileOut( __METHOD__ );
	}
	
}
