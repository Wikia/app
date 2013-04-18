<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 16:41
 */

class GWTException extends Exception {
	public function __construct($message = "Google Webmaster Tools Error.", $code = 0, Exception $previous = null) {
		super( $message, $code, $previous );
	}
}
