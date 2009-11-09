<?php

/**
 * Factory method for form input handling classes
 *
 * @file SM_FormInputFactory.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw 
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SMFormInputFactory {

	public static function getFormInputHtml() {
	global $egMapsServices;
	
	// If service_name is set, use this value, and ignore any given
	// service parameters
	// This will prevent ..input type=googlemaps|service=yahoo.. from
	// showing up as a Yahoo! Maps map
	if (array_key_exists('service_name', $field_args)) {
		$service_name = $field_args['service_name'];
	}
	elseif (array_key_exists('service', $field_args)) {
		$service_name = $field_args['service'];
	}
	else{
		$service_name = null;
	}
	
	$service_name = MapsMapper::getValidService($service_name, 'fi');
	
	$formInput = self::getFormInputInstance(); 
	
	// Get and return the form input HTML from the hook corresponding with the provided service
	return $formInput->formInputHTML($coordinates, $input_name, $is_mandatory, $is_disabled, $field_args);		
	}
	
	private static function getFormInputInstance($serviceName) {
		return new $egMapsServices[$service_name]['fi']['class']();
	}
	
}

/**
 * Class for the form input type 'map'. The relevant form input class is called depending on the provided service.
 *
 * @param unknown_type $coordinates
 * @param unknown_type $input_name
 * @param unknown_type $is_mandatory
 * @param unknown_type $is_disabled
 * @param array $field_args
 * @return unknown
 */
function smfSelectFormInputHTML($coordinates, $input_name, $is_mandatory, $is_disabled, array $field_args) {

}