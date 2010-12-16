<?php

/**
 * Initialization file for geocoder functionality in the Maps extension
 *
 * @file Maps_Geocoders.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Initialization class for geocoder functionality in the Maps extension. 
 * 
 * @author Jeroen De Dauw
 *
 */
final class Geocoders {  
	
	/**
	 * Initialization function for Maps geocoder functionality.
	 */
	public static function initialize() {
		global $wgAutoloadClasses, $egMapsDir, $egMapsGeoServices;
		
		$egMapsGeoServices = array();
		
		$wgAutoloadClasses['MapsBaseGeocoder'] 		= $egMapsDir . 'Geocoders/Maps_BaseGeocoder.php';
		$wgAutoloadClasses['MapsGeocoder'] 			= $egMapsDir . 'Geocoders/Maps_Geocoder.php';
		$wgAutoloadClasses['MapsGeocodeUtils'] 		= $egMapsDir . 'Geocoders/Maps_GeocodeUtils.php';
	}
	
}