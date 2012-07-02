<?php

/**
 * Parameter criterion stating that the value must be map dimension.
 * 
 * @since 0.7
 * 
 * @file CriterionMapDimension.php
 * @ingroup Maps
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionMapDimension extends ItemParameterCriterion {
	
	/**
	 * Indicates if the prarameter is for width or height.
	 * 
	 * @since 0.7
	 * 
	 * @var string
	 */
	protected $dimension;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct( $dimension ) {
		parent::__construct();
		
		$this->dimension = $dimension;
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		global $egMapsSizeRestrictions;

		if ( $value == 'auto' && $this->dimension == 'width' ) {
			return true;
		}		
		
		// See if the notation is valid.
		if ( !preg_match( '/^\d+(\.\d+)?(px|ex|em|%)?$/', $value ) ) {
			return false;
		}

		// Determine the minimum and maximum values.
		if ( preg_match( '/^.*%$/', $value ) ) {
			if ( count( $egMapsSizeRestrictions[$this->dimension] ) >= 4 ) {
				$min = $egMapsSizeRestrictions[$this->dimension][2];
				$max = $egMapsSizeRestrictions[$this->dimension][3];
			} else {
				// This is for backward compatibility with people who have set a custom min and max before 0.6.
				$min = 1;
				$max = 100;
			}
		} else {
			$min = $egMapsSizeRestrictions[$this->dimension][0];
			$max = $egMapsSizeRestrictions[$this->dimension][1];
		}

		// See if the actual value is withing the limits.
		$number = preg_replace( '/[^0-9]/', '', $value );

		return $number >= $min && $number <= $max;
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( "validation-error-invalid-$this->dimension", 'parsemag', $parameter->getOriginalName() );
	}
	
}