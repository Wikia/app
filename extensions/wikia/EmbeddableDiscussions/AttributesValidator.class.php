<?php

class AttributesValidator {

	/**
	 * Checks if a given value is a boolean or a boolean string ("true", "false")
	 * @param Mixed $value a value to be tested
	 * @return bool
	 */
	public static function isBoolish( $value ) {
		return is_bool( $value ) ||
		$value === 'true' ||
		$value === 'false';
	}
}
