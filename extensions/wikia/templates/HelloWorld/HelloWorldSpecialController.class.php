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

	// Controllers can all have an optional init method
	public function init() {
		$this->businessLogic = F::build( 'HelloWorld', array( $this->app->wg->Title ) );
	}

	/**
	 * @brief this is default method, which in this example just redirects to Hello method
	 * @details No parameters
	 * 
	 */
	public function index() {
		$this->wg->Out->setPageTitle("Page Title");
		$this->wg->Out->setPageTitle($this->wf->msg('helloworld-specialpage-title'));
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/templates/HelloWorld/css/HelloWorld_Oasis.scss'));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/templates/HelloWorld/js/HelloWorld.js');

		$this->redirect( 'HelloWorldSpecial', 'Hello' );
	}

	/**
	 * @brief Hello method
	 * @details Hello method
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
		$this->setVal( 'header', $this->wf->msg('helloworld-hello-msg') );
		$this->setVal( 'wikiData', $this->businessLogic->getWikiData( $wikiId ) );
		$this->setVal( 'controllerData', $this->controllerData );

		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;

		$this->wf->profileOut( __METHOD__ );
	}

}
