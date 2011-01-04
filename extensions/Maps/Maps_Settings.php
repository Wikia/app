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
 *
 * TODO: clean up, update docs
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}



$egMapsUseRL = false; //method_exists( 'OutputPage', 'addModules' );

# Features configuration
# Commenting out the inclusion of any feature will make Maps completely ignore it, and so improve performance.

	# Include the features you want to have available.
	# Functionality in the features directory uses the Maps framework to support multiple mapping services.


	# Registration of adittional parser hooks (tags and parser functions).
		
		$egMapsFeatures['pf'][]	= 'MapsDisplayMap::initialize';
		$egMapsFeatures['pf'][]	= 'MapsDisplayPoint::initialize';
		
		# Required for #coordinates.
		$wgHooks['ParserFirstCallInit'][] = 'MapsCoordinates::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsCoordinates::staticMagic';
		# Required for #display_map.
		$wgHooks['ParserFirstCallInit'][] = 'MapsDisplayMap::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsDisplayMap::staticMagic';	
		# Required for #display_point.
		$wgHooks['ParserFirstCallInit'][] = 'MapsDisplayPoint::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsDisplayPoint::staticMagic';				
		# Required for #distance.
		$wgHooks['ParserFirstCallInit'][] = 'MapsDistance::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsDistance::staticMagic';
		# Required for #finddestination.
		$wgHooks['ParserFirstCallInit'][] = 'MapsFinddestination::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsFinddestination::staticMagic';
		# Required for #geocode.
		$wgHooks['ParserFirstCallInit'][] = 'MapsGeocode::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsGeocode::staticMagic';		
		# Required for #geodistance.
		$wgHooks['ParserFirstCallInit'][] = 'MapsGeodistance::staticInit';
		$wgHooks['LanguageGetMagic'][] = 'MapsGeodistance::staticMagic';
		
	# Geocoders
		
		# Registration of the GeoNames service geocoder.
		$wgHooks['GeocoderFirstCallInit'][] = 'MapsGeonamesGeocoder::register';
		
		# Registration of the Google Geocoding (v2) service geocoder.
		$wgHooks['GeocoderFirstCallInit'][] = 'MapsGoogleGeocoder::register';
		
		# Registration of the Yahoo! Geocoding service geocoder.
		$wgHooks['GeocoderFirstCallInit'][] = 'MapsYahooGeocoder::register';
		
	# Layers
	
		# Registration of the image layer type.
		$wgHooks['MappingLayersInitialization'][] = 'MapsImageLayer::register';
		
		# Registration of the KML layer type.
		$wgHooks['MappingLayersInitialization'][] = 'MapsKMLLayer::register';

		
		
# Mapping services configuration
# Note: You can not use aliases in the settings. Use the main service names.

	# Include the mapping services that should be loaded into Maps.
	# Commenting or removing a mapping service will make Maps completely ignore it, and so improve performance.
	
	# Google Maps API v2
	include_once $egMapsDir . 'includes/services/GoogleMaps/GoogleMaps.php';
	
	# Google Maps API v3
	include_once $egMapsDir . 'includes/services/GoogleMaps3/GoogleMaps3.php';
	
	# OpenLayers API
	include_once $egMapsDir . 'includes/services/OpenLayers/OpenLayers.php';
	
	# Yahoo! Maps API
	include_once $egMapsDir . 'includes/services/YahooMaps/YahooMaps.php';
	
	# Yahoo! Maps API
	include_once $egMapsDir . 'includes/services/OSM/OSM.php';	

	# Array of String. Array containing all the mapping services that will be made available to the user.
	$egMapsAvailableServices = array(
		'googlemaps2',
		'googlemaps3',
		'yahoomaps',
		'openlayers',
		'osm'
	);

	# String. The default mapping service, which will be used when no default
	# service is present in the $egMapsDefaultServices array for a certain feature.
	# A service that supports all features is recommended. This service needs to be
	# enabled, if not, the first one from the available services will be taken.
	$egMapsDefaultService = 'googlemaps2';
	
	# Array of String. The default mapping service for each feature, which will be
	# used when no valid service is provided by the user. Each service needs to be
	# enabled, if not, the first one from the available services will be taken.
	# Note: The default service needs to be available for the feature you set it
	# for, since it's used as a fallback mechanism.
	$egMapsDefaultServices = array(
		'display_point' => $egMapsDefaultService,
		'display_map' => $egMapsDefaultService
	);


	
# Geocoding

	# Array of String. Array containing all the geocoding services that will be
	# made available to the user. Currently Maps provides the following services:
	# geonames, google, yahoo
	$egMapsAvailableGeoServices = array(
		'geonames',
		'google',
		'yahoo'
	);
	
	# String. The default geocoding service, which will be used when no service is
	# is provided by the user. This service needs to be enabled, if not, the first
	# one from the available services will be taken.
	$egMapsDefaultGeoService = 'geonames';
	
	# Boolean. Indicates if geocoders can override the default geoservice based on
	# the used mapping service.
	$egMapsUserGeoOverrides = true;
	
	# Boolean. Sets if coordinates should be allowed in geocoding calls.
	$egMapsAllowCoordsGeocoding = true;
	
	# Boolean. Sets if geocoded addresses should be stored in a cache.
	$egMapsEnableGeoCache = true;	



# Coordinate configuration

	# The coordinate notations that should be available.
	$egMapsAvailableCoordNotations = array(
		Maps_COORDS_FLOAT,
		Maps_COORDS_DMS,
		Maps_COORDS_DM,
		Maps_COORDS_DD
	);
	
	# Enum. The default output format of coordinates.
	# Possible values: Maps_COORDS_FLOAT, Maps_COORDS_DMS, Maps_COORDS_DM, Maps_COORDS_DD
	$egMapsCoordinateNotation = Maps_COORDS_DMS;
	
	# Boolean. Indicates if coordinates should be outputted in directional notation by default.
	# Recommended to be true for Maps_COORDS_DMS and false for Maps_COORDS_FLOAT.
	$egMapsCoordinateDirectional = true;
	
	# Boolean. Sets if direction labels should be translated to their equivalent in the wiki language or not.
	$egMapsInternatDirectionLabels = true;



# Distance configuration
	
	# Array. A list of units (keys) and how many meters they represent (value).
	# No spaces! If the unit consists out of multiple words, just write them together.
	$egMapsDistanceUnits = array(
		'm' => 1,
		'meter' => 1,
		'meters' => 1,
		'km' => 1000,
		'kilometers' => 1000,
		'kilometres' => 1000,
		'mi' => 1609.344,
		'mile' => 1609.344,
		'miles' => 1609.344,
		'nm' => 1852,
		'nauticalmile' => 1852,
		'nauticalmiles' => 1852,
	);
	
	# String. The default unit for distances.
	$egMapsDistanceUnit = 'm';
	
	# Integer. The default amount of fractal digits in a distance.
	$egMapsDistanceDecimals = 2;	
	
	
	
# General map configuration

	# Integer or string. The default width and height of a map. These values will
	# only be used when the user does not provide them.
	$egMapsMapWidth = '100%';
	$egMapsMapHeight = 350;

	# Array. The minimum and maximum width and height for all maps. First min and
	# max for absolute values, then min and max for percentage values. When the
	# height or width exceed their limits, they will be changed to the closest
	# allowed value.
	$egMapsSizeRestrictions = array(
		'width'  => array( 50, 1020, 1, 100 ),
		'height' => array( 50, 1000, 1, 100 ),
	);
	
	# String. The default centre for maps. Can be either a set of coordinates or an address.
	$egMapsDefaultMapCentre = '0, 0';
	
	# Strings. The default content for all pop-ups. This value will only be used
	# when the user does not provide one.
	$egMapsDefaultTitle = '';
	$egMapsDefaultLabel = '';


	
# Other general configuration
	
	# Namespace index start of the mapping namespaces.
	$egMapsNamespaceIndex = 420;
	
	# Boolean. Controls if you can specify images using a full path in layers.
	$egMapsAllowExternalImages = true;
	
	
	
# Specific mapping service configuration

	# Google Maps
	
		# Your Google Maps API key. Required for displaying Google Maps, and using the
		# Google Geocoder services.
		$egGoogleMapsKey = ''; # http://code.google.com/apis/maps/signup.html
		
		# Integer. The default zoom of a map. This value will only be used when the
		# user does not provide one.
		$egMapsGoogleMapsZoom = 14;
		
		# Array of String. The Google Maps v2 default map types. This value will only
		# be used when the user does not provide one.
		$egMapsGoogleMapsTypes = array(
			'normal',
			'satellite',
			'hybrid',
			'physical'
		);
	
		# String. The default map type. This value will only be used when the user does
		# not provide one.
		$egMapsGoogleMapsType = 'normal';
		
		# Boolean. The default value for enabling or disabling the autozoom of a map.
		# This value will only be used when the user does not provide one.
		$egMapsGoogleAutozoom = true;
		
		# Array of String. The default controls for Google Maps v2. This value will
		# only be used when the user does not provide one.
		# Available values: auto, large, small, large-original, small-original, zoom,
		# type, type-menu, overview-map, scale, nav-label, overlays
		$egMapsGMapControls = array(
			'auto',
			'scale',
			'type',
			'overlays'
		);
		
		# Array. The default overlays for the Google Maps v2 overlays control, and
		# whether they should be shown at pageload. This value will only be used when
		# the user does not provide one.
		# Available values: photos, videos, wikipedia, webcams
		$egMapsGMapOverlays = array(
			'photos',
			'videos',
			'wikipedia',
			'webcams'
		);
	
	
	
	# Google Maps v3
	
		# Integer. The default zoom of a map. This value will only be used when the
		# user does not provide one.
		$egMapsGMaps3Zoom = 14;
		
		# Array of String. The Google Maps v3 default map types. This value will only
		# be used when the user does not provide one.
		$egMapsGMaps3Types = array(
			'roadmap',
			'satellite',
			'hybrid',
			'terrain'
		);
		
		# String. The default map type. This value will only be used when the user
		# does not provide one.
		$egMapsGMaps3Type = 'roadmap';
	
	
	
	# Yahoo! Maps
	
		# Your Yahoo! Maps API key. Required for displaying Yahoo! Maps.
		# Haven't got an API key yet? Get it here: https://developer.yahoo.com/wsregapp/
		$egYahooMapsKey = '';
		
		# Array of String. The Google Maps default map types. This value will only be
		# used when the user does not provide one.
		$egMapsYahooMapsTypes = array(
			'normal',
			'satellite',
			'hybrid'
		);
		
		# String. The default map type. This value will only be used when the user does
		# not provide one.
		$egMapsYahooMapsType = 'normal';
		
		# Integer. The default zoom of a map. This value will only be used when the
		# user does not provide one.
		$egMapsYahooMapsZoom = 4;
		
		# Boolean. The default value for enabling or disabling the autozoom of a map.
		# This value will only be used when the user does not provide one.
		$egMapsYahooAutozoom = true;
		
		# Array of String. The default controls for Yahoo! Maps. This value will only
		# be used when the user does not provide one.
		# Available values: type, pan, zoom, zoom-short, auto-zoom
		$egMapsYMapControls = array(
			'type',
			'pan',
			'auto-zoom'
		);
	
	
	
	# OpenLayers
		
		# Integer. The default zoom of a map. This value will only be used when the
		# user does not provide one.
		$egMapsOpenLayersZoom = 13;
		
		# Array of String. The default controls for Open Layers. This value will only
		# be used when the user does not provide one.
		# Available values: layerswitcher, mouseposition, autopanzoom, panzoom,
		# panzoombar, scaleline, navigation, keyboarddefaults, overviewmap, permalink
		$egMapsOLControls = array(
			'layerswitcher',
			'mouseposition',
			'autopanzoom',
			'scaleline',
			'navigation'
		);
		
		# Array of String. The default layers for Open Layers. This value will only be
		# used when the user does not provide one.
		$egMapsOLLayers = array(
			'osm-mapnik',
			'osm-cyclemap',
			'osmarender'
		);
		
		# The difinitions for the layers that should be available for the user.
		$egMapsOLAvailableLayers = array(
			//'google' => array( 'OpenLayers.Layer.Google("Google Streets")' ),
		
			'bing-normal' => array( 'OpenLayers.Layer.VirtualEarth( "Bing Streets", {type: VEMapStyle.Shaded, "sphericalMercator":true} )', 'bing' ),
			'bing-satellite' => array( 'OpenLayers.Layer.VirtualEarth( "Bing Satellite", {type: VEMapStyle.Aerial, "sphericalMercator":true} )', 'bing' ),
			'bing-hybrid' => array( 'OpenLayers.Layer.VirtualEarth( "Bing Hybrid", {type: VEMapStyle.Hybrid, "sphericalMercator":true} )', 'bing' ),
		
			'yahoo-normal' => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Streets", {"sphericalMercator":true} )', 'yahoo' ),
			'yahoo-hybrid' => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Hybrid", {"type": YAHOO_MAP_HYB, "sphericalMercator":true} )', 'yahoo' ),
			'yahoo-satellite' => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Satellite", {"type": YAHOO_MAP_SAT, "sphericalMercator":true} )', 'yahoo' ),
		
			'osmarender' => array( 'OpenLayers.Layer.OSM.Osmarender("OSM arender")', 'osm' ),
			'osm-mapnik' => array( 'OpenLayers.Layer.OSM.Mapnik("OSM Mapnik")', 'osm' ),
			'osm-cyclemap' => array( 'OpenLayers.Layer.OSM.CycleMap("OSM Cycle Map")', 'osm' ),
		
			'nasa' => 'OpenLayers.Layer.WMS("NASA Global Mosaic", "http://t1.hypercube.telascience.org/cgi-bin/landsat7",
				{layers: "landsat7", "sphericalMercator":true} )',
		);
		
		# Layer group definitions. Group names must be different from layer names, and
		# must only contain layers that are present in $egMapsOLAvailableLayers.
		$egMapsOLLayerGroups = array(
			'yahoo' => array( 'yahoo-normal', 'yahoo-satellite', 'yahoo-hybrid' ),
			'bing' => array( 'bing-normal', 'bing-satellite', 'bing-hybrid' ),
			'osm' => array( 'osmarender', 'osm-mapnik', 'osm-cyclemap' ),
		);
		
		# Layer dependencie (MediaWiki >= 1.17).
		// http://maps.google.com/maps/api/js?sensor=false
		$egMapsOLLayerModules = array(/*
			'ext.maps.ol.osm' => array(
				'scripts' =>   array(
					'OSM/OpenStreetMap.js',
				),
			),
			'ext.maps.ol.yahoo' => array(
				'scripts' =>   array(
					'http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers',
				),
			),
			'ext.maps.ol.bing' => array(
				'scripts' =>   array(
					'http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1',
				),
			),
			'ext.maps.ol.ol-wms' => array(
				'scripts' =>   array(
					'http://clients.multimap.com/API/maps/1.1/metacarta_04',
				),
			)				
		*/);
		
		# Layer dependencies (MediaWiki < 1.17).
		$egMapsOLLayerDependencies = array(
			'yahoo' => "<style type='text/css'> #controls {width: 512px;}</style><script src='http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers'></script>",
			'bing' => "<script type='$wgJsMimeType' src='http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1'></script>",
			'ol-wms' => "<script type='$wgJsMimeType' src='http://clients.multimap.com/API/maps/1.1/metacarta_04'></script>",
			'osm' => "<script type='$wgJsMimeType' src='$egMapsScriptPath/includes/services/OpenLayers/OSM/OpenStreetMap.js?$egMapsStyleVersion'></script>"
		);	

	
	
	# OpenStreetMap
	
		# Integer. The default zoom of a map. This value will only be used when the
		# user does not provide one.
		$egMapsOSMZoom = 13;		
		
		# Boolean. Thumbnail pictures on or off.
		$egMapsOSMThumbs = false;
		
		# Boolean. Photos in article pop-ups on or off.
		$egMapsOSMPhotos = false;		