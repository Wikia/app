<?php

/**
 * Special page allows retrieval and display of pages from remote WMF sites
 * with year, lang and project specifable
 */
class ExternalPages extends UnlistedSpecialPage {
	protected $epSites, $epPages, $epExpiry;

	public function __construct() {
		global $wgExternalPagesSites, $wgExternalPages, $wgExternalPagesCacheExpiry;
		parent::__construct( 'ExternalPages' );
		wfLoadExtensionMessages( 'ExternalPages' );
		$this->epSites = $wgExternalPagesSites;
		$this->epPages = $wgExternalPages;
		$this->epExpiry = $wgExternalPagesCacheExpiry;
	}

	/**
	 * Entry point (retrieve parsed page, convert rel links to full
	 * URLs that direct to the remote site
	 * $par would be the subpage. we don't need it 
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgMemc, $wgRequest;

		$this->setHeaders();

		if ( strval( $subpage ) === '' ) {
			$this->showError( 'externalpages-no-page' );
			return;
		}

		if ( !isset( $this->epPages[$subpage] ) ) {
			$this->showError( 'externalpages-bad-page' );
			return;
		}

		$siteName = $this->epPages[$subpage]['site'];
		$titleText = $this->epPages[$subpage]['title'];

		if ( !isset( $this->epSites[$siteName] ) ) {
			throw new MWException( __METHOD__.': configuration error: invalid site name' );
		}
		$siteConf = $this->epSites[$siteName];
		if ( !isset( $siteConf['scriptUrl'] ) ) {
			throw new MWException( __METHOD__.': configuration error: missing API URL' );
		}
		$scriptUrl = $siteConf['scriptUrl'];
		$title = Title::newFromText( $titleText );
		if ( !$title ) {
			throw new MWException( __METHOD__.': configuration error: invalid title' );
		}
		$titleText = $title->getPrefixedDBkey();

		// Try the cache
		$action = $wgRequest->getVal( 'action' );
		$cacheKey = wfMemcKey( 'externalpages', $siteName, $titleText );
		if ( $action !== 'purge' ) {
			$entry = $wgMemc->get( $cacheKey );
			if ( $entry && is_array( $entry ) ) {
				wfDebug( __CLASS__.": got $titleText from cache\n" );
				$this->showExternalPage( $title, $entry );
				return;
			}
		}

		$status = $this->sendRequest( $scriptUrl, $titleText );
		if ( !$status->isOK() ) {
			$this->showStatusError( $status );
			return;
		}

		$entry = $status->value;

		// Save to the cache
		wfDebug( __CLASS__.": storing $titleText to cache\n" );
		$wgMemc->set( $cacheKey, $entry, $this->epExpiry );

		// Display the page
		$this->showExternalPage( $title, $entry );
	}

	function showExternalPage( $title, $data ) {
		global $wgOut;
		if ( isset( $data['displaytitle'] ) && strval( $data['displaytitle'] ) !== '' ) {
			$wgOut->setPageTitle( $data['displaytitle'] );
		} else {
			$wgOut->setPageTitle( $title->getPrefixedText() );
		}
		$wgOut->setSquidMaxage( $this->epExpiry );
		$wgOut->enableClientCache( true );
		$wgOut->addHTML( $data['text'] );
	}

	function showError( $msg ) {
		global $wgOut;
		$wgOut->wrapWikiMsg( "<div class=\"errorbox\" style=\"float:none;\">\n$1</div>", $msg );
	}

	function showStatusError( $status ) {
		global $wgOut;
		$text = $status->getWikiText();
		$wgOut->addWikiText( "<div class=\"errorbox\" style=\"float:none;\">\n$text</div>" );
	}

	function sendRequest( $scriptUrl, $titleText ) {
		$url = $scriptUrl . '?' . wfArrayToCGI( array(
			'action' => 'render',
			'title' => $titleText
		) );
		$req = HttpRequest::factory( $url );
		$status = $req->execute();
		if ( !$status->isOK() ) {
			return $status;
		}
		return Status::newGood( array( 'text' => $req->getContent() ) );
	}
}
