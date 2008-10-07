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

class LookupContribsPage extends SpecialPage {
	private $mTitle, $mUsername, $mMode, $mModeText, $mView, $mModes, $mViewModes;
	private $mUserPage, $mUserLink;
	private $mCore;
	const USE_EXTERNAL_DB = 0;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "LookupContribs"  /*class*/, 'lookupcontribs' /*restriction*/);
		wfLoadExtensionMessages("SpecialLookupContribs");
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;
		wfLoadExtensionMessages("WikiFactory");

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'LookupContribs' );
		$this->mUsername = $wgRequest->getVal ('target');
		$this->mMode = $wgRequest->getVal ('mode');
		$this->mView = $wgRequest->getVal ('view');
		$this->mModes = array ('normal', 'final') ;
		$this->mViewModes = array ('full', 'links') ;
		$wgOut->setPageTitle( wfMsg('lookupcontribstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * parse request
		 */
		if ($this->mUsername != '') {
			$sk = $wgUser->getSkin();
			$this->mUserPage = Title::makeTitle (NS_USER, $this->mUsername);
			$this->mUserLink = $sk->makeKnownLinkObj ($this->mUserPage, $this->mUsername);
			$this->mModeText = ($this->mMode == 'normal') ? wfMsg('lookupcontribsrecentcontributions', $this->mUserLink) : wfMsg('lookupcontribsfinalcontributions', $this->mUserLink);
			$wgOut->setSubtitle ($this->mModeText);
		}

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
            "mode"     	=> $this->mMode,
            "view"    	=> $this->mView,
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
		
		$this->mCore = new LookupContribsCore($this->mUsername);
		#---
		$action = $this->mTitle->escapeLocalURL("");
		$this->numResults = 0;
		$wikiList = $this->mCore->getWikiList();
		/* check user activity */
		if (self::USE_EXTERNAL_DB == 0) {
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
				// sort array 
				unset($userActivityWikiaList);
				$userActivityWikiaList = array();
				krsort($userActivityWikiaListByCnt);
				if (!empty($userActivityWikiaListByCnt)) {
					$loop=0;
					foreach ($userActivityWikiaListByCnt as $cnt => $wikis) {
						if (is_array($wikis) && !empty($wikis)) {
							foreach ($wikis as $i => $wikiName) {
								$userActivityWikiaList[$loop] = $wikiName;
								$loop++;
							}
						}
					}
				}
			} 
		} else {
			$userActivityWikiaList = $this->mCore->checkUserActivityExternal($this->mUsername);
		}
				
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"		=> $action,
			"username"  	=> $this->mUsername,
			"mode"     		=> $this->mMode,
			"view"    		=> $this->mView,
			"userActivity" 	=> $userActivityWikiaList,
			"wikiList"		=> $wikiList
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
		if ($this->mCore->checkUser() === false) {
			$wgOut->addHTML( wfMsg('lookupcontribsinvaliduser', $this->mUsername) );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* run a check against possible modes */
		if (!in_array($this->mView, $this->mViewModes)) {
			$wgOut->addHTML( wfMsg('lookupcontribsinvalidviewmode', $this->mView) );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if (!in_array($this->mMode, $this->mModes)) {
			$wgOut->addHTML( wfMsg('lookupcontribsinvalidmode', $this->mMode) ) ;
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* before, we need that numResults */
        wfProfileOut( __METHOD__ );
	}
	
}
