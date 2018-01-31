<?php

/**
 * Definition of Maps resource loader modules.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner < daniel.a.r.werner@gmail.com >
 *
 * @codeCoverageIgnoreStart
 */
return call_user_func( function() {

	$pathParts = explode( '/', str_replace( DIRECTORY_SEPARATOR, '/', __DIR__ ) );

	$moduleTemplate = [
		'position' => 'top',
		'localBasePath' => __DIR__ . '/includes',
		'remoteExtPath' =>  end( $pathParts ) . '/includes',
		'group' => 'ext.maps',
		'targets' => [
			'mobile',
			'desktop'
		]
	];

	return [
		'ext.maps.common' => $moduleTemplate + [
			'messages' => [
				'maps-load-failed',
			] ,
			'scripts' => [
				'ext.maps.common.js',
			],
		],

		'ext.maps.coord' => $moduleTemplate + [
			'messages' => [
				'maps-abb-north',
				'maps-abb-east',
				'maps-abb-south',
				'maps-abb-west',
			],
			'scripts' => [
				'ext.maps.coord.js'
			],
		],

		'ext.maps.resizable' => $moduleTemplate + [
			'dependencies' => 'jquery.ui.resizable',
		],

		'mapeditor' => $moduleTemplate + [
			'scripts' => [
				'editor/js/jquery.miniColors.js',
				'editor/js/mapeditor.iefixes.js',
				'editor/js/mapeditor.js',
			],
			'styles' => [
				'editor/css/jquery.miniColors.css',
				'editor/css/mapeditor.css',
			],
			'messages' => [
				'mapeditor-parser-error',
				'mapeditor-none-text',
				'mapeditor-done-button',
				'mapeditor-remove-button',
				'mapeditor-import-button',
				'mapeditor-export-button',
				'mapeditor-import-button2',
				'mapeditor-select-button',
				'mapeditor-mapparam-button',
				'mapeditor-clear-button',
				'mapeditor-imageoverlay-button',
			],
			'dependencies' => [
				'ext.maps.common',
				'jquery.ui.autocomplete',
				'jquery.ui.slider',
				'jquery.ui.dialog',
			],
		],

		'ext.maps.services' => $moduleTemplate + [
			'group' => 'ext.maps',
			'scripts' => [
				'ext.maps.services.js',
			],
			'dependencies' => [
				'ext.maps.common',
				'ext.maps.coord'
			]
		]
	];

} );
// @codeCoverageIgnoreEnd
