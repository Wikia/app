<?php

class WikiaResponsePrinter {

	public function __construct() {

	}

	public function render( WikiaResponse $response ) {
		return '<pre>' . var_export( array( 'data' => $response->getData(), 'exception' => $response->getException() ), true ) . '</pre>';
	}

}