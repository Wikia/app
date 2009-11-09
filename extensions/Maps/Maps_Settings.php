<?php

/**
 * File defining the settings for the Maps extension
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Maps#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it, 
 * and placing it in LocalSettings.php, AFTER the inclusion of Maps.
 *
 * @file Maps_Settings.php
 * @ingroup Maps
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
if (empty($egMapsAvailableFeatures)) $egMapsAvailableFeatures = array();

$egMapsAvailableFeatures['geocode'] = array(
							'name' => 'Geocoding',
							'class' => 'Geocoders',
							'file' => 'Geocoders/Maps_Geocoders.php',
							'local' => true,
							);

$egMapsAvailableFeatures['pf'] = array(
							'name' => 'Parser Functions',
							'class' => 'MapsParserFunctions',
							'file' => 'ParserFunctions/Maps_ParserFunctions.php',
							'local' => true,
							);





# Include the parser functions that should be loaded into Maps.
# Commenting or removing a parser functions will cause Maps to completely ignore it, and so improve performance.
include_once $egMapsIP . '/ParserFunctions/DisplayMap/Maps_DisplayMap.php';		// display_map	
include_once $egMapsIP . '/ParserFunctions/DisplayPoint/Maps_DisplayPoint.php';	// display_point(s)
include_once $egMapsIP . '/ParserFunctions/Geocode/Maps_GeocodeFunctions.php';	// geocode, geocodelon, geocodelat





# Map services configuration
# Note: You can not use aliases in the settings. Use the main service names.

# Include the mapping services that should be loaded into Maps. 
# Commenting or removing a mapping service will cause Maps to completely ignore it, and so improve performance.
include_once $egMapsIP . '/GoogleMaps/Maps_GoogleMaps.php'; 	// Google Maps
include_once $egMapsIP . '/OpenLayers/Maps_OpenLayers.php'; 	// OpenLayers
include_once $egMapsIP . '/YahooMaps/Maps_YahooMaps.php'; 		// Yahoo! Maps
include_once $egMapsIP . '/OpenStreetMaps/Maps_OSM.php'; 		// OpenLayers optimized for OSM
							
# Array of String. Array containing all the mapping services that will be made available to the user.
# Currently Maps provides the following services: googlemaps, yahoomaps, openlayers
$egMapsAvailableServices = array('googlemaps', 'yahoomaps', 'openlayers', 'osm');

# String. The default mapping service, which will be used when no default service is prsent in the
# $egMapsDefaultServices array for a certain feature. A service that supports all features is recommended.
# This service needs to be enabled, if not, the first one from the available services will be taken.
$egMapsDefaultService = 'googlemaps';

# Array of String. The default mapping service for each feature, which will be used when no valid service is provided by the user.
# Each service needs to be enabled, if not, the first one from the available services will be taken.
# Note: The default service needs to be available for the feature you set it for, since it's used as a fallback mechanism.
$egMapsDefaultServices = array('pf' => 'googlemaps', 'qp' => 'googlemaps', 'fi' => 'googlemaps');





# Geocoding services configuration

# Array of String. Array containing all the geocoding services that will be made available to the user.
# Currently Maps provides the following services: googlemaps, yahoomaps, openlayers
$egMapsAvailableGeoServices = array(
									'google' => array(
										'class' => 'MapsGoogleGeocoder',
										'file' => 'Geocoders/Maps_GoogleGeocoder.php',
										'local' => true,
										'overrides' => array('googlemaps'),
										),
									'yahoo' => array(
										'class' => 'MapsYahooGeocoder',
										'file' => 'Geocoders/Maps_YahooGeocoder.php',
										'local' => true,
										'overrides' => array('yahoomaps'),
										),
									'geonames' => array(
										'class' => 'MapsGeonamesGeocoder',
										'file' => 'Geocoders/Maps_GeonamesGeocoder.php',
										'local' => true,
										),
									);

# String. The default geocoding service, which will be used when no service is provided by the user.
# This service needs to be enabled, if not, the first one from the available services will be taken.
$egMapsDefaultGeoService = 'geonames';





# General map properties configuration

# Integer. The default width and height of a map. These values will only be used when the user does not provide them.
$egMapsMapWidth = 600;
$egMapsMapHeight = 350;

# Array. The minimum and maximum width and height for all maps.
$egMapsSizeRestrictions = array(
	'width'  => array( 100, 1000 ),
	'height' => array( 100, 1000 ),
);

# Strings. The default coordinates of the marker. This value will only be used when the user does not provide one.
$egMapsMapLat = '1';
$egMapsMapLon = '1';





# Specific map properties configuration

# Google maps

# Your Google Maps API key. Required for displaying Google Maps, and using the Google Geocoder services.
# Haven't got an API key yet? Get it here: http://code.google.com/apis/maps/signup.html
if (empty($egGoogleMapsKey)) $egGoogleMapsKey = ''; 

# String. The Google Maps map name prefix. It can not be identical to the one of another mapping service.
$egMapsGoogleMapsPrefix = 'map_google';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsGoogleMapsZoom = 14;

# Array of String. The Google Maps default map types. This value will only be used when the user does not provide one.
$egMapsGoogleMapsTypes = array('normal', 'satellite', 'hybrid', 'physical');

# String. The default map type. This value will only be used when the user does not provide one.
$egMapsGoogleMapsType = 'normal';

# Boolean. The default value for enabling or disabling the autozoom of a map.
# This value will only be used when the user does not provide one.
$egMapsGoogleAutozoom = true;

# Array of String. The default controls for Google Maps. This value will only be used when the user does not provide one.
# Available values: large, small, large-original, small-original, zoom, type, type-menu, overview-map, scale, nav-label
$egMapsGMapControls = array('large', 'scale', 'type');



# Yahoo maps

# Your Yahoo! Maps API key. Required for displaying Yahoo! Maps.
# Haven't got an API key yet? Get it here: https://developer.yahoo.com/wsregapp/
if (empty($egYahooMapsKey)) $egYahooMapsKey = ''; 

# String. The Yahoo! maps map name prefix. It can not be identical to the one of another mapping service.
$egMapsYahooMapsPrefix = 'map_yahoo';

# Array of String. The Google Maps default map types. This value will only be used when the user does not provide one.
$egMapsYahooMapsTypes = array('normal', 'satellite', 'hybrid');

# String. The default map type. This value will only be used when the user does not provide one.
$egMapsYahooMapsType = 'normal';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsYahooMapsZoom = 4;

# Boolean. The default value for enabling or disabling the autozoom of a map.
# This value will only be used when the user does not provide one.
$egMapsYahooAutozoom = true;

# Array of String. The default controls for Yahoo! Maps. This value will only be used when the user does not provide one.
# Available values: type, pan, zoom, zoom-short
$egMapsYMapControls = array('type', 'pan', 'zoom');



# OpenLayers

# String. The OpenLayers map name prefix. It can not be identical to the one of another mapping service.
$egMapsOpenLayersPrefix = 'open_layer';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsOpenLayersZoom = 13;

# Array of String. The default controls for Open Layers. This value will only be used when the user does not provide one.
# Available values: layerswitcher, mouseposition, autopanzoom, panzoom, panzoombar, scaleline, navigation, keyboarddefaults, overviewmap, permalink
$egMapsOLControls = array('layerswitcher', 'mouseposition', 'autopanzoom', 'scaleline', 'navigation');

# Array of String. The default layers for Open Layers. This value will only be used when the user does not provide one.
# Available values: google, bing, yahoo, openlayers, nasa
$egMapsOLLayers = array('openlayers');



# OpenStreetMaps (OpenLayers optimized for OSM)

# String. The OSM map name prefix. It can not be identical to the one of another mapping service.
$egMapsOSMPrefix = 'map_osm';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsOSMZoom = 13;

# Array of String. The default controls for OSM maps. This value will only be used when the user does not provide one.
# Available values: layerswitcher, mouseposition, autopanzoom, panzoom, panzoombar, scaleline, navigation, keyboarddefaults, overviewmap, permalink
$egMapsOSMControls = array('layerswitcher', 'mouseposition', 'autopanzoom', 'scaleline', 'navigation');