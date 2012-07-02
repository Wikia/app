<?php

/**
 * This groupe contains all Google Maps v2 related files of the Maps extension.
 * 
 * @defgroup MapsGoogleMaps Google Maps v2
 * @ingroup Maps
 */

/**
 * This file holds the hook and initialization for the Google Maps v2 service. 
 *
 * @file GoogleMaps.php
 * @ingroup MapsGoogleMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules['ext.maps.googlemaps2'] = array(
	'dependencies' => array( 'ext.maps.common' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps',	
	'group' => 'ext.maps',
	'scripts' => array(
		'jquery.googlemap2.js',
		'ext.maps.googlemaps2.js',
	),
	'styles' => array(
		//'ext.maps.googlemaps2.css',
	),
	'messages' => array(
		'maps-markers',
		'maps_overlays',
		'maps_photos',
		'maps_videos',
		'maps_wikipedia',
		'maps_webcams',
		'maps-googlemaps2-incompatbrowser'
	)
);

$wgHooks['MappingServiceLoad'][] = 'efMapsInitGoogleMaps';

/**
 * Initialization function for the Google Maps v2 service. 
 * 
 * @since 0.6.3
 * @ingroup MapsGoogleMaps
 * 
 * @return true
 */
function efMapsInitGoogleMaps() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['MapsGoogleMaps'] 			= dirname( __FILE__ ) . '/Maps_GoogleMaps.php';
	$wgAutoloadClasses['CriterionGoogleOverlay'] 	= dirname( __FILE__ ) . '/CriterionGoogleOverlay.php';
	$wgAutoloadClasses['MapsParamGMapType']		 	= dirname( __FILE__ ) . '/Maps_ParamGMapType.php';
	
	MapsMappingServices::registerService( 'googlemaps2', 'MapsGoogleMaps' );
	$googleMaps = MapsMappingServices::getServiceInstance( 'googlemaps2' );
	$googleMaps->addFeature( 'display_point', 'MapsBasePointMap' );
	$googleMaps->addFeature( 'display_map', 'MapsBaseMap' );
	
	return true;
}
