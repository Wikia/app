<?php

/**
 * Defines the float parameter type.
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
class FloatParam extends NumericParam {

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
			if ( preg_match( '/^(-)?\d+((\.|,)\d+)?$/', $value ) ) {
				$value = (float)$value;
			}
			else {
				return false;
			}
		}
		elseif ( !is_float( $value ) && !is_int( $value ) ) {
			return false;
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
		return (float)$value;
	}

}