<?php

class BadRequestApiException extends BadRequestException {}

class OutOfRangeApiException extends BadRequestException {
	function __construct( $paramName, $min, $max ) {
		parent::__construct( wfMessage( 'out-of-range', $paramName, $min, $max )->text() );
	}
}

class MissingParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( wfMessage( 'parameter-is-required', $paramName )->text() );
	}
}

class InvalidParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( self::getDetailsMsg($paramName) );
	}
	
	public static function getDetailsMsg($paramName) {
		return wfMessage( 'parameter-is-invalid', $paramName )->text();
	}
}

class LimitExceededApiException extends BadRequestException {
	function __construct( $paramName, $limit ) {
		parent::__construct( wfMessage( 'parameter-exceeds-limit', $paramName, $limit )->text() );
	}
}

class NotFoundApiException extends NotFoundException {
	public function __construct() {
		$this->$message = wfMessage( 'not-found' )->text();
	}
}

class InvalidDataApiException extends InvalidDataException {
	public function __construct() {
		$this->$message = wfMessage( 'invalid-data' )->text();
	}
}