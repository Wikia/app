<?php

/**
 * Defines the string parameter type.
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
class StringParam extends ParamDefinition {

	/**
	 * Indicates if the parameter should be lowercased post validation.
	 *
	 * @since 0.5
	 *
	 * @var boolean
	 */
	protected $toLower = false;

	/**
	 * The length the string should have (can be a range).
	 *
	 * @since 0.5
	 *
	 * @var false|integer|array
	 */
	protected $length = false;

	/**
	 * Indicates if the value can be an empty string or not.
	 *
	 * @since 0.5
	 *
	 * @var boolean
	 */
	protected $canBeEmpty = true;

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
		if ( !is_string( $value ) ) {
			return false;
		}

		if ( !parent::validateValue( $value, $param, $definitions, $params, $options ) ) {
			return false;
		}

		if ( !$this->canBeEmpty && $value === '' ) {
			return false;
		}

		if ( $this->length !== false ) {
			$length = strlen( $value );

			if ( is_array( $this->length ) ) {
				return ( $this->length[1] === false || $value <= $this->length[1] )
					&& ( $this->length[0] === false || $value >= $this->length[0] );
			}
			else {
				return $length == $this->length;
			}
		}

		return true;
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
		$value = (string)$value;

		if ( $this->toLower ) {
			$value = strtolower( $value );
		}

		return $value;
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

		if ( array_key_exists( 'tolower', $param ) ) {
			$this->toLower = $param['tolower'];
		}

		if ( array_key_exists( 'length', $param ) ) {
			$this->setLength( $param['length'] );
		}

		if ( array_key_exists( 'allowempty', $param ) ) {
			$this->canBeEmpty = $param['allowempty'];
		}
	}

	/**
	 * Sets of the value should be lowercased.
	 *
	 * @since 0.5
	 *
	 * @param boolean $toLower
	 */
	public function setToLower( $toLower ) {
		$this->toLower = $toLower;
	}

	/**
	 * Sets the length the value should have.
	 *
	 * @since 0.5
	 *
	 * @param mixed $length
	 */
	public function setLength( $length ) {
		if ( ( $length !== false && !is_integer( $length ) && !is_array( $length ) ) || ( is_array( $length ) && count( $length ) != 2 ) ) {
			throw new MWException(
				'The length of a string parameter needs to be either an integer,
				false (for no restriction) or an array with two elements (lower and upper bounds)'
			);
		}

		$this->length = $length;
	}

	/**
	 * Sets if the value can be an empty string or not.
	 *
	 * @since 0.5
	 *
	 * @param boolean $canBeEmpty
	 */
	public function setCanBeEmpty( $canBeEmpty ) {
		$this->canBeEmpty = $canBeEmpty;
	}

}