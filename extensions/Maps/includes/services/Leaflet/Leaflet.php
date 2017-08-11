<?php

/**
 * This group contains all Leaflet related files of the Maps extension.
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
	global $wgResourceModules;

	$pathParts = ( explode( DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR, __DIR__, 2 ) );

	$wgResourceModules['ext.maps.leaflet'] = [
		'dependencies' => [ 'ext.maps.common' ],
		'localBasePath' => __DIR__,
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => [
			'mobile',
			'desktop'
		],
		'scripts' => [
			'jquery.leaflet.js',
			'ext.maps.leaflet.js',
		],
		'messages' => [
			'maps-markers',
			'maps-copycoords-prompt',
			'maps-searchmarkers-text',
		],
	];

	$wgResourceModules['ext.maps.leaflet.fullscreen'] = [
		'localBasePath' => __DIR__ . '/leaflet.fullscreen',
		'remoteExtPath' => end( $pathParts ) . '/leaflet.fullscreen',
		'group' => 'ext.maps',
		'targets' => [
			'mobile',
			'desktop'
		],
		'scripts' => [
			'Control.FullScreen.js',
		],
		'styles' => [
			'Control.FullScreen.css',
		],
	];

	$wgResourceModules['ext.maps.leaflet.markercluster'] = [
		'localBasePath' => __DIR__ . '/leaflet.markercluster',
		'remoteExtPath' => end( $pathParts ),
		'group' => 'ext.maps',
		'targets' => [
			'mobile',
			'desktop'
		],
		'scripts' => [
			'leaflet.markercluster.js',
		],
		'styles' => [
			'MarkerCluster.css',
		],
	];

	$wgResourceModules['ext.maps.leaflet.providers'] = [
		'localBasePath' => __DIR__ . '/leaflet-providers',
		'remoteExtPath' => end( $pathParts ) . '/leaflet-providers',
		'group' => 'ext.maps',
		'targets' => [
			'mobile',
			'desktop'
		],
		'scripts' => [
			'leaflet-providers.js',
		],
	];
} );
