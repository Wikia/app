<?php

/**
 * Parameter criterion base class.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file ParameterCriterion.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParameterCriterion {
	
	/**
	 * Validate a parameter against the criterion.
	 * 
	 * @param Parameter $parameter
	 * @param array $parameters
	 * 
	 * @since 0.4
	 * 
	 * @return CriterionValidationResult
	 */	
	public abstract function validate( Parameter $parameter, array $parameters );
	
	/**
	 * Returns if the criterion applies to lists as a whole.
	 * 
	 * @since 0.4
	 * 
	 * @return boolean
	 */	
	public abstract function isForLists();		
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		
	}
	
}