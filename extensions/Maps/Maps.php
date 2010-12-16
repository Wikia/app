<?php

/**  
 * Initialization file for the Maps extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Maps
 *
 * @file Maps.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to Maps.
 *
 * Please do not use this group name for other code. If you have an extension to 
 * Maps, please use your own group defenition.
 *  
 * @defgroup Maps Maps
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for Maps to work.
if( !defined( 'Validator_VERSION' ) ) {
	@include_once('extensions/Validator/Validator.php');		
}

// Only initialize the extension when all dependencies are present.
if (! defined( 'Validator_VERSION' )) {
	echo '<b>Warning:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a>.';
}
else {
	define('Maps_VERSION', '0.5.4 a3');
	
	// TODO: try to get out the hardcoded path.
	$egMapsScriptPath 	= $wgScriptPath . '/extensions/Maps';
	$egMapsDir 			= dirname( __FILE__ ) . '/';
	
	$egMapsStyleVersion = $wgStyleVersion . '-' . Maps_VERSION;
	
	// Include the settings file
	require_once($egMapsDir . 'Maps_Settings.php');
	
	// Register the initialization function of Maps.
	$wgExtensionFunctions[] = 'efMapsSetup'; 
	
	$wgExtensionMessagesFiles['Maps'] = $egMapsDir . 'Maps.i18n.php';
	
	$wgHooks['AdminLinks'][] = 'efMapsAddToAdminLinks';
	
	// Autoload the general classes
	$wgAutoloadClasses['MapsMapFeature'] 			= $egMapsDir . 'Maps_MapFeature.php';
	$wgAutoloadClasses['MapsMapper'] 				= $egMapsDir . 'Maps_Mapper.php';
	$wgAutoloadClasses['MapsUtils'] 				= $egMapsDir . 'Maps_Utils.php';
}

/**
 * Initialization function for the Maps extension.
 */
function efMapsSetup() {
	global $wgExtensionCredits, $wgLang, $wgAutoloadClasses, $IP;	
	global $egMapsDefaultService, $egMapsAvailableServices, $egMapsServices, $egMapsDefaultGeoService, $egMapsAvailableGeoServices, $egMapsDir, $egMapsAvailableFeatures;

	// Remove all hooked in services that should not be available.
	foreach($egMapsServices as $service => $data) {
		if (! in_array($service, $egMapsAvailableServices)) unset($egMapsServices[$service]);
	}
	
	// Enure that the default service and geoservice are one of the enabled ones.
	$egMapsDefaultService = in_array($egMapsDefaultService, $egMapsAvailableServices) ? $egMapsDefaultService : $egMapsAvailableServices[0];
	if (!in_array($egMapsDefaultGeoService, $egMapsAvailableGeoServices)) {
		reset($egMapsAvailableGeoServices);
		$egMapsDefaultGeoService = key($egMapsAvailableGeoServices);
	}
	
	wfLoadExtensionMessages( 'Maps' ); 
	
	// Creation of a list of internationalized service names.
	$services = array();
	foreach (array_keys($egMapsServices) as $name) $services[] = wfMsg('maps_'.$name);
	$services_list = $wgLang->listToText($services);
	
	$wgExtensionCredits['parserhook'][] = array(
		'path' => __FILE__,
		'name' => wfMsg('maps_name'),
		'version' => Maps_VERSION,
		'author' => array('[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]', '[http://www.mediawiki.org/wiki/User:Yaron_Koren Yaron Koren]', 'others'),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Maps',
		'description' =>  wfMsgExt( 'maps_desc', 'parsemag', $services_list ),
		'descriptionmsg' => wfMsgExt( 'maps_desc', 'parsemag', $services_list ),
	);

	MapsMapper::initializeMainParams();

	// Loop through the available mapping features, load and initialize them.
	foreach($egMapsAvailableFeatures as $key => $values) {
		// Load and optionally initizlize feature.
		if (array_key_exists('class', $values) && array_key_exists('file', $values)) {
			$wgAutoloadClasses[$values['class']] = array_key_exists('local', $values) && $values['local'] ? $egMapsDir . $values['file'] : $IP . '/extensions/' . $values['file'];
			if (method_exists($values['class'], 'initialize')) call_user_func(array($values['class'], 'initialize'));
		}
	}

	// Loop through the available mapping services to load and initialize their general classes.
	foreach ($egMapsServices as $serviceData) {
		if (array_key_exists('classes', $serviceData)) {
			foreach($serviceData['classes'] as $class) {
				$file = array_key_exists('local', $class) && $class['local'] ? $egMapsDir . $class['file'] : $IP . '/extensions/' . $class['file'];
				$wgAutoloadClasses[$class['class']] = $file;
				if (method_exists($class['class'], 'initialize')) call_user_func(array($class['class'], 'initialize'));
			}
		}
	}
	
	return true;
}

/**
 * Adds a link to Admin Links page
 */
function efMapsAddToAdminLinks(&$admin_links_tree) {
    $displaying_data_section = $admin_links_tree->getSection(wfMsg('smw_adminlinks_displayingdata'));
    
    // Escape if SMW hasn't added links
    if (is_null($displaying_data_section)) return true;
    $smw_docu_row = $displaying_data_section->getRow('smw');
    
    $maps_docu_label = wfMsg('adminlinks_documentation', wfMsg('maps_name'));
    $smw_docu_row->addItem(AlItem::newFromExternalLink('http://www.mediawiki.org/wiki/Extension:Maps', $maps_docu_label));

    return true;
}