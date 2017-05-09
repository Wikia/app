<?php

namespace ParamProcessor\Definition;

use ParamProcessor\ParamDefinition;
use ParamProcessor\IParam;

/**
 * Defines the string parameter type.
 * Specifies the type specific validation and formatting logic.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StringParam extends ParamDefinition {

	/**
	 * Indicates if the parameter should be lowercased post validation.
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	protected $toLower = false;

	/**
	 * Formats the parameter value to it's final result.
	 * @see ParamDefinition::formatValue
	 *
	 * @since 1.0
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
	 * @since 1.0
	 *
	 * @param array $param
	 */
	public function setArrayValues( array $param ) {
		parent::setArrayValues( $param );

		if ( array_key_exists( 'tolower', $param ) ) {
			$this->toLower = $param['tolower'];
		}
	}

	/**
	 * Sets of the value should be lowercased.
	 *
	 * @since 1.0
	 *
	 * @param boolean $toLower
	 */
	public function setToLower( $toLower ) {
		$this->toLower = $toLower;
	}

}