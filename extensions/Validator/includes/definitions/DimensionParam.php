<?php

/**
 * Defines the dimension parameter type.
 * This parameter describes the size of a dimension (ie width) in some unit (ie px) or a percentage.
 * Specifies the type specific validation and formatting logic.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.5
 *
 * @file
 * @ingroup Validator
 * @ingroup ParamDefinition
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DimensionParam extends NumericParam {

	/**
	 * @since 0.5
	 *
	 * @var boolean
	 */
	protected $allowAuto = false;

	/**
	 * @since 0.5
	 *
	 * @var array
	 */
	protected $allowedUnits = array( 'px', '' );

	/**
	 * @since 0.5
	 *
	 * @var integer
	 */
	protected $minPercentage = 0;

	/**
	 * @since 0.5
	 *
	 * @var integer
	 */
	protected $maxPercentage = 100;

	/**
	 * @since 0.5
	 *
	 * @var string
	 */
	protected $defaultUnit = 'px';

	/**
	 * Returns an identifier for the parameter type.
	 * @since 0.5
	 * @return string
	 */
	public function getType() {
		return 'dimension';
	}

	/**
	 * Validates the parameters value and returns the result.
	 * @see ParamDefinition::validateValue
	 *
	 * @since 0.5
	 *
	 * @param $value mixed
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 *
	 * @return boolean
	 */
	protected function validateValue( $value, IParam $param, array $definitions, array $params, ValidatorOptions $options ) {
		if ( !$this->valueIsAllowed( $value ) ) {
			return false;
		}

		if ( $value === 'auto' ) {
			return $this->allowAuto;
		}

		if ( !preg_match( '/^\d+(\.\d+)?(' . implode( '|', $this->allowedUnits ) . ')$/', $value ) ) {
			return false;
		}

		if ( in_string( '%', $value ) ) {
			$upperBound = $this->maxPercentage;
			$lowerBound = $this->minPercentage;
		}
		else {
			$upperBound = null;
			$lowerBound = null;
		}

		$value = (float)preg_replace( '/[^0-9]/', '', $value );

		return $this->validateBounds( $value, $upperBound, $lowerBound );
	}

	/**
	 * Formats the parameter value to it's final result.
	 * @see ParamDefinition::formatValue
	 *
	 * @since 0.5
	 *
	 * @param $value mixed
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of iParam
	 *
	 * @return mixed
	 */
	protected function formatValue( $value, IParam $param, array &$definitions, array $params ) {
		if ( $value === 'auto' ) {
			return $value;
		}

		foreach ( $this->allowedUnits as $unit ) {
			if ( $unit !== '' && in_string( $unit, $value ) ) {
				return $value;
			}
		}

		return $value . $this->defaultUnit;
	}

	/**
	 * Sets the parameter definition values contained in the provided array.
	 * @see ParamDefinition::setArrayValues
	 *
	 * @since 0.5
	 *
	 * @param array $param
	 */
	public function setArrayValues( array $param ) {
		parent::setArrayValues( $param );

		if ( array_key_exists( 'allowauto', $param ) ) {
			$this->setAllowAuto( $param['allowauto'] );
		}

		if ( array_key_exists( 'maxpercentage', $param ) ) {
			$this->setMaxPercentage( $param['maxpercentage'] );
		}

		if ( array_key_exists( 'minpercentage', $param ) ) {
			$this->setMinPercentage( $param['minpercentage'] );
		}

		if ( array_key_exists( 'units', $param ) ) {
			$this->setAllowedUnits( $param['units'] );
		}

		if ( array_key_exists( 'defaultunit', $param ) ) {
			$this->setDefaultUnit( $param['defaultunit'] );
		}
	}

	/**
	 * If 'auto' should be seen as a valid value.
	 *
	 * @since 0.5
	 *
	 * @param boolean $allowAuto
	 */
	public function setAllowAuto( $allowAuto ) {
		$this->allowAuto = $allowAuto;
	}

	/**
	 * Set the upper bound for the value in case it's a percentage.
	 *
	 * @since 0.5
	 *
	 * @param integer $maxPercentage
	 */
	public function setMaxPercentage( $maxPercentage ) {
		$this->maxPercentage = $maxPercentage;
	}

	/**
	 * Set the lower bound for the value in case it's a percentage.
	 *
	 * @since 0.5
	 *
	 * @param integer $minPercentage
	 */
	public function setMinPercentage( $minPercentage ) {
		$this->minPercentage = $minPercentage;
	}

	/**
	 * Sets the default unit, ie the one that will be assumed when the empty unit is provided.
	 *
	 * @since 0.5
	 *
	 * @param string $defaultUnit
	 */
	public function setDefaultUnit( $defaultUnit ) {
		$this->defaultUnit = $defaultUnit;
	}

	/**
	 * If percentage values should be accepted.
	 *
	 * @since 0.5
	 *
	 * @param array $units
	 */
	public function setAllowedUnits( array $units = array( 'px', 'em', 'ex', '%', '' ) ) {
		$this->allowedUnits = $units;
	}

}
