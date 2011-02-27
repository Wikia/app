<?php 

class WikiaValidationError 
{	
	protected $code = "";
	protected $msg = "";
	
	function __construct( $code, $msg ) {
		$this->code = $code;
		$this->msg = $msg;
	}
	
	function getCode() {
		return $this->code;
	}
	
	function getMsg() {
		return $this->msg;	
	}
}