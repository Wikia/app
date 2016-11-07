<?php

/**
 * File defining the settings for the Maps extension.
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Maps.
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// Mapping services configuration

	// Array of String. Array containing all the mapping services that will be made available to the user.
	$GLOBALS['egMapsAvailableServices'] = array(
		'googlemaps3',
		'openlayers',
		'leaflet',
	);

	// String. The default mapping service, which will be used when no default
	// service is present in the $GLOBALS['egMapsDefaultServices'] array for a certain feature.
	// A service that supports all features is recommended. This service needs to be
	// enabled, if not, the first one from the available services will be taken.
	$GLOBALS['egMapsDefaultService'] = 'googlemaps3';

	// Array of String. The default mapping service for each feature, which will be
	// used when no valid service is provided by the user. Each service needs to be
	// enabled, if not, the first one from the available services will be taken.
	// Note: The default service needs to be available for the feature you set it
	// for, since it's used as a fallback mechanism.
	$GLOBALS['egMapsDefaultServices'] = array(
		'display_map' => $GLOBALS['egMapsDefaultService'],
	);

// Geocoding

	// Array of String. Array containing all the geocoding services that will be
	// made available to the user. Currently Maps provides the following services:
	// geonames, google
    // It is recommended that when using GeoNames you get a GeoNames webservice account
    // at http://www.geonames.org/login and set the username to $GLOBALS['egMapsGeoNamesUser'] below.
    // Not doing this will result into a legacy service being used, which might be
    // disabled at some future point.
	$GLOBALS['egMapsAvailableGeoServices'] = array(
		'geonames',
		'google',
		'geocoderus',
	);

	// String. The default geocoding service, which will be used when no service is
	// is provided by the user. This service needs to be enabled, if not, the first
	// one from the available services will be taken.
	$GLOBALS['egMapsDefaultGeoService'] = 'geonames';

	// Boolean. Indicates if geocoders can override the default geoservice based on
	// the used mapping service.
	$GLOBALS['egMapsUserGeoOverrides'] = true;

	// Boolean. Sets if coordinates should be allowed in geocoding calls.
	$GLOBALS['egMapsAllowCoordsGeocoding'] = true;

	// Boolean. Sets if geocoded addresses should be stored in a cache.
	$GLOBALS['egMapsEnableGeoCache'] = true;

	// String. GeoNames API user/application name.
	// Obtain an account here: http://www.geonames.org/login
	// Do not forget to activate your account for API usage!
	$GLOBALS['egMapsGeoNamesUser'] = '';


// Coordinate configuration

	// The coordinate notations that should be available.
	$GLOBALS['egMapsAvailableCoordNotations'] = array(
		Maps_COORDS_FLOAT,
		Maps_COORDS_DMS,
		Maps_COORDS_DM,
		Maps_COORDS_DD
	);

	// Enum. The default output format of coordinates.
	// Possible values: Maps_COORDS_FLOAT, Maps_COORDS_DMS, Maps_COORDS_DM, Maps_COORDS_DD
	$GLOBALS['egMapsCoordinateNotation'] = Maps_COORDS_DMS;

	// Boolean. Indicates if coordinates should be outputted in directional notation by default.
	// Recommended to be true for Maps_COORDS_DMS and false for Maps_COORDS_FLOAT.
	$GLOBALS['egMapsCoordinateDirectional'] = true;

	// Boolean. Sets if direction labels should be translated to their equivalent in the wiki language or not.
	$GLOBALS['egMapsInternatDirectionLabels'] = true;


// Distance configuration


	// Array. A list of units (keys) and how many meters they represent (value).
	// No spaces! If the unit consists out of multiple words, just write them together.
	$GLOBALS['egMapsDistanceUnits'] = array(
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

	// String. The default unit for distances.
	$GLOBALS['egMapsDistanceUnit'] = 'm';

	// Integer. The default amount of fractal digits in a distance.
	$GLOBALS['egMapsDistanceDecimals'] = 2;


// General map configuration

	// Integer or string. The default width and height of a map. These values will
	// only be used when the user does not provide them.
	$GLOBALS['egMapsMapWidth'] = 'auto';
	$GLOBALS['egMapsMapHeight'] = 350;

	// Array. The minimum and maximum width and height for all maps. First min and
	// max for absolute values, then min and max for percentage values. When the
	// height or width exceed their limits, they will be changed to the closest
	// allowed value.
	$GLOBALS['egMapsSizeRestrictions'] = array(
		'width'  => array( 50, 1020, 1, 100 ),
		'height' => array( 50, 1000, 1, 100 ),
	);

	// String. The default centre for maps. Can be either a set of coordinates or an address.
	$GLOBALS['egMapsDefaultMapCentre'] = '0, 0';

	// Strings. The default content for all pop-ups. This value will only be used
	// when the user does not provide one.
	$GLOBALS['egMapsDefaultTitle'] = '';
	$GLOBALS['egMapsDefaultLabel'] = '';

	$GLOBALS['egMapsResizableByDefault'] = false;

	$GLOBALS['egMapsRezoomForKML'] = false;


// Other general configuration

	// When true, debugging messages will be logged using mw.log(). Do not use on production wikis.
	$GLOBALS['egMapsDebugJS'] = false;

	// Namespace index start of the mapping namespaces.
	$GLOBALS['egMapsNamespaceIndex'] = 420;

	// Boolean. Controls if you can specify images using a full path in layers.
	$GLOBALS['egMapsAllowExternalImages'] = true;

	// Boolean. Sets if pages with maps should be put in special category
	$GLOBALS['egMapsEnableCategory'] = true;


// Specific mapping service configuration

	// Google Maps v3

		// Integer. The default zoom of a map. This value will only be used when the
		// user does not provide one.
		$GLOBALS['egMapsGMaps3Zoom'] = 14;

		// Array of String. The Google Maps v3 default map types. This value will only
		// be used when the user does not provide one.
		$GLOBALS['egMapsGMaps3Types'] = array(
			'roadmap',
			'satellite',
			'hybrid',
			'terrain'
		);

		// String. The default map type. This value will only be used when the user
		// does not provide one.
		$GLOBALS['egMapsGMaps3Type'] = 'roadmap';

		// Array. List of controls to display onto maps by default.
		$GLOBALS['egMapsGMaps3Controls'] = array(
			'pan',
			'zoom',
			'type',
			'scale',
			'streetview'
		);

		// String. The default style for the type control.
		// horizontal, vertical or default
		$GLOBALS['egMapsGMaps3DefTypeStyle'] = 'default';

		// String. The default style for the zoom control.
		// small, large or default
		$GLOBALS['egMapsGMaps3DefZoomStyle'] = 'default';

		// Boolean. Open the info windows on load by default?
		$GLOBALS['egMapsGMaps3AutoInfoWindows'] = false;

		// Array. Layers to load by default.
		// traffic and bicycling
		$GLOBALS['egMapsGMaps3Layers'] = array();

		// Integer. Default tilt when using Google Maps.
		$GLOBALS['egMapsGMaps3DefaultTilt'] = 0;

		// Show points of interest or not.
		$GLOBALS['egMapsShowPOI'] = true;

		// String. Set the language when rendering Google Maps.
		$GLOBALS['egMapsGMaps3Language'] = '';

	// OpenLayers

		// Integer. The default zoom of a map. This value will only be used when the
		// user does not provide one.
		$GLOBALS['egMapsOpenLayersZoom'] = 13;

		// Array of String. The default controls for Open Layers. This value will only
		// be used when the user does not provide one.
		// Available values: layerswitcher, mouseposition, autopanzoom, panzoom,
		// panzoombar, scaleline, navigation, keyboarddefaults, overviewmap, permalink
		$GLOBALS['egMapsOLControls'] = array(
			'layerswitcher',
			'mouseposition',
			'autopanzoom',
			'scaleline',
			'navigation'
		);

		// Array of String. The default layers for Open Layers. This value will only be
		// used when the user does not provide one.
		$GLOBALS['egMapsOLLayers'] = array(
			'osm-mapnik',
			'osm-cyclemap'
		);

		// The difinitions for the layers that should be available for the user.
		$GLOBALS['egMapsOLAvailableLayers'] = array(
			//'google' => array( 'OpenLayers.Layer.Google("Google Streets")' ),

			'bing-normal'    => array( 'OpenLayers.Layer.VirtualEarth( "Bing Streets", {type: VEMapStyle.Shaded, "sphericalMercator":true} )', 'bing' ),
			'bing-satellite' => array( 'OpenLayers.Layer.VirtualEarth( "Bing Satellite", {type: VEMapStyle.Aerial, "sphericalMercator":true} )', 'bing' ),
			'bing-hybrid'    => array( 'OpenLayers.Layer.VirtualEarth( "Bing Hybrid", {type: VEMapStyle.Hybrid, "sphericalMercator":true} )', 'bing' ),

			'yahoo-normal'    => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Streets", {"sphericalMercator":true} )', 'yahoo' ),
			'yahoo-hybrid'    => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Hybrid", {"type": YAHOO_MAP_HYB, "sphericalMercator":true} )', 'yahoo' ),
			'yahoo-satellite' => array( 'OpenLayers.Layer.Yahoo( "Yahoo! Satellite", {"type": YAHOO_MAP_SAT, "sphericalMercator":true} )', 'yahoo' ),

			'osm-mapnik'   => array( 'OpenLayers.Layer.OSM.Mapnik("OSM Mapnik")', 'osm' ),
			'osm-cyclemap' => array( 'OpenLayers.Layer.OSM.CycleMap("OSM Cycle Map")', 'osm' ),
			'osm-mapquest' => array( 'OpenLayers.Layer.OSM.Mapquest("Mapquest OSM")', 'osm' ),

			'google-normal'    => array( 'OpenLayers.Layer.Google("Google Streets", {type: google.maps.MapTypeId.STREETS, numZoomLevels: 20})', 'google' ),
			'google-satellite' => array( 'OpenLayers.Layer.Google("Google Satellite", {type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22})', 'google' ),
			'google-hybrid'    => array( 'OpenLayers.Layer.Google("Google Hybrid", {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20})', 'google' ),
			'google-terrain'  => array( 'OpenLayers.Layer.Google("Google Terrain", {type: google.maps.MapTypeId.TERRAIN, numZoomLevels: 22})', 'google' ),

			'nasa' => 'OpenLayers.Layer.WMS("NASA Global Mosaic", "http://t1.hypercube.telascience.org/cgi-bin/landsat7",
				{layers: "landsat7", "sphericalMercator":true} )',
		);

		// Layer group definitions. Group names must be different from layer names, and
		// must only contain layers that are present in $GLOBALS['egMapsOLAvailableLayers'].
		$GLOBALS['egMapsOLLayerGroups'] = array(
			'yahoo' => array( 'yahoo-normal', 'yahoo-satellite', 'yahoo-hybrid' ),
			'bing' => array( 'bing-normal', 'bing-satellite', 'bing-hybrid' ),
			'google' => array( 'google-normal', 'google-satellite', 'google-terrain', 'google-hybrid' ),
			'osm' => array( 'osm-mapnik', 'osm-cyclemap' ),
		);

		global $wgJsMimeType;

		// Layer dependencies
		$GLOBALS['egMapsOLLayerDependencies'] = array(
			'yahoo' => "<style type='text/css'> #controls {width: 512px;}</style><script src='http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers'></script>",
			'bing' => "<script type='$wgJsMimeType' src='http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1'></script>",
			'ol-wms' => "<script type='$wgJsMimeType' src='http://clients.multimap.com/API/maps/1.1/metacarta_04'></script>",
			'google' => "<script src='http://maps.google.com/maps/api/js?sensor=false'></script>",
		);

	// Leaflet


		// Integer. The default zoom of a map. This value will only be used when the
		// user does not provide one.
		$GLOBALS['egMapsLeafletZoom'] = 14;


$GLOBALS['egMapsGlobalJSVars'] = array();
