<?php
/*
 * An enumeration of some status codes to use in EzApiModuleBase::setResponseStatusCode calls
 * @author Federico "Lox" Lucignano
 */
class EzApiStatusCodes {
	const OK = '200 OK';
	const BAD_REQUEST = '400 Bad Request';
	const UNATHORIZED = '401 Unathorized';
	const FORBIDDEN = '403 Forbidden';
	const NOT_FOUND = '404 Not Found';
	const NOT_ACCEPTABLE = '406 Not Acceptable';
	const INTERNAL_SERVER_ERROR = '500 Internal Server Error';
	const NOT_IMPLEMENTED = '501 Not Implemented';
	
	//TODO: add more as needed
	//see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
}