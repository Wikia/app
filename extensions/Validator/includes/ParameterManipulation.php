<?php

/**
 * Parameter manipulation base class.
 * 
 * @since 0.4
 * 
 * @file ParameterManipulation.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
abstract class ParameterManipulation {
	
	/**
	 * Validate a parameter against the criterion.
	 * 
	 * @param Parameter $parameter
	 * @param array $parameters
	 * 
	 * @since 0.4
	 */	
	public abstract function manipulate( Parameter &$parameter, array &$parameters );
	
	/**
	 * Returns if the manipulation applies to lists as a whole.
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