<?php

/**
 * This is an example use of SpecialPage controller
 * @author ADi
 *
 */
class DummyExtensionSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		$this->allowedRequests[ 'helloWorld' ] = array( 'html' );

		parent::__construct( 'DummyExtension', '', false );
	}

	public function helloWorld() {
		if($this->request->getVal('param') == 1 ) {
			$this->response->setTemplatePath( dirname( __FILE__ ) . '/templates/someTemplate.php' );
		}
		$this->response->setVal( 'header', 'Hello World!' );
	}

}