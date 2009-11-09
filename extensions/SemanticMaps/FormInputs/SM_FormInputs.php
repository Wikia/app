<?php

/**
 * Initialization file for form input functionality in the Maps extension
 *
 * @file SM_FormInputs.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMFormInputs {
	
	public static function initialize() {
		global $smgIP, $wgAutoloadClasses, $egMapsServices, $sfgFormPrinter;

		$wgAutoloadClasses['SMFormInput'] 	= $smgIP . '/FormInputs/SM_FormInput.php';
		
		// This feature can only be enbled when Semantic Forms is loaded.
		if (isset($sfgFormPrinter)) {
			$hasFormInputs = false;
			
			foreach($egMapsServices as $serviceName => $serviceData) {
				// Check if the service has a form input
				$hasFI = array_key_exists('fi', $serviceData);
				
				// If the service has no FI, skipt it and continue with the next one.
				if (!$hasFI) continue;
				
				// At least one form input will be enabled when this point is reached.
				$hasFormInputs = true;			

				// Add the result form input type for the service name.
				self::initFormHook($serviceName, $serviceData['fi']);
				
				// Loop through the service alliases, and add them as form input types.
				foreach ($serviceData['aliases'] as $alias) self::initFormHook($alias, $serviceData['fi'], $serviceName);
			}		
			
			// Add the 'map' form input type if there are mapping services that have FI's loaded.
			if ($hasFormInputs) self::initFormHook('map');	

		}

	}
	
	/**
	 * Adds a mapping service's form hook
	 *
	 * @param string $service
	 * @param array $fi
	 * @param strig $mainName
	 */
	private static function initFormHook($service, array $fi = null, $mainName = '') {
		global $wgAutoloadClasses, $sfgFormPrinter, $smgIP;
	
		if (isset($fi)) {
			if (! array_key_exists($fi['class'], $wgAutoloadClasses)) {
				$file = $fi['local'] ? $smgIP . '/' . $fi['file'] : $fi['file'];
				$wgAutoloadClasses[$fi['class']] = $file;
			}
		}
		
		// Add the form input hook for the service
		$field_args = array();
		if (strlen($mainName) > 0) $field_args['service_name'] = $mainName;
		$sfgFormPrinter->setInputTypeHook($service, 'smfSelectFormInputHTML', $field_args);
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
    
    $formInput = new $egMapsServices[$service_name]['fi']['class']();
    
    // Get and return the form input HTML from the hook corresponding with the provided service
    return $formInput->formInputHTML($coordinates, $input_name, $is_mandatory, $is_disabled, $field_args);
    
}