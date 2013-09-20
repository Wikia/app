<?php

/**
 * Item parameter criterion definition class. This is for criteria
 * that apply to individual values, which can either be the whole value
 * of a non-list parameter, or a single item of a list parameter.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file ItemParameterCriterion.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ItemParameterCriterion extends ParameterCriterion {
	
	/**
	 * Validate a value against the criterion.
	 * 
	 * @param string $value
	 * @param Parameter $parameter
	 * @param array $parameters
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */	
	protected abstract function doValidation( $value, Parameter $parameter, array $parameters );
	
	/**
	 * Gets an internationalized error message to construct a ValidationError with
	 * when the criteria validation failed. (for non-list values)
	 * 
	 * @param Parameter $parameter
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */	
	protected abstract function getItemErrorMessage( Parameter $parameter );
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ParameterCriterion::isForLists
	 */
	public function isForLists() {
		return false;
	}
	
	/**
	 * Validate the provided value or list of values against the criterion.
	 * 
	 * @since 0.4
	 * 
	 * @param Parameter $parameter
	 * @param array $parameters
	 * 
	 * @return CriterionValidationResult
	 */
	public function validate( Parameter $parameter, array $parameters ) {
		$result = new CriterionValidationResult();
		
		if ( is_array( $parameter->getValue() ) ) {
			foreach ( $parameter->getValue() as $item ) {
				if ( !$this->doValidation( $item, $parameter, $parameters ) ) {
					$result->addInvalidItem( $item );
				}
			}
			
			if ( $result->hasInvalidItems() ) {
				$allInvalid = count( $result->getInvalidItems() ) == count( $parameter->getValue() );
				
				// If the parameter is required and all items are invalid, it's fatal.
				// Else it's high for required, and normal for non-required parameters.
				if ( $parameter->isRequired() ) {
					$severity = $allInvalid ? ValidationError::SEVERITY_FATAL : ValidationError::SEVERITY_HIGH;
				}
				else {
					$severity = $allInvalid ? ValidationError::SEVERITY_NORMAL : ValidationError::SEVERITY_LOW;
				}
					
				$result->addError(
					new ValidationError(
						$this->getListErrorMessage( $parameter, $result->getInvalidItems(), $allInvalid ),
						$severity
					)
				);
			}
		}
		else {
			if ( !$this->doValidation( $parameter->getValue(), $parameter, $parameters ) ) {
				$result->addError(
					new ValidationError(
						$this->getItemErrorMessage( $parameter ),
						$parameter->isRequired() ? ValidationError::SEVERITY_FATAL : ValidationError::SEVERITY_NORMAL
					)
				);
			}
		}
		
		return $result;
	}
	
	/**
	 * Gets an internationalized error message to construct a ValidationError with
	 * when the criteria validation failed. (for list values)
	 * 
	 * @param Parameter $parameter
	 * @param array $invalidItems
	 * @param boolean $allInvalid
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */		
	protected function getListErrorMessage( Parameter $parameter, array $invalidItems, $allInvalid ) {
		if ( $allInvalid ) {
			return $this->getFullListErrorMessage( $parameter );
		}
		else {
			return $this->getPartialListErrorMessage( $parameter, $invalidItems, $allInvalid );
		}		
	}
	
	/**
	 * Gets an internationalized error message to construct a ValidationError with
	 * when the criteria validation failed. (for list values when all values are invalid)
	 * 
	 * @param Parameter $parameter
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */			
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator-error-problem', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * Gets an internationalized error message to construct a ValidationError with
	 * when the criteria validation failed. (for list values when only some values are invalid)
	 * 
	 * @param Parameter $parameter
	 * @param array $invalidItems
	 * @param boolean $allInvalid
	 * 
	 * @since 0.4
	 * 
	 * @return string
	 */			
	protected function getPartialListErrorMessage( Parameter $parameter, array $invalidItems, $allInvalid ) {
		global $wgLang;

		return $this->getFullListErrorMessage( $parameter ) . 
			wfMsgExt(
				'validator-error-omitted',
				'parsemag',
				$wgLang->listToText( $invalidItems ),
				count( $invalidItems )
			);		
	}	
	
}