<?php
/**
 * @author Federico "Lox" Lucignano
 * 
 * Exception class for MobileAPI modules
 */

class MobileApiException extends Exception {
	const DEFAULT_STATUS_CODE = '501 Not Implemented'; //500 gets redirected to Iowa
	
	protected $mStatusCode;
	
	function __construct( $message = '', $statusCode = self::DEFAULT_STATUS_CODE ) {
		parent::__construct( $message );
		$this->mStatusCode = $statusCode;
	}
	
	public function getStatusCode(){
		return $this->mStatusCode;
	}
}

?>
