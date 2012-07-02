<?php

/**
 * This groupe contains all Google Maps related files of the UK Geocoding for Maps extension.
 * 
 * @ingroup UKGeocodingForMaps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$egMapsServices[MapsGoogleMaps::SERVICE_NAME]['features']['display_uk_point'] = 'UKGGoogleMapsDispUkPoint';

$wgAutoloadClasses['UKGGoogleMapsDispUkPoint'] = dirname( __FILE__ ) . '/UKG_GoogleMapsDispUkPoint.php';