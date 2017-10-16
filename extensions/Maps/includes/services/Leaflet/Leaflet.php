<?php

/**
 * This groupe contains all Leaflet related files of the Maps extension.
 *
 * @defgroup Leaflet
 */

/**
 * This file holds the hook and initialization for the Leaflet service.
 *
 * @licence GNU GPL v2+
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */

// Check to see if we are being called as an extension or directly
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is an extension to MediaWiki and thus not a valid entry point.' );
}

call_user_func( function() {
	global $wgHooks, $wgResourceModules;

	// Specify the function that will initialize the parser function.
	$wgHooks['MappingServiceLoad'][] = 'efMapsInitLeaflet';

	$pathParts = ( explode( DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR, __DIR__, 2 ) );

	$wgResourceModules['ext.maps.leaflet'] = array(
		'dependencies' => array( 'ext.maps.common' ),
		'localBasePath' => __DIR__,
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' => array(
			'jquery.leaflet.js',
			'ext.maps.leaflet.js',
		),
		'messages' => array(
			'maps-markers',
			'maps-copycoords-prompt',
			'maps-searchmarkers-text',
		),
	);
} );

/**
 * Initialization function for the Leaflet service.
 *
 * @ingroup Leaflet
 *
 * @return boolean true
 */
function efMapsInitLeaflet() {
	global $wgAutoloadClasses;

	$wgAutoloadClasses['MapsLeaflet'] = __DIR__ . '/Maps_Leaflet.php';

	MapsMappingServices::registerService( 'leaflet', 'MapsLeaflet' );
	$leafletMaps = MapsMappingServices::getServiceInstance( 'leaflet' );
	$leafletMaps->addFeature( 'display_map', 'MapsDisplayMapRenderer' );

	return true;
}
