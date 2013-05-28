<?php

/**
 * This groupe contains all Google Maps v3 related files of the Maps extension.
 * 
 * @defgroup MapsGoogleMaps3 Google Maps v3
 * @ingroup Maps
 */

/**
 * This file holds the hook and initialization for the Google Maps v3 service. 
 *
 * @file GoogleMaps3.php
 * @ingroup MapsGoogleMaps3
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules['ext.maps.googlemaps3'] = array(
	'dependencies' => array( 'ext.maps.common' ),
	'localBasePath' => __DIR__,
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3',	
	'group' => 'ext.maps',
	'scripts' => array(
		'jquery.googlemap.js',
		'ext.maps.googlemaps3.js'
	),
	'messages' => array(
		'maps-googlemaps3-incompatbrowser',
		'maps-copycoords-prompt',
		'maps-searchmarkers-text'
	)
);

$wgResourceModules['ext.maps.gm3.markercluster'] = array(
	'localBasePath' => __DIR__ . '/gm3-util-library',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/gm3-util-library',
	'group' => 'ext.maps',
	'scripts' => array(
		'markerclusterer.js',
	),
);

$wgResourceModules['ext.maps.gm3.markerwithlabel'] = array(
	'localBasePath' => __DIR__ . '/gm3-util-library',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/gm3-util-library',
	'group' => 'ext.maps',
	'scripts' => array(
		'markerwithlabel.js',
	),
	'styles' => array(
		'markerwithlabel.css',
	),
);

$wgResourceModules['ext.maps.gm3.geoxml'] = array(
	'localBasePath' => __DIR__ . '/geoxml3',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/geoxml3',
	'group' => 'ext.maps',
	'scripts' => array(
		'geoxml3.js',
		'ZipFile.complete.js', //kmz handling
	),
);

$wgResourceModules['ext.maps.gm3.earth'] = array(
	'localBasePath' => __DIR__ . '/gm3-util-library',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/gm3-util-library',
	'group' => 'ext.maps',
	'scripts' => array(
		'googleearth-compiled.js',
	),
);

$wgHooks['MappingServiceLoad'][] = 'efMapsInitGoogleMaps3';

/**
 * Initialization function for the Google Maps v3 service. 
 * 
 * @since 0.6.3
 * @ingroup MapsGoogleMaps3
 * 
 * @return true
 */
function efMapsInitGoogleMaps3() {
	global $wgAutoloadClasses;

	$wgAutoloadClasses['MapsGoogleMaps3'] 			= __DIR__ . '/Maps_GoogleMaps3.php';
	$wgAutoloadClasses['MapsParamGMap3Type']		= __DIR__ . '/Maps_ParamGMap3Type.php';
	$wgAutoloadClasses['MapsParamGMap3Types']		= __DIR__ . '/Maps_ParamGMap3Types.php';
	$wgAutoloadClasses['MapsParamGMap3Typestyle']	= __DIR__ . '/Maps_ParamGMap3Typestyle.php';
	$wgAutoloadClasses['MapsParamGMap3Zoomstyle']	= __DIR__ . '/Maps_ParamGMap3Zoomstyle.php';

	MapsMappingServices::registerService( 'googlemaps3', 'MapsGoogleMaps3' );
	$googleMaps = MapsMappingServices::getServiceInstance( 'googlemaps3' );	
	$googleMaps->addFeature( 'display_map', 'MapsDisplayMapRenderer' );

	return true;
}
