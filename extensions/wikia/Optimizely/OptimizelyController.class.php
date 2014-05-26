<?php

class OptimizelyController extends WikiaController {
	public function getCode() {
		$response = $this->getResponse();
		$response->setContentType( 'text/javascript; charset=utf-8' );
		// TODO
		$this->code = 'console.log("optimizely script content goes here")';

		// set appropriate cache TTL
		$response->setCacheValidity( 300 );
	}
}
