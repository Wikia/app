<?php

/**
 * Google Maps v3 form input class for multiple locations.
 *
 * @since 1.0
 * @file SM_GoogleMaps3MultiInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMGoogleMaps3MultiInput extends SMFormInput {
	
	/**
	 * @see SMFormInput::getResourceModules
	 * 
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	protected function getResourceModules() {
		return array_merge( parent::getResourceModules(), array( 'ext.sm.fi.googlemaps3.multi' ) );
	}
	
	public static function onInputRequest( $coordinates, $input_name, $is_mandatory, $is_disabled, array $field_args ) {
		$formInput = new self( MapsMappingServices::getServiceInstance( 'googlemaps3' ) );
	    return $formInput->getInputOutput( $coordinates, $input_name, $is_mandatory, $is_disabled, $field_args );		
	}
	
	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 1.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return mixed
	 */	
	protected function getJSONObject( array $params, Parser $parser ) {
		$params['ismulti'] = true;
		
		return $params;
	}	
	
}
