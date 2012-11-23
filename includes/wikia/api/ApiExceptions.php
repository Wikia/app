<?php

class BadRequestApiException extends BadRequestException {}

class OutOfRangeApiException extends BadRequestException {
	function __construct( $paramName, $min, $max ) {
		parent::__construct( "{$paramName} out of range ({$min}, {$max})" );
	}
}

class MissingParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( "{$paramName} is required" );
	}
}


class InvalidParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( "{$paramName} is invalid" );
	}
}