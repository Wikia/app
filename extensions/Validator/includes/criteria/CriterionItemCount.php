<?php

/**
 * Parameter criterion stating that the value must have a certain length.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file CriterionHasLength.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionItemCount extends ListParameterCriterion {
	
	protected $lowerBound;
	protected $upperBound;
	
	/**
	 * Constructor.
	 * 
	 * @param integer $lowerBound False for no lower bound (since 0.4.8).
	 * @param mixed $upperBound False for no lower bound (since 0.4.8).
	 * 
	 * @since 0.4
	 */
	public function __construct( $lowerBound, $upperBound = null ) {
		parent::__construct();
		
		$this->lowerBound = $lowerBound;
		$this->upperBound = is_null( $upperBound ) ? $lowerBound : $upperBound;
	}
	
	/**
	 * @see ParameterCriterion::validate
	 */	
	public function validate( Parameter $parameter, array $parameters) {
		$count = count( $parameter->getValue() );
		return ( $this->upperBound === false || $count <= $this->upperBound )
			&& ( $this->lowerBound === false || $count >= $this->lowerBound );
	}
	
}