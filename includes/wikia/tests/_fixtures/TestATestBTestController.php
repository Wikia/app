<?php

namespace TestA\TestB;
use \TestController as BaseTestController;
use \AnotherTestController as BaseAnotherTestController;

global $wgAutoloadClasses;
$wgAutoloadClasses['TestA\TestB\TestController'] = __DIR__ . '/TestATestBTestController.php';
$wgAutoloadClasses['TestA\TestB\AnotherTestController'] = __DIR__ . '/TestATestBTestController.php';

class TestController extends BaseTestController {
	public function forwardTest() {
		$resetResponse = (bool)$this->getRequest()->getVal( 'resetResponse', false );

		$this->getResponse()->setVal( 'content', true );
		$this->getResponse()->setVal( 'controller', __CLASS__ );

		// set some data so we can check that resetData works
		$this->getResponse()->setVal( 'forwardTest', true );

		$this->forward( 'TestA\TestB\AnotherTest', 'hello', $resetResponse );
	}
}

class AnotherTestController extends BaseAnotherTestController {}
