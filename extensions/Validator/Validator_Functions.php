<?php
/**
 * File holding the ValidatorFunctions class.
 *
 * @file ValidatorFunctions.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class holding variouse static methods for the validation of parameters that have to comply to cetrain criteria.
 * Functions are called by Validator with the parameters $value, $arguments, where $arguments is optional.
 *
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */
final class ValidatorFunctions {

	/**
	 * Returns whether the provided value, which must be a number, is within a certain range. Upper bound included.
	 *
	 * @param $value
	 * @param $lower
	 * @param $upper
	 *
	 * @return boolean
	 */
	public static function in_range( $value, $lower = false, $upper = false ) {
		if ( ! is_numeric( $value ) ) return false;
		$value = (int)$value;
		if ($lower !== false && $value < $lower) return false;
		if ($upper !== false && $value > $upper) return false;
		return true;
	}

	/**
	 * Returns whether the string value is not empty. Not empty is defined as having at least one character after trimming.
	 *
	 * @param $value
	 *
	 * @return boolean
	 */
	public static function not_empty( $value ) {
		return strlen( trim( $value ) ) > 0;
	}
	
	/**
	 * Returns whether the string value is not empty. Not empty is defined as having at least one character after trimming.
	 *
	 * @param $value
	 *
	 * @return boolean
	 */
	public static function in_array( $value ) {
		// TODO: It's possible the way the allowed values are passed here is quite inneficient...
		$params = func_get_args();
		array_shift( $params ); // Ommit the value
		return in_array($value, $params);
	}	
	
	/**
	 * Returns whether a variable is an integer or an integer string. Uses the native PHP function.
	 *
	 * @param $value
	 *
	 * @return boolean
	 */
	public static function is_integer( $value ) {
		return ctype_digit( (string)$value );
	}	
	
	/**
	 * Returns whether the length of the value is within a certain range. Upper bound included.
	 * 
	 * @param string $value
	 * @param $lower
	 * @param $upper
	 * 
	 * @return boolean
	 */
	public static function has_length( $value, $lower = false, $upper = false ) {
		return self::in_range(strlen($value), $lower, $upper);
	}
	
	/**
	 * Returns whether the amount of items in the list is within a certain range. Upper bound included.
	 * 
	 * @param array $values
	 * @param $lower
	 * @param $upper
	 * 
	 * @return boolean
	 */
	public static function has_item_count( array $values, $lower = false, $upper = false ) {
		return self::in_range(count($values), $lower, $upper);
	}
	
	/**
	 * Returns whether the list of values does not have any duplicates.
	 * 
	 * @param array $values
	 * 
	 * @return boolean
	 */
	public static function has_unique_items( array $values ) {
		return count($values) == count(array_unique($values));
	}	
	
	/**
	 * Returns the result of preg_match.
	 * 
	 * @param string $value
	 * @param string $pattern
	 * 
	 * @return boolean
	 */
	public static function regex( $value, $pattern ) {
		return (bool)preg_match($pattern, $value);
	}
}
