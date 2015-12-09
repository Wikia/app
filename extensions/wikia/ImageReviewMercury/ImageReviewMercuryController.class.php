<?php

class ImageReviewMercuryController extends WikiaSpecialPageController {

	/**
	 * Constructor method. Overrides the original Special:ImageReviewMercury page.
	 */
	public function __construct() {
		parent::__construct( 'ImageReviewMercury' );
	}

	// Copied from Version extension
	public function index() {
		$title = Title::newFromText( 'Version', NS_SPECIAL );
		$popts = ParserOptions::newFromContext( RequestContext::getMain() );

		$this->wg->Title = $title;
		$this->specialPage->setHeaders();

		$softwareListPrepped = array();
		foreach ( $this->version->getSoftwareList() as $key => $val ) {
			$softwareListPrepped[$this->wg->Parser->parse( $key, $title, $popts )->getText()] = $this->wg->Parser->parse( $val, $title, $popts )->getText();
		}

		$this->setVal( 'copyRightAndAuthorList', $this->wg->Parser->parse( $this->version->getCopyrightAndAuthorList(), $title, $popts )->getText() );
		$this->setVal( 'softwareInformation', $this->wg->Parser->parse( $this->version->softwareInformation(), $title, $popts )->getText() );
		$this->setVal( 'extensionCredit', $this->wg->Parser->parse( $this->version->getExtensionCredits(), $title, $popts )->getText() );
		$this->setVal( 'ip', str_replace( '--', ' - ', htmlspecialchars( $this->getContext()->getRequest()->getIP() ) ) );
		$this->setVal( 'wikiaCodeMessage', wfMessage( 'wikia-version-code' )->escaped() );
		$this->setVal( 'wikiaCodeVersion', $this->version->getWikiaCodeVersion() );
		$this->setVal( 'wikiaConfigMessage', wfMessage( 'wikia-version-config' )->escaped() );
		$this->setVal( 'wikiaConfigVersion', $this->version->getWikiaConfigVersion() );
		$this->setVal( 'versionLicenseMessage', wfMessage( 'version-license' )->escaped() );
		$this->setVal( 'versionLicenseInfoMessage', wfMessage( 'version-license-info' )->parse() );
		$this->setVal( 'versionSoftwareMessage', wfMessage( 'version-software' )->escaped() );
		$this->setVal( 'versionSoftwareProductMessage', wfMessage( 'version-software-product' )->escaped() );
		$this->setVal( 'versionSoftwareVersionMessage', wfMessage( 'version-software-version' )->escaped() );
		$this->setVal( 'versionSoftwareList', $softwareListPrepped );

	}

	function urlHandler () {
		$this->response->addAsset( 'fooandbar_js' );
		$this->response->addAsset( 'fooandbar_scss' );
		$this->response->addAsset( 'fooandbar_css' );

		// Data to be used in FooAndBarController_urlhandler.php template
		$this->templateValue = 'foo';
	}
}
