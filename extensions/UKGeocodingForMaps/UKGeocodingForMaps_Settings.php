<?php

/**
 * File defining the settings for the UK Geocoding for Maps extension
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it, 
 * and placing it in LocalSettings.php, AFTER the inclusion of UK Geocoding for Maps.
 *
 * @file UKGeocodingForMaps_Settings.php
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# Include the parser functions that should be loaded into Maps.
# Commenting or removing a parser functions will cause Maps to completely ignore it, and so improve performance.
include_once $ukggDir . 'ParserFunctions/DisplayUkPoint/UKG_DisplayUkPoint.php';		// display_uk_point	

# Include the mapping services that should be loaded into Maps. 
# Commenting or removing a mapping service will cause Semantic Maps to completely ignore it, and so improve performance.
include_once $ukggDir . 'GoogleMaps/UKG_GoogleMaps.php'; 	// Google Maps

# Your Google AJAX search API key. Required for displaying Google Maps with the display_uk_point(s) parser function.
$egGoogleAjaxSearchKey = ''; # http://code.google.com/apis/ajaxsearch/signup.html

$egMapsDefaultServices['display_uk_point'] = 'googlemaps2';