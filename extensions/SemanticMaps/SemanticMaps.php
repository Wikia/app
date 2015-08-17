<?php

/**
 * Initialization file for the Maps extension.
 *
 * On MediaWiki.org: 		http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * Official documentation: 	http://mapping.referata.com/wiki/Semantic_Maps
 * Examples/demo's: 		http://mapping.referata.com/wiki/Semantic_Maps_examples
 *
 * @file SemanticMaps.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Semantic Maps.
 *
 * Please do not use this group name for other code. If you have an extension to
 * Semantic Maps, please use your own group definition.
 *
 * @defgroup SemanticMaps Semantic Maps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.18c', '<' ) ) {
	die( '<b>Error:</b> This version of Semantic Maps requires MediaWiki 1.18 or above; use Semantic Maps 1.0.x for MediaWiki 1.17 and Semantic Maps 0.7.x for older versions.' );
}

// Show a warning if Maps is not loaded.
if ( ! defined( 'Maps_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="https://www.mediawiki.org/wiki/Extension:Maps">Maps</a> installed in order to use <a href="https://www.mediawiki.org/wiki/Extension:Semantic Maps">Semantic Maps</a>.<br />' );
}

// Version check for SMW, which needs to be at 1.8 or greater.
if ( version_compare( Maps_VERSION, '1.1c', '<' ) ) {
	die(
		'<b>Error:</b> This version of Semantic Maps needs <a href="https://semantic-mediawiki.org/wiki/Maps">Maps</a> 2.0 or later.
		You are currently using version ' . Maps_VERSION . '.
	 	If for any reason you are stuck at Maps 1.0.x, you can use Semantic Maps 1.0.x instead.<br />'
	);
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( ! defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="https://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Semantic Maps">Semantic Maps</a>.<br />' );
}

// Version check for SMW, which needs to be at 1.8 or greater.
if ( version_compare( SMW_VERSION, '1.8c', '<' ) ) {
	die(
		'<b>Error:</b> This version of Semantic Maps needs <a href="https://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> 1.8 or later.
		You are currently using version ' . SMW_VERSION . '.
	 	If for any reason you are stuck at SMW 1.7.x or 1.6.x, you can use Semantic Maps 1.0.x instead.<br />'
	);
}

define( 'SM_VERSION', '2.0.1.2' );

$wgExtensionCredits['semantic'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Maps',
	'version' => SM_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Maps',
	'descriptionmsg' => 'semanticmaps-desc'
);

$smgScriptPath 	= ( $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions' : $wgExtensionAssetsPath ) . '/SemanticMaps';
$smgDir 		= __DIR__ . '/';

$smgStyleVersion = $wgStyleVersion . '-' . SM_VERSION;

// Include the settings file.
require_once 'SM_Settings.php';

# (named) Array of String. This array contains the available features for Maps.
# Commenting out the inclusion of any feature will make Maps completely ignore it, and so improve performance.

	# Query printers
	include_once $smgDir . 'includes/queryprinters/SM_QueryPrinters.php';
	# Form imputs
	include_once $smgDir . 'includes/forminputs/SM_FormInputs.php';

# Include the mapping services that should be loaded into Semantic Maps.
# Commenting or removing a mapping service will cause Semantic Maps to completely ignore it, and so improve performance.

	# Google Maps API v3
	include_once $smgDir . 'includes/services/GoogleMaps3/SM_GoogleMaps3.php';

	# OpenLayers API
	include_once $smgDir . 'includes/services/OpenLayers/SM_OpenLayers.php';

$wgExtensionMessagesFiles['SemanticMaps'] = $smgDir . 'SemanticMaps.i18n.php';

$incDir = __DIR__ . '/includes/';

// Data values
$wgAutoloadClasses['SMGeoCoordsValue'] 				= $incDir . 'SM_GeoCoordsValue.php';
$wgAutoloadClasses['SMGeoPolygonsValue'] 				= $incDir . 'SM_GeoPolygonsValue.php';
$wgAutoloadClasses['PolygonHandler'] 				= $incDir . 'SM_PolygonHandler.php';

// Value descriptions
$wgAutoloadClasses['SMGeoCoordsValueDescription'] 	= $incDir . 'SM_GeoCoordsValueDescription.php';
$wgAutoloadClasses['SMAreaValueDescription'] 		= $incDir . 'SM_AreaValueDescription.php';

$wgAutoloadClasses['SemanticMapsHooks'] 			= __DIR__ . '/SemanticMaps.hooks.php';

// Hook for initializing the Geographical Data types.
$wgHooks['smwInitDatatypes'][] = 'SemanticMapsHooks::initGeoDataTypes';

// Hook for defining the default query printer for queries that ask for geographical coordinates.
$wgHooks['SMWResultFormat'][] = 'SemanticMapsHooks::addGeoCoordsDefaultFormat';

// Hook for adding a Semantic Maps links to the Admin Links extension.
$wgHooks['AdminLinks'][] = 'SemanticMapsHooks::addToAdminLinks';

$wgHooks['UnitTestsList'][] = 'SemanticMapsHooks::registerUnitTests';
