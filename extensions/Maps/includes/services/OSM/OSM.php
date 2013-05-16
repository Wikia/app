<?php

/**
 * This groupe contains all OSM related files of the Maps extension.
 * 
 * @defgroup OSM OpenStreetMap
 * @ingroup Maps
 */

/**
 * This file holds the hook and initialization for the OSM service. 
 *
 * @file OSM.php
 * @ingroup OSM
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['MappingServiceLoad'][] = 'efMapsInitOSM';

/**
 * Initialization function for the OSM service. 
 * 
 * @since 0.6.4
 * @ingroup OSM
 * 
 * @return true
 */
function efMapsInitOSM() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['MapsOSM'] = dirname( __FILE__ ) . '/Maps_OSM.php';
	$wgAutoloadClasses['MapsOSMDispMap'] = dirname( __FILE__ ) . '/Maps_OSMDispMap.php';
	
	MapsMappingServices::registerService( 
		'osm',
		'MapsOSM',
		array(
			'display_map' => 'MapsOSMDispMap',
		)
	);	
	
	return true;
}