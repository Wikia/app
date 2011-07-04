<?php

/**
 * User Path Prediction Special page
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

class UserPathPredictionSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'UserPathPrediction', '', false );
	}
	
	public function init() {
		//TODO: initialization code here
	}
	
	public function index() {
		/*
		$this->wg->Out->setPageTitle( "Page Title" );
		$this->wg->Out->setPageTitle( $this->wf->msg( 'helloworld-specialpage-title' ) );
		$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/css/HelloWorld_Oasis.scss' );
		$this->response->addAsset( 'extensions/wikia/templates/HelloWorld/js/HelloWorld.js' );

		$this->redirect( 'HelloWorldSpecial', 'Hello' );
		*/
	}
	
	/*
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
	*/

}
