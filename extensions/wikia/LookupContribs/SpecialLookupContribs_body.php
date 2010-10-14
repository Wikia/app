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
	private $mTitle, $mUsername, $mMode, $mModeText, $mView, $mModes, $mViewModes, $mNSpace;
	private $mUserPage, $mUserLink;
	private $mCore;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "LookupContribs"  /*class*/, 'lookupcontribs' /*restriction*/);
	}
	
	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgContLang, $wgExtensionsPath, $wgJsMimeType, $wgStyleVersion, $wgStylePath, $wgUser;
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
		$this->mUsername = $wgRequest->getVal ('target', $subpage);
		$this->mMode = $wgRequest->getVal ('mode');
		$this->mView = $wgRequest->getVal ('view');
		$this->mWiki = $wgRequest->getVal ('wiki');
		$this->mNSpace = $wgRequest->getVal ('ns', -1);
		$this->mModes = array (
			'normal' => wfMsg('lookupcontribsselectmodenormal'),
			'final'  => wfMsg('lookupcontribsselectmodefinal'),
			'all'	 => wfMsg('lookupcontribsselectmodeall')
		) ;
		
		$this->mViewModes = array ('full', 'links');
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
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/LookupContribs/css/table.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/jquery/jquery.dataTables.min.js?{$wgStyleVersion}\"></script>\n");
				 
		if ( !empty($this->mMode) && !empty($this->mWiki) ) {
			if ( !in_array( $this->mMode, array_keys($this->mModes) ) ) {
				return;
			}
			$this->showWikiForm();
		} else {
			$this->showMainForm();
		}
		#$this->showUserList();
	}

	/* draws the form itself  */
	function showMainForm ($error = "") {
		global $wgOut;
		
		wfProfileIn( __METHOD__ );

		$action = $this->mTitle->escapeLocalURL("");

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title" 	=> $this->mTitle,
			"error"     => $error,
			"action"    => $action,
			"username"  => $this->mUsername,
			"mode"      => $this->mMode,
			"view"      => $this->mView,
			"modes"		=> $this->mModes
		));
		$wgOut->addHTML( $oTmpl->execute("main-form") );
		wfProfileOut( __METHOD__ );
	}
	
	/* draws the results table  */
	function showWikiForm($error = "") {
		global $wgOut, $wgLang ;
		wfProfileIn( __METHOD__ );

		/* no list when no user */
		if (empty($this->mUsername)) {
			wfProfileOut( __METHOD__ );
			return false ;
		}
		
		$action = $this->mTitle->escapeLocalURL("");
		$oWiki = WikiFactory::getWikiByDB($this->mWiki);
				
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title" 	=> $this->mTitle,
			"error"     => $error,
			"action"    => $action,
			"username"  => $this->mUsername,
			"mode"      => $this->mMode,
			"view"      => $this->mView,
			"modes"		=> $this->mModes,
			"wiki"		=> $this->mWiki,
			"nspace"	=> $this->mNSpace,
			"nspaces"	=> $wgLang->getFormattedNamespaces(),
		));
		$wgOut->addHTML( $oTmpl->execute("mode-form") );
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

		if (!in_array($this->mMode, array_keys($this->mModes))) {
			$wgOut->addHTML( wfMsg('lookupcontribsinvalidmode', $this->mMode) ) ;
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* before, we need that numResults */
		wfProfileOut( __METHOD__ );
	}
}
