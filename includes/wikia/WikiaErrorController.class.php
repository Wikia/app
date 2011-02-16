<?php

class WikiaErrorController extends WikiaController {

	public function __construct() {
		$this->allowedRequests[ 'error' ] = array( 'html', 'json' );
	}

	public function error() {
		$code = $this->getResponse()->getException()->getCode();

		if( empty( $code ) || !$this->isValidHTTPErrorCode( $code ) ) {
			$code = WikiaResponse::RESPONSE_CODE_ERROR;
		}

		$this->getResponse()->setCode( $code );
		$this->getResponse()->setVal('request', $this->request);
		$this->getResponse()->setVal('response', $this->response);
	}

	private function isValidHTTPErrorCode( $code ) {
		return in_array( $code, array( 400, 401, 402, 403, 404, 500, 501, 502, 503 ) );
	}
}