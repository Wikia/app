<?php

/**
 * Initialization file for the Maps extension.
 *
 * On MediaWiki.org:         http://www.mediawiki.org/wiki/Extension:Maps
 * Official documentation:     http://mapping.referata.com/wiki/Maps
 * Examples/demo's:         http://mapping.referata.com/wiki/Maps_examples
 *
 * @file Maps.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
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

if ( version_compare( $wgVersion , '1.18c' , '<' ) ) {
	die( '<b>Error:</b> This version of Maps requires MediaWiki 1.18 or above; use Maps 1.0.x for MediaWiki 1.17 and Maps 0.7.x for older versions.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for Maps to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( __DIR__ . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'Validator_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a>.<br />' );
}

define( 'Maps_VERSION' , '2.0.1' );

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__ ,
	'name' => 'Maps' ,
	'version' => Maps_VERSION ,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
	) ,
	'url' => 'https://www.mediawiki.org/wiki/Extension:Maps' ,
	'descriptionmsg' => 'maps-desc'
);

// The different coordinate notations.
define( 'Maps_COORDS_FLOAT' , 'float' );
define( 'Maps_COORDS_DMS' , 'dms' );
define( 'Maps_COORDS_DM' , 'dm' );
define( 'Maps_COORDS_DD' , 'dd' );

$egMapsScriptPath = ( $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions' : $wgExtensionAssetsPath ) . '/Maps';
$egMapsDir = __DIR__ . '/';

$egMapsStyleVersion = $wgStyleVersion . '-' . Maps_VERSION;

$wgAutoloadClasses['MapsHooks'] = __DIR__ . '/Maps.hooks.php';

// Autoload the "includes/" classes and interfaces.
$wgAutoloadClasses['MapsMapper'] 				= __DIR__ . '/includes/Maps_Mapper.php';
$wgAutoloadClasses['MapsCoordinateParser'] 		= __DIR__ . '/includes/Maps_CoordinateParser.php';
$wgAutoloadClasses['MapsDistanceParser'] 		= __DIR__ . '/includes/Maps_DistanceParser.php';
$wgAutoloadClasses['MapsGeoFunctions'] 			= __DIR__ . '/includes/Maps_GeoFunctions.php';
$wgAutoloadClasses['MapsGeocoders'] 			= __DIR__ . '/includes/Maps_Geocoders.php';
$wgAutoloadClasses['MapsGeocoder'] 				= __DIR__ . '/includes/Maps_Geocoder.php';
$wgAutoloadClasses['MapsKMLFormatter'] 			= __DIR__ . '/includes/Maps_KMLFormatter.php';
$wgAutoloadClasses['MapsLayer'] 				= __DIR__ . '/includes/Maps_Layer.php';
$wgAutoloadClasses['MapsLayerPage'] 			= __DIR__ . '/includes/Maps_LayerPage.php';
$wgAutoloadClasses['MapsLayers'] 				= __DIR__ . '/includes/Maps_Layers.php';
$wgAutoloadClasses['MapsLocation'] 				= __DIR__ . '/includes/Maps_Location.php';
$wgAutoloadClasses['MapsLine'] 					= __DIR__ . '/includes/Maps_Line.php';
$wgAutoloadClasses['MapsPolygon'] 				= __DIR__ . '/includes/Maps_Polygon.php';
$wgAutoloadClasses['MapsCircle'] 				= __DIR__ . '/includes/Maps_Circle.php';
$wgAutoloadClasses['MapsRectangle'] 			= __DIR__ . '/includes/Maps_Rectangle.php';
$wgAutoloadClasses['MapsImageOverlay'] 			= __DIR__ . '/includes/Maps_ImageOverlay.php';
$wgAutoloadClasses['iMappingService'] 			= __DIR__ . '/includes/iMappingService.php';
$wgAutoloadClasses['MapsMappingServices'] 		= __DIR__ . '/includes/Maps_MappingServices.php';
$wgAutoloadClasses['MapsMappingService'] 		= __DIR__ . '/includes/Maps_MappingService.php';
$wgAutoloadClasses['MapsWmsOverlay'] 			= __DIR__ . '/includes/Maps_WmsOverlay.php';
$wgAutoloadClasses['MapsBaseElement']			= __DIR__ . '/includes/Maps_BaseElement.php';
$wgAutoloadClasses['MapsBaseFillableElement'] 	= __DIR__ . '/includes/Maps_BaseFillableElement.php';
$wgAutoloadClasses['MapsBaseStrokableElement'] 	= __DIR__ . '/includes/Maps_BaseStrokableElement.php';
$wgAutoloadClasses['MapsDisplayMapRenderer'] 	= __DIR__ . '/includes/Maps_DisplayMapRenderer.php';

$wgAutoloadClasses['ApiGeocode'] 				= __DIR__ . '/includes/api/ApiGeocode.php';

$wgAutoloadClasses['iBubbleMapElement'] 		= __DIR__ . '/includes/properties/iBubbleMapElement.php';
$wgAutoloadClasses['iFillableMapElement'] 		= __DIR__ . '/includes/properties/iFillableMapElement.php';
$wgAutoloadClasses['iHoverableMapElement'] 		= __DIR__ . '/includes/properties/iHoverableMapElement.php';
$wgAutoloadClasses['iLinkableMapElement'] 		= __DIR__ . '/includes/properties/iLinkableMapElement.php';
$wgAutoloadClasses['iStrokableMapElement'] 		= __DIR__ . '/includes/properties/iStrokableMapElement.php';

// Autoload Geo Validators
$wgAutoloadClasses['GeoValidator'] 				= __DIR__ . '/includes/validators/GeoValidator.php';
$wgAutoloadClasses['LocationValidator'] 		= __DIR__ . '/includes/validators/LocationValidator.php';
$wgAutoloadClasses['LineValidator'] 			= __DIR__ . '/includes/validators/LineValidator.php';
$wgAutoloadClasses['PolygonValidator'] 			= __DIR__ . '/includes/validators/PolygonValidator.php';
$wgAutoloadClasses['RectangleValidator'] 		= __DIR__ . '/includes/validators/RectangleValidator.php';
$wgAutoloadClasses['CircleValidator'] 			= __DIR__ . '/includes/validators/CircleValidator.php';

// Autoload the "includes/criteria/" classes.
// TODO: migrate to Params
$wgAutoloadClasses['CriterionIsDistance'] 		= __DIR__ . '/includes/criteria/CriterionIsDistance.php';
$wgAutoloadClasses['CriterionIsImage'] 			= __DIR__ . '/includes/criteria/CriterionIsImage.php';
$wgAutoloadClasses['CriterionIsLocation'] 		= __DIR__ . '/includes/criteria/CriterionIsLocation.php';
$wgAutoloadClasses['CriterionMapDimension'] 	= __DIR__ . '/includes/criteria/CriterionMapDimension.php';
$wgAutoloadClasses['CriterionMapLayer'] 		= __DIR__ . '/includes/criteria/CriterionMapLayer.php';
$wgAutoloadClasses['CriterionLine'] 			= __DIR__ . '/includes/criteria/CriterionLine.php';
$wgAutoloadClasses['CriterionPolygon'] 			= __DIR__ . '/includes/criteria/CriterionPolygon.php';
$wgAutoloadClasses['CriterionSearchMarkers'] 	= __DIR__ . '/includes/criteria/CriterionSearchMarkers.php';

$wgAutoloadClasses['MapsGeonamesGeocoder'] 		= __DIR__ . '/includes/geocoders/Maps_GeonamesGeocoder.php';
$wgAutoloadClasses['MapsGoogleGeocoder'] 		= __DIR__ . '/includes/geocoders/Maps_GoogleGeocoder.php';

$wgAutoloadClasses['MapsImageLayer'] 			= __DIR__ . '/includes/layers/Maps_ImageLayer.php';
$wgAutoloadClasses['MapsKMLLayer'] 				= __DIR__ . '/includes/layers/Maps_KMLLayer.php';

// Autoload the "includes/manipulations/" classes.
// TODO: migrate to Params
$manDir = __DIR__ . '/includes/manipulations/';
$wgAutoloadClasses['MapsCommonParameterManipulation'] = $manDir . 'Maps_CommonParameterManipulation.php';
$wgAutoloadClasses['MapsParamDimension'] = $manDir . 'Maps_ParamDimension.php';
$wgAutoloadClasses['MapsParamFile'] = $manDir . 'Maps_ParamFile.php';
$wgAutoloadClasses['MapsParamGeoService'] = $manDir . 'Maps_ParamGeoService.php';
$wgAutoloadClasses['MapsParamLocation'] = $manDir . 'Maps_ParamLocation.php';
$wgAutoloadClasses['MapsParamZoom'] = $manDir . 'Maps_ParamZoom.php';
$wgAutoloadClasses['MapsParamLine'] = $manDir . 'Maps_ParamLine.php';
$wgAutoloadClasses['MapsParamPolygon'] = $manDir . 'Maps_ParamPolygon.php';
$wgAutoloadClasses['MapsParamCircle'] = $manDir . 'Maps_ParamCircle.php';
$wgAutoloadClasses['MapsParamRectangle'] = $manDir . 'Maps_ParamRectangle.php';
$wgAutoloadClasses['MapsParamImageOverlay'] = $manDir . 'Maps_ParamImageOverlay.php';
$wgAutoloadClasses['MapsParamWmsOverlay'] = $manDir . 'Maps_ParamWmsOverlay.php';
unset( $manDir );

$paramDir = __DIR__ . '/includes/params/';
$wgAutoloadClasses['MapsServiceParam'] = $paramDir . 'Maps_ServiceParam.php';
unset( $paramDir );

// Autoload the "includes/parserhooks/" classes.
$wgAutoloadClasses['MapsCoordinates'] 			= __DIR__ . '/includes/parserhooks/Maps_Coordinates.php';
$wgAutoloadClasses['MapsDisplayMap'] 			= __DIR__ . '/includes/parserhooks/Maps_DisplayMap.php';
$wgAutoloadClasses['MapsDistance'] 				= __DIR__ . '/includes/parserhooks/Maps_Distance.php';
$wgAutoloadClasses['MapsFinddestination'] 		= __DIR__ . '/includes/parserhooks/Maps_Finddestination.php';
$wgAutoloadClasses['MapsGeocode'] 				= __DIR__ . '/includes/parserhooks/Maps_Geocode.php';
$wgAutoloadClasses['MapsGeodistance'] 			= __DIR__ . '/includes/parserhooks/Maps_Geodistance.php';
$wgAutoloadClasses['MapsMapsDoc'] 				= __DIR__ . '/includes/parserhooks/Maps_MapsDoc.php';

// Load the special pages
$wgAutoloadClasses['SpecialMapEditor'] 			= __DIR__ . '/includes/specials/SpecialMapEditor.php';
$wgAutoloadClasses['MapEditor'] 				= __DIR__ . '/includes/editor/EditorHtml.php';

$wgAutoloadClasses['Maps\Test\ParserHookTest'] 	= __DIR__ . '/tests/phpunit/parserhooks/ParserHookTest.php';

$wgExtensionMessagesFiles['Maps'] 				= __DIR__ . '/Maps.i18n.php';
$wgExtensionMessagesFiles['MapsMagic'] 			= __DIR__ . '/Maps.i18n.magic.php';
$wgExtensionMessagesFiles['MapsNamespaces'] 	= __DIR__ . '/Maps.i18n.namespaces.php';
$wgExtensionMessagesFiles['MapsAlias'] 			= __DIR__ . '/Maps.i18n.alias.php';


$wgAPIModules['geocode'] = 'ApiGeocode';

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

# Parser hooks

# Required for #coordinates.
$wgHooks['ParserFirstCallInit'][] = 'MapsCoordinates::staticInit';
# Required for #display_map.
$wgHooks['ParserFirstCallInit'][] = 'MapsDisplayMap::staticInit';
# Required for #distance.
$wgHooks['ParserFirstCallInit'][] = 'MapsDistance::staticInit';
# Required for #finddestination.
$wgHooks['ParserFirstCallInit'][] = 'MapsFinddestination::staticInit';
# Required for #geocode.
$wgHooks['ParserFirstCallInit'][] = 'MapsGeocode::staticInit';
# Required for #geodistance.
$wgHooks['ParserFirstCallInit'][] = 'MapsGeodistance::staticInit';
# Required for #mapsdoc.
$wgHooks['ParserFirstCallInit'][] = 'MapsMapsDoc::staticInit';

# Geocoders

# Registration of the GeoNames service geocoder.
$wgHooks['GeocoderFirstCallInit'][] = 'MapsGeonamesGeocoder::register';

# Registration of the Google Geocoding (v2) service geocoder.
$wgHooks['GeocoderFirstCallInit'][] = 'MapsGoogleGeocoder::register';

# Layers

# Registration of the image layer type.
$wgHooks['MappingLayersInitialization'][] = 'MapsImageLayer::register';

# Registration of the KML layer type.
$wgHooks['MappingLayersInitialization'][] = 'MapsKMLLayer::register';

# Mapping services

# Include the mapping services that should be loaded into Maps.
# Commenting or removing a mapping service will make Maps completely ignore it, and so improve performance.

# Google Maps API v3
include_once $egMapsDir . 'includes/services/GoogleMaps3/GoogleMaps3.php';

# OpenLayers API
include_once $egMapsDir . 'includes/services/OpenLayers/OpenLayers.php';

# WMF OSM
// TODO
//include_once $egMapsDir . 'includes/services/OSM/OSM.php';

$egMapsSettings = array();

// Include the settings file.
require_once $egMapsDir . 'Maps_Settings.php';

define( 'Maps_NS_LAYER' , $egMapsNamespaceIndex + 0 );
define( 'Maps_NS_LAYER_TALK' , $egMapsNamespaceIndex + 1 );

$wgResourceModules['ext.maps.common'] = array(
	'localBasePath' => __DIR__ . '/includes' ,
	'remoteBasePath' => $egMapsScriptPath . '/includes' ,
	'group' => 'ext.maps' ,
	'messages' => array(
		'maps-load-failed' ,
	) ,
	'scripts' => array(
		'ext.maps.common.js'
	)
);

$wgResourceModules['ext.maps.coord'] = array(
	'localBasePath' => __DIR__ . '/includes' ,
	'remoteBasePath' => $egMapsScriptPath . '/includes' ,
	'group' => 'ext.maps' ,
	'messages' => array(
		'maps-abb-north' ,
		'maps-abb-east' ,
		'maps-abb-south' ,
		'maps-abb-west' ,
	) ,
	'scripts' => array(
		'ext.maps.coord.js'
	)
);

$wgResourceModules['ext.maps.resizable'] = array(
	'dependencies' => 'jquery.ui.resizable'
);

$wgResourceModules['mapeditor'] = array(
	'dependencies' => array( 'ext.maps.common','jquery.ui.autocomplete','jquery.ui.slider', 'jquery.ui.dialog' ),
	'localBasePath' => __DIR__ . '/includes/editor/',
	'remoteBasePath' => $egMapsScriptPath.  '/includes/editor/',
	'group' => 'mapeditor',
	'scripts' => array(
		'js/jquery.miniColors.js',
		'js/mapeditor.iefixes.js',
		'js/mapeditor.js',
	),
	'styles' => array(
		'css/jquery.miniColors.css',
		'css/mapeditor.css'
	),
	'messages' => array(
		'mapeditor-parser-error',
		'mapeditor-none-text',
		'mapeditor-done-button',
		'mapeditor-remove-button',
		'mapeditor-import-button',
		'mapeditor-export-button',
		'mapeditor-import-button2',
		'mapeditor-select-button',
		'mapeditor-mapparam-button',
		'mapeditor-clear-button',
		'mapeditor-imageoverlay-button'
	)
);

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

	if ( in_array( 'googlemaps3', $GLOBALS['egMapsAvailableServices'] ) ) {
		global $wgSpecialPages, $wgSpecialPageGroups;

		$wgSpecialPages['MapEditor'] = 'SpecialMapEditor';
		$wgSpecialPageGroups['MapEditor'] = 'maps';
	}

	return true;
}

$egParamDefinitions['mappingservice'] = 'MapsServiceParam';

