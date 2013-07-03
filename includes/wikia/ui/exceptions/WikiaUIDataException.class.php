<?php

/**
 * Exception thrown by UI Component in case of invalid parameters
 * passed
 *
 * Class WikiaUIDataException
 */
class WikiaUIDataException extends WikiaException {

	const EXCEPTION_MSG_INVALID_DATA = 'Invalid data passed to UI Component';

	public function __construct( $message = self::EXCEPTION_MSG_INVALID_DATA, $code = 0, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}
}
