<?php

class DummyExtensionController extends WikiaController {

	public function __construct() {
		$this->allowedRequests[ 'helloWorld' ] = array( 'html', 'json' );
		$this->allowedRequests[ 'errorTest' ] = array( 'html', 'json' );
	}

	public function helloWorld() {
		if($this->request->getVal('param') == 1 ) {
			$this->response->setTemplatePath( dirname( __FILE__ ) . '/templates/someTemplate.php' );
		}
		else {
			$this->response->setTemplatePath( dirname( __FILE__ ) . '/templates/DummyExtensionSpecialPage_helloWorld.php' );
		}

		$this->response->setVal( 'header', 'Hello World!' );
	}


	public function errorTest() {
		throw new WikiaException( 'Test Exception' );
	}

}