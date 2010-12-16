<?php

/**
 * File defining the settings for the Semantic Maps extension
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Semantic_Maps#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it, 
 * and placing it in LocalSettings.php, AFTER the inclusion of Semantic Maps.
 *
 * @file SM_Settings.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}




# Map features configuration
# (named) Array of String. This array contains the available features for Maps.
# The array element name contains an abbriviation, used for code references,
# and in the service data arrays, the value is the human readible version for displaying purpouses.
$egMapsAvailableFeatures['qp'] = array(
							'name' => 'Query Printer',
							'class' => 'SMQueryPrinters',
							'file' => 'SemanticMaps/QueryPrinters/SM_QueryPrinters.php'
							);

$egMapsAvailableFeatures['fi'] = array(
							'name' => 'Form input',
							'class' => 'SMFormInputs',
							'file' => 'SemanticMaps/FormInputs/SM_FormInputs.php'
							);		





# Mapping services configuration

# Include the mapping services that should be loaded into Semantic Maps. 
# Commenting or removing a mapping service will cause Semantic Maps to completely ignore it, and so improve performance.
include_once $smgDir . 'GoogleMaps/SM_GoogleMaps.php'; 	// Google Maps
include_once $smgDir . 'OpenLayers/SM_OpenLayers.php'; 	// OpenLayers
include_once $smgDir . 'YahooMaps/SM_YahooMaps.php'; 	// Yahoo! Maps
include_once $smgDir . 'OpenStreetMap/SM_OSM.php'; 		// OpenLayers optimized for OSM

# Array of String. The default mapping service for each feature, which will be used when no valid service is provided by the user.
# Each service needs to be enabled, if not, the first one from the available services will be taken.
# Note: The default service needs to be available for the feature you set it for, since it's used as a fallback mechanism.
$egMapsDefaultServices['qp'] = 'googlemaps2';
$egMapsDefaultServices['fi'] = 'googlemaps2';





# Query Printers

# Boolean. The default value for the forceshow parameter. Will force a map to be shown even when there are no query results
# when set to true. This value will only be used when the user does not provide one.
$smgQPForceShow = false;

# Boolean. The default value for the showtitle parameter. Will hide the title in the marker pop-ups when set to true. 
# This value will only be used when the user does not provide one.
$smgQPShowTitle = true;

# String or false. Allows you to define the content and it's layout of marker pop-ups via a template.
# This value will only be used when the user does not provide one.
$smgQPTemplate = false; 
