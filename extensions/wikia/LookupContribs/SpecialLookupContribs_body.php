<?php

class LookupContribsPage extends SpecialPage {
	private $mTitle, $mUsername, $mMode, $mModeText, $mView, $mModes, $mViewModes, $mNSpace;
	private $mUserPage, $mUserLink;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "LookupContribs"  /*class*/, 'lookupcontribs' /*restriction*/ );

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'LookupContribs' );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath, $wgUser;

		$this->setHeaders();
		// SUS-288: Check permissions before checking for block
		$this->checkPermissions();
		$this->checkReadOnly();
		$this->checkIfUserIsBlocked();

		/**
		 * initial output
		 */
		$this->mUsername = $wgRequest->getVal ( 'target', $subpage );
		$this->mMode = $wgRequest->getVal ( 'mode' );
		$this->mView = $wgRequest->getVal ( 'view' );
		$this->mWiki = $wgRequest->getVal ( 'wiki' );
		$this->mNSpace = $wgRequest->getVal ( 'ns', -1 );
		$this->mModes = array (
			'normal' => wfMsg( 'lookupcontribsselectmodenormal' ),
			'final'  => wfMsg( 'lookupcontribsselectmodefinal' ),
			'all'	 => wfMsg( 'lookupcontribsselectmodeall' )
		) ;

		$this->mShortModes = array(
			'normal' => wfMsg( 'lookupcontribsnormal' ),
			'final' => wfMsg( 'lookupcontribsfinal' ),
			'all' => wfMsg( 'lookupcontribsall' )
		);

		$this->mViewModes = array ( 'full', 'links' );
		$wgOut->setPageTitle( wfMsg( 'lookupcontribstitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * parse request
		 */
		if ( $this->mUsername != '' ) {
			$sk = RequestContext::getMain()->getSkin();
			$this->mUserPage = Title::makeTitle( NS_USER, $this->mUsername );
			$this->mUserLink = $sk->makeKnownLinkObj( $this->mUserPage, htmlspecialchars( $this->mUsername, ENT_QUOTES ) );
			$this->mModeText = $this->mMode == 'normal' ? wfMessage( 'lookupcontribsrecentcontributions' )->rawParams( $this->mUserLink )->escaped() : wfMessage( 'lookupcontribsfinalcontributions' )->rawParams( $this->mUserLink )->escaped();
			$wgOut->setSubtitle( $this->mModeText );
		}

		/**
		 * show form
		 */
		$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/LookupContribs/css/table.css" );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n" );

		if ( !empty( $this->mMode ) && !empty( $this->mWiki ) ) {
			if ( !in_array( $this->mMode, array_keys( $this->mModes ) ) ) {
				return;
			}
			$this->showWikiForm();
		} else {
			$this->showMainForm();
		}
	}

	/* draws the form itself  */
	function showMainForm ( $error = "" ) {
		global $wgOut;

		$action = htmlspecialchars( $this->mTitle->getLocalURL() );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title" 	=> $this->mTitle,
			"error"     => $error,
			"action"    => $action,
			"username"  => $this->mUsername,
			"mode"      => $this->mMode,
			"view"      => $this->mView,
			"modes"		=> $this->mShortModes
		) );
		$wgOut->addHTML( $oTmpl->render( "main-form" ) );
	}

	/* draws the results table  */
	function showWikiForm( $error = "" ) {
		global $wgOut, $wgLang ;

		/* no list when no user */
		if ( empty( $this->mUsername ) ) {
			return false ;
		}

		$action = htmlspecialchars( $this->mTitle->getLocalURL() );

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
		) );
		$wgOut->addHTML( $oTmpl->render( "mode-form" ) );
	}

}
