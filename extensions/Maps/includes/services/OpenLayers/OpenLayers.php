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

call_user_func(
	function () {
		global $wgResourceModules;

		$pathParts = explode( '/', str_replace( DIRECTORY_SEPARATOR, '/', __DIR__ ) );
		$remoteExtPath = implode( DIRECTORY_SEPARATOR, array_slice( $pathParts, -4 ) );

		$wgResourceModules['ext.maps.openlayers'] = [
			'dependencies' => [ 'ext.maps.common' ],
			'localBasePath' => __DIR__,
			'remoteExtPath' => $remoteExtPath,
			'group' => 'ext.maps',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'OpenLayers/OpenLayers.js',
				'OSM/OpenStreetMap.js',
				'jquery.openlayers.js',
				'ext.maps.openlayers.js'
			],
			'styles' => [
				'OpenLayers/theme/default/style.css'
			],
			'messages' => [
				'maps-markers',
				'maps-copycoords-prompt',
				'maps-searchmarkers-text',
			]
		];
	}
);
