<?php

/**
 * Parameter manipulation converting the value to a wiki Title.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4.14
 * 
 * @file ParamManipulationTitle.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Daniel Werner
 */
class ParamManipulationTitle extends ItemParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4.14
	 */
	public function __construct() {
		parent::__construct();
	}	
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = Title::newFromText( trim( $value ) );
	}
	
}
