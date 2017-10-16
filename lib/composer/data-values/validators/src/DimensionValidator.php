<?php

namespace ValueValidators;

use Exception;

/**
 * ValueValidator that validates a dimension value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DimensionValidator extends ValueValidatorObject {

	/**
	 * @since 0.1
	 *
	 * @var boolean
	 */
	protected $allowAuto = false;

	/**
	 * @since 0.1
	 *
	 * @var array
	 */
	protected $allowedUnits = array( 'px', '' );

	/**
	 * @since 0.1
	 *
	 * @var integer
	 */
	protected $minPercentage = 0;

	/**
	 * @since 0.1
	 *
	 * @var integer
	 */
	protected $maxPercentage = 100;

	/**
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $defaultUnit = 'px';

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
	 * @see ValueValidatorObject::doValidation
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 */
	public function doValidation( $value ) {
		if ( !is_string( $value ) && !is_int( $value ) && !is_float( $value ) ) {
			$this->addErrorMessage( 'Dimension is not a string, float or int' );
			return;
		}

		if ( !is_string( $value ) ) {
			$value = (string)$value;
		}

		if ( $value === 'auto' ) {
			if ( !$this->allowAuto ) {
				$this->addErrorMessage( 'Dimension value cannot be auto' );
			}
			return;
		}

		if ( !preg_match( '/^\d+(\.\d+)?(' . implode( '|', $this->allowedUnits ) . ')$/', $value ) ) {
			$this->addErrorMessage( 'Not a valid dimension value' );
			return;
		}

		if ( strpos( $value, '%' ) !== false ) {
			$upperBound = $this->maxPercentage;
			$lowerBound = $this->minPercentage;
		}
		else {
			$upperBound = $this->upperBound;
			$lowerBound = $this->lowerBound;
		}

		$value = (float)preg_replace( '/[^0-9]/', '', $value );

		$rangeValidator = new RangeValidator();
		$rangeValidator->setRange( $lowerBound, $upperBound );

		$this->runSubValidator( $value, $rangeValidator );
	}

	/**
	 * If 'auto' should be seen as a valid value.
	 *
	 * @since 0.1
	 *
	 * @param boolean $allowAuto
	 */
	public function setAllowAuto( $allowAuto ) {
		$this->allowAuto = $allowAuto;
	}

	/**
	 * Set the upper bound for the value in case it's a percentage.
	 *
	 * @since 0.1
	 *
	 * @param integer $maxPercentage
	 */
	public function setMaxPercentage( $maxPercentage ) {
		$this->maxPercentage = $maxPercentage;
	}

	/**
	 * Set the lower bound for the value in case it's a percentage.
	 *
	 * @since 0.1
	 *
	 * @param integer $minPercentage
	 */
	public function setMinPercentage( $minPercentage ) {
		$this->minPercentage = $minPercentage;
	}

	/**
	 * Sets the default unit, ie the one that will be assumed when the empty unit is provided.
	 *
	 * @since 0.1
	 *
	 * @param string $defaultUnit
	 */
	public function setDefaultUnit( $defaultUnit ) {
		$this->defaultUnit = $defaultUnit;
	}

	/**
	 * Sets the allowed units.
	 *
	 * @since 0.1
	 *
	 * @param array $units
	 */
	public function setAllowedUnits( array $units = array( 'px', 'em', 'ex', '%', '' ) ) {
		$this->allowedUnits = $units;
	}

	/**
	 * Returns the allowed units.
	 *
	 * @since 0.1
	 *
	 * @return string[]
	 */
	public function getAllowedUnits() {
		return $this->allowedUnits;
	}

	/**
	 * Returns the default unit.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDefaultUnit() {
		return $this->defaultUnit;
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

		if ( array_key_exists( 'allowauto', $options ) ) {
			$this->setAllowAuto( $options['allowauto'] );
		}

		if ( array_key_exists( 'maxpercentage', $options ) ) {
			$this->setMaxPercentage( $options['maxpercentage'] );
		}

		if ( array_key_exists( 'minpercentage', $options ) ) {
			$this->setMinPercentage( $options['minpercentage'] );
		}

		if ( array_key_exists( 'units', $options ) ) {
			$this->setAllowedUnits( $options['units'] );
		}

		if ( array_key_exists( 'defaultunit', $options ) ) {
			$this->setDefaultUnit( $options['defaultunit'] );
		}

		if ( array_key_exists( 'lowerbound', $options ) ) {
			$this->setLowerBound( $options['lowerbound'] );
		}

		if ( array_key_exists( 'upperbound', $options ) ) {
			$this->setUpperBound( $options['upperbound'] );
		}
	}

}
