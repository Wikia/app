<?php

/**
 * Parameter criterion stating that the value must be an integer.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file CriterionIsInteger.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsInteger extends ItemParameterCriterion {
	
	protected $negativesAllowed;
	
	/**
	 * Constructor.
	 * 
	 * @param boolean $negativesAllowed since 0.4.8
	 * 
	 * @since 0.4
	 */
	public function __construct( $negativesAllowed = true ) {
		$this->negativesAllowed = $negativesAllowed;
		
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		if ( $this->negativesAllowed && strpos( $value, '-' ) === 0 ) {
			$value = substr( $value, 1 );
		}
		
		return ctype_digit( (string)$value );
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator_error_must_be_integer', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator_list_error_must_be_integer', 'parsemag', $parameter->getOriginalName() );
	}	
	
}