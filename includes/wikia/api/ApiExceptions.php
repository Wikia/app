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

class InvalidParameterApiException extends BadRequestException {
	function __construct( $paramName ) {
		parent::__construct( self::getDetailsMsg($paramName) );
	}
	
	public static function getDetailsMsg($paramName) {
		return "Parameter '{$paramName}' is invalid";
	}
}

class LimitExceededApiException extends BadRequestException {
	function __construct( $paramName, $limit ) {
		parent::__construct( "Parameter '{$paramName}' exceeds limit of {$limit}" );
	}
}

class NotFoundApiException extends NotFoundException {}

class InvalidDataApiException extends InvalidDataException {}