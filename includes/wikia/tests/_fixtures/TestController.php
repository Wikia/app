<?php

global $wgAutoloadClasses;
$wgAutoloadClasses['TestController'] = dirname(__FILE__) . '/_fixtures/TestController.php';
$wgAutoloadClasses['AnotherTestController'] = dirname(__FILE__) . '/_fixtures/TestController.php';

class TestController extends WikiaController {

	/**
	 * This method does nothing and is available in json context only
	 */
	public function jsonOnly() {
	}

	public function sendTest() {
		$this->sendRequest( 'nonExistentController', 'test' );
	}

	public function redirectTest() {
		$resetResponse = (bool) $this->getRequest()->getVal( 'resetResponse', false );

		$this->getResponse()->setVal( 'content', true );
		$this->getResponse()->setVal( 'controller', __CLASS__ );

		$this->redirect( 'AnotherTest', 'hello', $resetResponse);
	}

}

class AnotherTestController extends WikiaController {

	public function hello() {
		$this->getResponse()->setVal( 'controller', __CLASS__ );
		$this->getResponse()->setVal( 'foo', true );
	}
}