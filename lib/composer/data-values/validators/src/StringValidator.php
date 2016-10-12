<?php

namespace ValueValidators;

/**
 * ValueValidator that validates a string value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StringValidator extends ValueValidatorObject {

	/**
	 * @see ValueValidatorObject::doValidation
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 * @throws \Exception
	 */
	public function doValidation( $value ) {
		if ( !is_string( $value ) ) {
			$this->addErrorMessage( 'Not a string' ); // TODO
			return;
		}

		$lowerBound = false;
		$upperBound = false;

		if ( array_key_exists( 'length', $this->options ) ) {
			$lowerBound = $this->options['length'];
			$upperBound = $this->options['length'];
		}
		else {
			if ( array_key_exists( 'minlength', $this->options ) ) {
				$lowerBound = $this->options['minlength'];
			}

			if ( array_key_exists( 'maxlength', $this->options ) ) {
				$upperBound = $this->options['maxlength'];
			}
		}

		if ( $lowerBound !== false || $upperBound !== false ) {
			$rangeValidator = new RangeValidator();
			$rangeValidator->setRange( $lowerBound, $upperBound );
			$this->runSubValidator( strlen( $value ), $rangeValidator, 'length' );
		}

		// TODO: this needs tests
		if ( array_key_exists( 'regex', $this->options ) ) {
			$match = preg_match( $this->options['regex'], $value );

			if ( $match === false ) {
				throw new \Exception( 'The regex argument must be a valid Perl regular expression.' );
			} elseif ( $match === 0 ) {
				$this->addErrorMessage( 'String does not match the regular expression ' . $this->options['regex'] );
			}
		}
	}

}
