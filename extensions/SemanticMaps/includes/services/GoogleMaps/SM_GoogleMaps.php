<?php

/**
 * This groupe contains all Google Maps related files of the Semantic Maps extension.
 * 
 * @defgroup SMGoogleMaps Google Maps
 * @ingroup SemanticMaps
 */

/**
 * This file holds the general information for the Google Maps service.
 *
 * @file SM_GoogleMaps.php
 * @ingroup SMGoogleMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['MappingServiceLoad'][] = 'smfInitGoogleMaps';

function smfInitGoogleMaps() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['SMGoogleMapsQP'] = dirname( __FILE__ ) . '/SM_GoogleMapsQP.php';
	
	MapsMappingServices::registerServiceFeature( 'googlemaps2', 'qp', 'SMMapPrinter' );
	
	return true;
}