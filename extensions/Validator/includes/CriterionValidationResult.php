<?php

/**
 * Class to hold parameter validation result info.
 * 
 * @since 0.4
 * 
 * @file CriterionValidationResult.php
 * @ingroup Validator
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CriterionValidationResult {
	
	/**
	 * @since 0.4
	 * 
	 * @var array of ValidationError
	 */
	protected $errors = array();
	
	/**
	 * @since 0.4
	 * 
	 * @var array of string
	 */
	protected $invalidItems = array();
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {

	}
	
	/**
	 * Adds a single error object.
	 * 
	 * @since 0.4
	 * 
	 * @param ValidationError $error
	 */
	public function addError( ValidationError $error ) {
		$this->errors[] = $error; 
	}
	
	/**
	 * Adds a single invalid item.
	 * 
	 * @since 0.4
	 * 
	 * @param string $item
	 */
	public function addInvalidItem( $item ) {
		$this->invalidItems[] = $item;
	}
	
	/**
	 * Gets the errors.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ValidationError
	 */
	public function getErrors() {
		return $this->errors;
	}	
	
	/**
	 * Gets the invalid items.
	 * 
	 * @since 0.4
	 * 
	 * @return array of string
	 */
	public function getInvalidItems() {
		return $this->invalidItems;
	}
	
	/**
	 * Returns whether no errors occurred.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */
	public function isValid() {
		return count( $this->errors ) == 0 && !$this->hasInvalidItems();
	}
	
	/**
	 * Returns there are any invalid items.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */	
	public function hasInvalidItems() {
		return count( $this->invalidItems ) != 0;
	}
	
}