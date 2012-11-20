<?php
abstract class WikiaApiException extends WikiaException {
	protected $errorCode = null;
	protected $errorMessage = null;

	function __construct( Exception $previous = null ) {
		parent::construct( $this->message, $this->errorCode, $previous );
	}
}