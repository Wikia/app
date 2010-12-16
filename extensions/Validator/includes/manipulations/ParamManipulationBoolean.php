<?php

/**
 * Parameter manipulation converting the value to a boolean.
 * 
 * @since 0.4
 * 
 * @file ParamManipulationBoolean.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class ParamManipulationBoolean extends ItemParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct();
	}	
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.4
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = in_array( $value, array( 'yes', 'on' ) );
	}
	
}