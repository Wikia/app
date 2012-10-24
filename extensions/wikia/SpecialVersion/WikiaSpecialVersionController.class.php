<?php 

/**
 * Controller for Wikia's Special:Version page
 * We use a custom extension for this because we deploy via package, not via repo.
 * @author relwell
 *
 */
class WikiaSpecialVersionController extends WikiaSpecialPageController 
{
	/**
	 * The special page class
	 * @var $version WikiaSpecialVersion
	 */
	protected $version;

	/**
	 * Constructor method. Overrides the original Special:Version page.
	 */
	public function __construct() {
		$this->version = F::build( 'WikiaSpecialVersion' );
		
		parent::__construct( 'Version', 'Version', false );
	}
	
	public function index() {
		$title = F::build( 'Title', array( 'Version' ), 'newFromText' );
		$popts = F::build('ParserOptions', array( RequestContext::getMain() ), 'newFromContext' );

		$this->wg->Title = $title;
		$this->app->wg->Out->setPageTitle( $title );
		
		$softwareListPrepped = array();
		foreach ( $this->version->getSoftwareList() as $key => $val ) {
			$softwareListPrepped[$this->wg->Parser->parse( $key, $title, $popts )->getText()] = $this->wg->Parser->parse( $val, $title, $popts ) ->getText();
		}

		$this->setVal( 'copyRightAndAuthorList',		$this->wg->Parser->parse( $this->version->getCopyrightAndAuthorList(), $title, $popts )->getText() );
		$this->setVal( 'softwareInformation',			$this->wg->Parser->parse( $this->version->softwareInformation(), $title, $popts )->getText() );
		$this->setVal( 'extensionCredit',				$this->wg->Parser->parse( $this->version->getExtensionCredits(), $title, $popts )->getText() );
		$this->setVal( 'ip',							str_replace( '--', ' - ', htmlspecialchars( $this->getContext()->getRequest()->getIP() ) ) );
		$this->setVal( 'wikiaVersion',					$this->version->getWikiaVersion() );
		$this->setVal( 'versionLicenseMessage',			$this->wf->Message( 'version-license' ) );
		$this->setVal( 'versionLicenseInfoMessage',		$this->wf->Message( 'version-license-info' ) );
		$this->setVal( 'versionSoftwareMessage',		$this->wf->Message( 'version-software' ) );
		$this->setVal( 'versionSoftwareProductMessage',	$this->wf->Message( 'version-software-product' ) );
		$this->setVal( 'versionSoftwareVersionMessage', $this->wf->Message( 'version-software-version' ) );
		$this->setVal( 'versionSoftwareList',			$softwareListPrepped );
	}
}