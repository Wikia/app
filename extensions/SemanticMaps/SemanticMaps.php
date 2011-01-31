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
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Semantic Maps.
 *
 * Please do not use this group name for other code. If you have an extension to 
 * Semantic Maps, please use your own group defenition.
 * 
 * @defgroup SemanticMaps Semantic Maps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// Show a warning if Maps is not loaded.
if ( ! defined( 'Maps_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Semantic Maps">Semantic Maps</a>.<br />' );
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( ! defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Semantic Maps">Semantic Maps</a>.<br />' );
}

// Only initialize the extension when all dependencies are present.
if ( defined( 'Maps_VERSION' ) && defined( 'SMW_VERSION' ) ) {
	define( 'SM_VERSION', '0.7.4 alpha' );

	$useExtensionPath = version_compare( $wgVersion, '1.16', '>=' ) && isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath;
	$smgScriptPath 	= ( $useExtensionPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/SemanticMaps';	
	$smgDir 		= dirname( __FILE__ ) . '/';
	unset( $useExtensionPath );

	$smgStyleVersion = $wgStyleVersion . '-' . SM_VERSION;

	// Include the settings file.
	require_once 'SM_Settings.php';

	$wgExtensionFunctions[] = 'smfSetup';

	$wgExtensionMessagesFiles['SemanticMaps'] = $smgDir . 'SemanticMaps.i18n.php';
	
	$incDir = dirname( __FILE__ ) . '/includes/';
	
	// Data values
	$wgAutoloadClasses['SMGeoCoordsValue'] 				= $incDir . 'SM_GeoCoordsValue.php';
	
	// Value descriptions
	$wgAutoloadClasses['SMGeoCoordsValueDescription'] 	= $incDir . 'SM_GeoCoordsValueDescription.php';
	$wgAutoloadClasses['SMAreaValueDescription'] 		= $incDir . 'SM_AreaValueDescription.php';
	
	$wgAutoloadClasses['SemanticMapsHooks'] 			= dirname( __FILE__ ) . '/SemanticMaps.hooks.php';
	
	// Hook for initializing the Geographical Coordinate type.
	$wgHooks['smwInitDatatypes'][] = 'SMGeoCoordsValue::initGeoCoordsType';
	
	// Hook for initializing the field types needed by Geographical Coordinates.
	$wgHooks['SMWCustomSQLStoreFieldType'][] = 'SMGeoCoordsValue::initGeoCoordsFieldTypes';
	
	// Hook for defining a table to store geographical coordinates in.
	$wgHooks['SMWPropertyTables'][] = 'SMGeoCoordsValue::initGeoCoordsTable';
	
	// Hook for defining the default query printer for queries that ask for geographical coordinates.
	$wgHooks['SMWResultFormat'][] = 'SMGeoCoordsValue::addGeoCoordsDefaultFormat';	
	
	// Hook for adding a Semantic Maps links to the Admin Links extension.
	$wgHooks['AdminLinks'][] = 'SemanticMapsHooks::addToAdminLinks';	
}

/**
 * 'Initialization' function for the Semantic Maps extension. 
 * The only work done here is creating the extension credits for
 * Semantic Maps. The actuall work in done via the Maps hooks.
 * 
 * @since 0.1
 * 
 * @return true
 */
function smfSetup() {
	global $wgExtensionCredits, $wgLang;

	// Creation of a list of internationalized service names.
	$services = array();
	foreach ( MapsMappingServices::getServiceIdentifiers() as $identifier ) $services[] = wfMsg( 'maps_' . $identifier );
	$servicesList = $wgLang->listToText( $services );

	// This function has been deprecated in 1.16, but needed for earlier versions.
	// It's present in 1.16 as a stub, but lets check if it exists in case it gets removed at some point.
	if ( function_exists( 'wfLoadExtensionMessages' ) ) {
		wfLoadExtensionMessages( 'SemanticMaps' );
	}

	$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
		'path' => __FILE__,
		'name' => wfMsg( 'semanticmaps_name' ),
		'version' => SM_VERSION,
		'author' => array(
			'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
			'[http://www.mediawiki.org/wiki/Extension:Semantic_Maps/Credits ' . wfMsg( 'maps-others' ) . ']'
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Maps',
		'description' => wfMsgExt( 'semanticmaps_desc', 'parsemag', $servicesList ),
	);

	return true;
}
