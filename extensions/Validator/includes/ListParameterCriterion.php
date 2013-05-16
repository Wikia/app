<?php

/**
 * List parameter criterion definition class. This is for criteria
 * that apply to list parameters as a whole instead of to their
 * individual items.
 * 
 * TODO: error message support
 * 
 * @since 0.4
 * 
 * @file ListParameterCriterion.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ListParameterCriterion extends ParameterCriterion {
	
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
		return true;
	}	
	
}