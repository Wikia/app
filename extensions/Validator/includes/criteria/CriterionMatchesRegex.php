<?php

/**
 * Parameter criterion stating that the value must match a regex.
 * 
 * @since 0.4
 * 
 * @file CriterionMatchesRegex.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionMatchesRegex extends ItemParameterCriterion {
	
	/**
	 * The pattern to match against.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $pattern;
	
	/**
	 * Constructor.
	 * 
	 * @param string $pattern
	 * 
	 * @since 0.4
	 */
	public function __construct( $pattern ) {
		parent::__construct();
		
		$this->pattern = $pattern;
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		return (bool)preg_match( $this->pattern, $value );
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator-error-invalid-regex', 'parsemag', $parameter->getOriginalName(), $this->pattern );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator-list-error-invalid-regex', 'parsemag', $parameter->getOriginalName(), $this->pattern );
	}	
	
}