<?php

/**
 * Parameter manipulation ensuring the value is a Google Maps v3 type control style.
 * 
 * @since 1.0
 * 
 * @file Maps_ParamGMap3Typestyle.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsGoogleMaps3
 * 
 * @author Jeroen De Dauw
 */
class MapsParamGMap3Typestyle extends ItemParameterManipulation {
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 1.0
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = MapsGoogleMaps3::$tyepControlStyles[strtolower( $value )];
	}
	
}