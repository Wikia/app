<?php

class GWTException extends Exception {
	public function __construct($message = "Google Webmaster Tools Error.", $code = 0, Exception $previous = null) {
		parent::__construct( $message, $code, $previous );
	}
}
