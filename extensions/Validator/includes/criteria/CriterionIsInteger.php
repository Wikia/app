<?php

/**
 * Parameter criterion stating that the value must be an integer.
 * 
 * @since 0.4
 * 
 * @file CriterionIsInteger.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsInteger extends ItemParameterCriterion {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct(  ) {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
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