<?php

/**
 * This is an example use of SpecialPage controller
 * @author ADi
 *
 */
class HelloWorldSpecialController extends WikiaSpecialPageController {

	private $businessLogic = null;
	private $controllerData = array();

	public function __construct() {
		$this->controllerData[] = 'foo';
		$this->controllerData[] = 'bar';
		$this->controllerData[] = 'baz';

		// standard SpecialPage constructor call
		parent::__construct( 'HelloWorld', '', false );
	}

	public function init() {
		$this->businessLogic = F::build( 'HelloWorld', array( $this->app->wg->Title ) );
	}

	/**
	 * this is default method, which in this example just redirects to helloWorld method
	 */
	public function index() {
		$this->redirect( 'HelloWorldSpecial', 'Hello' );
	}

	/**
	 * helloWorld method
	 *
	 * @requestParam int $wikiId
	 * @responseParam string $header
	 * @responseParam array $wikiData
	 */
	public function Hello() {
		$this->wf->profileIn( __METHOD__ );

		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );

		// setting response data
		$this->setVal( 'header', $this->wf->msg('extension-hello-msg') );
		$this->setVal( 'wikiData', $this->businessLogic->getWikiData( $wikiId ) );

		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;

		$this->wf->profileOut( __METHOD__ );
	}

	public function getSomeControllerData() {
		$this->setVal( 'controllerData', $this->controllerData );
	}

}
