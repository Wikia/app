<?php

global $wgAutoloadClasses;
$wgAutoloadClasses['TestController'] = __DIR__ . '/TestController.php';
$wgAutoloadClasses['AnotherTestController'] = __DIR__ . '/TestController.php';

class TestController extends WikiaController {

	/**
	 * This method does nothing and is available in json context only
	 */
	public function jsonOnly() {
	}

	public function index() {
		$this->getResponse()->setVal("wasCalled", "index");
	}

	public function sendTest() {
		$this->sendRequest( 'nonExistentController', 'test' );
	}

	public function forwardTest() {
		$resetResponse = (bool) $this->getRequest()->getVal( 'resetResponse', false );

		$this->getResponse()->setVal( 'content', true );
		$this->getResponse()->setVal( 'controller', __CLASS__ );

		// set some data so we can check that resetData works
		$this->getResponse()->setVal( 'forwardTest', true );

		$this->forward( 'AnotherTest', 'hello', $resetResponse);
	}

	public function overrideTemplateTest(){
		$this->response->setVal( 'output', $this->request->getVal( 'input' ) );
		$this->overrideTemplate( $this->request->getVal( 'template' ) );
	}

	// This is for testing dispatch by skin
	public function skinRoutingTest() {
		$this->getResponse()->setVal( 'wasCalled', "skinRouting");
	}

	// This is for testing dispatch by global var
	public function globalRoutingTest() {
		$this->getResponse()->setVal( 'wasCalled', "globalRouting");
	}
}

class AnotherTestController extends WikiaController {

	public function index() {
		$this->skipRendering();
		// this is for testing dispatch by * (total controller override)
		$this->getResponse()->setVal( 'wasCalled', 'controllerRouting');
	}

	public function hello() {
		$this->getResponse()->setVal( 'controller', __CLASS__ );
		$this->getResponse()->setVal( 'wasCalled', "hello" );
		$this->getResponse()->setVal( 'foo', true );

	}
}