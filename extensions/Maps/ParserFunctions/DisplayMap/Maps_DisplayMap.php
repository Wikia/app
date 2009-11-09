<?php

/**
 * 
 *
 * @file Maps_DisplayMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgAutoloadClasses['MapsDisplayMap'] 	= $egMapsIP . '/ParserFunctions/DisplayMap/Maps_DisplayMap.php';
$wgAutoloadClasses['MapsBaseMap'] 		= $egMapsIP . '/ParserFunctions/DisplayMap/Maps_BaseMap.php';

$wgHooks['LanguageGetMagic'][] 			= 'efMapsDisplayMapMagic';
$wgHooks['ParserFirstCallInit'][] 		= 'efMapsRegisterDisplayMap';

/**
 * Adds the magic words for the parser functions
 */
function efMapsDisplayMapMagic( &$magicWords, $langCode ) {
	$magicWords['display_map'] = array( 0,  'display_map');
	
	return true; // Unless we return true, other parser functions won't get loaded
}	

/**
 * Adds the parser function hooks
 */
function efMapsRegisterDisplayMap(&$wgParser) {
	// A hook to enable the '#display_map' parser function
	$wgParser->setFunctionHook( 'display_map', array('MapsDisplayMap', 'displayMapRender') );
	
	return true;
}

/**
 * 
 * 
 * @author Jeroen De Dauw
 *
 */
final class MapsDisplayMap {
	
	/**
	 * If an address value is provided, turn it into coordinates,
	 * then calls getMapHtml() and returns it's result. 
	 *
	 * @param unknown_type $parser
	 * @return array
	 */
	public static function displayMapRender(&$parser) {		
		$params = func_get_args();
		array_shift( $params ); // We already know the $parser ...
		
		$fails = MapsParserGeocoder::changeAddressesToCoords($params);
		
		return self::getMapHtml($parser, $params, 'display_map', $fails);
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