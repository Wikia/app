<?php

namespace TestA;
use \TestController as BaseTestController;
use \AnotherTestController as BaseAnotherTestController;

global $wgAutoloadClasses;
$wgAutoloadClasses['TestA\TestController'] = dirname(__FILE__) . '/TestATestController.php';
$wgAutoloadClasses['TestA\AnotherTestController'] = dirname(__FILE__) . '/TestATestController.php';


class TestController extends BaseTestController {
	public function forwardTest() {
		$resetResponse = (bool) $this->getRequest()->getVal( 'resetResponse', false );

		$this->getResponse()->setVal( 'content', true );
		$this->getResponse()->setVal( 'controller', __CLASS__ );

		// set some data so we can check that resetData works
		$this->getResponse()->setVal( 'forwardTest', true );

		$this->forward( 'TestA\AnotherTest', 'hello', $resetResponse);
	}
}

class AnotherTestController extends BaseAnotherTestController {}
