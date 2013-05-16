<?php

/**
 * Class for describing map layers.
 *
 * @since 0.7.1
 * 
 * @file Maps_Layer.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class MapsLayer {

	/**
	 * Returns an array of parameter definitions.
	 * 
	 * @since 0.7.2
	 * 
	 * @param array $params Array that can already hold definitions for common parameters.
	 * 
	 * @return array
	 */
	protected abstract function getParameterDefinitions( array $params );
	
	/**
	 * Returns a string containing the JavaScript definition of this layer.
	 * Only call this function when you are sure the layer is valid!
	 * 
	 * @since 0.7.1
	 * 
	 * @return string
	 */
	public abstract function getJavaScriptDefinition();
	
	/**
	 * @since 0.7.1
	 * 
	 * @var array
	 */
	protected $properties;
	
	/**
	 * @since 0.7.1
	 * 
	 * @var array
	 */
	protected $errors = array();
	
	/**
	 * Keeps track if the layer has been validated, to prevent doing redundant work.
	 * 
	 * @since 0.7.1
	 * 
	 * @var boolean
	 */
	protected $hasValidated = false;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7.1
	 * 
	 * @param array $properties
	 */
	public function __construct( array $properties ) {
		$this->properties = $properties;
	}
	
	/**
	 * Returns the error messages, optionally filtered by an error tag.
	 * 
	 * @since 0.7.1
	 * 
	 * @param mixed $tag
	 * 
	 * @return array of string
	 */
	public function getErrorMessages( $tag = false ) {
		$messages = array();
		
		foreach ( $this->errors as $error ) {
			if ( $tag === false || $error->hasTag( $tag ) ) {
				$messages[] = $error->getMessage();
			}
		}
		
		return $messages;
	}
	
	/**
	 * Returns the layers properties.
	 * 
	 * @since 0.7.1
	 * 
	 * @return array
	 */
	public function getProperties() {
		return $this->properties;
	}
	
	/**
	 * Validates the layer.
	 * 
	 * @since 0.7.1
	 */
	protected function validate() {
		$validator = new Validator();
		
		$validator->setParameters( $this->properties, $this->getParameterDefinitions( array() ) );
		$validator->validateParameters();
		
		if ( $validator->hasFatalError() !== false ) {
			$this->errors = $validator->getErrors();
		}
		
		$this->properties = $validator->getParameterValues();
	}
	
	/**
	 * Gets if the properties make up a valid layer definition.
	 * 
	 * @since 0.7.1
	 * 
	 * @return boolean
	 */
	public function isValid() {
		if ( !$this->hasValidated ) {
			$this->validate();
			$this->hasValidated = true;
		}
		
		return count( $this->errors ) == 0;
	}		
	
}
