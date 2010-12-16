<?php

/**
 * File holding the registration and handling functions for the display_point parser function.
 *
 * @file Maps_DisplayPoint.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgAutoloadClasses['MapsDisplayPoint'] 		= $egMapsDir . 'ParserFunctions/DisplayPoint/Maps_DisplayPoint.php';
$wgAutoloadClasses['MapsBasePointMap']		= $egMapsDir . 'ParserFunctions/DisplayPoint/Maps_BasePointMap.php';

$wgHooks['LanguageGetMagic'][] 				= 'efMapsDisplayPointMagic';
$wgHooks['ParserFirstCallInit'][] 			= 'efMapsRegisterDisplayPoint';

$egMapsAvailableFeatures['pf']['hooks'][]	= 'MapsDisplayPoint';

/**
 * Adds the magic words for the parser functions.
 */
function efMapsDisplayPointMagic( &$magicWords, $langCode ) {
	// The display_address(es) aliases are for backward compatibility only, and will be removed eventually.
	$magicWords['display_point'] = array( 0, 'display_point', 'display_points', 'display_address', 'display_addresses' );
	
	return true; // Unless we return true, other parser functions won't get loaded.
}	

/**
 * Adds the parser function hooks
 */
function efMapsRegisterDisplayPoint(&$wgParser) {
	// Hooks to enable the '#display_point' and '#display_points' parser functions.
	$wgParser->setFunctionHook( 'display_point', array('MapsDisplayPoint', 'displayPointRender') );
	
	return true;
}

/**
 * Class containing the rendering functions for the display_point parser function.
 * 
 * @author Jeroen De Dauw
 *
 */
final class MapsDisplayPoint {
	
	public static $parameters = array();
	
	public static function initialize() {
		self::initializeParams();
	}		
	
	/**
	 * Returns the output for a display_point call.
	 *
	 * @param unknown_type $parser
	 * 
	 * @return array
	 */
	public static function displayPointRender(&$parser) {	
		$args = func_get_args();
		return MapsParserFunctions::getMapHtml($parser, $args, 'display_point');
	}
	
	private static function initializeParams() {
		global $egMapsDefaultCentre, $egMapsDefaultTitle, $egMapsDefaultLabel;
		
		self::$parameters = array_merge(MapsParserFunctions::$parameters, array(	
			'centre' => array(
				'aliases' => array('center'),
				'default' => $egMapsDefaultCentre		
				),	
			'title' => array(			
				'default' => $egMapsDefaultTitle					
				),
			'label' => array(			
				'default' => $egMapsDefaultLabel
				),
			'icon' => array(			
				'criteria' => array(
					'not_empty' => array()
					)
				),										
			));
	}	
	
}