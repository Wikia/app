<?php

global $wgAutoloadClasses;
$wgAutoloadClasses['TestController'] = dirname(__FILE__) . '/TestController.php';
$wgAutoloadClasses['AnotherTestController'] = dirname(__FILE__) . '/TestController.php';

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

		$this->forward( 'AnotherTest', 'hello', $resetResponse);
	}

	public function overrideTemplateTest(){
		$this->response->setVal( 'output', $this->request->getVal( 'input' ) );
		$this->overrideTemplate( $this->request->getVal( 'template' ) );
	}
}

class AnotherTestController extends WikiaController {

	public function hello() {
		$this->getResponse()->setVal( 'controller', __CLASS__ );
		$this->getResponse()->setVal( 'foo', true );
	}
}