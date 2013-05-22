<?php

/**
 * Defines the boolean parameter type.
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
class BoolParam extends ParamDefinition {

	protected $true = array( 'yes', 'on', '1' );
	protected $false = array( 'no', 'off', '0' );

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
		if ( !parent::validateValue( $value, $param, $definitions, $params, $options ) ) {
			return false;
		}

		return ( !$options->isStringlyTyped() && is_bool( $value ) )
			|| ( $options->isStringlyTyped() && ( in_array( $value, $this->true ) || in_array( $value, $this->false ) ) );
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
		return is_bool( $value ) ? $value : in_array( $value, $this->true );
	}

}