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
		parent::__construct( "MultiLookup"  /*class*/, 'multilookup' /*restriction*/ );
		wfLoadExtensionMessages( "MultiLookup" );
	}

	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgStylePath;

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if ( !$wgUser->isAllowed( 'multilookup' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'MultiLookup' );
		$wgOut->setPageTitle( wfMsg( 'multilookupstitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$this->mUsername = $wgRequest->getVal ( 'target' );
		$this->mWiki = $wgRequest->getVal ('wiki');
		if ( $this->mUsername !== null ) { $this->mUsername = trim( $this->mUsername ); }

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/SpecialMultipleLookup/css/table.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/jquery/jquery.dataTables.min.js?{$wgStyleVersion}\"></script>\n");
				 
		if ( !empty($this->mWiki) ) {
			$this->showWikiForm();
		} else {
			$this->showMainForm();
		}
	}

	/* draws the form itself  */
	function showMainForm ( $error = "" ) {
		global $wgOut;
		wfProfileIn( __METHOD__ );
		$action = $this->mTitle->escapeLocalURL( "" );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"error"		=> $error,
			"title" 	=> $this->mTitle,			
			"action"	=> $action,
			"username"  => $this->mUsername,
		) );
		$wgOut->addHTML( $oTmpl->execute( "main-form" ) );
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
			"wiki"		=> $this->mWiki,
		));
		$wgOut->addHTML( $oTmpl->execute("wiki-form") );
		wfProfileOut( __METHOD__ );
	}
	
	function getResults() {
		global $wgOut, $wgRequest ;
		wfProfileIn( __METHOD__ );

		/* no list when no user */
		if ( empty( $this->mUsername ) ) {
			wfProfileOut( __METHOD__ );
			return false ;
		}

		/* no list when user does not exist - may be a typo */
		if ( $this->mCore->checkIp() === false ) {
			$wgOut->addHTML( wfMsg( 'multilookupinvaliduser', $this->mUsername ) );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* before, we need that numResults */
		wfProfileOut( __METHOD__ );
	}
}
