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
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Maps.
 *
 * Please do not use this group name for other code. If you have an extension to
 * Maps, please use your own group defenition.
 *
 * @defgroup Maps Maps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for Maps to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( ! defined( 'Validator_VERSION' ) ) {
	echo '<b>Warning:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a>.';
}
else {
	define( 'Maps_VERSION', '0.7.3 beta 1' );

	// The different coordinate notations.
	define( 'Maps_COORDS_FLOAT', 'float' );
	define( 'Maps_COORDS_DMS', 'dms' );
	define( 'Maps_COORDS_DM', 'dm' );
	define( 'Maps_COORDS_DD', 'dd' );
	
	$useExtensionPath = version_compare( $wgVersion, '1.16', '>=' ) && isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath;
	$egMapsScriptPath 	= ( $useExtensionPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/Maps';
	$egMapsDir 			= dirname( __FILE__ ) . '/';
	unset( $useExtensionPath );

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
	$wgAutoloadClasses['iMappingFeature'] 			= $incDir . 'iMappingFeature.php';
	$wgAutoloadClasses['iMappingService'] 			= $incDir . 'iMappingService.php';
	$wgAutoloadClasses['MapsMappingServices'] 		= $incDir . 'Maps_MappingServices.php';
	$wgAutoloadClasses['MapsMappingService'] 		= $incDir . 'Maps_MappingService.php';
	
	// Autoload the "includes/criteria/" classes.
	$criDir = $incDir . 'criteria/';
	$wgAutoloadClasses['CriterionIsDistance'] 		= $criDir . 'CriterionIsDistance.php';
	$wgAutoloadClasses['CriterionIsImage'] 			= $criDir . 'CriterionIsImage.php';
	$wgAutoloadClasses['CriterionIsLocation'] 		= $criDir . 'CriterionIsLocation.php';
	$wgAutoloadClasses['CriterionMapDimension'] 	= $criDir . 'CriterionMapDimension.php';
	$wgAutoloadClasses['CriterionMapLayer'] 		= $criDir . 'CriterionMapLayer.php';
	
	// Autoload the "includes/features/" classes.
	$ftDir = $incDir . '/features/';
	$wgAutoloadClasses['MapsBaseMap'] 				= $ftDir . 'Maps_BaseMap.php';
	$wgAutoloadClasses['MapsBasePointMap'] 			= $ftDir . 'Maps_BasePointMap.php';	
	
	// Autoload the "includes/geocoders/" classes.
	$geoDir = $incDir . 'geocoders/';
	$wgAutoloadClasses['MapsGeonamesGeocoder'] 		= $geoDir . 'Maps_GeonamesGeocoder.php';
	$wgAutoloadClasses['MapsGoogleGeocoder'] 		= $geoDir . 'Maps_GoogleGeocoder.php';
	$wgAutoloadClasses['MapsYahooGeocoder'] 		= $geoDir . 'Maps_YahooGeocoder.php';
	
	// Autoload the "includes/layers/" classes.
	$lyrDir = $incDir . 'layers/';
	$wgAutoloadClasses['MapsImageLayer'] 			= $lyrDir . 'Maps_ImageLayer.php';
	$wgAutoloadClasses['MapsKMLLayer'] 				= $lyrDir . 'Maps_KMLLayer.php';
	
	// Autoload the "includes/manipulations/" classes.
	$manDir = $incDir . 'manipulations/';
	$wgAutoloadClasses['MapsParamCoordSet'] 		= $manDir . 'Maps_ParamCoordSet.php';
	$wgAutoloadClasses['MapsParamDimension'] 		= $manDir . 'Maps_ParamDimension.php';
	$wgAutoloadClasses['MapsParamImage'] 			= $manDir . 'Maps_ParamImage.php';
	$wgAutoloadClasses['MapsParamLocation'] 		= $manDir . 'Maps_ParamLocation.php';
	$wgAutoloadClasses['MapsParamService'] 			= $manDir . 'Maps_ParamService.php';
	$wgAutoloadClasses['MapsParamZoom'] 			= $manDir . 'Maps_ParamZoom.php';
	
	// Autoload the "includes/parserHooks/" classes.
	$phDir = $incDir . '/parserHooks/';
	$wgAutoloadClasses['MapsCoordinates'] 			= $phDir . 'Maps_Coordinates.php';
	$wgAutoloadClasses['MapsDisplayMap'] 			= $phDir . 'Maps_DisplayMap.php';
	$wgAutoloadClasses['MapsDisplayPoint'] 			= $phDir . 'Maps_DisplayPoint.php';
	$wgAutoloadClasses['MapsDistance'] 				= $phDir . 'Maps_Distance.php';
	$wgAutoloadClasses['MapsFinddestination'] 		= $phDir . 'Maps_Finddestination.php';
	$wgAutoloadClasses['MapsGeocode'] 				= $phDir . 'Maps_Geocode.php';
	$wgAutoloadClasses['MapsGeodistance'] 			= $phDir . 'Maps_Geodistance.php';	
	
	// To ensure Maps remains compatible with pre 1.16.
	if ( !class_exists( 'Html' ) ) {
		$wgAutoloadClasses['Html'] = $egMapsDir . 'compat/Html.php';
	}	
	
	if ( version_compare( $wgVersion, '1.16alpha', '>=' ) ) {
		$wgExtensionMessagesFiles['MapsMagic'] = $egMapsDir . 'Maps.i18n.magic.php';
	}		
	
	$wgExtensionMessagesFiles['Maps'] = $egMapsDir . 'Maps.i18n.php';

	// Register the initialization function of Maps.
	$wgExtensionFunctions[] = 'efMapsSetup';

	// Since 0.2
	$wgHooks['AdminLinks'][] = 'MapsHooks::addToAdminLinks';
	
	// Since 0.6.5
	$wgHooks['UnitTestsList'][] = 'MapsHooks::registerUnitTests';
	
	// Since 0.7
	$wgHooks['SkinAfterBottomScripts'][] = 'MapsHooks::addOnloadFunction';
	
	// Since 0.7
	$wgHooks['ResourceLoaderRegisterModules'][] = 'MapsHooks::registerResourceLoaderModules';
	
	// Since 0.7.1
	$wgHooks['ArticleFromTitle'][] = 'MapsHooks::onArticleFromTitle';	
	
	$egMapsFeatures = array();
	
	// Include the settings file.
	require_once $egMapsDir . 'Maps_Settings.php';
	
	define( 'Maps_NS_LAYER', 		$egMapsNamespaceIndex + 0 );
	define( 'Maps_NS_LAYER_TALK', 	$egMapsNamespaceIndex + 1 );
}

/**
 * Initialization function for the Maps extension.
 * 
 * @since 0.1
 * 
 * @return true
 */
function efMapsSetup() {
	global $wgExtensionCredits, $wgLang, $wgExtraNamespaces, $wgNamespaceAliases;

	// This function has been deprecated in 1.16, but needed for earlier versions.
	// It's present in 1.16 as a stub, but lets check if it exists in case it gets removed at some point.
	if ( function_exists( 'wfLoadExtensionMessages' ) ) {
		wfLoadExtensionMessages( 'Maps' );
	}

	$wgExtraNamespaces += array(
		Maps_NS_LAYER => 'Layer',
		Maps_NS_LAYER_TALK => 'Layer talk'
	);
	
	$wgNamespaceAliases += array(
		wfMsg( 'maps-ns-layer' ) => Maps_NS_LAYER,
		wfMsg( 'maps-ns-layer-talk' ) => Maps_NS_LAYER_TALK
	);
	
	wfRunHooks( 'MappingServiceLoad' );
	wfRunHooks( 'MappingFeatureLoad' );

	// Creation of a list of internationalized service names.
	$services = array();
	foreach ( MapsMappingServices::getServiceIdentifiers() as $identifier ) $services[] = wfMsg( 'maps_' . $identifier );
	$servicesList = $wgLang->listToText( $services );

	$wgExtensionCredits['parserhook'][] = array(
		'path' => __FILE__,
		'name' => wfMsg( 'maps_name' ),
		'version' => Maps_VERSION,
		'author' => array(
			'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
			'[http://www.mediawiki.org/wiki/Extension:Maps/Credits ' . wfMsg( 'maps-others' ) . ']'
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Maps',
		'description' => wfMsgExt( 'maps_desc', 'parsemag', $servicesList ),
	);

	return true;
}
