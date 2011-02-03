<?php

class WikiaHTTPRequest extends WikiaRequest {

	public function __construct( Array $params ) {
		parent::__construct( $params );
	}

	public function isXmlHttp() {
		if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
			return true;
		}
		return false;
	}

}