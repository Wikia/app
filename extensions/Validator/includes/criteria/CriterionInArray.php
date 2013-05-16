<?php

/**
 * Parameter criterion stating that the value must be in an array.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file CriterionInArray.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionInArray extends ItemParameterCriterion {
	
	/**
	 * List of allowed values.
	 * 
	 * @since 0.4
	 * 
	 * @var array
	 */
	protected $allowedValues;
	
	/**
	 * If the values should match case.
	 * 
	 * @since 0.4.2
	 * 
	 * @var boolean
	 */
	protected $careAboutCapitalization = false;
	
	/**
	 * Constructor.
	 * 
	 * You can specify the allowed values either by passing an array,
	 * or by passing each value as an argument. You can also specify
	 * if the criterion should care about capitalization or not by
	 * adding a boolean as last argument. This value default to false.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct();
		
		$args = func_get_args();
		
		$lastElement = array_pop( $args );
		
		if ( is_bool( $lastElement ) ) {
			// The element is a boolean, so it's the capitalization parameter.
			$this->careAboutCapitalization = $lastElement;
		}
		else {
			// Add the element back to the array.
			$args[] = $lastElement;
		}
		
		if ( count( $args ) > 1 ) {
			$this->allowedValues = $args; 
		}
		elseif ( count( $args ) == 1 )  {
			$this->allowedValues = (array)$args[0];
		}
		else {
			// Not a lot that will pass validation in this case :D
			$this->allowedValues = array();
		}
		
		if ( !$this->careAboutCapitalization ) {
			// If case doesn't matter, lowercase everything and later on compare a lowercased value.
			$this->allowedValues = array_map( 'strtolower', $this->allowedValues );
		}
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		return in_array(
			$this->careAboutCapitalization ? $value : strtolower( $value ),
			$this->allowedValues
		);
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		global $wgLang;

		$originalCount = count( $this->allowedValues );
		
		if ( $originalCount > 15 ) {
			$allowedValues = array_slice( $this->allowedValues, 0, 13 );
			$omitCount = $originalCount - count( $allowedValues );

			return wfMsgExt(
				'validator-error-accepts-only-omitted',
				'parsemag',
				$parameter->getOriginalName(),
				$parameter->getValue(),
				$wgLang->listToText( $allowedValues ),
				$wgLang->formatNum( $omitCount )
			);			
		}
		else {
			return wfMsgExt(
				'validator_error_accepts_only',
				'parsemag',
				$parameter->getOriginalName(),
				$wgLang->listToText( $this->allowedValues ),
				count( $this->allowedValues ),
				$parameter->getValue()
			);			
		}
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		global $wgLang;

		$originalCount = count( $this->allowedValues );

		if ( $originalCount > 15 ) {
			$allowedValues = array_slice( $this->allowedValues, 0, 13 );
			$omitCount = $originalCount - count( $allowedValues );

			return wfMsgExt(
				'validator-list-error-accepts-only-omitted',
				'parsemag',
				$parameter->getOriginalName(),
				$wgLang->listToText( $allowedValues ),
				count( $allowedValues ),
				$wgLang->formatNum( $omitCount )
			);			
		}
		else {
			return wfMsgExt(
				'validator-list-error-accepts-only',
				'parsemag',
				$parameter->getOriginalName(),
				$wgLang->listToText( $this->allowedValues ),
				count( $this->allowedValues ),
				$parameter->getValue()
			);			
		}
	}
	
	/**
	 * Returns the allowed values.
	 * 
	 * @since 0.4.6
	 * 
	 * @return array
	 */
	public function getAllowedValues() {
		return $this->allowedValues;
	}
	
}