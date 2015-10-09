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
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath, $wgUser;

		if( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
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

		$this->mShortModes = array(
			'normal' => wfMsg('lookupcontribsnormal'),
			'final' => wfMsg('lookupcontribsfinal'),
			'all' => wfMsg('lookupcontribsall')
		);

		$this->mViewModes = array ('full', 'links');
		$wgOut->setPageTitle( wfMsg('lookupcontribstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * parse request
		 */
		if ($this->mUsername != '') {
			$sk = RequestContext::getMain()->getSkin();
			$this->mUserPage = Title::makeTitle (NS_USER, $this->mUsername);
			$this->mUserLink = $sk->makeKnownLinkObj( $this->mUserPage, htmlspecialchars( $this->mUsername, ENT_QUOTES ) );
			$this->mModeText = ($this->mMode == 'normal') ? wfMessage( 'lookupcontribsrecentcontributions' )->rawParams( $this->mUserLink )->escaped() : wfMessage( 'lookupcontribsfinalcontributions' )->rawParams( $this->mUserLink )->escaped();
			$wgOut->setSubtitle ($this->mModeText);
		}

		/**
		 * show form
		 */
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/LookupContribs/css/table.css");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n");

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

		$action = htmlspecialchars($this->mTitle->getLocalURL());

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title" 	=> $this->mTitle,
			"error"     => $error,
			"action"    => $action,
			"username"  => $this->mUsername,
			"mode"      => $this->mMode,
			"view"      => $this->mView,
			"modes"		=> $this->mShortModes
		));
		$wgOut->addHTML( $oTmpl->render("main-form") );
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

		$action = htmlspecialchars($this->mTitle->getLocalURL());
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
		$wgOut->addHTML( $oTmpl->render("mode-form") );
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
			$wgOut->addHTML( wfMessage( 'lookupcontribsinvaliduser', $this->mUsername )->parse() );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* run a check against possible modes */
		if (!in_array($this->mView, $this->mViewModes)) {
			$wgOut->addHTML( wfMessage( 'lookupcontribsinvalidviewmode', $this->mView )->parse() );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if (!in_array($this->mMode, array_keys($this->mModes))) {
			$wgOut->addHTML( wfMessage( 'lookupcontribsinvalidmode', $this->mMode )->parse() ) ;
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* before, we need that numResults */
		wfProfileOut( __METHOD__ );
	}
}
