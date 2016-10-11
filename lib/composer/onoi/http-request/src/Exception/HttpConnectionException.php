<?php

namespace Onoi\HttpRequest\Exception;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HttpConnectionException extends \Exception {

	/**
	 * @since  1.0
	 *
	 * @param string $message
	 * @param integer $errorCode
	 */
	public function __construct( $message = '', $errorCode = 0 ) {
		parent::__construct( "Failed http connection with error $errorCode ($message).\n" );
	}

}
