<?php

/**
 * This is an example use of SpecialPage controller
 *
 * @author ADi
 *
 */
class HelloWorldSpecialController extends WikiaSpecialPageController {

	/* @var HelloWorld */
	private $helper = null;
	private $privateData = array();

	public function __construct() {
		// parent SpecialPage constructor call MUST be done
		parent::__construct( 'HelloWorld', '', false );
	}

	// Controllers can all have an optional init method
	public function init() {
		$this->privateData[] = 'foo';
		$this->privateData[] = 'bar';
		$this->privateData[] = 'baz';

		$this->helper = new HelloWorld( $this->app->wg->Title );
	}

	/**
	 * @brief this is the default controller method
	 * @details default method
	 * @requestParam int $wikiId
	 * @responseParam string $header
	 * @responseParam array $wikiData
	 *
	 */
	public function index() {
		// Global function call
		wfProfileIn( __METHOD__ );
		// Global variable access
		$this->wg->Out->setPageTitle( "Page Title" );
		$this->wg->Out->setPageTitle( wfMsg( 'helloworld-specialpage-title' ) );
		// adding custom css and js for this extension
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/css/HelloWorld_Oasis.scss' );
		$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/js/modules/hello.js' );
		$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/js/HelloWorld.js' );

		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );

		// setting response data
		// Note: special page controllers cannot use the shorthand syntax of $this->var to set response variables
		// This is because the
		$this->setVal( 'header', wfMsg('helloworld-hello-msg') );
		$this->setVal( 'helperData', $this->helper->getWikiData( $wikiId ) );
		$this->setVal( 'controllerData', $this->privateData );

		// example of setting SpecialPage::mIncluding
		$this->including(true);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief this just redirects to the index method
	 * @details Example of redirecting to another internal controller method
	 *
	 */
	public function HelloForwarding() {
		$this->forward( __CLASS__, 'index' );
	}

	public function HelloData() {
		$response = $this->sendSelfRequest('index' );
		$this->setVal('helperData', $response->getVal('helperData'));
	}

}
