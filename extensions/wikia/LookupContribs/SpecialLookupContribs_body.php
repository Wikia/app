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
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "LookupContribs"  /*class*/, 'lookupcontribs' /*restriction*/);
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;
		wfLoadExtensionMessages("SpecialLookupContribs");

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
				"error"     => $error,
				"action"    => $action,
				"username"  => $this->mUsername,
				"mode"      => $this->mMode,
				"view"      => $this->mView,
		));
		$wgOut->addHTML( $oTmpl->execute("main-form") );
		wfProfileOut( __METHOD__ );
	}
	
	/* draws the results table  */
	function showUserList() {
		global $wgOut, $wgRequest, $wgLang ;
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
		/* check user activity */
		$userActivity = array();
		if ( $this->mCore->checkUser() ) {
			$userActivity = $this->mCore->checkUserActivityExternal();
		}
				
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"		=> $action,
			"numResults"	=> $this->numResults,
			"username"  	=> $this->mUsername,
			"mode"     		=> $this->mMode,
			"view"    		=> $this->mView,
			"userActivity" 	=> $userActivity,
			"nspaces"		=> $wgLang->getFormattedNamespaces(),
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
