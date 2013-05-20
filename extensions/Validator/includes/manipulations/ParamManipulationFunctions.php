<?php

/**
 * Parameter manipulation for assigning the value to the result of one
 * or more functions with as only argument the value itself.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4.2
 * 
 * @file ParamManipulationFunctions.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class ParamManipulationFunctions extends ItemParameterManipulation {
	
	/**
	 * The names of functions to apply.
	 * 
	 * @since 0.4.2
	 * 
	 * @var array of callbacks
	 */
	protected $functions = array();
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4.2
	 * 
	 * You can provide an array with function names or pass each function name as a separate argument.
	 */
	public function __construct() {
		parent::__construct();
		
		$args = func_get_args();
		
		if ( count( $args ) > 0 ) {
			$this->functions = is_array( $args[0] ) ? $args[0] : $args;
		}
	}	
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.4.2
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		foreach ( $this->functions as $function ) {
			$value = call_user_func( $function, $value );
		}
	}
	
}