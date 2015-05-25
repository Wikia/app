<?php

/**
 * This group contains all Google Maps v3 related files of the Semantic Maps extension.
 * 
 * @defgroup SMGoogleMaps3 Google Maps v3
 * @ingroup SMGoogleMaps3
 */

/**
 * This file holds the general information for the Google Maps v3 service.
 *
 * @since 1.0
 *
 * @file SM_GoogleMaps3.php
 * @ingroup SMGoogleMaps3
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$moduleTemplate = array(
	'localBasePath' => __DIR__,
	'remoteBasePath' => $smgScriptPath .  '/includes/services/GoogleMaps3',	
	'group' => 'ext.semanticmaps',
);

$wgResourceModules['ext.sm.fi.googlemaps3'] = $moduleTemplate + array(
	'dependencies' => array(
		'ext.sm.fi.googlemaps3.single',
	),
	'scripts' => array(
		'ext.sm.googlemapsinput.js',
	),
);

$wgResourceModules['ext.sm.fi.googlemaps3.single'] = $moduleTemplate + array(
	'dependencies' => array(
		'ext.maps.googlemaps3',
		'ext.sm.forminputs',
	),
	'scripts' => array(
		'jquery.googlemapsinput.js',
	),
	'messages' => array(
	)
);
/*
$wgResourceModules['ext.sm.fi.googlemaps3.multi'] = $moduleTemplate + array(
	'dependencies' => array( 'ext.sm.fi.googlemaps3', 'jquery.ui.button', 'jquery.ui.dialog' ),
	'localBasePath' => __DIR__,
	'scripts' => array(
		'jquery.gmapsmultiinput.js',
	),
	'messages' => array(
		'semanticmaps-forminput-remove',
		'semanticmaps-forminput-add',
		'semanticmaps-forminput-locations'
	)
);
*/
unset( $moduleTemplate );

$wgHooks['MappingServiceLoad'][] = 'smfInitGoogleMaps3';

function smfInitGoogleMaps3() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['SMGoogleMaps3FormInput'] = __DIR__ . '/SM_GoogleMaps3FormInput.php';
	//$wgAutoloadClasses['SMGoogleMaps3MultiInput'] = __DIR__ . '/SM_GoogleMaps3MultiInput.php';
	
	MapsMappingServices::registerServiceFeature( 'googlemaps3', 'qp', 'SMMapPrinter' );
	MapsMappingServices::registerServiceFeature( 'googlemaps3', 'fi', 'SMGoogleMaps3FormInput' );
	
	//$sfgFormPrinter->setInputTypeHook( 'googlemapsmulti', array( 'SMGoogleMaps3MultiInput', 'onInputRequest' ), array() );
	
	return true;
}
