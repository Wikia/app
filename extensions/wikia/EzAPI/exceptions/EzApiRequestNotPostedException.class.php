<?php

/**
 * @author Federico "Lox" Lucignano
 * 
 * Exception thrown when a request to a module was not submitted via POST and 
 * the method being invoked uses requiresPost. See EzApiModuleBase
 */
class EzApiRequestNotPostedException extends EzApiException {
	const DEFAULT_STATUS_CODE = EzApiStatusCodes::NOT_ACCEPTABLE;
	const DEFAULT_ERROR_MSG = 'The request should be submitted via POST';
	
	function __construct() {
		parent::__construct( self::DEFAULT_ERROR_MSG, self::DEFAULT_STATUS_CODE );
	}
}