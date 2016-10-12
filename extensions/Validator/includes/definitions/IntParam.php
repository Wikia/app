<?php

/**
 * Defines the boolean integer type.
 * Specifies the type specific validation and formatting logic.
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
class IntParam extends NumericParam {

	/**
	 * If negative values should be allowed or not.
	 *
	 * @since 0.5
	 *
	 * @param boolean $allowNegatives
	 */
	protected $allowNegatives = true;

	/**
	 * Sets if negative values should be allowed or not.
	 *
	 * @since 0.5
	 *
	 * @param boolean $allowNegatives
	 */
	public function setAllowNegatives( $allowNegatives ) {
		$this->allowNegatives = $allowNegatives;
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
		if ( $options->isStringlyTyped() ) {
			if ( !is_string( $value ) ) {
				return false;
			}

			$isNegative = false;

			if ( $this->allowNegatives && strpos( $value, '-' ) === 0 ) {
				$value = substr( $value, 1 );
				$isNegative = true;
			}

			if ( ctype_digit( (string)$value ) ) {
				$value = (int)$value;

				if ( $isNegative ) {
					$value = -$value;
				}
			}
			else {
				return false;
			}
		}
		elseif ( ( !is_int( $value ) && !is_float( $value ) ) || ( !$this->allowNegatives && $value < 0 ) ) {
			return false;
		}

		if ( is_float( $value ) ) {
			if ( (int)$value == $value ) {
				$value = (int)$value;
			}
			else {
				return false;
			}
		}

		return parent::validateValue( $value, $param, $definitions, $params, $options );
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
	 * @param $params array of IParam
	 *
	 * @return mixed
	 */
	protected function formatValue( $value, IParam $param, array &$definitions, array $params ) {
		return (int)$value;
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

		if ( array_key_exists( 'negatives', $param ) ) {
			$this->setAllowNegatives( $param['negatives'] );
		}
	}

	/**
	 * Returns if negatives are allowed.
	 * Can be set via @see IntParam::setAllowNegatives
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function allowsNegatives() {
		return $this->allowNegatives;
	}

}