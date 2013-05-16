<?php

/**
 * List parameter manipulation base class. This is for manipulations
 * that apply to list parameters as a whole instead of to their
 * individual items.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file ListParameterManipulation.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ListParameterManipulation extends ParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ParameterManipulation::isForLists
	 */
	public function isForLists() {
		return true;
	}		
	
}