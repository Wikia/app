<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Original Author?
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class NewWebsite extends SpecialPage {

	private $mTitle, $mParam, $mLastError, $mRedirectTitle;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct( "NewWebsite"  /*class*/ );
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @access public
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgOut, $wgUser;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
		}
		wfLoadExtensionMessages( 'Newsite' );

	    $this->setHeaders();
		$this->mTitle = Title::newFromText( $this->getLocalname(), NS_SPECIAL );
		$this->mParam = $wgRequest->getVal( "param", false );
		if( ! $this->mParam ) {
			$this->mParam = empty( $subpage ) ? false : $subpage;
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$status = false;
		if( $this->mParam ) {
			$status = $this->processForm();
		}
		if( $status === true ) {
			/**
			 * redirect to created article
			 */
			if( $this->mRedirectTitle ) {
				$wgOut->redirect( $this->mRedirectTitle->getFullURL() );
			}
		}
		else {
			$template->set_vars( array(
				"title" => $this->mTitle,
				"error" => $this->mLastError
			));
			$wgOut->addHTML( $template->render( "form" ) );
		}
	}

	/**
	 * process request
	 *
	 * @access private
	 *
	 * @return Boolean status
	 */
	private function processForm() {
		global $wgContLang;

		wfProfileIn( __METHOD__ );

		$status = true;

		/**
		 * check if param looks like domain
		 */
		$this->mParam = $wgContLang->lc( $this->mParam );

		/**
		 * remove www. if exists
		 */
		if( substr( $this->mParam, 0, 4 ) === "www." ) {
            $this->mParam = substr( $this->mParam, 4, strlen( $this->mParam ) - 4 );
		}

		$this->mParam = $wgContLang->ucfirst( $this->mParam );

		if( Wikia::isValidDomain( $this->mParam ) ) {

			/**
			 * check if page is not created already
			 */
			$this->mRedirectTitle = Title::makeTitle( NS_MAIN, $this->mParam );
			$article = new Article( $this->mRedirectTitle, 0 );
			if( ! $article->exists( ) ) {
				/**
				 * create page
				 */
				$article->doEdit( wfMsg( 'newsite-article-placeholder'), wfMsg( 'newsite-article-placeholder-log' ) );

				/**
				 * add job
				 */
				$job = new NewWebsiteJob( $this->mRedirectTitle, array() );
				$job->insert();
				Wikia::log( __METHOD__, "info", "job added" );

				/**
				 * add task
				 */
			}
			else {
				/**
				 * article exists
				 */
				$status = false;
				$this->mLastError = wfMsg( "newsite-error-exists", array( "http://{$this->mParam}/", $this->mParam ) );
				Wikia::log( __METHOD__, "error", "page about {$this->mParam} already exists" );
			}
		}
		else {
			/**
			 * domain is not valid
			 */
			$status = false;
			$this->mLastError = wfMsg( "newsite-error-invalid", array( $this->mParam ) );
			Wikia::log( __METHOD__, "error", "domain {$this->mParam} is invalid" );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * get path for thumbnail based on domain name
	 *
	 * @static
	 * @access public
	 *
	 * @param String $domain -- domain name
	 * @param String $extension -- extension for file default .png
	 *
	 * @return String thumbnail path
	 */
	static public function getThumbnailDirectory( $domain, $extension = "png" ) {

		global $wgUploadDirectory;

		$hash = md5( $domain );

		$basePath = $wgUploadDirectory . '/screenshots/' . substr( $hash, 0, 1 ) . '/' . substr( $hash, 0, 2 );
		wfMkdirParents( $basePath );

		return sprintf( "%s/%s.%s", $basePath, $domain, $extension );
	}

	/**
	 * get url for thumbnail based on domain name
	 *
	 * @static
	 * @access public
	 *
	 * @param String $domain -- domain name
	 * @param String $extension -- extension for file default .png
	 *
	 * @return String thumbnail url
	 */
	static public function getThumbnailUrl( $domain, $extension = "png" ) {
		global $wgUploadPath;

		Wikia::log( __METHOD__, "info", "Using {$wgUploadPath} as base url" );
		$hash = md5( $domain );
		$basePath = $wgUploadPath . '/screenshots/' . substr( $hash, 0, 1 ) . '/' . substr( $hash, 0, 2 );

		return sprintf( "%s/%s.%s", $basePath, $domain, $extension );
	}
}
