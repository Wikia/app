<?php

/**
 * File holding the SPSIterator class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

	define('SPS_OPTIONAL', 0);
	define('SPS_MANDATORY', 1);
	
/**
 * The SPSIterator class.
 *
 * @ingroup SemanticPageSeries
 */
abstract class SPSIterator {

	/**
	 * @return array An array containing the names of the parameters this iterator uses.
	 */
	abstract function getParameterNames();
	
	/**
	 * @return an array of the values to be used in the target field of the target form
	 */
	abstract function getValues ( &$data );
	
}
