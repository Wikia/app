<?php

namespace Wikia\Paginator;

class Validator {
	public static function isInteger( $value ) {
		return is_numeric( $value ) && ( intval( $value ) == $value );
	}

	public static function isPositiveInteger( $value ) {
		return self::isInteger( $value ) && $value > 0;
	}

	public static function isNonNegativeInteger( $value ) {
		return self::isInteger( $value ) && $value >= 0;
	}
}
