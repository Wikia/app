<?php

/**
 * Interface for parameter definition classes.
 *
 * @since 0.5
 *
 * @file
 * @ingroup Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface IParamDefinition {

	/**
	 * Adds one or more aliases for the parameter name.
	 *
	 * @since 0.5
	 *
	 * @param mixed $aliases string or array of string
	 */
	public function addAliases( $aliases );

	/**
	 * Adds one or more ParameterCriterion.
	 *
	 * @since 0.5
	 *
	 * @param mixed $criteria ParameterCriterion or array of ParameterCriterion
	 */
	public function addCriteria( $criteria );

	/**
	 * Adds one or more dependencies. There are the names of parameters
	 * that need to be validated and formatted before this one.
	 *
	 * @since 0.5
	 *
	 * @param mixed $dependencies string or array of string
	 */
	public function addDependencies( $dependencies );

	/**
	 * Adds one or more ParameterManipulation.
	 *
	 * @deprecated since 0.5, removal in 0.7
	 * @since 0.5
	 *
	 * @param mixed $manipulations ParameterManipulation or array of ParameterManipulation
	 */
	public function addManipulations( $manipulations );

	/**
	 * Formats the parameter value to it's final result.
	 *
	 * @since 0.5
	 *
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 */
	public function format( IParam $param, array &$definitions, array $params );

	/**
	 * Returns the parameter name aliases.
	 *
	 * @since 0.5
	 *
	 * @return array
	 */
	public function getAliases();

	/**
	 * Returns the parameter criteria.
	 *
	 * @deprecated since 0.5, removal in 0.7
	 * @since 0.5
	 *
	 * @return array of ParameterCriterion
	 */
	public function getCriteria();

	/**
	 * Returns the default value.
	 *
	 * @since 0.5
	 *
	 * @return mixed
	 */
	public function getDefault();

	/**
	 * Returns the delimiter to use to split the raw value in case the
	 * parameter is a list.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getDelimiter();

	/**
	 * Returns a list of dependencies the parameter has, in the form of
	 * other parameter names.
	 *
	 * @since 0.5
	 *
	 * @return array
	 */
	public function getDependencies();

	/**
	 * Returns the parameter manipulations.
	 *
	 * @deprecated since 0.5, removal in 0.7
	 * @since 0.5
	 *
	 * @return array of ParameterManipulation
	 */
	public function getManipulations();

	/**
	 * Returns a message that will act as a description message for the parameter.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getMessage();

	/**
	 * Returns the parameters main name.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Returns an identifier for the type of the parameter.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getType();

	/**
	 * Returns if the parameter has a certain alias.
	 *
	 * @since 0.5
	 *
	 * @param string $alias
	 *
	 * @return boolean
	 */
	public function hasAlias( $alias );

	/**
	 * Returns if the parameter has a certain dependency.
	 *
	 * @since 0.5
	 *
	 * @param string $dependency
	 *
	 * @return boolean
	 */
	public function hasDependency( $dependency );

	/**
	 * Returns if the parameter is a list or not.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function isList();

	/**
	 * Returns if the parameter is a required one or not.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function isRequired();

	/**
	 * Sets the default parameter value. Null indicates no default,
	 * and therefore makes the parameter required.
	 *
	 * @since 0.5
	 *
	 * @param mixed $default
	 * @param boolean $manipulate Should the default be manipulated or not? Since 0.4.6.
	 */
	public function setDefault( $default, $manipulate = true );

	/**
	 * Sets the delimiter to use to split the raw value in case the
	 * parameter is a list.
	 *
	 * @since 0.5
	 *
	 * @param $delimiter string
	 */
	public function setDelimiter( $delimiter );

	/**
	 * Set if the parameter manipulations should be applied to the default value.
	 *
	 * @since 0.5
	 *
	 * @param boolean $doOrDoNotThereIsNoTry
	 */
	public function setDoManipulationOfDefault( $doOrDoNotThereIsNoTry );

	/**
	 * Sets a message for the parameter that will act as description.
	 * This should be a message key, ie something that can be passed
	 * to wfMsg. Not an actual text. If you do not have a message key,
	 * but only a text, use setDescription instead.
	 *
	 * @since 0.5
	 *
	 * @param string $message
	 */
	public function setMessage( $message );

	/**
	 * Returns if the parameter manipulations should be applied to the default value.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function shouldManipulateDefault();

	/**
	 * Validates the parameters value.
	 *
	 * @since 0.5
	 *
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 *
	 * @return array|true
	 *
	 * TODO: return error list (ie Status object)
	 */
	public function validate( IParam $param, array $definitions, array $params, ValidatorOptions $options );

	/**
	 * Returns a message key for a message describing the parameter type.
	 *
	 * @since 0.5
	 *
	 * @return string
	 */
	public function getTypeMessage();

	/**
	 * Returns if the value should be trimmed before validation and any further processing.
	 * @see IParamDefinition::trimDuringClean
	 *
	 * @since 0.5
	 *
	 * @since boolean|null
	 */
	public function trimDuringClean();

}