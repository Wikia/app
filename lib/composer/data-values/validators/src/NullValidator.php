<?php

namespace ValueValidators;

/**
 * ValueValidator does a null validation (ie everything passes).
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullValidator implements ValueValidator {

	/**
	 * @see ValueValidator::validate
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 *
	 * @return Result
	 */
	public function validate( $value ) {
		return Result::newSuccess();
	}

	/**
	 * @see ValueValidator::setOptions
	 *
	 * @since 0.1
	 *
	 * @param array $options
	 */
	public function setOptions( array $options ) {
		// No op
	}

}
