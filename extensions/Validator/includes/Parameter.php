<?php

/**
 * Parameter definition class.
 * @deprecated since 0.5, removal in 0.7.
 *
 * @since 0.4
 * 
 * @file Parameter.php
 * @ingroup Validator
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Parameter {
	
	const TYPE_STRING = 'string';
	const TYPE_NUMBER = 'number';
	const TYPE_INTEGER = 'integer';
	const TYPE_FLOAT = 'float';
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_CHAR = 'char';
	const TYPE_TITLE = 'title'; // since 0.4.14
	
	/**
	 * Indicates whether parameters that are provided more then once  should be accepted,
	 * and use the first provided value, or not, and generate an error.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean  
	 */
	public static $acceptOverriding = false;	
	
	/**
	 * Indicates whether parameters not found in the criteria list
	 * should be stored in case they are not accepted. The default is false.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean 
	 */
	public static $accumulateParameterErrors = false;	
	
	/**
	 * Indicates if the parameter value should trimmed.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean
	 */
	public $trimValue = true;	
	
	/**
	 * Dependency list containing parameters that need to be handled before this one. 
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */			
	protected $dependencies = array();	
	
	/**
	 * The default value for the parameter, or null when the parameter is required.
	 * 
	 * @since 0.4
	 * 
	 * @var mixed
	 */
	protected $default;	
	
	/**
	 * The main name of the parameter.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * The type of the parameter, element of the Parameter::TYPE_ enum.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $type;
	
	/**
	 * List of aliases for the parameter name.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */	
	protected $aliases = array();
	
	/**
	 * List of criteria the parameter value needs to hold against.
	 * 
	 * @since 0.4
	 * 
	 * @var array of ParameterCriterion
	 */		
	protected $criteria = array();
	
	/**
	 * List of manipulations the parameter value needs to undergo.
	 * 
	 * @since 0.4
	 * 
	 * @var array of ParameterManipulation
	 */		
	protected $manipulations = array();	
	
	/**
	 * The original parameter name as provided by the user. This can be the
	 * main name or an alias.
	 * 
	 * @since 0.4 
	 * 
	 * @var string
	 */
	public $originalName;
	
	/**
	 * The original value as provided by the user. This is mainly retained for
	 * usage in error messages when the parameter turns out to be invalid.
	 * 
	 * @since 0.4 
	 * 
	 * @var string
	 */
	protected $originalValue;
	
	/**
	 * The value of the parameter. 
	 * 
	 * @since 0.4 
	 * 
	 * @var mixed
	 */	
	protected $value;
	
	/**
	 * Keeps track of how many times the parameter has been set by the user.
	 * This is used to detect overrides and for figuring out a parameter is missing. 
	 * 
	 * @since 0.4 
	 * 
	 * @var integer
	 */
	protected $setCount = 0;
	
	/**
	 * List of validation errors for this parameter.
	 * 
	 * @since 0.4
	 * 
	 * @var array of ValidationError
	 */
	protected $errors = array();
	
	/**
	 * Indicates if the parameter manipulations should be applied to the default value.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean
	 */
	public $applyManipulationsToDefault = true;
	
	/**
	 * Indicates if the parameter was set to it's default.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean
	 */
	protected $defaulted = false;
	
	/**
	 * A description for the parameter or false when there is none.
	 * Can be obtained via getDescription and set via setDescription.
	 * 
	 * @since 0.4.3
	 * 
	 * @var mixed string or false
	 */
	protected $description = false;
	
	/**
	 * A message that acts as description for the parameter or false when there is none.
	 * Can be obtained via getMessage and set via setMessage.
	 * 
	 * @since 0.4.9
	 * 
	 * @var mixed string or false
	 */
	
	protected $message = false;
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 * 
	 * @param string $name
	 * @param string $type
	 * @param mixed $default Use null for no default (which makes the parameter required)
	 * @param array $aliases
	 * @param array $criteria
	 * @param array $dependencies
	 */
	public function __construct( $name, $type = Parameter::TYPE_STRING,
		$default = null, array $aliases = array(), array $criteria = array(), array $dependencies = array() ) {
			
		$this->name = $name;
		$this->type = $type;
		$this->default = $default;
		$this->aliases = $aliases;
		
		$this->cleanCriteria( $criteria );
		$this->criteria = $criteria;
		
		$this->dependencies = $dependencies;
	}
	
	/**
	 * Ensures all Validator 3.x-style criteria definitions are converted into ParameterCriterion instances.
	 * 
	 * @since 0.4
	 * 
	 * @param array $criteria
	 */
	protected function cleanCriteria( array &$criteria ) {
		foreach ( $criteria as $key => &$criterion ) {
			if ( !$criterion instanceof ParameterCriterion )  {
				throw new MWException( "$key is not a valid ParameterCriterion." );
			}
		} 
	}
	
	/**
	 * Adds one or more aliases for the parameter name.
	 * 
	 * @since 0.4
	 * 
	 * @param mixed $aliases string or array of string
	 */
	public function addAliases() {
		$args = func_get_args();
		$this->aliases = array_merge( $this->aliases, is_array( $args[0] ) ? $args[0] : $args );
	}	
	
	/**
	 * Adds one or more ParameterCriterion.
	 * 
	 * @since 0.4
	 * 
	 * @param mixed $criteria ParameterCriterion or array of ParameterCriterion
	 */
	public function addCriteria() {
		$args = func_get_args();
		$this->criteria = array_merge( $this->criteria, is_array( $args[0] ) ? $args[0] : $args );		
	}
	
	/**
	 * Adds one or more dependencies. There are the names of parameters
	 * that need to be validated and formatted before this one.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */		
	public function addDependencies() {
		$args = func_get_args();
		$this->dependencies = array_merge( $this->dependencies, is_array( $args[0] ) ? $args[0] : $args );
	}	
	
	/**
	 * Adds one or more ParameterManipulation.
	 * 
	 * @since 0.4
	 * 
	 * @param mixed $manipulations ParameterManipulation or array of ParameterManipulation
	 */
	public function addManipulations( $manipulations ) {
		$args = func_get_args();
		$this->manipulations = array_merge( $this->manipulations, is_array( $args[0] ) ? $args[0] : $args );		
	}	
	
	/**
	 * Sets and cleans the original value and name.
	 * 
	 * @since 0.4
	 * 
	 * @param string $paramName
	 * @param string $paramValue
	 * 
	 * @return boolean
	 */
	public function setUserValue( $paramName, $paramValue ) {
		if ( $this->setCount > 0 && !self::$acceptOverriding ) {
			// TODO: fatal error
			/*
					$this->registerError(
						wfMsgExt(
							'validator-error-override-argument',
							'parsemag',
							$paramName,
							$this->mParameters[$mainName]['original-value'],
							is_array( $paramData ) ? $paramData['original-value'] : $paramData
						),
						'override'		
					);
			 */
			return false;
		}
		else {
			$this->originalName = $paramName;
			$this->originalValue = $paramValue;
			
			$this->cleanValue();
			
			$this->setCount++;

			return true;
		}
	}
	
	/**
	 * Sets the value.
	 * 
	 * @since 0.4
	 * 
	 * @param mixed $value
	 */
	public function setValue( $value ) {
		$this->value = $value;
	}
	
	/**
	 * Sets the $value to a cleaned value of $originalValue.
	 * 
	 * @since 0.4
	 */
	protected function cleanValue() {
		$this->value = $this->originalValue;
		
		if ( $this->trimValue ) {
			$this->value = trim( $this->value );
		}
	}
	
	/**
	 * Validates the parameter value and sets the value to it's default when errors occur.
	 * 
	 * @since 0.4
	 *
	 * @param array $parameters
	 */
	public function validate( array $parameters ) {
		$this->doValidation( $parameters );
	}
	
	/**
	 * Applies the parameter manipulations.
	 * 
	 * @since 0.4
	 * 
	 * @param array $parameters
	 */
	public function format( array &$parameters ) {
		if ( $this->applyManipulationsToDefault || !$this->wasSetToDefault() ) {
			foreach ( $this->getManipulations() as $manipulation ) {
				$manipulation->manipulate( $this, $parameters );
			}			
		}
	}
	
	/**
	 * Validates the parameter value.
	 * Also sets the value to the default when it's not set or invalid, assuming there is a default.
	 * 
	 * @since 0.4
	 *
	 * @param array $parameters
	 */	
	protected function doValidation( array $parameters ) {
		if ( $this->setCount == 0 ) {
			if ( $this->isRequired() ) {
				// This should not occur, so thorw an exception.
				throw new MWException( 'Attempted to validate a required parameter without first setting a value.' );
			}
			else {
				$this->setToDefault();
			}
		}
		else {
			$this->validateCriteria( $parameters );
			$this->setToDefaultIfNeeded();
		}
	}
	
	/**
	 * Sets the parameter value to the default if needed.
	 * 
	 * @since 0.4
	 */
	protected function setToDefaultIfNeeded() {
		if ( count( $this->errors ) > 0 && !$this->hasFatalError() ) {
			$this->setToDefault();
		}		
	}
	
	/**
	 * Validates the provided value against all criteria.
	 * 
	 * @since 0.4
	 * 
	 * @param array $parameters
	 */
	protected function validateCriteria( array $parameters ) {
		foreach ( $this->getCriteria() as $criterion ) {
			$validationResult = $criterion->validate( $this, $parameters );
			
			if ( !$validationResult->isValid() ) {
				$this->handleValidationError( $validationResult );
				
				if ( !self::$accumulateParameterErrors || $this->hasFatalError() ) {
					break; 
				}
			}
		}
	}
	
	/**
	 * Handles any validation errors that occurred for a single criterion.
	 * 
	 * @since 0.4
	 * 
	 * @param CriterionValidationResult $validationResult
	 */
	protected function handleValidationError( CriterionValidationResult $validationResult ) {
		foreach ( $validationResult->getErrors() as $error ) {
			$error->addTags( $this->getName() );
			$this->errors[] = $error;
		}
	}
	
	/**
	 * Returns the parameters main name.
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */			
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the parameters value.
	 * 
	 * @since 0.4
	 * 
	 * @return mixed
	 */			
	public function &getValue() {
		return $this->value;
	}
	
	/**
	 * Returns the type of the parameter.
	 * 
	 * @since 0.4.3
	 * 
	 * @return string element of the Parameter::TYPE_ enum 
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Returns an internationalized message indicating the parameter type suited for display to users. 
	 * 
	 * @since 0.4.3
	 * 
	 * @return string
	 */
	public function getTypeMessage() {
		global $wgLang;

		$message = wfMsg( 'validator-type-' . $this->type );
		return $this->isList() ?
			wfMsgExt( 'validator-describe-listtype', 'parsemag', $message )
			: $wgLang->ucfirst( $message );
	}
	
	/**
	 * Returns a list of dependencies the parameter has, in the form of 
	 * other parameter names.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */		
	public function getDependencies() {
		return $this->dependencies;
	}	
	
	/**
	 * Returns the original use-provided name.
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */
	public function getOriginalName() {
		if ( $this->setCount == 0 && empty( $this->originalName ) ) {
			throw new MWException( 'No user input set to the parameter yet, so the original name does not exist' );
		}		
		return $this->originalName;
	}

	/**
	 * Returns the original use-provided value.
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */
	public function getOriginalValue() {
		if ( $this->setCount == 0 ) {
			throw new MWException( 'No user input set to the parameter yet, so the original value does not exist' );
		}
		return $this->originalValue;
	}	
	
	/**
	 * Returns all validation errors that occurred so far.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ValidationError
	 */
	public function getErrors() {
		return $this->errors;
	}
	
	/**
	 * Returns if the parameter is a required one or not.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */		
	public function isRequired() {
		return is_null( $this->default );
	}
	
	/**
	 * Returns if the parameter is a list or not.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */		
	public function isList() {
		return false;
	}
	
	/**
	 * Returns the parameter criteria.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ParameterCriterion
	 */	
	public function getCriteria() {
		return array_merge( $this->getCriteriaForType(), $this->criteria ); 
	}
	
	/**
	 * Returns the parameter manipulations.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ParameterManipulation
	 */	
	public function getManipulations() {
		return array_merge( $this->getManipulationsForType(), $this->manipulations ); 
	}	
	
	/**
	 * Gets the criteria for the type of the parameter.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	protected function getCriteriaForType() {
		$criteria = array();

		switch( $this->type ) {
			case self::TYPE_INTEGER:
				$criteria[] = new CriterionIsInteger();
				break;
			case self::TYPE_FLOAT:
				$criteria[] = new CriterionIsFloat();
				break;
			case self::TYPE_NUMBER: // Note: This accepts non-decimal notations! 
				$criteria[] = new CriterionIsNumeric();
				break;
			case self::TYPE_BOOLEAN:
				// TODO: work with list of true and false values and i18n. 
				$criteria[] = new CriterionInArray( 'yes', 'no', 'on', 'off', '1', '0' );
				break;
			case self::TYPE_CHAR:
				$criteria[] = new CriterionHasLength( 1, 1 ); 
				break;
			case self::TYPE_TITLE:
				$criteria[] = new CriterionIsTitle();
				break;
			case self::TYPE_STRING: default:
				// No extra criteria for strings.
				break;
		}

		return $criteria;
	}
	
	/**
	 * Gets the manipulation for the type of the parameter.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	protected function getManipulationsForType() {
		$manipulations = array();
		
		switch( $this->type ) {
			case self::TYPE_INTEGER:
				//$manipulations[] = new ParamManipulationInteger();
				break;
			case self::TYPE_FLOAT: case self::TYPE_NUMBER: 
				//$manipulations[] = new ParamManipulationFloat();
				break;
			case self::TYPE_BOOLEAN:
				$manipulations[] = new ParamManipulationBoolean();
				break;
			case self::TYPE_TITLE:
				$manipulations[] = new ParamManipulationTitle();
				break;
			case self::TYPE_CHAR: case self::TYPE_STRING: default:
				//$manipulations[] = new ParamManipulationString();
		}		
		
		return $manipulations;
	}
	
	/**
	 * Sets the parameter value to the default.
	 * 
	 * @since 0.4
	 */
	protected function setToDefault() {
		$this->defaulted = true;
		$this->value = $this->default;
	}
	
	/**
	 * Gets if the parameter was set to it's default.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */
	public function wasSetToDefault() {
		return $this->defaulted;
	}

	/**
	 * @since 0.5
	 * @param boolean $defaulted
	 */
	public function setWasSetToDefault( $defaulted ) {
		$this->defaulted = $defaulted;
	}
	
	/**
	 * Returns the criteria that apply to the list as a whole.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */		
	public function getListCriteria() {
		return array();
	}
	
	/**
	 * Returns the parameter name aliases.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	public function getAliases() {
		return $this->aliases;
	}
	
	/**
	 * Returns if the parameter has a certain alias.
	 * 
	 * @since 0.4
	 * 
	 * @param string $alias
	 * 
	 * @return boolean
	 */
	public function hasAlias( $alias ) {
		return in_array( $alias, $this->getAliases() );
	}
	
	/**
	 * Returns if the parameter has a certain dependency.
	 * 
	 * @since 0.4
	 * 
	 * @param string $dependency
	 * 
	 * @return boolean
	 */
	public function hasDependency( $dependency ) {
		return in_array( $dependency, $this->getDependencies() );
	}
	
	/**
	 * Sets the default parameter value. Null indicates no default,
	 * and therefore makes the parameter required.
	 * 
	 * @since 0.4
	 * 
	 * @param mixed $default
	 * @param boolean $manipulate Should the default be manipulated or not? Since 0.4.6.
	 */
	public function setDefault( $default, $manipulate = true ) {
		$this->default = $default;
		$this->setDoManipulationOfDefault( $manipulate );
	}
	
	/**
	 * Returns the default value.
	 * 
	 * @since 0.4.3
	 * 
	 * @return mixed
	 */
	public function getDefault() {
		return $this->default; 
	}
	
	/**
	 * Set if the parameter manipulations should be applied to the default value.
	 * 
	 * @since 0.4
	 * 
	 * @param boolean $doOrDoNot
	 */
	public function setDoManipulationOfDefault( $doOrDoNot ) {
		$this->applyManipulationsToDefault = $doOrDoNot;
	}
	
	/**
	 * Returns false when there are no fatal errors or an ValidationError when one is found.
	 * 
	 * @return mixed false or ValidationError
	 */
	public function hasFatalError() {
		foreach ( $this->errors as $error ) {
			if ( $error->isFatal() ) {
				return true;
			}
		}
		
		return false;
	}

	/**
	 * Returns a description message for the parameter, or false when there is none.
	 * Override in deriving classes to add a message.
	 * 
	 * @since 0.4.3
	 * 
	 * @return mixed string or false
	 */
	public function getDescription() {
		if ( $this->description === false and $this->message !== false ) {
			return wfMsg( $this->message );
		}
		else {
			return $this->description;
		}
	}
	
	/**
	 * Sets a description for the parameter.
	 * This is a string describing the parameter, if you have a message
	 * key, ie something that can be passed to wfMsg, then use the
	 * setMessage method instead.
	 * 
	 * @since 0.4.3
	 * 
	 * @param string $descriptionMessage
	 */
	public function setDescription( $descriptionMessage ) {
		$this->description = $descriptionMessage;
	}

	/**
	 * Returns a message that will act as a description message for the parameter, or false when there is none.
	 * Override in deriving classes to add a message.
	 * 
	 * @since 0.4.9
	 * 
	 * @return mixed string or false
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * Sets a message for the parameter that will act as description.
	 * This should be a message key, ie something that can be passed
	 * to wfMsg. Not an actual text. If you do not have a message key,
	 * but only a text, use setDescription instead.
	 * 
	 * @since 0.4.9
	 * 
	 * @param string $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}
	
}
