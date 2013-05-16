<?php

/**
 * Parameter criterion stating that the value must have a certain length.
 * 
 * @since 0.4
 * 
 * @file CriterionHasLength.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionUniqueItems extends ListParameterCriterion {
	
	/**
	 * If the values should match case.
	 * 
	 * @since 0.4.2
	 * 
	 * @var boolean
	 */
	protected $careAboutCapitalization;	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct( $careAboutCapitalization = false ) {
		parent::__construct();
		
		$this->careAboutCapitalization = $careAboutCapitalization;
	}
	
	/**
	 * @see ParameterCriterion::validate
	 */	
	public function validate( Parameter $parameter, array $parameters ) {
		return count( $parameter->getValue() ) 
			== count( array_unique( 
				$this->careAboutCapitalization ? $parameter->getValue() : array_map( 'strtolower', $parameter->getValue() )
			) ); 
	}
	
}