<?php

/**
 * File holding the Validator class.
 *
 * @file Validator.class.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for parameter validation.
 *
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */
final class Validator {

	/**
	 * @var boolean Indicates whether parameters not found in the criteria list
	 * should be stored in case they are not accepted. The default is false.
	 */
	public static $storeUnknownParameters = false;

	/**
	 * @var boolean Indicates whether parameters not found in the criteria list
	 * should be stored in case they are not accepted. The default is false.
	 */
	public static $accumulateParameterErrors = false;
	
	/**
	 * @var boolean Indicates whether parameters that are provided more then once 
	 * should be accepted, and use the first provided value, or not, and generate an error.
	 */	
	public static $acceptOverriding = false;
	
	/**
	 * @var boolean Indicates if errors in list items should cause the item to be omitted,
	 * versus having the whole list be set to it's default.
	 */	
	public static $perItemValidation = true;	
	
	/**
	 * @var array Holder for the validation functions.
	 */
	private static $validationFunctions = array(
			'in_array' => array( 'ValidatorFunctions', 'in_array' ),
			'in_range' => array( 'ValidatorFunctions', 'in_range' ),
			'is_numeric' => 'is_numeric',
			'is_integer' => array( 'ValidatorFunctions', 'is_integer' ),	
			'not_empty' => array( 'ValidatorFunctions', 'not_empty' ),
			'has_length' => array( 'ValidatorFunctions', 'has_length' ),
			'regex' => array( 'ValidatorFunctions', 'regex' ),
			);
	
	/**
	 * @var array Holder for the list validation functions.
	 */
	private static $listValidationFunctions = array(
			'item_count' => array( 'ValidatorFunctions', 'has_item_count' ),
			'unique_items' => array( 'ValidatorFunctions', 'has_unique_items' ),
			);

	/**
	 * @var array Holder for the formatting functions.
	 */
	private static $outputFormats = array(
			'array' => array( 'ValidatorFormats', 'format_array' ),
			'list' => array( 'ValidatorFormats', 'format_list' ),
			'boolean' => array( 'ValidatorFormats', 'format_boolean' ),
			'boolstr' => array( 'ValidatorFormats', 'format_boolean_string' ),
			'string' => array( 'ValidatorFormats', 'format_string' ),
			'unique_items' => array( 'ValidatorFormats', 'format_unique_items' ),
			'filtered_array' => array( 'ValidatorFormats', 'format_filtered_array' ),
			);

	private $parameterInfo;
	private $rawParameters = array();

	private $parameters= array();
	private $valid = array();
	private $invalid = array();
	private $unknown = array();

	private $errors = array();

	/**
	 * Sets the parameter criteria, used to valiate the parameters.
	 *
	 * @param array $parameterInfo
	 */
	public function setParameterInfo( array $parameterInfo ) {
		$this->parameterInfo = $parameterInfo;
	}

	/**
	 * Sets the raw parameters that will be validated when validateParameters is called.
	 *
	 * @param array $parameters
	 */
	public function setParameters( array $parameters ) {
		$this->rawParameters = $parameters;
	}

	/**
	 * Valides the raw parameters, and allocates them as valid, invalid or unknown.
	 * Errors are collected, and can be retrieved via getErrors.
	 *
	 * @return boolean Indicates whether there where no errors.
	 */
	public function validateParameters() {
		// Loop through all the user provided parameters, and destinguise between those that are allowed and those that are not.
		foreach ( $this->rawParameters as $paramName => $paramValue ) {
			// Attempt to get the main parameter name (takes care of aliases).
			$mainName = self::getMainParamName( $paramName, $this->parameterInfo );
			// If the parameter is found in the list of allowed ones, add it to the $parameters array.
			if ( $mainName ) {
				// Check for parameter overriding. In most cases, this has already largely been taken care off, 
				// in the form of later parameters overriding earlier ones. This is not true for different aliases though.
				if (! array_key_exists($mainName, $this->parameters) || self::$acceptOverriding ) {
					$this->parameters[$mainName] = $paramValue;
				}
				else {
					$this->errors[] = array( 'type' => 'unknown', 'name' => $mainName );
				}
			}
			else { // If the parameter is not found in the list of allowed ones, add an item to the $this->errors array.
				if ( self::$storeUnknownParameters ) $this->unknown[$paramName] = $paramValue;
				$this->errors[] = array( 'type' => 'unknown', 'name' => $paramName);
			}
		}

		// Loop through the list of allowed parameters.
		foreach ( $this->parameterInfo as $paramName => $paramInfo ) {
			// If the user provided a value for this parameter, validate and handle it.
			if ( array_key_exists( $paramName, $this->parameters ) ) {

				$paramValue = $this->parameters[$paramName];
				$this->cleanParameter( $paramName, $paramValue );

				if ( $this->validateParameter( $paramName, $paramValue ) ) {
					// If the validation succeeded, add the parameter to the list of valid ones.
					$this->valid[$paramName] = $paramValue;
					$this->setOutputTypes($this->valid[$paramName], $paramInfo);	
				}
				else {
					// If the validation failed, add the parameter to the list of invalid ones.
					$this->invalid[$paramName] = $paramValue;
				}
			}
			else {
				// If the parameter is required, add a new error of type 'missing'.
				if ( array_key_exists( 'required', $paramInfo ) && $paramInfo['required'] ) {
					$this->errors[] = array( 'type' => 'missing', 'name' => $paramName );
				}
				else {
					// Set the default value (or default 'default value' if none is provided), and ensure the type is correct.
					$this->valid[$paramName] = array_key_exists( 'default', $paramInfo ) ? $paramInfo['default'] : '';	
					$this->setOutputTypes($this->valid[$paramName], $paramInfo);	
				}
			}
		}

		return count( $this->errors ) == 0;
	}

	/**
	 * Returns the main parameter name for a given parameter or alias, or false
	 * when it is not recognized as main parameter or alias.
	 *
	 * @param string $paramName
	 * @param array $allowedParms
	 *
	 * @return string
	 */
	private function getMainParamName( $paramName, array $allowedParms ) {
		$result = false;

		if ( array_key_exists( $paramName, $allowedParms ) ) {
			$result = $paramName;
		}
		else {
			foreach ( $allowedParms as $name => $data ) {
				if ( array_key_exists( 'aliases', $data ) ) {
					if ( in_array( $paramName, $data['aliases'] ) ) {
						$result = $name;
						break;
					}
				}
			}
		}

		return $result;
	}

	/**
	 * Ensures the parameter info is valid, trims the value, and splits lists.
	 * 
	 * @param string $name
	 * @param $value
	 */
	private function cleanParameter( $name, &$value ) {		
		// Ensure there is a criteria array.
		if (! array_key_exists('criteria', $this->parameterInfo[$name] )) {
			$this->parameterInfo[$name]['criteria'] = array();
		}			
		
		// Ensure the type is set in array form.
		if (! array_key_exists('type', $this->parameterInfo[$name] )) {
			$this->parameterInfo[$name]['type'] = array('string');
		}
		elseif(! is_array($this->parameterInfo[$name]['type'])) {
			$this->parameterInfo[$name]['type'] = array($this->parameterInfo[$name]['type']);
		}
		
		if ( array_key_exists( 'type', $this->parameterInfo[$name] ) ) {
			// Add type specific criteria.
			switch(strtolower($this->parameterInfo[$name]['type'][0])) {			
				case 'integer':
					$this->addTypeCriteria($name, 'is_integer');
					break;
				case 'number':
					$this->addTypeCriteria($name, 'is_numeric');
					break;
				case 'boolean':
					// TODO: work with list of true and false values. 
					$this->addTypeCriteria($name, 'in_array', array('yes', 'no', 'on', 'off'));
					break;
				case 'char':
					$this->addTypeCriteria($name, 'has_length', array(1, 1));
					break;	
			}
		}
		
		if (count($this->parameterInfo[$name]['type']) > 1 && $this->parameterInfo[$name]['type'][1] == 'list') {
			// Trimming and splitting of list values.
			$delimiter = count($this->parameterInfo[$name]['type']) > 2 ? $this->parameterInfo[$name]['type'][2] : ',';
			$value = preg_replace('/((\s)*' . $delimiter . '(\s)*)/', $delimiter, $value);
			$value = explode($delimiter, $value);
		}
		elseif (count($this->parameterInfo[$name]['type']) > 1 && $this->parameterInfo[$name]['type'][1] == 'array' && is_array($value)) {
			// Trimming of array values.
			for($i = count($value); $i > 0; $i--) $value[$i] = trim ($value[$i]);
		}
		else {
			// Trimming of non-list values.
			$value = trim ($value);
		}
	}
	
	private function addTypeCriteria($paramName, $criteriaName, $criteriaArgs = array()) {
		$this->parameterInfo[$paramName]['criteria'] = array_merge(array($criteriaName => $criteriaArgs), $this->parameterInfo[$paramName]['criteria']);
	}
	
	/**
	 * Valides the provided parameter by matching the value against the list and item criteria for the name.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return boolean Indicates whether there the parameter value(s) is/are valid.
	 */
	private function validateParameter( $name, &$value ) {
		$hasNoErrors = true;
		$checkItemCriteria = true;
		
		if (array_key_exists('list-criteria', $this->parameterInfo[$name])) {
			foreach ( $this->parameterInfo[$name]['list-criteria'] as $criteriaName => $criteriaArgs ) {
				// Get the validation function. If there is no matching function, throw an exception.
				if (array_key_exists($criteriaName, self::$listValidationFunctions)) {
					$validationFunction = self::$listValidationFunctions[$criteriaName];
					$isValid = $this->doCriteriaValidation($validationFunction, $value, $criteriaArgs);
					
					// Add a new error when the validation failed, and break the loop if errors for one parameter should not be accumulated.
					if ( ! $isValid ) {
						$hasNoErrors = false;
						
						$this->errors[] = array( 'type' => $criteriaName, 'args' => $criteriaArgs, 'name' => $name, 'list' => true, 'value' => $this->rawParameters[$name] );
						
						if ( ! self::$accumulateParameterErrors ) {
							$checkItemCriteria = false;
							break;
						}
					}						
				}
				else {
					$hasNoErrors = false;
					throw new Exception( 'There is no validation function for list criteria type ' . $criteriaName );
				}				
			}
		}

		if ($checkItemCriteria) $hasNoErrors = $hasNoErrors && $this->doItemValidation($name, $value);

		return $hasNoErrors;
	}
	
	/**
	 * Valides the provided parameter by matching the value against the item criteria for the name.
	 * 
	 * @param $name
	 * @param $value
	 * 
	 * @return boolean Indicates whether there the parameter value(s) is/are valid.
	 */
	private function doItemValidation( $name, &$value ) {
		$hasNoErrors = true;
		
		// Go through all item criteria.
		foreach ( $this->parameterInfo[$name]['criteria'] as $criteriaName => $criteriaArgs ) {
			// Get the validation function. If there is no matching function, throw an exception.
			if (array_key_exists($criteriaName, self::$validationFunctions)) {
				$validationFunction = self::$validationFunctions[$criteriaName];
				
				if (is_array($value)) {
					// Handling of list parameters
					$invalidItems = array();
					$validItems = array();
					
					// Loop through all the items in the parameter value, and validate them.
					foreach($value as $item) {
						$isValid = $this->doCriteriaValidation($validationFunction, $item, $criteriaArgs);
						if ($isValid) {
							// If per item validation is on, store the valid items, so only these can be returned by Validator.
							if (self::$perItemValidation) $validItems[] = $item;
						}
						else {
							// If per item validation is on, store the invalid items, so a fitting error message can be created.
							if (self::$perItemValidation) {
								$invalidItems[] = $item;
							}
							else {
								// If per item validation is not on, an error to one item means the complete value is invalid.
								// Therefore it's not required to validate the remaining items.
								break;
							}
						}
					}
					
					if (self::$perItemValidation) {
						// If per item validation is on, the parameter value is valid as long as there is at least one valid item.
						$isValid = count($validItems) > 0;
						
						// If the value is valid, but there are invalid items, add an error with a list of these items.
						if ($isValid && count($invalidItems) > 0) {
							$value = $validItems;
							$this->errors[] = array( 'type' => $criteriaName, 'args' => $criteriaArgs, 'name' => $name, 'list' => true, 'invalid-items' => $invalidItems );
						}
					}
				}
				else {
					// Determine if the value is valid for single valued parameters.
					$isValid = $this->doCriteriaValidation($validationFunction, $value, $criteriaArgs);
				}
				
				// Add a new error when the validation failed, and break the loop if errors for one parameter should not be accumulated.
				if ( ! $isValid ) {
					$isList = is_array($value);
					if ($isList) $value = $this->rawParameters[$name];
					$this->errors[] = array( 'type' => $criteriaName, 'args' => $criteriaArgs, 'name' => $name, 'list' => $isList, 'value' => $value );
					$hasNoErrors = false;
					if ( ! self::$accumulateParameterErrors ) break;
				}				
			}
			else {
				$hasNoErrors = false;
				throw new Exception( 'There is no validation function for criteria type ' . $criteriaName );
			}
		}	

		return $hasNoErrors;
	}
	
	/**
	 * Validates the value of an item, and returns the validation result.
	 * 
	 * @param $validationFunction
	 * @param $value
	 * @param $criteriaArgs
	 * 
	 * @return unknown_type
	 */
	private function doCriteriaValidation($validationFunction, $value, $criteriaArgs) {		
		// Call the validation function and store the result. 
		return call_user_func_array( $validationFunction, array_merge(array($value), $criteriaArgs) );		
	}
	
	/**
	 * Changes the invalid parameters to their default values, and changes their state to valid.
	 */
	public function correctInvalidParams() {
		foreach ( $this->invalid as $paramName => $paramValue ) {
			unset( $this->invalid[$paramName] );
			$this->valid[$paramName] = array_key_exists( 'default', $this->parameterInfo[$paramName] ) ? $this->parameterInfo[$paramName]['default'] : '';
			$this->setOutputTypes($this->valid[$paramName], $this->parameterInfo[$paramName]);
		}
	}	
	
	/**
	 * Ensures the output type values are arrays, and then calls setOutputType.
	 * 
	 * @param array $value
	 * @param $info
	 * @return unknown_type
	 */
	private function setOutputTypes(&$value, array $info) {
		if (array_key_exists('output-types', $info)) {
			for($i = 0, $c = count($info['output-types']); $i < $c; $i++) {
				if (! is_array($info['output-types'][$i])) $info['output-types'][$i] = array($info['output-types'][$i]);
				$this->setOutputType($value, $info['output-types'][$i]);
			}
		}
		elseif (array_key_exists('output-type', $info)) {
			if (! is_array($info['output-type'])) $info['output-type'] = array($info['output-type']);
			$this->setOutputType($value, $info['output-type']);
		}
		
	}
	
	/**
	 * Calls the formatting function for the provided output format with the provided value.
	 * 
	 * @param $value
	 * @param array $typeInfo
	 */
	private function setOutputType(&$value, array $typeInfo) {
		// The output type is the first value in the type info array.
		// The remaining ones will be any extra arguments.
		$outputType = strtolower(array_shift($typeInfo));
		
		if (array_key_exists($outputType, self::$outputFormats)) {
			// Call the formatting function with as first parameter the value, followed by the extra arguments.
			call_user_func_array( self::$outputFormats[$outputType], array_merge(array(&$value), $typeInfo) );
		}
		else {
			throw new Exception( 'There is no formatting function for output format ' . $outputType );
		}
	}

	/**
	 * Returns the valid parameters.
	 *
	 * @return array
	 */
	public function getValidParams() {
		return $this->valid;
	}

	/**
	 * Returns the unknown parameters.
	 *
	 * @return array
	 */
	public static function getUnknownParams() {
		return $this->unknown;
	}

	/**
	 * Returns the errors.
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Adds a new criteria type and the validation function that should validate values of this type.
	 * You can use this function to override existing criteria type handlers.
	 *
	 * @param string $criteriaName The name of the cirteria.
	 * @param array $functionName The functions location. If it's a global function, only the name,
	 * if it's in a class, first the class name, then the method name.
	 */
	public static function addValidationFunction( $criteriaName, array $functionName ) {
		self::$validationFunctions[$criteriaName] = $functionName;
	}
	
	/**
	 * Adds a new list criteria type and the validation function that should validate values of this type.
	 * You can use this function to override existing criteria type handlers.
	 *
	 * @param string $criteriaName The name of the list cirteria.
	 * @param array $functionName The functions location. If it's a global function, only the name,
	 * if it's in a class, first the class name, then the method name.
	 */
	public static function addListValidationFunction( $criteriaName, array $functionName ) {
		self::$listValidationFunctions[$criteriaName] = $functionName;
	}	
	
	/**
	 * Adds a new output format and the formatting function that should validate values of this type.
	 * You can use this function to override existing criteria type handlers.
	 *
	 * @param string $formatName The name of the format.
	 * @param array $functionName The functions location. If it's a global function, only the name,
	 * if it's in a class, first the class name, then the method name.
	 */
	public static function addOutputFormat( $formatName, array $functionName ) {
		self::$outputFormats[$formatName] = $functionName;
	}	
}