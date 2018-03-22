<?php

/**
 * This group contains all Google Maps v3 related files of the Maps extension.
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

call_user_func(
	function () {
		global $wgResourceModules;

		$pathParts = explode( '/', str_replace( DIRECTORY_SEPARATOR, '/', __DIR__ ) );
		$remoteExtPath = implode( DIRECTORY_SEPARATOR, array_slice( $pathParts, -4 ) );

		$wgResourceModules['ext.maps.googlemaps3'] = [
			'dependencies' => [ 'ext.maps.common' ],
			'localBasePath' => __DIR__,
			'remoteExtPath' => $remoteExtPath,
			'group' => 'ext.maps',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'jquery.googlemap.js',
				'ext.maps.googlemaps3.js'
			],
			'messages' => [
				'maps-googlemaps3-incompatbrowser',
				'maps-copycoords-prompt',
				'maps-searchmarkers-text',
				'maps-fullscreen-button',
				'maps-fullscreen-button-tooltip',
			]
		];

		$wgResourceModules['ext.maps.gm3.markercluster'] = [
			'localBasePath' => __DIR__ . '/gm3-util-library',
			'remoteExtPath' => $remoteExtPath . '/gm3-util-library',
			'group' => 'ext.maps',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'markerclusterer.js',
			],
		];

		$wgResourceModules['ext.maps.gm3.markerwithlabel'] = [
			'localBasePath' => __DIR__ . '/gm3-util-library',
			'remoteExtPath' => $remoteExtPath  . '/gm3-util-library',
			'group' => 'ext.maps',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'markerwithlabel.js',
			],
			'styles' => [
				'markerwithlabel.css',
			],
		];

		$wgResourceModules['ext.maps.gm3.geoxml'] = [
			'localBasePath' => __DIR__ . '/geoxml3',
			'remoteExtPath' => $remoteExtPath,
			'group' => 'ext.maps' . '/geoxml3',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'geoxml3.js',
				'ZipFile.complete.js', //kmz handling
				'ProjectedOverlay.js', //Overlay handling
			],
		];

		$wgResourceModules['ext.maps.gm3.earth'] = [
			'localBasePath' => __DIR__ . '/gm3-util-library',
			'remoteExtPath' => $remoteExtPath  . '/gm3-util-library',
			'group' => 'ext.maps',
			'targets' => [
				'mobile',
				'desktop'
			],
			'scripts' => [
				'googleearth-compiled.js',
			],
		];
	}
);
