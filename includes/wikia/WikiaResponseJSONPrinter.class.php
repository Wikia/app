<?php

class WikiaResponseJSONPrinter extends WikiaResponsePrinter {

	const ERROR_HEADER_NAME = 'X-Wikia-Error';

	public function prepareResponse( WikiaResponse $response ) {
		if( $response->hasException() ) {
			$response->setHeader( self::ERROR_HEADER_NAME, $response->getException()->getMessage() );
		}
	}

	public function render( WikiaResponse $response ) {
		if( $response->hasException() ) {
			$output = array( 'exception' => array( 'message' => $response->getException()->getMessage(), 'code' => $response->getException()->getCode() ) );
		}
		else {
			$output = array ( 'data' => $response->getData() );
		}

		return json_encode( $output );
	}

}