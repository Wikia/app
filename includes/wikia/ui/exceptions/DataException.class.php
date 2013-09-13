<?php
namespace Wikia\UI;

/**
 * Exception thrown by UI Component in case of invalid parameters
 * passed
 *
 * Class WikiaUIDataException
 */
class DataException extends \WikiaException {

	const EXCEPTION_MSG_INVALID_DATA = 'Invalid data passed to UI Component';
	const EXCEPTION_MSG_INVALID_DATA_FOR_PARAMETER = 'Mandatory variable %s not set';
	const EXCEPTION_MSG_INVALID_ASSETS_TYPE = 'Assets should be passed as array';

	public function __construct( $message = self::EXCEPTION_MSG_INVALID_DATA, $code = 0, \Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}

	public static function getInvalidParamDataMsg( $args) {
		return sprintf( self::EXCEPTION_MSG_INVALID_DATA_FOR_PARAMETER, $args );
	}
}
