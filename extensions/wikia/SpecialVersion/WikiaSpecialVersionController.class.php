<?php

/**
 * Controller for Wikia's Special:Version page
 * We use a custom extension for this because we deploy via package, not via repo.
 * @author relwell
 *
 */
class WikiaSpecialVersionController extends WikiaSpecialPageController {
	/**
	 * The special page class
	 * @var $version WikiaSpecialVersion
	 */
	protected $version;

	/**
	 * Constructor method. Overrides the original Special:Version page.
	 */
	public function __construct() {
		$this->version = (new WikiaSpecialVersion);

		parent::__construct( 'Version' );
	}

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
		$this->setVal( 'wikiaCodeMessage', wfMessage( 'wikia-version-code' )->text() );
		$this->setVal( 'wikiaCodeVersion', $this->version->getWikiaCodeVersion() );
		$this->setVal( 'wikiaConfigMessage', wfMessage( 'wikia-version-config' )->text() );
		$this->setVal( 'wikiaConfigVersion', $this->version->getWikiaConfigVersion() );
		$this->setVal( 'versionLicenseMessage', wfMessage( 'version-license' )->text() );
		$this->setVal( 'versionLicenseInfoMessage', wfMessage( 'version-license-info' )->parse() );
		$this->setVal( 'versionSoftwareMessage', wfMessage( 'version-software' )->text() );
		$this->setVal( 'versionSoftwareProductMessage', wfMessage( 'version-software-product' )->text() );
		$this->setVal( 'versionSoftwareVersionMessage', wfMessage( 'version-software-version' )->text() );
		$this->setVal( 'versionSoftwareList', $softwareListPrepped );

	}
}
