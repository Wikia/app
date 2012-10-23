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
		$title = F::build( 'Title', array( 'Special:Version' ), 'newFromText' );
		$popts = F::build('ParserOptions', array( RequestContext::getMain() ), 'newFromContext' ); 
		$this->wg->Title = $title;
		
		$this->setVal( 'copyRightAndAuthorList',	$this->wg->Parser->parse( $this->version->getCopyrightAndAuthorList(), $title, $popts )->getText() );
		$this->setVal( 'softwareInformation',		$this->wg->Parser->parse( $this->version->softwareInformation(), $title, $popts )->getText() );
		$this->setVal( 'extensionCredit',			$this->wg->Parser->parse( $this->version->getExtensionCredits(), $title, $popts )->getText() );
		$this->setVal( 'ip',						str_replace( '--', ' - ', htmlspecialchars( $this->getContext()->getRequest()->getIP() ) ) );
		$this->setVal( 'versionLicense',			$this->wf->Message( 'version-license' ) );
		$this->setVal( 'versionLicenseInfo',		$this->wf->Message( 'version-license-info' ) );
	}
}