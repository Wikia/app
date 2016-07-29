<?php

namespace ValueValidators;

/**
 * Interface for value validators.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface ValueValidator {

	/**
	 * Parses a value.
	 *
	 * @since 0.1
	 *
	 * @param mixed $value The value to validate
	 *
	 * @return Result
	 */
	public function validate( $value );

	/**
	 * Takes an associative array with options and sets those known to the ValueValidator.
	 *
	 * @since 0.1
	 *
	 * @param array $options
	 */
	public function setOptions( array $options );

}
