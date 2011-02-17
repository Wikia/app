<?php

/**
 * @author Federico "Lox" Lucignano
 * 
 * Exception thrown when a request to the WikiaGameGuides API asks for
 * an old or non-existing API version. See EzApiModuleBase
 */
class WikiaGameGuidesWrongAPIVersionException extends EzApiException {
	const DEFAULT_STATUS_CODE = EzApiStatusCodes::NOT_ACCEPTABLE;
	const DEFAULT_ERROR_MSG = 'Wrong API version';
	
	function __construct() {
		parent::__construct( self::DEFAULT_ERROR_MSG, self::DEFAULT_STATUS_CODE );
	}
}