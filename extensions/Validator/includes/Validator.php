<?php

/**
 * Class for parameter validation of a single parser hook or other parametrized construct.
 *
 * @since 0.1
 *
 * @file Validator.php
 * @ingroup Validator
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Validator {
	
	/**
	 * Array containing the parameters.
	 * 
	 * @since 0.4
	 * 
	 * @var array of Parameter
	 */
	protected $parameters;
	
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
	 * List of ValidationError.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Name of the element that's being validated.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $element;
	
	/** 
	 * Indicates if unknown parameters should be seen as invalid.
	 * If this value is false, they will simply be ignored.
	 * 
	 * @since 0.4.3
	 * 
	 * @var boolean
	 */
	protected $unknownInvalid;
	
	/**
	 * Constructor.
	 * 
	 * @param string $element
	 * @param boolean $unknownInvalid Should unknown parameter be regarded as invalid (or, if not, just be ignored)
	 * 
	 * @since 0.4
	 */
	public function __construct( $element = '', $unknownInvalid = true ) {
		$this->element = $element;
		$this->unknownInvalid = $unknownInvalid;
	}
	
	/**
	 * Determines the names and values of all parameters. Also takes care of default parameters. 
	 * After that the resulting parameter list is passed to Validator::setParameters
	 * 
	 * @since 0.4
	 * 
	 * @param array $rawParams
	 * @param array $parameterInfo
	 * @param array $defaultParams
	 * @param boolean $toLower Indicates if the parameter values should be put to lower case. Defaults to true.
	 */
	public function setFunctionParams( array $rawParams, array $parameterInfo, array $defaultParams = array(), $toLower = true ) {
		$parameters = array();

		$nr = 0;
		$defaultNr = 0;
		
		foreach ( $rawParams as $arg ) {
			// Only take into account strings. If the value is not a string,
			// it is not a raw parameter, and can not be parsed correctly in all cases.
			if ( is_string( $arg ) ) {
				$parts = explode( '=', $arg, 2 );
				
				// If there is only one part, no parameter name is provided, so try default parameter assignment.
				if ( count( $parts ) == 1 ) {
					// Default parameter assignment is only possible when there are default parameters!
					if ( count( $defaultParams ) > 0 ) {
						$defaultParam = strtolower( array_shift( $defaultParams ) );
						
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
	 * @param array $parameterInfo Main parameter name as key, parameter meta data as value
	 * @param boolean $toLower Indicates if the parameter values should be put to lower case. Defaults to true.
	 */
	public function setParameters( array $parameters, array $parameterInfo, $toLower = true ) {
		$this->cleanParameterInfo( $parameterInfo );
		
		$this->parameters = $parameterInfo;
		
		// Loop through all the user provided parameters, and distinguish between those that are allowed and those that are not.
		foreach ( $parameters as $paramName => $paramData ) {
			$paramName = trim( strtolower( $paramName ) );
			$paramValue = is_array( $paramData ) ? $paramData['original-value'] : trim( $paramData );
			
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
				$this->element,
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
		$error->element = $this->element;
		$this->errors[] = $error;
		ValidationErrorHandler::addError( $error );		
	}
	
	/**
	 * Ensures all elements of the array are Parameter objects,
	 * and that the array keys match the main parameter name.
	 * 
	 * @since 0.4
	 * 
	 * @param array $paramInfo
	 */
	protected function cleanParameterInfo( array &$paramInfo ) {
		$cleanedList = array();
		
		foreach ( $paramInfo as $key => $parameter ) {
			if ( $parameter instanceof Parameter ) {
				$cleanedList[$parameter->getName()] = $parameter;
			}
			else {
				throw new Exception( "$key is not a valid Parameter." );
			}
		}
		
		$paramInfo = $cleanedList;
	}	
	
	/**
	 * Validates and formats all the parameters (but aborts when a fatal error occurs).
	 * 
	 * @since 0.4
	 */
	public function validateParameters() {
		$this->doParamProcessing();
		
		if ( !$this->hasFatalError() && $this->unknownInvalid ) {
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
		$this->getParamsToProcess( array(), $this->parameters );

		while ( $paramName = array_shift( $this->paramsTohandle ) ) {
			$parameter = $this->parameters[$paramName];

			$setUservalue = $this->attemptToSetUserValue( $parameter );
			
			// If the parameter is required but not provided, register a fatal error and stop processing. 
			if ( !$setUservalue && $parameter->isRequired() ) {
				$this->registerNewError(
					wfMsgExt( 'validator_error_required_missing', 'parsemag', $paramName ),
					array( $paramName, 'missing' ),
					ValidationError::SEVERITY_FATAL
				);
				break;
			}
			else {
				$parameter->validate( $this->parameters );			
				
				foreach ( $parameter->getErrors() as $error ) {
					$this->registerError( $error );
				}				
				
				if ( $parameter->hasFatalError() ) {
					// If there was a fatal error, and the parameter is required, stop processing. 
					break;
				}
				
				$initialSet = $this->parameters;
				
				$parameter->format( $this->parameters );	

				$this->getParamsToProcess( $initialSet, $this->parameters );
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
		if ( count( $initialParamSet ) == 0 ) {
			$this->paramsTohandle = array_keys( $resultingParamSet );
		}
		else {
			if ( !is_array( $this->paramsTohandle ) ) {
				$this->paramsTohandle = array();
			}			
			
			foreach ( $resultingParamSet as $paramName => $parameter ) {
				if ( !array_key_exists( $paramName, $initialParamSet ) ) {
					$this->paramsTohandle[] = $paramName;
				}
			}	
		}
		
		$dependencyList = array();

		// Loop over the parameters to handle to create a dependency list.
		foreach ( $this->paramsTohandle as $paramName ) {
			$dependencies = array();
			
			// Only include dependencies that are in the list of parameters to handle.
			foreach ( $this->parameters[$paramName]->getDependencies() as $dependency ) {
				if ( in_array( $dependency, $this->paramsTohandle ) ) {
					$dependencies[] = $dependency;
				}
			}
			
			$dependencyList[$paramName] = $dependencies;
		}

		$sorter = new TopologicalSort( $dependencyList, true );

		$this->paramsTohandle = $sorter->doSort();
	}
	
	/**
	 * Tries to find a matching user provided value and, when found, assigns it
	 * to the parameter, and removes it from the raw values. Returns a boolean
	 * indicating if there was any user value set or not.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */
	protected function attemptToSetUserValue( Parameter $parameter ) {
		if ( array_key_exists( $parameter->getName(), $this->rawParameters ) ) {
			$parameter->setUserValue( $parameter->getName(), $this->rawParameters[$parameter->getName()] );
			unset( $this->rawParameters[$parameter->getName()] );
			return true;
		}
		else {
			foreach ( $parameter->getAliases() as $alias ) {
				if ( array_key_exists( $alias, $this->rawParameters ) ) {
					$parameter->setUserValue( $alias, $this->rawParameters[$alias] );
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
	 * @return array
	 */
	public function getParameters() {
		return $this->parameters;
	}
	
	/**
	 * Returns a single parameter.
	 * 
	 * @since 0.4
	 * 
	 * @param string $parameterName The name of the parameter to return
	 * 
	 * @return Parameter
	 */
	public function getParameter( $parameterName ) {
		return $this->parameters[$parameterName];
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
		
		foreach ( $this->parameters as $parameter ) {
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
		return count( $this->errors ) > 0;
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
