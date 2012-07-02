<?php

/**
 * Parameter manipulation ensuring the value is a Google Maps v3 map type.
 * 
 * @since 0.7
 * 
 * @file Maps_ParamGMap3Type.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsGoogleMaps3
 * 
 * @author Jeroen De Dauw
 */
class MapsParamGMap3Type extends ItemParameterManipulation {
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = MapsGoogleMaps3::$mapTypes[strtolower( $value )];
	}
	
}