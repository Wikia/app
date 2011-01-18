<?php
/**
 * @author Federico "Lox" Lucignano
 * 
 * Base exception class for EzAPI modules
 */
class EzApiException extends Exception {
	const DEFAULT_STATUS_CODE = EzApiStatusCodes::BAD_REQUEST; //500 gets redirected to Iowa
	
	protected $mStatusCode;
	
	function __construct( $message = '', $statusCode = self::DEFAULT_STATUS_CODE ) {
		parent::__construct( $message );
		$this->mStatusCode = $statusCode;
	}
	
	public function getStatusCode(){
		return $this->mStatusCode;
	}
}