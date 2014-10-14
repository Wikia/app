<?php
/**
 * @author Sean Colombo
 *
 * Special page for testing cooler error pages.
 *
 * @file
 * @ingroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * 
 *
 * @ingroup SpecialPage
 */
class ErrorPageSpecialController extends WikiaSpecialPageController {
	
	public function __construct() {
		//$this->controllerData[] = 'foo';
		//$this->controllerData[] = 'bar';

		// standard SpecialPage constructor call
		parent::__construct( 'ErrorPage', '', false );
	}
	
	// Controllers can all have an optional init method
	public function init() {
		//$this->businessLogic = new HelloWorld( $this->app->wg->Title );
	}

	/**
	 * @brief this is default method, which in this example just redirects to Hello method
	 * @details No parameters
	 *
	 */
	public function index() {
		$this->wg->Out->setPageTitle( "Trying to cause an error" );

		//$this->wg->Out->setPageTitle( wfMsg( 'helloworld-specialpage-title' ) );
		//$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/css/HelloWorld_Oasis.scss' );
		//$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/js/HelloWorld.js' );

		// Cause an error
		$db = wfGetDB( DB_SLAVE );
		$db->query("SELECT * FROM tablethatdoesntexist");
		
		throw new WikiaException("Throwing errors all up in here because things are intentionally broken. But if they're intentionally broken, then they're working as expcted. Russel Paradox?");

		//$this->wg->Out->addHTML("Created an error and it should show up below.");

		//$this->forward( 'HelloWorldSpecial', 'Hello' ); // would forward to the "Hello()" controller method instead of index()
	} // end index()

	
	
} // end class ErrorPageSpecialController
