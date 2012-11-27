<?php

class BadRequestApiException extends BadRequestException {}

class OutOfRangeApiException extends BadRequestException {
	function __construct( $paramName, $min, $max ) {
		parent::__construct( "The value of '{$paramName}' is out of range ({$min}, {$max})" );
	}
}

class MissingParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( "Parameter '{$paramName}' is required" );
	}
}

class InvalidDataApiException extends InvalidDataException {}