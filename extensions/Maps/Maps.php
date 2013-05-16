<?php

/**
 * Initialization file for the Maps extension.
 * 
 * On MediaWiki.org: 		http://www.mediawiki.org/wiki/Extension:Maps
 * Official documentation: 	http://mapping.referata.com/wiki/Maps
 * Examples/demo's: 		http://mapping.referata.com/wiki/Maps_examples
 *
 * @file Maps.php
 * @ingroup Maps
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Maps.
 *
 * Please do not use this group name for other code. If you have an extension to
 * Maps, please use your own group definition.
 *
 * @defgroup Maps Maps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.17', '<' ) ) {
	die( '<b>Error:</b> This version of Maps requires MediaWiki 1.17 or above; use Maps 0.7.x for older versions.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for Maps to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( ! defined( 'Validator_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a>.<br />' );
}

define( 'Maps_VERSION', '1.0.5' );

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Maps',
	'version' => Maps_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
	),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Maps',
	'descriptionmsg' => 'maps-desc'
);

// The different coordinate notations.
define( 'Maps_COORDS_FLOAT', 'float' );
define( 'Maps_COORDS_DMS', 'dms' );
define( 'Maps_COORDS_DM', 'dm' );
define( 'Maps_COORDS_DD', 'dd' );

$egMapsScriptPath 	= ( $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions' : $wgExtensionAssetsPath ) . '/Maps';
$egMapsDir 			= dirname( __FILE__ ) . '/';

$egMapsStyleVersion = $wgStyleVersion . '-' . Maps_VERSION;

$wgAutoloadClasses['MapsHooks'] = dirname( __FILE__ ) . '/Maps.hooks.php';

// Autoload the "includes/" classes and interfaces.
$incDir = dirname( __FILE__ ) . '/includes/';
$wgAutoloadClasses['MapsMapper'] 				= $incDir . 'Maps_Mapper.php';
$wgAutoloadClasses['MapsCoordinateParser'] 		= $incDir . 'Maps_CoordinateParser.php';
$wgAutoloadClasses['MapsDistanceParser'] 		= $incDir . 'Maps_DistanceParser.php';
$wgAutoloadClasses['MapsGeoFunctions'] 			= $incDir . 'Maps_GeoFunctions.php';
$wgAutoloadClasses['MapsGeocoders'] 			= $incDir . 'Maps_Geocoders.php';
$wgAutoloadClasses['MapsGeocoder'] 				= $incDir . 'Maps_Geocoder.php';
$wgAutoloadClasses['MapsKMLFormatter'] 			= $incDir . 'Maps_KMLFormatter.php';
$wgAutoloadClasses['MapsLayer'] 				= $incDir . 'Maps_Layer.php';
$wgAutoloadClasses['MapsLayerPage'] 			= $incDir . 'Maps_LayerPage.php';
$wgAutoloadClasses['MapsLayers'] 				= $incDir . 'Maps_Layers.php';
$wgAutoloadClasses['MapsLocation'] 				= $incDir . 'Maps_Location.php';
$wgAutoloadClasses['iMappingService'] 			= $incDir . 'iMappingService.php';
$wgAutoloadClasses['MapsMappingServices'] 		= $incDir . 'Maps_MappingServices.php';
$wgAutoloadClasses['MapsMappingService'] 		= $incDir . 'Maps_MappingService.php';

$wgAutoloadClasses['ApiGeocode'] 				= $incDir . 'api/ApiGeocode.php';

// Autoload the "includes/criteria/" classes.
$criDir = $incDir . 'criteria/';
$wgAutoloadClasses['CriterionIsDistance'] 		= $criDir . 'CriterionIsDistance.php';
$wgAutoloadClasses['CriterionIsImage'] 			= $criDir . 'CriterionIsImage.php';
$wgAutoloadClasses['CriterionIsLocation'] 		= $criDir . 'CriterionIsLocation.php';
$wgAutoloadClasses['CriterionMapDimension'] 	= $criDir . 'CriterionMapDimension.php';
$wgAutoloadClasses['CriterionMapLayer'] 		= $criDir . 'CriterionMapLayer.php';
unset( $criDir );

// Autoload the "includes/features/" classes.
$ftDir = $incDir . '/features/';
$wgAutoloadClasses['MapsBaseMap'] 				= $ftDir . 'Maps_BaseMap.php';
$wgAutoloadClasses['MapsBasePointMap'] 			= $ftDir . 'Maps_BasePointMap.php';	
unset( $ftDir );

// Autoload the "includes/geocoders/" classes.
$geoDir = $incDir . 'geocoders/';
$wgAutoloadClasses['MapsGeonamesGeocoder'] 		= $geoDir . 'Maps_GeonamesGeocoder.php';
$wgAutoloadClasses['MapsGeonamesOldGeocoder'] 	= $geoDir . 'Maps_GeonamesOldGeocoder.php';
$wgAutoloadClasses['MapsGoogleGeocoder'] 		= $geoDir . 'Maps_GoogleGeocoder.php';
$wgAutoloadClasses['MapsYahooGeocoder'] 		= $geoDir . 'Maps_YahooGeocoder.php';
unset( $geoDir );

// Autoload the "includes/layers/" classes.
$lyrDir = $incDir . 'layers/';
$wgAutoloadClasses['MapsImageLayer'] 			= $lyrDir . 'Maps_ImageLayer.php';
$wgAutoloadClasses['MapsKMLLayer'] 				= $lyrDir . 'Maps_KMLLayer.php';
unset( $lyrDir );

// Autoload the "includes/manipulations/" classes.
$manDir = $incDir . 'manipulations/';
$wgAutoloadClasses['MapsParamDimension'] 		= $manDir . 'Maps_ParamDimension.php';
$wgAutoloadClasses['MapsParamFile'] 			= $manDir . 'Maps_ParamFile.php';
$wgAutoloadClasses['MapsParamGeoService'] 		= $manDir . 'Maps_ParamGeoService.php';
$wgAutoloadClasses['MapsParamLocation'] 		= $manDir . 'Maps_ParamLocation.php';
$wgAutoloadClasses['MapsParamService'] 			= $manDir . 'Maps_ParamService.php';
$wgAutoloadClasses['MapsParamZoom'] 			= $manDir . 'Maps_ParamZoom.php';
unset( $manDir );

// Autoload the "includes/parserHooks/" classes.
$phDir = $incDir . '/parserHooks/';
$wgAutoloadClasses['MapsCoordinates'] 			= $phDir . 'Maps_Coordinates.php';
$wgAutoloadClasses['MapsDisplayMap'] 			= $phDir . 'Maps_DisplayMap.php';
$wgAutoloadClasses['MapsDisplayPoint'] 			= $phDir . 'Maps_DisplayPoint.php';
$wgAutoloadClasses['MapsDistance'] 				= $phDir . 'Maps_Distance.php';
$wgAutoloadClasses['MapsFinddestination'] 		= $phDir . 'Maps_Finddestination.php';
$wgAutoloadClasses['MapsGeocode'] 				= $phDir . 'Maps_Geocode.php';
$wgAutoloadClasses['MapsGeodistance'] 			= $phDir . 'Maps_Geodistance.php';
$wgAutoloadClasses['MapsMapsDoc'] 				= $phDir . 'Maps_MapsDoc.php';
unset( $phDir );
unset( $incDir );

$wgAPIModules['geocode'] 						= 'ApiGeocode';

$wgExtensionMessagesFiles['MapsMagic'] = $egMapsDir . 'Maps.i18n.magic.php';
$wgExtensionMessagesFiles['Maps'] = $egMapsDir . 'Maps.i18n.php';
$wgExtensionMessagesFiles['MapsNamespaces'] = $egMapsDir . 'Maps.i18n.namespaces.php';

// Register the initialization function of Maps.
$wgExtensionFunctions[] = 'efMapsSetup';

// Since 0.2
$wgHooks['AdminLinks'][] = 'MapsHooks::addToAdminLinks';

// Since 0.6.5
$wgHooks['UnitTestsList'][] = 'MapsHooks::registerUnitTests';
	
// Since 0.7.1
$wgHooks['ArticleFromTitle'][] = 'MapsHooks::onArticleFromTitle';	

// Since 1.0
$wgHooks['MakeGlobalVariablesScript'][] = 'MapsHooks::onMakeGlobalVariablesScript';

// Since ??
$wgHooks['CanonicalNamespaces'][] = 'MapsHooks::onCanonicalNamespaces';

$egMapsFeatures = array();

$egMapsFeatures['pf'][]	= 'MapsDisplayMap::initialize';
$egMapsFeatures['pf'][]	= 'MapsDisplayPoint::initialize';

# Parser hooks

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
	# Required for #mapsdoc.
	$wgHooks['ParserFirstCallInit'][] = 'MapsMapsDoc::staticInit';
	$wgHooks['LanguageGetMagic'][] = 'MapsMapsDoc::staticMagic';
	
# Geocoders
	
	# Registration of the GeoNames service geocoder.
	$wgHooks['GeocoderFirstCallInit'][] = 'MapsGeonamesGeocoder::register';	
	
	# Registration of the legacy GeoNames service geocoder.
	$wgHooks['GeocoderFirstCallInit'][] = 'MapsGeonamesOldGeocoder::register';
	
	# Registration of the Google Geocoding (v2) service geocoder.
	$wgHooks['GeocoderFirstCallInit'][] = 'MapsGoogleGeocoder::register';
	
	# Registration of the Yahoo! Geocoding service geocoder.
	$wgHooks['GeocoderFirstCallInit'][] = 'MapsYahooGeocoder::register';
	
# Layers

	# Registration of the image layer type.
	$wgHooks['MappingLayersInitialization'][] = 'MapsImageLayer::register';
	
	# Registration of the KML layer type.
	$wgHooks['MappingLayersInitialization'][] = 'MapsKMLLayer::register';

# Mapping services
	
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
	
	# WMF OSM
	include_once $egMapsDir . 'includes/services/OSM/OSM.php';		

$egMapsSettings = array();
	
// Include the settings file.
require_once $egMapsDir . 'Maps_Settings.php';

define( 'Maps_NS_LAYER', 		$egMapsNamespaceIndex + 0 );
define( 'Maps_NS_LAYER_TALK', 	$egMapsNamespaceIndex + 1 );

$wgResourceModules['ext.maps.common'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/includes',
	'remoteBasePath' => $egMapsScriptPath . '/includes',	
	'group' => 'ext.maps',
	'messages' => array(
		'maps-load-failed',
	),
	'scripts' => array(
		'ext.maps.common.js'
	)
);

$wgResourceModules['ext.maps.coord'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/includes',
	'remoteBasePath' => $egMapsScriptPath . '/includes',	
	'group' => 'ext.maps',
	'messages' => array(
		'maps-abb-north',
		'maps-abb-east',
		'maps-abb-south',
		'maps-abb-west',
	),
	'scripts' => array(
		'ext.maps.coord.js'
	)
);

$wgResourceModules['ext.maps.resizable'] = array(
	'dependencies' => 'jquery.ui.resizable'
);

$wgAvailableRights[] = 'geocode';

# Users that can geocode. By default the same as those that can edit.
foreach ( $wgGroupPermissions as $group => $rights ) {
	if ( array_key_exists( 'edit', $rights ) ) {
		$wgGroupPermissions[$group]['geocode'] = $wgGroupPermissions[$group]['edit'];
	}
}

$egMapsGlobalJSVars = array();

/**
 * Initialization function for the Maps extension.
 * 
 * @since 0.1
 * 
 * @return true
 */
function efMapsSetup() {
	wfRunHooks( 'MappingServiceLoad' );
	wfRunHooks( 'MappingFeatureLoad' );

	return true;
}
