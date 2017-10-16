<?php

namespace Onoi\HttpRequest\Exception;

use Onoi\HttpRequest\HttpRequest;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class BadHttpResponseException extends HttpConnectionException {

	/**
	 * @since  1.0
	 *
	 * @param HttpRequest $httpRequest
	 */
	public function __construct( HttpRequest $httpRequest ) {

		$errorCode = $httpRequest->getLastErrorCode();

		switch ( $errorCode ) {
			case 22: //	equals CURLE_HTTP_RETURNED_ERROR but this constant is not defined in PHP
				$httpCode = $httpRequest->getLastTransferInfo( CURLINFO_HTTP_CODE );
				$message = "HTTP request ended with $httpCode code\n";
				break;
			default:
				$message = $httpRequest->getLastError();
		}

		parent::__construct( $message, $errorCode );
	}

}
