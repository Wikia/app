<?php

namespace ParamProcessor;

use ValueParsers\ValueParser;
use ValueValidators\ValueValidator;

/**
 * Interface for parameter definition classes.
 *
 * @since 1.0
 * @deprecated since 1.0, use ParamDefinition
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface IParamDefinition {

	/**
	 * Adds one or more aliases for the parameter name.
	 *
	 * @since 1.0
	 *
	 * @param string|string[] $aliases
	 */
	public function addAliases( $aliases );

	/**
	 * Adds one or more dependencies. There are the names of parameters
	 * that need to be validated and formatted before this one.
	 *
	 * @since 1.0
	 *
	 * @param string|string[] $dependencies
	 */
	public function addDependencies( $dependencies );

	/**
	 * Formats the parameter value to it's final result.
	 *
	 * @since 1.0
	 *
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 */
	public function format( IParam $param, array &$definitions, array $params );

	/**
	 * Returns the parameter name aliases.
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getAliases();

	/**
	 * Returns the default value.
	 *
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function getDefault();

	/**
	 * Returns the delimiter to use to split the raw value in case the
	 * parameter is a list.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getDelimiter();

	/**
	 * Returns a list of dependencies the parameter has, in the form of
	 * other parameter names.
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getDependencies();

	/**
	 * Returns a message that will act as a description message for the parameter.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getMessage();

	/**
	 * Returns the parameters main name.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Returns an identifier for the type of the parameter.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType();

	/**
	 * Returns if the parameter has a certain alias.
	 *
	 * @since 1.0
	 *
	 * @param string $alias
	 *
	 * @return boolean
	 */
	public function hasAlias( $alias );

	/**
	 * Returns if the parameter has a certain dependency.
	 *
	 * @since 1.0
	 *
	 * @param string $dependency
	 *
	 * @return boolean
	 */
	public function hasDependency( $dependency );

	/**
	 * Returns if the parameter is a list or not.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isList();

	/**
	 * Returns if the parameter is a required one or not.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isRequired();

	/**
	 * Sets the default parameter value. Null indicates no default,
	 * and therefore makes the parameter required.
	 *
	 * @since 1.0
	 *
	 * @param mixed $default
	 * @param boolean $manipulate Should the default be manipulated or not? Since 0.4.6.
	 */
	public function setDefault( $default, $manipulate = true );

	/**
	 * Sets the delimiter to use to split the raw value in case the
	 * parameter is a list.
	 *
	 * @since 1.0
	 *
	 * @param $delimiter string
	 */
	public function setDelimiter( $delimiter );

	/**
	 * Set if the parameter manipulations should be applied to the default value.
	 *
	 * @since 1.0
	 *
	 * @param boolean $manipulateDefault
	 */
	public function setDoManipulationOfDefault( $manipulateDefault );

	/**
	 * Sets a message for the parameter that will act as description.
	 * This should be a message key, ie something that can be passed
	 * to wfMsg. Not an actual text. If you do not have a message key,
	 * but only a text, use setDescription instead.
	 *
	 * @since 1.0
	 *
	 * @param string $message
	 */
	public function setMessage( $message );

	/**
	 * Returns if the parameter manipulations should be applied to the default value.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function shouldManipulateDefault();

	/**
	 * Returns a message key for a message describing the parameter type.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getTypeMessage();

	/**
	 * Returns if the value should be trimmed before validation and any further processing.
	 * @see IParamDefinition::trimDuringClean
	 *
	 * @since 1.0
	 *
	 * @since boolean|null
	 */
	public function trimDuringClean();

	/**
	 * Returns a ValueParser object to parse the parameters value.
	 *
	 * @since 1.0
	 *
	 * @return ValueParser
	 */
	public function getValueParser();

	/**
	 * Returns the ValueParser object to parse the parameters value.
	 *
	 * @since 1.0
	 *
	 * @param ValueParser $parser
	 */
	public function setValueParser( ValueParser $parser );

	/**
	 * Returns a ValueValidator that can be used to validate the parameters value.
	 *
	 * @since 1.0
	 *
	 * @return ValueValidator
	 */
	public function getValueValidator();

	/**
	 * Sets the ValueValidator that can be used to validate the parameters value.
	 *
	 * @since 1.0
	 *
	 * @param ValueValidator $validator
	 */
	public function setValueValidator( ValueValidator $validator );

	/**
	 * Sets a validation function that will be run before the ValueValidator.
	 *
	 * This can be used instead of a ValueValidator where validation is very
	 * trivial, ie checking if something is a boolean can be done with is_bool.
	 *
	 * @since 1.0
	 *
	 * @param callable $validationFunction
	 */
	public function setValidationCallback( /* callable */ $validationFunction );

	/**
	 * Sets the parameter definition values contained in the provided array.
	 *
	 * @since 1.0
	 *
	 * @param array $options
	 */
	public function setArrayValues( array $options );

	/**
	 * Returns a validation function that should be run before the ValueValidator.
	 *
	 * @since 1.0
	 *
	 * @return callable|null
	 */
	public function getValidationCallback();

}