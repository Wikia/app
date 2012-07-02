<?php

/**
 * Initialization file for the UK Geocoding for Maps extension.
 * For more info see http://www.mediawiki.org/wiki/Extension:UK_geocoding_for_Maps
 *
 * @file UKGeocodingForMaps.php
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to UK Geocoding for Maps.
 *
 *
 * @defgroup UKGeocodingForMaps UK Geocoding for Maps
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'UKG_VERSION', '0.3 a1' );

$ukggScriptPath 	= ( isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/UKGeocodingForMaps';
$ukggDir 			= dirname( __FILE__ ) . '/';

$ukggStyleVersion 	= $wgStyleVersion . '-' . UKG_VERSION;

// Include the settings file
require_once( $ukggDir . 'UKGeocodingForMaps_Settings.php' );

$wgExtensionMessagesFiles['UKGeocodingForMaps'] = $ukggDir . 'UKGeocodingForMaps.i18n.php';
$wgExtensionMessagesFiles['UKGeocodingForMapsMagic'] = $ukggDir . 'UKGeocodingForMaps.i18n.magic.php';

$loadedAjaxApi = false;

$wgExtensionFunctions[] = 'ukgfSetup';

/**
 * 'Initialization' function for the UK Geocoding for Maps extension.
 * The only work done here is creating the extension credits for
 * UK Geocoding for Maps. The actuall work in done via the Maps hooks.
 */
function ukgfSetup() {
	global $wgExtensionCredits;

	$wgExtensionCredits['parserhook'][] = array(
		'path' => __FILE__,
		'name' => wfMsg( 'ukgeocoding_name' ),
		'version' => UKG_VERSION,
		'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw] for Neill Mitchell at Prescient Software Ltd' ),
		'url' => 'https://www.mediawiki.org/wiki/Extension:UK_geocoding_for_Maps',
		'descriptionmsg' => 'ukgeocoding-desc',
	);

	return true;
}
