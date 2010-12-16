<?php

/**
 * File defining the settings for the Maps extension.
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
include_once $egMapsDir . 'ParserFunctions/DisplayMap/Maps_DisplayMap.php';		// display_map	
include_once $egMapsDir . 'ParserFunctions/DisplayPoint/Maps_DisplayPoint.php';	// display_point(s)
include_once $egMapsDir . 'ParserFunctions/Geocode/Maps_GeocodeFunctions.php';	// geocode, geocodelon, geocodelat





# Mapping services configuration
# Note: You can not use aliases in the settings. Use the main service names.

# Initialization of the mapping services array. 
$egMapsServices = array();

# Include the mapping services that should be loaded into Maps. 
# Commenting or removing a mapping service will cause Maps to completely ignore it, and so improve performance.
include_once $egMapsDir . 'GoogleMaps/Maps_GoogleMaps.php'; 	// Google Maps
include_once $egMapsDir . 'GoogleMaps3/Maps_GoogleMaps3.php'; 	// Google Maps v3
include_once $egMapsDir . 'OpenLayers/Maps_OpenLayers.php'; 	// OpenLayers
include_once $egMapsDir . 'YahooMaps/Maps_YahooMaps.php'; 		// Yahoo! Maps
include_once $egMapsDir . 'OpenStreetMap/Maps_OSM.php'; 		// OpenLayers optimized for OSM

# Array of String. Array containing all the mapping services that will be made available to the user.
# Currently Maps provides the following services: googlemaps, yahoomaps, openlayers
$egMapsAvailableServices = array('googlemaps2', 'googlemaps3', 'yahoomaps', 'openlayers', 'osm');

# String. The default mapping service, which will be used when no default service is present in the
# $egMapsDefaultServices array for a certain feature. A service that supports all features is recommended.
# This service needs to be enabled, if not, the first one from the available services will be taken.
$egMapsDefaultService = 'googlemaps2';

# Array of String. The default mapping service for each feature, which will be used when no valid service is provided by the user.
# Each service needs to be enabled, if not, the first one from the available services will be taken.
# Note: The default service needs to be available for the feature you set it for, since it's used as a fallback mechanism.
$egMapsDefaultServices = array(
	'pf' => array(
		'display_point' => 'googlemaps2',
		'display_map' => 'googlemaps2'
	)
);





# Geocoding services configuration

# Array of String. Array containing all the geocoding services that will be made available to the user.
# Currently Maps provides the following services: googlemaps, yahoomaps, openlayers
$egMapsAvailableGeoServices = array(
									'google' => array(
										'class' => 'MapsGoogleGeocoder',
										'file' => 'Geocoders/Maps_GoogleGeocoder.php',
										'local' => true,
										'overrides' => array('googlemaps2'),
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





# General map configuration

# Integer. The default width and height of a map. These values will only be used when the user does not provide them.
$egMapsMapWidth = 600;
$egMapsMapHeight = 350;

# Array. The minimum and maximum width and height for all maps. First min, then max. Min needs to be smaller then max.
# When the height or width exceed their limits, they will be changed to the closest allowed value.
$egMapsSizeRestrictions = array(
	'width'  => array( 50, 1020 ),
	'height' => array( 50, 1000 ),
);

# Strings. The default coordinates for the map. Must be in floating point notation.
# This value will only be used when the user does not provide one.
$egMapsMapLat = '1';
$egMapsMapLon = '1';

# String. The default centre for a map. Must be in floating point notation. 
# This value will override the smart behaviour when multiple markers are present when set.
# This value will only be used when the user does not provide one.
$egMapsDefaultCentre = '';

# Strings. The default content for all pop-ups. This value will only be used when the user does not provide one.
$egMapsDefaultTitle = '';
$egMapsDefaultLabel = '';





# Specific map properties configuration

# Google Maps

# Your Google Maps API key. Required for displaying Google Maps, and using the Google Geocoder services.
$egGoogleMapsKey = ''; # http://code.google.com/apis/maps/signup.html

# String. The Google Maps map name prefix. It can not be identical to the one of another mapping service.
$egMapsGoogleMapsPrefix = 'map_google';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsGoogleMapsZoom = 14;

# Array of String. The Google Maps v2 default map types. This value will only be used when the user does not provide one.
$egMapsGoogleMapsTypes = array('normal', 'satellite', 'hybrid', 'physical');

# String. The default map type. This value will only be used when the user does not provide one.
$egMapsGoogleMapsType = 'normal';

# Boolean. The default value for enabling or disabling the autozoom of a map.
# This value will only be used when the user does not provide one.
$egMapsGoogleAutozoom = true;

# Array of String. The default controls for Google Maps v2. This value will only be used when the user does not provide one.
# Available values: auto, large, small, large-original, small-original, zoom, type, type-menu, overview-map, scale, nav-label, overlays
$egMapsGMapControls = array('auto', 'scale', 'type', 'overlays');

# Array. The default overlays for the Google Maps v2 overlays control, and whether they should be shown at pageload.
# This value will only be used when the user does not provide one.
# Available values: photos, videos, wikipedia, webcams
$egMapsGMapOverlays = array('photos', 'videos', 'wikipedia', 'webcams');



# Google Maps v3

# String. The Google Maps v3 map name prefix. It can not be identical to the one of another mapping service.
$egMapsGMaps3Prefix = 'map_google3';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsGMaps3Zoom = 14;

# Array of String. The Google Maps v3 default map types. This value will only be used when the user does not provide one.
$egMapsGMaps3Types = array('roadmap', 'satellite', 'hybrid', 'terrain');

# String. The default map type. This value will only be used when the user does not provide one.
$egMapsGMaps3Type = 'roadmap';



# Yahoo! Maps

# Your Yahoo! Maps API key. Required for displaying Yahoo! Maps.
# Haven't got an API key yet? Get it here: https://developer.yahoo.com/wsregapp/
$egYahooMapsKey = ''; 

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
# Available values: type, pan, zoom, zoom-short, auto-zoom
$egMapsYMapControls = array('type', 'pan', 'auto-zoom');



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
$egMapsOLLayers = array('openlayers-wms');

# The difinitions for the layers that should be available for the user.
$egMapsOLAvailableLayers = array(
	'google-normal' => array('OpenLayers.Layer.Google( "Google Streets", {"sphericalMercator":true} )', 'google'),
	'google-satellite' => array('OpenLayers.Layer.Google( "Google Satellite", {type: G_SATELLITE_MAP , "sphericalMercator":true} )', 'google'),
	'google-hybrid' => array('OpenLayers.Layer.Google( "Google Hybrid", {type: G_HYBRID_MAP , "sphericalMercator":true} )', 'google'),
	'google-physical' => array('OpenLayers.Layer.Google( "Google Physical", {type: G_PHYSICAL_MAP , "sphericalMercator":true} )', 'google'),

	'bing-normal' => array('OpenLayers.Layer.VirtualEarth( "Bing Streets", {type: VEMapStyle.Shaded, "sphericalMercator":true} )', 'bing'),
	'bing-satellite' => array('OpenLayers.Layer.VirtualEarth( "Bing Satellite", {type: VEMapStyle.Aerial, "sphericalMercator":true} )', 'bing'),
	'bing-hybrid' => array('OpenLayers.Layer.VirtualEarth( "Bing Hybrid", {type: VEMapStyle.Hybrid, "sphericalMercator":true} )', 'bing'),

	'yahoo-normal' => array('OpenLayers.Layer.Yahoo( "Yahoo! Streets", {"sphericalMercator":true} )', 'yahoo'),
	'yahoo-hybrid' => array('OpenLayers.Layer.Yahoo( "Yahoo! Hybrid", {"type": YAHOO_MAP_HYB, "sphericalMercator":true} )', 'yahoo'),
	'yahoo-satellite' => array('OpenLayers.Layer.Yahoo( "Yahoo! Satellite", {"type": YAHOO_MAP_SAT, "sphericalMercator":true} )', 'yahoo'),

	'osmarender' => array('OpenLayers.Layer.OSM.Osmarender("OSM arender")', 'osm'),
	'osm-mapnik' => array('OpenLayers.Layer.OSM.Mapnik("OSM Mapnik")', 'osm'),
	'osm-cyclemap' => array('OpenLayers.Layer.OSM.CycleMap("OSM Cycle Map")', 'osm'),

	'openlayers-wms' => array('OpenLayers.Layer.WMS( "OpenLayers WMS", "http://labs.metacarta.com/wms/vmap0",
		{layers: "basic", "sphericalMercator":true} )', 'ol-wms'),

	'nasa' => 'OpenLayers.Layer.WMS("NASA Global Mosaic", "http://t1.hypercube.telascience.org/cgi-bin/landsat7", 
		{layers: "landsat7", "sphericalMercator":true} )',
);

# Layer group definitions. Group names must be different from layer names, and must only contain layers that are present in $egMapsOLAvailableLayers.
$egMapsOLLayerGroups = array(
	'google' => array('google-normal', 'google-satellite', 'google-hybrid', 'google-physical'),
	'yahoo' => array('yahoo-normal', 'yahoo-satellite', 'yahoo-hybrid'),
	'bing' => array('bing-normal', 'bing-satellite', 'bing-hybrid'),
	'osm' => array('osmarender', 'osm-mapnik', 'osm-cyclemap'),
);

# Layer dependencies.
$egMapsOLLayerDependencies = array(
	'google' => "<script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=$egGoogleMapsKey&amp;hl={}' type='$wgJsMimeType'></script><script type='$wgJsMimeType' src='$egMapsScriptPath/GoogleMaps/GoogleMapFunctions.min.js?$egMapsStyleVersion'></script><script type='$wgJsMimeType'>window.unload = GUnload;</script>",
	'yahoo' => "<style type='text/css'> #controls {width: 512px;}</style><script src='http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers'></script>",
	'bing' => "<script type='$wgJsMimeType' src='http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1'></script>",
	'ol-wms' => "<script type='$wgJsMimeType' src='http://clients.multimap.com/API/maps/1.1/metacarta_04'></script>",
	'osm' => "<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OSM/OpenStreetMap.js?$egMapsStyleVersion'></script>",
);



# OpenStreetMap (OpenLayers optimized for OSM)

# String. The OSM map name prefix. It can not be identical to the one of another mapping service.
$egMapsOSMPrefix = 'map_osm';

# Integer. The default zoom of a map. This value will only be used when the user does not provide one.
$egMapsOSMZoom = 13;

# Array of String. The default controls for OSM maps. This value will only be used when the user does not provide one.
# Available values: layerswitcher, mouseposition, autopanzoom, panzoom, panzoombar, scaleline, navigation, keyboarddefaults, overviewmap, permalink
$egMapsOSMControls = array('layerswitcher', 'mouseposition', 'autopanzoom', 'scaleline', 'navigation');

# Boolean. Indicates whether you want to get a static map (image) or not.
# This value will only be used when the user does not provide one.
$egMapsOSMStaticAsDefault = false;

# Boolean. Indicates whether the user should be able to activate a static map.
# This value will only be used when the user does not provide one.      
$egMapsOSMStaticActivatable = true;