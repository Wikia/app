<?php

/**
 * This groupe contains all Google Maps v3 related files of the Maps extension.
 * 
 * @defgroup MapsGoogleMaps3 Google Maps v3
 */

/**
 * This file holds the hook and initialization for the Google Maps v3 service. 
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

call_user_func( function() {
	global $wgResourceModules, $wgHooks;

	$pathParts = ( explode( DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR, __DIR__, 2 ) );

	$wgResourceModules['ext.maps.googlemaps3'] = array(
		'dependencies' => array( 'ext.maps.common' ),
		'localBasePath' => __DIR__,
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'jquery.googlemap.js',
			'ext.maps.googlemaps3.js'
		),
		'messages' => array(
			'maps-googlemaps3-incompatbrowser',
			'maps-copycoords-prompt',
			'maps-searchmarkers-text',
			'maps-fullscreen-button',
			'maps-fullscreen-button-tooltip',
		)
	);

	$wgResourceModules['ext.maps.gm3.markercluster'] = array(
		'localBasePath' => __DIR__ . '/gm3-util-library',
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'markerclusterer.js',
		),
	);

	$wgResourceModules['ext.maps.gm3.markerwithlabel'] = array(
		'localBasePath' => __DIR__ . '/gm3-util-library',
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'markerwithlabel.js',
		),
		'styles' => array(
			'markerwithlabel.css',
		),
	);

	$wgResourceModules['ext.maps.gm3.geoxml'] = array(
		'localBasePath' => __DIR__ . '/geoxml3',
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'geoxml3.js',
			'ZipFile.complete.js', //kmz handling
			'ProjectedOverlay.js', //Overlay handling
		),
	);

	$wgResourceModules['ext.maps.gm3.earth'] = array(
		'localBasePath' => __DIR__ . '/gm3-util-library',
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'googleearth-compiled.js',
		),
	);

	$wgHooks['MappingServiceLoad'][] = 'efMapsInitGoogleMaps3';
} );

/**
 * Initialization function for the Google Maps v3 service. 
 * 
 * @since 0.6.3
 * @ingroup MapsGoogleMaps3
 * 
 * @return boolean true
 */
function efMapsInitGoogleMaps3() {
	global $wgAutoloadClasses;

	$wgAutoloadClasses['MapsGoogleMaps3'] = __DIR__ . '/Maps_GoogleMaps3.php';

	MapsMappingServices::registerService( 'googlemaps3', 'MapsGoogleMaps3' );

	// TODO: kill below code
	$googleMaps = MapsMappingServices::getServiceInstance( 'googlemaps3' );
	$googleMaps->addFeature( 'display_map', 'MapsDisplayMapRenderer' );

	return true;
}
