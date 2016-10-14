<?php

/**
 * Parameter class, representing the "instance" of a parameter.
 * Holds a ParamDefinition, user provided input (name & value) and processing state.
 *
 * @since 0.5
 *
 * @file Param.php
 * @ingroup Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Param implements IParam {

	/**
	 * Indicates whether parameters not found in the criteria list
	 * should be stored in case they are not accepted. The default is false.
	 *
	 * @since 0.5
	 *
	 * @var boolean
	 */
	public static $accumulateParameterErrors = false;

	/**
	 * The original parameter name as provided by the user. This can be the
	 * main name or an alias.
	 *
	 * @since 0.5
	 *
	 * @var string
	 */
	protected $originalName;

	/**
	 * The original value as provided by the user. This is mainly retained for
	 * usage in error messages when the parameter turns out to be invalid.
	 *
	 * @since 0.5
	 *
	 * @var string
	 */
	protected $originalValue;

	/**
	 * The value of the parameter.
	 *
	 * @since 0.5
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Keeps track of how many times the parameter has been set by the user.
	 * This is used to detect overrides and for figuring out a parameter is missing.
	 *
	 * @since 0.5
	 *
	 * @var integer
	 */
	protected $setCount = 0;

	/**
	 * List of validation errors for this parameter.
	 *
	 * @since 0.5
	 *
	 * @var array of ValidationError
	 */
	protected $errors = array();

	/**
	 * Indicates if the parameter was set to it's default.
	 *
	 * @since 0.5
	 *
	 * @var boolean
	 */
	protected $defaulted = false;

	/**
	 * The definition of the parameter.
	 *
	 * @since 0.5
	 *
	 * @var IParamDefinition
	 */
	protected $definition;

	/**
	 * Constructor.
	 *
	 * @since 0.5
	 *
	 * @param IParamDefinition $definition
	 */
	public function __construct( IParamDefinition $definition ) {
		$this->definition = $definition;
	}

	/**
	 * Sets and cleans the original value and name.
	 * @see IParam::setUserValue
	 *
	 * @since 0.5
	 *
	 * @param string $paramName
	 * @param string $paramValue
	 * @param ValidatorOptions $options
	 *
	 * @return boolean
	 */
	public function setUserValue( $paramName, $paramValue, ValidatorOptions $options ) {
		if ( $this->setCount > 0 && !self::$acceptOverriding ) {
			// TODO
			return false;
		}
		else {
			$this->originalName = $paramName;
			$this->originalValue = $paramValue;

			$this->cleanValue( $options );

			$this->setCount++;

			return true;
		}
	}

	/**
	 * Sets the value.
	 *
	 * @since 0.5
	 *
	 * @param mixed $value
	 */
	public function setValue( $value ) {
		$this->value = $value;
	}

	/**
	 * Sets the $value to a cleaned value of $originalValue.
	 *
	 * @since 0.5
	 *
	 * @param ValidatorOptions $options
	 */
	protected function cleanValue( ValidatorOptions $options ) {
		$this->value = $this->originalValue;

		if ( $this->definition->isList() ) {
			$this->value = explode( $this->definition->getDelimiter(), $this->value );
		}

		$trim = $this->getDefinition()->trimDuringClean();

		if ( $trim === true || ( is_null( $trim ) && $options->trimValues() ) ) {
			if ( $this->definition->isList() ) {
				foreach ( $this->value as &$element ) {
					if ( is_string( $element ) ) {
						$element = trim( $element );
					}
				}
			}
			elseif ( is_string( $this->value ) ) {
				$this->value = trim( $this->value );
			}
		}

		if ( $options->lowercaseValues() ) {
			if ( $this->definition->isList() ) {
				foreach ( $this->value as &$element ) {
					if ( is_string( $element ) ) {
						$element = strtolower( $element );
					}
				}
			}
			elseif ( is_string( $this->value ) ) {
				$this->value = strtolower( $this->value );
			}
		}
	}

	/**
	 * Validates the parameter value and sets the value to it's default when errors occur.
	 * @see IParam::validate
	 *
	 * @since 0.5
	 *
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 */
	public function validate( array $definitions, array $params, ValidatorOptions $options ) {
		$this->doValidation( $definitions, $params, $options );
	}

	/**
	 * Applies the parameter manipulations.
	 * @see IParam::format
	 *
	 * @since 0.5
	 *
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param ValidatorOptions $options
	 */
	public function format( array &$definitions, array $params, ValidatorOptions $options ) {
		if ( $this->definition->shouldManipulateDefault() || !$this->wasSetToDefault() ) {
			$this->definition->format( $this, $definitions, $params );

			$definitions = ParamDefinition::getCleanDefinitions( $definitions );

			// Compat code.
			$manipulations = array();

			foreach ( $this->definition->getManipulations() as $manipulation ) {
				if ( !( $manipulation instanceof ParamManipulationInteger )
					&& !( $manipulation instanceof ParamManipulationFloat )
					&& !( $manipulation instanceof ParamManipulationString )) {
					$manipulations[] = $manipulation;
				}
			}

			// This whole block is compat code, to be removed in 0.7.
			if ( $manipulations !== array() ) {
				$parameter = $this->toParameter();
				$parameters = array();

				foreach ( $params as $param ) {
					$parameters[$param->getName()] = $param->toParameter();
				}

				foreach ( $definitions as $definition ) {
					if ( !array_key_exists( $definition->getName(), $parameters ) ) {
						$parameters[$definition->getName()] = $definition->toParameter();
					}
				}

				foreach ( $manipulations as $manipulation ) {
					$manipulation->manipulate( $parameter, $parameters );
				}

				$this->setValue( $parameter->getValue() );

				foreach ( $parameters as /* Parameter */ $parameterObject ) {
					if ( !array_key_exists( $parameterObject->getName(), $params ) ) {
						$definitions[$parameterObject->getName()] = ParamDefinition::newFromParameter( $parameterObject );
					}
				}
			}
		}
	}

	/**
	 * Compatibility helper method, will be removed in 0.7.
	 *
	 * @deprecated since 0.5, removal in 0.7
	 *
	 * @return Parameter
	 */
	public function toParameter() {
		$parameter = $this->definition->toParameter();

		$parameter->setValue( $this->getValue() );
		$parameter->originalName = $this->setCount === 0 ? $this->getName() : $this->getOriginalName();

		$parameter->setWasSetToDefault( $this->wasSetToDefault() );

		return $parameter;
	}

	/**
	 * Validates the parameter value.
	 * Also sets the value to the default when it's not set or invalid, assuming there is a default.
	 *
	 * @since 0.5
	 *
	 * @param $definitions array of ParamDefinition
	 * @param $params array of Param
	 * @param ValidatorOptions $options
	 *
	 * @throws MWException
	 */
	protected function doValidation( array $definitions, array $params, ValidatorOptions $options ) {
		if ( $this->setCount == 0 ) {
			if ( $this->definition->isRequired() ) {
				// This should not occur, so throw an exception.
				throw new MWException( 'Attempted to validate a required parameter without first setting a value.' );
			}
			else {
				$this->setToDefault();
			}
		}
		else {
			$validationResult = $this->definition->validate( $this, $definitions, $params, $options );

			if ( is_array( $validationResult ) ) {
				/**
				 * @var ValidationError $error
				 */
				foreach ( $validationResult as $error ) {
					$error->addTags( $this->getName() );
					$this->errors[] = $error;
				}
			}

			$this->validateCriteria( $definitions, $params );
			$this->setToDefaultIfNeeded();
		}
	}

	/**
	 * Sets the parameter value to the default if needed.
	 *
	 * @since 0.5
	 */
	protected function setToDefaultIfNeeded() {
		if ( count( $this->errors ) > 0 && !$this->hasFatalError() ) {
			$this->setToDefault();
		}
	}

	/**
	 * Validates the provided value against all criteria.
	 *
	 * @deprecated removal in 0.7
	 * @since 0.5
	 *
	 * @param $definitions array of ParamDefinition
	 * @param $params array of Param
	 */
	protected function validateCriteria( array $definitions, array $params ) {
		$parameter = $this->toParameter();

		foreach ( $this->definition->getCriteria() as $criterion ) {
			$validationResult = $criterion->validate( $parameter, $params );

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
	 * @deprecated removal in 0.7
	 * @since 0.5
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
	 * Returns the original use-provided name.
	 *
	 * @since 0.5
	 *
	 * @throws MWException
	 * @return string
	 */
	public function getOriginalName() {
		if ( $this->setCount == 0 ) {
			throw new MWException( 'No user input set to the parameter yet, so the original name does not exist' );
		}
		return $this->originalName;
	}

	/**
	 * Returns the original use-provided value.
	 *
	 * @since 0.5
	 *
	 * @throws MWException
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
	 * @since 0.5
	 *
	 * @return array of ValidationError
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Sets the parameter value to the default.
	 *
	 * @since 0.5
	 */
	protected function setToDefault() {
		$this->defaulted = true;
		$this->value = $this->definition->getDefault();
	}

	/**
	 * Gets if the parameter was set to it's default.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function wasSetToDefault() {
		return $this->defaulted;
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
	 * Returns the IParamDefinition this IParam was constructed from.
	 *
	 * @since 0.5
	 *
	 * @return IParamDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

	/**
	 * Returns the parameters value.
	 *
	 * @since 0.5
	 *
	 * @return mixed
	 */
	public function &getValue() {
		return $this->value;
	}

	/**
	 * Returns if the parameter is required or not.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function isRequired() {
		return $this->definition->isRequired();
	}

	/**
	 * Returns if the name of the parameter.
	 *
	 * @since 0.5
	 *
	 * @return boolean
	 */
	public function getName() {
		return $this->definition->getName();
	}

	/**
	 * Returns the parameter name aliases.
	 *
	 * @since 0.5
	 *
	 * @return array
	 */
	public function getAliases() {
		return $this->definition->getAliases();
	}

}