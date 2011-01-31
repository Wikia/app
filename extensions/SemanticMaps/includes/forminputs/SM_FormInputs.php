<?php

/**
 * Initialization file for form input functionality in the Maps extension
 *
 * @file SM_FormInputs.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['MappingFeatureLoad'][] = 'SMFormInputs::initialize';

final class SMFormInputs {
	
	public static function initialize() {
		global $smgDir, $wgAutoloadClasses, $sfgFormPrinter;

		// This code should not get called when SF is not loaded, but let's have this
		// check to not run into problems when people mess up the settings.
		if ( !defined( 'SF_VERSION' ) ) return true;
		
		$wgAutoloadClasses['SMFormInput'] = dirname( __FILE__ ) . '/SM_FormInput.php';
		
		$hasFormInputs = false;
		
		foreach ( MapsMappingServices::getServiceIdentifiers() as $serviceIdentifier ) {
			$service = MapsMappingServices::getServiceInstance( $serviceIdentifier );
			
			// Check if the service has a form input.
			$FIClass = $service->getFeature( 'fi' );
			
			// If the service has no FI, skipt it and continue with the next one.
			if ( $FIClass === false ) continue;
			
			// At least one form input will be enabled when this point is reached.
			$hasFormInputs = true;

			// Add the result form input type for the service name.
			self::initFormHook( $service->getName(), $service->getName() );
			
			// Loop through the service alliases, and add them as form input types.
			foreach ( $service->getAliases() as $alias ) {
				self::initFormHook( $alias, $service->getName() );
			}
		}
		
		// Add the 'map' form input type if there are mapping services that have FI's loaded.
		if ( $hasFormInputs ) self::initFormHook( 'map' );

		return true;
	}
	

	
	/**
	 * Adds a mapping service's form hook.
	 *
	 * @param string $inputName The name of the form input.
	 * @param strig $mainName
	 */
	private static function initFormHook( $inputName, $mainName = '' ) {
		global $wgAutoloadClasses, $sfgFormPrinter, $smgDir;

		// Add the form input hook for the service.
		$field_args = array();
		
		if ( $mainName != '' ) {
			$field_args['service_name'] = $mainName;
		}
		
		$sfgFormPrinter->setInputTypeHook( $inputName, 'smfSelectFormInputHTML', $field_args );
	}
	
}

/**
 * Calls the relevant form input class depending on the provided service.
 *
 * @param string $coordinates
 * @param string $input_name
 * @param boolean $is_mandatory
 * @param boolean $is_disabled
 * @param array $field_args
 * 
 * @return array
 */
function smfSelectFormInputHTML( $coordinates, $input_name, $is_mandatory, $is_disabled, array $field_args ) {
	// Get the service name from the field_args, and set it to null if it doesn't exist.
    if ( array_key_exists( 'service_name', $field_args ) ) {
        $serviceName = $field_args['service_name'];
    }
    else {
        $serviceName = null;
    }
    
	// Get the instance of the service class.
	$service = MapsMappingServices::getValidServiceInstance( $serviceName, 'fi' );
	
	// Get an instance of the class handling the current form input and service.
	$formInput = $service->getFeatureInstance( 'fi' );    
    
    // Get and return the form input HTML from the hook corresponding with the provided service.
    return $formInput->formInputHTML( $coordinates, $input_name, $is_mandatory, $is_disabled, $field_args );
}