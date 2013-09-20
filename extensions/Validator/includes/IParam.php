<?php

/**
 * Interface for objects representing an "instance" of a parameter.
 *
 * @since 0.5
 *
 * @file
 * @ingroup Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface IParam {

	/**
	 * Constructor.
	 *
	 * @since 0.5
	 *
	 * @param IParamDefinition $definition
	 */
	public function __construct( IParamDefinition $definition );

	/**
	 * Sets and cleans the original value and name.
	 *
	 * @since 0.5
	 *
	 * @param string $paramName
	 * @param string $paramValue
	 * @param ValidatorOptions $options
	 */
	public function setUserValue( $paramName, $paramValue, ValidatorOptions $options );

	/**
	 * Sets the value.
	 *
	 * @since 0.5
	 *
	 * @param mixed $value
	 */
	public function setValue( $value );

	/**
	 * Validates the parameter value and sets the value to it's default when errors occur.
	 *
	 * @since 0.5
	 *
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 */
	public function validate( array $definitions, array $params, ValidatorOptions $options );

	/**
	 * Applies the parameter manipulations.
	 *
	 * @since 0.5
	 *
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 */
	public function format( array &$definitions, array $params, ValidatorOptions $options );

	/**
	 * Returns the original use-provided name.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getOriginalName();

	/**
	 * Returns the original use-provided value.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getOriginalValue();

	/**
	 * Returns all validation errors that occurred so far.
	 *
	 * @since 0.5
	 *
	 * @return array of ValidationError
	 */
	public function getErrors();

	/**
	 * Gets if the parameter was set to it's default.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function wasSetToDefault();

	/**
	 * Returns the IParamDefinition this IParam was constructed from.
	 *
	 * @since 0.5
	 *
	 * @return IParamDefinition
	 */
	public function getDefinition();

	/**
	 * Returns the parameters value.
	 *
	 * @since 0.5
	 *
	 * @return mixed
	 */
	public function &getValue();

	/**
	 * Returns if the name of the parameter.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function getName();

}
