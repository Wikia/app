<?php

/**
 * Class for list parameters.
 * 
 * @since 0.4
 * 
 * @file ListParameter.php
 * @ingroup Validator
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ListParameter extends Parameter {
	
	/**
	 * Indicates if errors in list items should cause the item to be omitted,
	 * versus having the whole list be set to it's default.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean 
	 */
	public static $perItemValidation = true;	
	
	/**
	 * The default delimiter for lists, used when the parameter definition does not specify one.
	 * 
	 * @since 0.4
	 * 
	 * @var string 
	 */
	const DEFAULT_DELIMITER = ',';		
	
	/**
	 * The list delimiter.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $delimiter;
	
	/**
	 * List of criteria the parameter value as a whole needs to hold against.
	 * 
	 * @since 0.4
	 * 
	 * @var array of ListParameterCriterion
	 */		
	protected $listCriteria;	
	
	/**
	 * Holder for temporary information needed in the itemIsValid callback.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */
	protected $tempInvalidList;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 * 
	 * @param string $name
	 * @param string $delimiter
	 * @param mixed $type
	 * @param mixed $default Use null for no default (which makes the parameter required)
	 * @param array $aliases
	 * @param array $criteria
	 */
	public function __construct( $name, $delimiter = ListParameter::DEFAULT_DELIMITER, $type = Parameter::TYPE_STRING,
								 $default = null, array $aliases = array(), array $criteria = array() ) {
		$itemCriteria = array();
		$listCriteria = array();

		$this->cleanCriteria( $criteria );
		
		foreach ( $criteria as $criterion ) {
			if ( $criterion->isForLists() ) {
				$listCriteria[] = $criterion;
			}
			else {
				$itemCriteria[] = $criterion;
			}
		}
		
		$this->listCriteria = $listCriteria;

		parent::__construct( $name, $type, $default, $aliases, $itemCriteria );
		
		$this->delimiter = $delimiter;
		
	}
	
	/**
	 * Returns if the parameter is a list or not.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */		
	public function isList() {
		return true;
	}

	/**
	 * Sets the $value to a cleaned value of $originalValue.
	 * 
	 * @since 0.4
	 */
	protected function cleanValue() {
		if ( $this->originalValue == '' ) {
			// If no value is provided, there are no items, and not a single empty item.
			$this->value = array();			
		}
		else {
			$this->value = explode( $this->delimiter, $this->originalValue );
	
			if ( $this->trimValue ) {
				foreach ( $this->value as &$item ) {
					$item = trim( $item );
				}
			}	
		}
	}	
	
	/**
	 * @see Parameter::validate
	 */
	public function validate( array $parameters ) {
		$listSuccess = $this->validateListCriteria( $parameters );
		
		if ( $listSuccess ) {
			$this->doValidation( $parameters );
		}
		// TODO

		// FIXME: it's possible the list criteria are not satisfied here anymore due to filtering of invalid items.
	}	
	
	/**
	 * @see Parameter::setToDefaultIfNeeded
	 * 
	 * @since 0.4
	 */	
	protected function setToDefaultIfNeeded() {
		if ( count( $this->errors ) > 0 && count( $this->value ) == 0 && !$this->hasFatalError() ) {
			$this->setToDefault();
		}		
	}
	
	/**
	 * @see Parameter::setToDefault
	 * 
	 * @since 0.4
	 */
	protected function setToDefault() {
		$this->defaulted = true;
		$this->value = is_array( $this->default ) ? $this->default : array( $this->default );
	}	
	
	/**
	 * 
	 * 
	 * @since 0.4
	 * 
	 * @param array $parameters
	 */
	protected function validateListCriteria( array $parameters ) {
		foreach ( $this->getListCriteria() as $listCriterion ) {
			if ( !$listCriterion->validate( $this, $parameters ) ) {
				$hasError = true;
				
				if ( !self::$accumulateParameterErrors ) {
					break;
				}
			}			
		}
		
		// TODO
		return true;
	}
	
	/**
	 * Returns the parameter list criteria.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ListParameterCriterion
	 */	
	public function getListCriteria() {
		return $this->listCriteria; 
	}
	
	/**
	 * Handles any validation errors that occurred for a single criterion.
	 * 
	 * @since 0.4
	 * 
	 * @param CriterionValidationResult $validationResult
	 */
	protected function handleValidationError( CriterionValidationResult $validationResult ) {
		parent::handleValidationError( $validationResult );
		
		// Filter out the items that have already been found to be invalid.
		if ( $validationResult->hasInvalidItems() ) {
			$this->tempInvalidList = $validationResult->getInvalidItems();
			$this->value = array_filter( $this->value, array( $this, 'itemIsValid' ) );
		}
	}
	
	/**
	 * Returns if an item is valid or not. 
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */
	protected function itemIsValid( $item ) {
		return !in_array( $item, $this->tempInvalidList );
	}
	
	/**
	 * @see Parameter::setDefault
	 * 
	 * @since 0.4
	 */
	public function setDefault( $default, $manipulate = true ) {
		$this->default = is_array( $default ) ? $default : array( $default );
		$this->setDoManipulationOfDefault( $manipulate );
	}	
	
}