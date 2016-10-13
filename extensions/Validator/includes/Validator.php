<?php

/**
 * Class for parameter validation of a single parser hook or other parametrized construct.
 *
 * @since 0.1
 *
 * @file Validator.php
 * @ingroup Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class Validator {
	
	/**
	 * Flag for unnamed default parameters used in Validator::setFunctionParams() to determine that
	 * a parameter should not have a named fallback.
	 * 
	 * @since 0.4.13
	 */
	const PARAM_UNNAMED = 1;
	
	/**
	 * Array containing the parameters.
	 * 
	 * @since 0.4
	 * 
	 * @var array of IParam
	 */
	protected $params;
	
	/**
	 * Associative array containing parameter names (keys) and their user-provided data (values).
	 * This list is needed because additional parameter definitions can be added to the $parameters
	 * field during validation, so we can't determine in advance if a parameter is unknown.
	 * 
	 * @since 0.4
	 * 
	 * @var array of string
	 */
	protected $rawParameters = array();
	
	/**
	 * Array containing the names of the parameters to handle, ordered by priority.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */
	protected $paramsToHandle = array();

	/**
	 *
	 *
	 * @since 0.5
	 *
	 * @var array
	 */
	protected $paramDefinitions = array();
	
	/**
	 * List of ValidationError.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Options for this validator object.
	 *
	 * @since 0.5
	 *
	 * @var ValidatorOptions
	 */
	protected $options;

	/**
	 * Deprecated since 0.5, breaking changes in 0.7, use newFrom* instead.
	 * 
	 * @param string $element
	 * @param boolean $unknownInvalid Should unknown parameter be regarded as invalid (or, if not, just be ignored)
	 * @param ValidatorOptions $options
	 * 
	 * @since 0.4
	 */
	public function __construct( $element = '', $unknownInvalid = true, ValidatorOptions $options = null ) {
		if ( is_null( $options ) ) {
			$options = new ValidatorOptions();
			$options->setName( $element );
			$options->setUnknownInvalid( $unknownInvalid );
		}

		$this->options = $options;
	}

	/**
	 * Constructs and returns a Validator object based on the provided options.
	 *
	 * @since 0.5
	 *
	 * @param ValidatorOptions $options
	 *
	 * @return Validator
	 */
	public static function newFromOptions( ValidatorOptions $options ) {
		return new Validator( '', true, $options );
	}

	/**
	 * Returns the options used by this Validator object.
	 *
	 * @since 0.5
	 *
	 * @return ValidatorOptions
	 */
	public function getOptions() {
		return clone $this->options;
	}
	
	/**
	 * Determines the names and values of all parameters. Also takes care of default parameters. 
	 * After that the resulting parameter list is passed to Validator::setParameters
	 * 
	 * @since 0.4
	 * 
	 * @param array $rawParams
	 * @param array $parameterInfo
	 * @param array $defaultParams array of strings or array of arrays to define which parameters can be used unnamed.
	 *        The second value in array-form is reserved for flags. Currently, Validator::PARAM_UNNAMED determines that
	 *        the parameter has no name which can be used to set it. Therefore all these parameters must be set before
	 *        any named parameter. The effect is, that '=' within the string won't confuse the parameter anymore like
	 *        it would happen with default parameters that still have a name as well.
	 * @param boolean $toLower Indicates if the parameter values should be put to lower case. Defaults to true.
	 * 
	 * @todo: $toLower takes no effect yet.
	 */
	public function setFunctionParams( array $rawParams, array $parameterInfo, array $defaultParams = array(), $toLower = true ) {
		$parameters = array();

		$nr = 0;
		$defaultNr = 0;
		$lastUnnamedDefaultNr = -1;
		
		/*
		 * Find last parameter with self::PARAM_UNNAMED set. Tread all parameters in front as
		 * the flag were set for them as well to ensure that there can't be any unnamed params
		 * after the first named param. Wouldn't be possible to determine which unnamed value
		 * belongs to which parameter otherwise.
		 */		
		for( $i = count( $defaultParams ) - 1; $i >= 0 ; $i-- ) {
			$dflt = $defaultParams[$i];
			if( is_array( $dflt ) && !empty( $dflt[1] ) && ( $dflt[1] | self::PARAM_UNNAMED ) ) {
				$lastUnnamedDefaultNr = $i;
				break;
			}
		}
		
		foreach ( $rawParams as $arg ) {
			// Only take into account strings. If the value is not a string,
			// it is not a raw parameter, and can not be parsed correctly in all cases.
			if ( is_string( $arg ) ) {				
				$parts = explode( '=', $arg, ( $nr <= $lastUnnamedDefaultNr ? 1 : 2 ) );
				
				// If there is only one part, no parameter name is provided, so try default parameter assignment.
				// Default parameters having self::PARAM_UNNAMED set for having no name alias go here in any case.
				if ( count( $parts ) == 1 ) {
					// Default parameter assignment is only possible when there are default parameters!
					if ( count( $defaultParams ) > 0 ) {
						$defaultParam = array_shift( $defaultParams );
						if( is_array( $defaultParam ) ) {
							$defaultParam = $defaultParam[0];
						}
						$defaultParam = strtolower( $defaultParam );
						
						$parameters[$defaultParam] = array(
							'original-value' => trim( $parts[0] ),
							'default' => $defaultNr,
							'position' => $nr
						);
						$defaultNr++;
					}
					else {
						// It might be nice to have some sort of warning or error here, as the value is simply ignored.
					}
				} else {
					$paramName = trim( strtolower( $parts[0] ) );
					
					$parameters[$paramName] = array(
						'original-value' => trim( $parts[1] ),
						'default' => false,
						'position' => $nr
					);
					
					// Let's not be evil, and remove the used parameter name from the default parameter list.
					// This code is basically a remove array element by value algorithm.
					$newDefaults = array();
					
					foreach( $defaultParams as $defaultParam ) {
						if ( $defaultParam != $paramName ) $newDefaults[] = $defaultParam;
					}
					
					$defaultParams = $newDefaults;
				}
			}
			
			$nr++;
		}	

		$this->setParameters( $parameters, $parameterInfo, false );
	}
	
	/**
	 * Loops through a list of provided parameters, resolves aliasing and stores errors
	 * for unknown parameters and optionally for parameter overriding.
	 * 
	 * @param array $parameters Parameter name as key, parameter value as value
	 * @param array $paramDefinitions List of parameter definitions. Either ParamDefinition objects or equivalent arrays.
	 */
	public function setParameters( array $parameters, array $paramDefinitions ) {
		$this->paramDefinitions = ParamDefinition::getCleanDefinitions( $paramDefinitions );

		// Loop through all the user provided parameters, and distinguish between those that are allowed and those that are not.
		foreach ( $parameters as $paramName => $paramData ) {
			if ( $this->options->lowercaseNames() ) {
				$paramName = strtolower( $paramName );
			}

			if ( $this->options->trimNames() ) {
				$paramName = trim( $paramName );
			}

			$paramValue = is_array( $paramData ) ? $paramData['original-value'] : $paramData;

			$this->rawParameters[$paramName] = $paramValue;
		}
	}
	
	/**
	 * Registers an error.
	 * 
	 * @since 0.4
	 * 
	 * @param string $message
	 * @param mixed $tags string or array
	 * @param integer $severity
	 */
	protected function registerNewError( $message, $tags = array(), $severity = ValidationError::SEVERITY_NORMAL ) {
		$this->registerError(
			new ValidationError(
				$message,
				$severity,
				$this->options->getName(),
				(array)$tags
			)
		);
	}
	
	/**
	 * Registers an error.
	 * 
	 * @since 0.4
	 * 
	 * @param ValidationError $error
	 */
	protected function registerError( ValidationError $error ) {
		$error->element = $this->options->getName();
		$this->errors[] = $error;
		ValidationErrorHandler::addError( $error );		
	}
	
	/**
	 * Validates and formats all the parameters (but aborts when a fatal error occurs).
	 * 
	 * @since 0.4
	 */
	public function validateParameters() {
		$this->doParamProcessing();
		
		if ( !$this->hasFatalError() && $this->options->unknownIsInvalid() ) {
			// Loop over the remaining raw parameters.
			// These are unrecognized parameters, as they where not used by any parameter definition.
			foreach ( $this->rawParameters as $paramName => $paramValue ) {
				$this->registerNewError(
					wfMsgExt( 'validator_error_unknown_argument', 'parsemag', $paramName ),
					$paramName
				);
			}			
		}
	}
	
	/**
	 * Does the actual parameter processing. 
	 * 
	 * @since 0.4
	 */
	protected function doParamProcessing() {
		$this->getParamsToProcess( array(), $this->paramDefinitions );

		while ( $this->paramsToHandle !== array() ) {
			$paramName = array_shift( $this->paramsToHandle );
			$definition = $this->paramDefinitions[$paramName];

			// Compat code for 0.4.x style definitions, will be removed in 0.7.
			if ( $definition instanceof Parameter ) {
				$definition = ParamDefinition::newFromParameter( $definition );
			}

			$param = new Param( $definition );

			$setUserValue = $this->attemptToSetUserValue( $param );
			
			// If the parameter is required but not provided, register a fatal error and stop processing. 
			if ( !$setUserValue && $param->isRequired() ) {
				$this->registerNewError(
					wfMsgExt( 'validator_error_required_missing', 'parsemag', $paramName ),
					array( $paramName, 'missing' ),
					ValidationError::SEVERITY_FATAL
				);
				break;
			}
			else {
				$this->params[$param->getName()] = $param;

				$param->validate( $this->paramDefinitions, $this->params, $this->options );
				
				foreach ( $param->getErrors() as $error ) {
					$this->registerError( $error );
				}
				
				if ( $param->hasFatalError() ) {
					// If there was a fatal error, and the parameter is required, stop processing. 
					break;
				}
				
				$initialSet = $this->paramDefinitions;

				$param->format( $this->paramDefinitions, $this->params, $this->options );

				$this->getParamsToProcess( $initialSet, $this->paramDefinitions );
			}
		}
	}
	
	/**
	 * Gets an ordered list of parameters to process.
	 * 
	 * @since 0.4
	 * 
	 * @param array $initialParamSet
	 * @param array $resultingParamSet
	 */
	protected function getParamsToProcess( array $initialParamSet, array $resultingParamSet ) {
		if ( $initialParamSet === array() ) {
			$this->paramsToHandle = array_keys( $resultingParamSet );
		}
		else {
			if ( !is_array( $this->paramsToHandle ) ) {
				$this->paramsToHandle = array();
			}			
			
			foreach ( $resultingParamSet as $paramName => $parameter ) {
				if ( !array_key_exists( $paramName, $initialParamSet ) ) {
					$this->paramsToHandle[] = $paramName;
				}
			}	
		}
		
		$dependencyList = array();

		// Loop over the parameters to handle to create a dependency list.
		foreach ( $this->paramsToHandle as $paramName ) {
			$dependencies = array();

			// Only include dependencies that are in the list of parameters to handle.
			foreach ( $this->paramDefinitions[$paramName]->getDependencies() as $dependency ) {
				if ( in_array( $dependency, $this->paramsToHandle ) ) {
					$dependencies[] = $dependency;
				}
			}
			
			$dependencyList[$paramName] = $dependencies;
		}

		$sorter = new TopologicalSort( $dependencyList, true );

		$this->paramsToHandle = $sorter->doSort();
	}
	
	/**
	 * Tries to find a matching user provided value and, when found, assigns it
	 * to the parameter, and removes it from the raw values. Returns a boolean
	 * indicating if there was any user value set or not.
	 * 
	 * @since 0.4
	 *
	 * @param IParam $param
	 * 
	 * @return boolean
	 */
	protected function attemptToSetUserValue( IParam $param ) {
		if ( array_key_exists( $param->getName(), $this->rawParameters ) ) {
			$param->setUserValue( $param->getName(), $this->rawParameters[$param->getName()], $this->options );
			unset( $this->rawParameters[$param->getName()] );
			return true;
		}
		else {
			foreach ( $param->getDefinition()->getAliases() as $alias ) {
				if ( array_key_exists( $alias, $this->rawParameters ) ) {
					$param->setUserValue( $alias, $this->rawParameters[$alias], $this->options );
					unset( $this->rawParameters[$alias] );
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Returns the parameters.
	 * 
	 * @since 0.4
	 * 
	 * @return array of IParam
	 */
	public function getParameters() {
		return $this->params;
	}
	
	/**
	 * Returns a single parameter.
	 * 
	 * @since 0.4
	 * 
	 * @param string $parameterName The name of the parameter to return
	 * 
	 * @return IParam
	 */
	public function getParameter( $parameterName ) {
		return $this->params[$parameterName];
	}
	
	/**
	 * Returns an associative array with the parameter names as key and their
	 * corresponding values as value.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	public function getParameterValues() {
		$parameters = array();

		foreach ( $this->params as $parameter ) {
			/**
			 * @var IParam $parameter
			 */
			$parameters[$parameter->getName()] = $parameter->getValue(); 
		}
		
		return $parameters;
	}
	
	/**
	 * Returns the errors.
	 *
	 * @since 0.4
	 *
	 * @return array of ValidationError
	 */
	public function getErrors() {
		return $this->errors;
	}
	
	/**
	 * @since 0.4.6
	 * 
	 * @return array of string
	 */
	public function getErrorMessages() {
		$errors = array();
		
		foreach ( $this->errors as $error ) {
			$errors[] = $error->getMessage();
		}
		
		return $errors;
	}
	
	/**
	 * Returns if there where any errors during validation. 
	 * 
	 * @return boolean
	 */
	public function hasErrors() {
		return !empty( $this->errors );
	}
	
	/**
	 * Returns false when there are no fatal errors or an ValidationError when one is found.
	 * 
	 * @return mixed false or ValidationError
	 */
	public function hasFatalError() {
		foreach ( $this->errors as $error ) {
			if ( $error->isFatal() ) {
				return $error;
			}
		}
		
		return false;
	}	
	
}
