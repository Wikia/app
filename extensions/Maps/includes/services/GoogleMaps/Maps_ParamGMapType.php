<?php

/**
 * Parameter manipulation ensuring the value is a Google Maps v2 map type.
 * 
 * @since 0.7
 * 
 * @file Maps_ParamGMapType.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsGoogleMaps
 * 
 * @author Jeroen De Dauw
 */
class MapsParamGMapType extends ItemParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = MapsGoogleMaps::$mapTypes[strtolower( $value )];
	}
	
}