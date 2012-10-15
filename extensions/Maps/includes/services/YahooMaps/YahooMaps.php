<?php

/**
 * This groupe contains all Yahoo! Maps related files of the Maps extension.
 * 
 * @defgroup MapsYahooMaps Yahoo! Maps
 * @ingroup Maps
 */

/**
 * This file holds the hook and initialization for the Yahoo! Maps service. 
 *
 * @file YahooMaps.php
 * @ingroup MapsYahooMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules['ext.maps.yahoomaps'] = array(
	'dependencies' => array( 'ext.maps.common' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/YahooMaps',	
	'group' => 'ext.maps',
	'scripts' =>   array(
		'jquery.yahoomaps.js',
		'ext.maps.yahoomaps.js'
	),
);

$wgHooks['MappingServiceLoad'][] = 'efMapsInitYahooMaps';

function efMapsInitYahooMaps() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['MapsParamYMapType'] 		= dirname( __FILE__ ) . '/Maps_ParamYMapType.php';
	$wgAutoloadClasses['MapsYahooMaps'] 			= dirname( __FILE__ ) . '/Maps_YahooMaps.php';
	
	MapsMappingServices::registerService( 
		'yahoomaps',
		'MapsYahooMaps',
		array(
			'display_point' => 'MapsBasePointMap',
			'display_map' => 'MapsBaseMap'
		)
	);	
	
	return true;
}