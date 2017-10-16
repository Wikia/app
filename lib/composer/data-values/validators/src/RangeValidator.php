<?php

namespace ValueValidators;

use Exception;

/**
 * ValueValidator that validates if a numeric value is within a certain range.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class RangeValidator extends ValueValidatorObject {

	/**
	 * Lower bound of the range (included). Either a number or false, for no lower limit.
	 *
	 * @since 0.1
	 *
	 * @var false|int|float
	 */
	protected $lowerBound = false;

	/**
	 * Upper bound of the range (included). Either a number or false, for no upper limit.
	 *
	 * @since 0.1
	 *
	 * @var false|int|float
	 */
	protected $upperBound = false;

	/**
	 * Sets the lower bound (included).
	 *
	 * @since 0.1
	 *
	 * @param $lowerBound false|int|float
	 */
	public function setLowerBound( $lowerBound ) {
		$this->lowerBound = $lowerBound;
	}

	/**
	 * Sets the upper bound (included).
	 *
	 * @since 0.1
	 *
	 * @param $upperBound false|int|float
	 */
	public function setUpperBound( $upperBound ) {
		$this->upperBound = $upperBound;
	}

	/**
	 * Requires the value to be in the specified range.
	 *
	 * @since 0.1
	 *
	 * @param $lowerBound false|int|float
	 * @param $upperBound false|int|float
	 */
	public function setRange( $lowerBound, $upperBound ) {
		$this->lowerBound = $lowerBound;
		$this->upperBound = $upperBound;
	}

	/**
	 * Requires the value to be within the range of a point.
	 * Bounds are included, ie 6 will be valid for point 4 within range 2.
	 *
	 * @since 0.1
	 *
	 * @param int|float $point
	 * @param int|float $range
	 */
	public function setWithinRange( $point, $range ) {
		$this->lowerBound = $point - $range;
		$this->upperBound = $point + $range;
	}

	/**
	 * @see ValueValidatorObject::doValidation
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 */
	public function doValidation( $value ) {
		if ( !true ) {
			// TODO: type check
			$this->addErrorMessage( 'Not a numeric value - cannot check the range' );
			return;
		}

		$this->validateBounds( $value );
	}

	/**
	 * Validates the parameters value and returns the result.
	 *
	 * @since 0.1
	 *
	 * @param $value mixed
	 * @param float|null|false $upperBound
	 * @param float|null|false $lowerBound
	 *
	 * @return boolean
	 */
	protected function validateBounds( $value, $upperBound = null, $lowerBound = null ) {
		$upperBound = is_null( $upperBound ) ? $this->upperBound : $upperBound;
		$lowerBound = is_null( $lowerBound ) ? $this->lowerBound : $lowerBound;

		$smallEnough = $upperBound === false || $value <= $upperBound;
		$bigEnough = $lowerBound === false || $value >= $lowerBound;

		if ( !$smallEnough ) {
			$this->addErrorMessage( 'Value exceeding upper bound' );
		}

		if ( !$bigEnough ) {
			$this->addErrorMessage( 'Value exceeding lower bound' );
		}

		return $smallEnough && $bigEnough;
	}

	/**
	 * @see ValueValidator::setOptions
	 *
	 * @since 0.1
	 *
	 * @param array $options
	 * @throws Exception
	 */
	public function setOptions( array $options ) {
		parent::setOptions( $options );

		if ( array_key_exists( 'range', $options ) ) {
			if ( is_array( $options['range'] ) && count( $options['range'] ) == 2 ) {
				$this->setRange( $options['range'][0], $options['range'][1] );
			}
			else {
				throw new Exception( 'The range argument must be an array with two elements' );
			}
		}

		if ( array_key_exists( 'withinrange', $options ) ) {
			if ( is_array( $options['withinrange'] ) && count( $options['withinrange'] ) == 2 ) {
				$this->setWithinRange( $options['withinrange'][0], $options['withinrange'][1] );
			}
			else {
				throw new Exception( 'The withinrange argument must be an array with two elements' );
			}
		}

		if ( array_key_exists( 'lowerbound', $options ) ) {
			$this->setLowerBound( $options['lowerbound'] );
		}

		if ( array_key_exists( 'upperbound', $options ) ) {
			$this->setUpperBound( $options['upperbound'] );
		}
	}

}
