<?php

class WikiaResponseJSONPrinter extends WikiaResponsePrinter {

	public function render( WikiaResponse $response ) {
		if( $response->isException() ) {
			$output = array( 'exception' => array( 'message' => $response->getException()->getMessage(), 'code' => $response->getException()->getCode() ) );
		}
		else {
			$output = array ( 'data' => $response->getData() );
		}

		return json_encode( $output );
	}

}