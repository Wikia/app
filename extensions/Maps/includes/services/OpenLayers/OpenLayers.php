<?php

/**
 * This group contains all OpenLayers related files of the Maps extension.
 * 
 * @defgroup MapsOpenLayers OpenLayers
 */

/**
 * This file holds the hook and initialization for the OpenLayers service. 
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

call_user_func( function() {
	global $wgHooks, $wgResourceModules, $wgAutoloadClasses;

	$pathParts = ( explode( DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR, __DIR__, 2 ) );

	$wgResourceModules['ext.maps.openlayers'] = array(
		'dependencies' => array( 'ext.maps.common' ),
		'localBasePath' => __DIR__,
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => array(
			'mobile',
			'desktop'
		),
		'scripts' =>   array(
			'OpenLayers/OpenLayers.js',
			'OSM/OpenStreetMap.js',
			'jquery.openlayers.js',
			'ext.maps.openlayers.js'
		),
		'styles' => array(
			'OpenLayers/theme/default/style.css'
		),
		'messages' => array(
			'maps-markers',
			'maps-copycoords-prompt',
			'maps-searchmarkers-text',
		)
	);

	$wgAutoloadClasses['MapsOpenLayers'] = __DIR__ . '/Maps_OpenLayers.php';

	$wgHooks['MappingServiceLoad'][] = 'efMapsInitOpenLayers';
} );

function efMapsInitOpenLayers() {
	MapsMappingServices::registerService( 
		'openlayers',
		'MapsOpenLayers',
		array( 'display_map' => 'MapsDisplayMapRenderer' )
	);
	
	return true;
}