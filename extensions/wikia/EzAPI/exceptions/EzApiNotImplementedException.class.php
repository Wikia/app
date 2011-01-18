<?php
/**
 * @author Federico "Lox" Lucignano
 * 
 * Exception thrown when an unregistered/non-existing module/method has been requested
 */
class EzApiNotImplementedException extends EzApiException {
	const DEFAULT_STATUS_CODE = EzApiStatusCodes::NOT_IMPLEMENTED;
	const DEFAULT_ERROR_MSG = 'The requested module/method is not implemented';
	
	function __construct() {
		parent::__construct( self::DEFAULT_ERROR_MSG, self::DEFAULT_STATUS_CODE );
	}
}