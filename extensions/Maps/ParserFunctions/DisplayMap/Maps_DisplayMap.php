<?php

/**
 * File holding the registration and handling functions for the display_map parser function.
 *
 * @file Maps_DisplayMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgAutoloadClasses['MapsDisplayMap'] 		= $egMapsDir . 'ParserFunctions/DisplayMap/Maps_DisplayMap.php';
$wgAutoloadClasses['MapsBaseMap'] 			= $egMapsDir . 'ParserFunctions/DisplayMap/Maps_BaseMap.php';

$wgHooks['LanguageGetMagic'][] 				= 'efMapsDisplayMapMagic';
$wgHooks['ParserFirstCallInit'][] 			= 'efMapsRegisterDisplayMap';

$egMapsAvailableFeatures['pf']['hooks'][]	= 'MapsDisplayMap';

/**
 * Adds the magic words for the parser functions.
 */
function efMapsDisplayMapMagic( &$magicWords, $langCode ) {
	$magicWords['display_map'] = array( 0,  'display_map');
	
	return true; // Unless we return true, other parser functions won't get loaded.
}	

/**
 * Adds the parser function hooks
 */
function efMapsRegisterDisplayMap(&$wgParser) {
	// A hook to enable the '#display_map' parser function.
	$wgParser->setFunctionHook( 'display_map', array('MapsDisplayMap', 'displayMapRender') );
	
	return true;
}

/**
 * Class containing the rendering functions for the display_map parser function.
 * 
 * @author Jeroen De Dauw
 *
 */
final class MapsDisplayMap {
	
	public static $parameters = array();
	
	public static function initialize() {
		self::initializeParams();
	}	
	
	/**
	 * Returns the output for a display_map call.
	 *
	 * @param unknown_type $parser
	 * 
	 * @return array
	 */
	public static function displayMapRender(&$parser) {	
		$args = func_get_args();
		return MapsParserFunctions::getMapHtml($parser, $args, 'display_map');
	}
	
	private static function initializeParams() {
		global $egMapsAvailableGeoServices, $egMapsDefaultGeoService;
		
		self::$parameters = array_merge(MapsParserFunctions::$parameters, array(
			));
	}
	
}