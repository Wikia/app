<?php

class WikiaErrorController extends WikiaController {

	public function __construct() {
		$this->allowedRequests[ 'error' ] = array( 'html', 'json' );
	}

	public function error() {
		$code = $this->getResponse()->getException()->getCode();

		if( empty($code) ) {
			$code = 501;
		}

		$this->getResponse()->setCode( $code );
		$this->getResponse()->setVal('request', $this->request);
		$this->getResponse()->setVal('response', $this->response);
	}
}