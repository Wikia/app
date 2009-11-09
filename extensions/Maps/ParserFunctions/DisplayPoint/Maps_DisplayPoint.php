<?php

/**
 * 
 *
 * @file Maps_DisplayPoint.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgAutoloadClasses['MapsDisplayPoint'] 	= $egMapsIP . '/ParserFunctions/DisplayPoint/Maps_DisplayPoint.php';
$wgAutoloadClasses['MapsBasePointMap']	= $egMapsIP . '/ParserFunctions/DisplayPoint/Maps_BasePointMap.php';

$wgHooks['LanguageGetMagic'][] 			= 'efMapsDisplayPointMagic';
$wgHooks['ParserFirstCallInit'][] 		= 'efMapsRegisterDisplayPoint';

/**
 * Adds the magic words for the parser functions
 */
function efMapsDisplayPointMagic( &$magicWords, $langCode ) {
	// The display_address(es) aliases are for backward compatibility only, and will be removed eventually.
	$magicWords['display_point'] = array( 0, 'display_point', 'display_points', 'display_address', 'display_addresses' );
	
	return true; // Unless we return true, other parser functions won't get loaded
}	

/**
 * Adds the parser function hooks
 */
function efMapsRegisterDisplayPoint(&$wgParser) {
	// Hooks to enable the '#display_point' and '#display_points' parser functions
	$wgParser->setFunctionHook( 'display_point', array('MapsDisplayPoint', 'displayPointRender') );
	
	return true;
}

/**
 * 
 * 
 * @author Jeroen De Dauw
 *
 */
final class MapsDisplayPoint {
	
	/**
	 * Sets the default map properties, gets the map HTML depending 
	 * on the provided service, and then returns it.
	 *
	 * @param unknown_type $parser
	 * @return array
	 */
	public static function displayPointRender(&$parser) {	
		$params = func_get_args();
		array_shift( $params ); // We already know the $parser ...
				
		$fails = MapsParserGeocoder::changeAddressesToCoords($params);
		
		return self::getMapHtml($parser, $params, 'display_point', $fails);
	}
	
	public static function getMapHtml(&$parser, array $params, $parserFunction, array $coordFails = array()) {
        global $wgLang;
        
        $map = array();
        
        // Go through all parameters, split their names and values, and put them in the $map array.
        foreach($params as $param) {
            $split = split('=', $param);
            if (count($split) > 1) {
                $paramName = strtolower(trim($split[0]));
                $paramValue = trim($split[1]);
                if (strlen($paramName) > 0 && strlen($paramValue) > 0) {
                	$map[$paramName] = $paramValue;
                }
            }
            else if (count($split) == 1) { // Default parameter (without name)
            	$split[0] = trim($split[0]);
                if (strlen($split[0]) > 0) $map['coordinates'] = $split[0];
            }
        }
        
        $coords = MapsMapper::getParamValue('coordinates', $map);
        
        if ($coords) {
            if (! MapsMapper::paramIsPresent('service', $map)) $map['service'] = '';
            $map['service'] = MapsMapper::getValidService($map['service'], 'pf');                
    
            $mapClass = self::getParserClassInstance($map['service'], $parserFunction);
    
            // Call the function according to the map service to get the HTML output
            $output = $mapClass->displayMap($parser, $map);    
            
            if (count($coordFails) > 0) {
                $output .= '<i>' . wfMsgExt( 'maps_geocoding_failed_for', array( 'parsemag' ), $wgLang->listToText($coordFails ), count( $coordFails ) ) . '</i>';
            }
        }
        elseif (trim($coords) == "" && count($coordFails) > 0) {
            $output = '<i>' . wfMsgExt( 'maps_geocoding_failed', array( 'parsemag' ), $wgLang->listToText( $coordFails ), count( $coordFails ) ) . '</i>';
        }
        else {
            $output = '<i>'.wfMsg( 'maps_coordinates_missing' ).'</i>';
        }
        
        // Return the result
        return array( $output, 'noparse' => true, 'isHTML' => true ); 	
	}
	
	private static function getParserClassInstance($service, $parserFunction) {
		global $egMapsServices;
		// TODO: add check to see if the service actually supports this parser function, and return false for error handling if not.
		//die($egMapsServices[$service]['pf'][$parserFunction]['class']);
		return new $egMapsServices[$service]['pf'][$parserFunction]['class']();
	}	
	
}