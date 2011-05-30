<?php

/**
 * Parameter manipulation converting the value to a string.
 * 
 * @since 0.4.5
 * 
 * @file ParamManipulationString.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class ParamManipulationString extends ItemParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4.5
	 */
	public function __construct() {
		parent::__construct();
	}	
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.4.5
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = (string)$value;
	}
	
}