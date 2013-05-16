<?php

/**
 * Parameter criterion stating that the value must be a distance.
 * 
 * @since 0.7
 * 
 * @file CriterionIsDistance.php
 * @ingroup Maps
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsDistance extends ItemParameterCriterion {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		return MapsDistanceParser::isDistance( $value );
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-distance', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-distances', 'parsemag', $parameter->getOriginalName() );
	}	
	
}