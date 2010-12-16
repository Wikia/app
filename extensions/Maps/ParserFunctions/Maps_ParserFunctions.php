<?php
 
/**
 * Initialization file for parser function functionality in the Maps extension
 *
 * @file Maps_ParserFunctions.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * A class that holds handlers for the mapping parser functions.
 * 
 * @author Jeroen De Dauw
 */
final class MapsParserFunctions {
	
	public static $parameters = array();
	
	/**
	 * Initialize the parser functions feature. This function handles the parser function hook,
	 * and will load the required classes.
	 */
	public static function initialize() {
		global $egMapsDir, $IP, $wgAutoloadClasses, $egMapsAvailableFeatures, $egMapsServices;
		
		include_once $egMapsDir . 'ParserFunctions/Maps_iDisplayFunction.php';
		
		self::initializeParams();	
		
		foreach($egMapsServices as $serviceName => $serviceData) {
			// Check if the service has parser function support
			$hasPFs = array_key_exists('pf', $serviceData);
			
			// If the service has no parser function support, skipt it and continue with the next one.
			if (!$hasPFs) continue;
			
			// Go through the parser functions supported by the mapping service, and load their classes.
			foreach($serviceData['pf'] as $parser_name => $parser_data) {
				$file = $parser_data['local'] ? $egMapsDir . $parser_data['file'] : $IP . '/extensions/' . $parser_data['file'];
				$wgAutoloadClasses[$parser_data['class']] = $file;
			}
		}
		
		// This runs a small hook that enables parser functions to run initialization code.
		foreach($egMapsAvailableFeatures['pf']['hooks'] as $hook) {
			if (method_exists($hook, 'initialize')) call_user_func(array($hook, 'initialize'));
		}			
	}
	
	private static function initializeParams() {
		global $egMapsAvailableServices, $egMapsDefaultServices, $egMapsAvailableGeoServices, $egMapsDefaultGeoService;
		
		self::$parameters = array(
			'service' => array(
				'criteria' => array(
					'in_array' => $egMapsAvailableServices
					),
				'default' => $egMapsDefaultServices['pf']
				),
			'coordinates' => array(				
				'aliases' => array('coords', 'location', 'locations'),
				),			
			'geoservice' => array(
				'criteria' => array(
					'in_array' => array_keys($egMapsAvailableGeoServices)
					),
				'default' => $egMapsDefaultGeoService
				),	
			);		
	}
	
	/**
	 * Returns the output for the call to the specified parser function.
	 * 
	 * @param $parser
	 * @param array $params
	 * @param string $parserFunction
	 * 
	 * @return array
	 */
	public static function getMapHtml(&$parser, array $params, $parserFunction) {
        global $wgLang, $egValidatorErrorLevel;
        
        array_shift( $params ); // We already know the $parser.
        
        $map = array();
        $coordFails = array();
        
        $paramInfo = array_merge(MapsMapper::getMainParams(), self::$parameters);
        
        $geoFails = self::changeAddressesToCoords($params, $paramInfo);        
        
        // Go through all parameters, split their names and values, and put them in the $map array.
        foreach($params as $param) {
            $split = explode('=', $param);
            if (count($split) > 1) {
                $paramName = strtolower(trim($split[0]));
                $paramValue = trim($split[1]);
                if (strlen($paramName) > 0 && strlen($paramValue) > 0) {
                	$map[$paramName] = $paramValue;
                	if (self::inParamAliases($paramName, 'coordinates', $paramInfo)) $coordFails = self::filterInvalidCoords($map[$paramName]);
                }
            }
            else if (count($split) == 1) { // Default parameter (without name)
            	$split[0] = trim($split[0]);
                if (strlen($split[0]) > 0) $map['coordinates'] = $split[0];
            }
        }

        $coords = self::getParamValue('coordinates', $map, $paramInfo);
        
        if ($coords) {
            if (! self::paramIsPresent('service', $map, $paramInfo)) $map['service'] = '';

            $map['service'] = MapsMapper::getValidService($map['service'], 'pf', $parserFunction);                

            $mapClass = self::getParserClassInstance($map['service'], $parserFunction);
    
            // Call the function according to the map service to get the HTML output
            $output = $mapClass->displayMap($parser, $map);    

            if ($egValidatorErrorLevel >= Validator_ERRORS_WARN) {
	            if (count($coordFails) > 0) {
	                $output .= '<i>' . wfMsgExt( 'maps_unrecognized_coords_for', array( 'parsemag' ), $wgLang->listToText( $coordFails ), count( $coordFails ) ) . '</i>';
	            }

	            if (count($geoFails) > 0) {
	                $output .= '<i>' . wfMsgExt( 'maps_geocoding_failed_for', array( 'parsemag' ), $wgLang->listToText( $geoFails ), count( $geoFails ) ) . '</i>';
	            }            	
            }
        }
        elseif ($egValidatorErrorLevel >= Validator_ERRORS_MINIMAL) {
	        if (trim($coords) == '' && (count($geoFails) > 0 || count($coordFails) > 0)) {
	        	if (count($coordFails) > 0) $output = '<i>' . wfMsgExt( 'maps_unrecognized_coords', array( 'parsemag' ), $wgLang->listToText( $coordFails ), count( $coordFails ) ) . '</i>';
	            if (count($geoFails) > 0) $output = '<i>' . wfMsgExt( 'maps_geocoding_failed', array( 'parsemag' ), $wgLang->listToText( $geoFails ), count( $geoFails ) ) . '</i>';
	            $output .= '<i>' . wfMsg('maps_map_cannot_be_displayed') .'</i>';
	        }
	        else {
	            $output = '<i>'.wfMsg( 'maps_coordinates_missing' ).'</i>';
	        }
        }
        
        // Return the result
        return $parser->insertStripItem($output, $parser->mStripState);	
	}		
	
	/**
	 * Filters all non coordinate valus from a coordinate string, 
	 * and returns an array containing all filtered out values.
	 * 
	 * @param string $coordList
	 * @param string $delimeter
	 * 
	 * @return array
	 */
	private static function filterInvalidCoords(&$coordList, $delimeter = ';') {
		$coordFails = array();
		$validCoordinates = array();
        $coordinates = explode($delimeter, $coordList);
        
        foreach($coordinates as $coordinate) {
        	if (MapsGeocodeUtils::isCoordinate($coordinate)) {
        		$validCoordinates[] = $coordinate;
        	}
        	else {
        		$coordFails[] = $coordinate;
        	}
        }
        
        $coordList = implode($delimeter, $validCoordinates);  
        return $coordFails;
	}
	
	/**
	 * Changes the values of the address or addresses parameter into coordinates
	 * in the provided array. Returns an array containing the addresses that
	 * could not be geocoded.
	 *
	 * @param array $params
	 * 
	 * @return array
	 */
	private static function changeAddressesToCoords(&$params, array $paramInfo) {
		global $egMapsDefaultService;

		$fails = array();
		
		// Get the service and geoservice from the parameters, since they are needed to geocode addresses.
		for ($i = 0; $i < count($params); $i++) {
			$split = explode('=', $params[$i]);
			if (self::inParamAliases(strtolower(trim($split[0])), 'service', $paramInfo) && count($split) > 1) {
				$service = trim($split[1]);
			}
			else if (strtolower(trim($split[0])) == 'geoservice' && count($split) > 1) {
				$geoservice = trim($split[1]);
			}			
		}

		// Make sure the service and geoservice are valid.
		$service = isset($service) ? MapsMapper::getValidService($service, 'pf') : $egMapsDefaultService;
		if (! isset($geoservice)) $geoservice = '';
		
		// Go over all parameters.
		for ($i = 0; $i < count($params); $i++) {
			$split = explode('=', $params[$i]);
			$isAddress = (strtolower(trim($split[0])) == 'address' || strtolower(trim($split[0])) == 'addresses') && count($split) > 1;
			$isDefault = count($split) == 1;
			
			// If a parameter is either the default (no name), or an addresses list, extract all locations.
			if ($isAddress || $isDefault) {
				
				$address_srting = $split[count($split) == 1 ? 0 : 1];
				$addresses = explode(';', $address_srting);

				$coordinates = array();
				
				// Go over every location and attempt to geocode it.
				foreach($addresses as $address) {
					$args = explode('~', $address);
					$args[0] = trim($args[0]);
					
					if (strlen($args[0]) > 0) {
						$coords =  MapsGeocodeUtils::attemptToGeocode($args[0], $geoservice, $service, $isDefault);
						
						if ($coords) {
							$args[0] = $coords;
							$coordinates[] = implode('~', $args);
						}
						else {
							$fails[] = $args[0];
						}
					}
				}				
				
				// Add the geocoded result back to the parameter list.
				$params[$i] = implode(';', $coordinates);

			}
			
		}

		return $fails;
	}	
	
	/**
	 * Returns an instance of the class supporting the spesified mapping service for
	 * the also spesified parser function.
	 * 
	 * @param string $service
	 * @param string $parserFunction
	 * 
	 * @return class
	 */
	private static function getParserClassInstance($service, $parserFunction) {
		global $egMapsServices;
		return new $egMapsServices[$service]['pf'][$parserFunction]['class']();
	}		
	
	/**
	 * Gets if a provided name is present in the aliases array of a parameter
	 * name in the $mainParams array.
	 *
	 * @param string $name The name you want to check for.
	 * @param string $mainParamName The main parameter name.
	 * @param array $paramInfo Contains meta data, including aliases, of the possible parameters.
	 * @param boolean $compareMainName Boolean indicating wether the main name should also be compared.
	 * 
	 * @return boolean
	 */
	private static function inParamAliases($name, $mainParamName, array $paramInfo = array(), $compareMainName = true) {
		$equals = $compareMainName && $mainParamName == $name;

		if (array_key_exists($mainParamName, $paramInfo)) {
			$equals = $equals || in_array($name, $paramInfo[$mainParamName]);
		}

		return $equals;
	}	
	
    /**
     * Gets if a parameter is present as key in the $stack. Also checks for
     * the presence of aliases in the $mainParams array unless specified not to.
     *
     * @param string $paramName
     * @param array $stack
	 * @param array $paramInfo Contains meta data, including aliases, of the possible parameters.
     * @param boolean $checkForAliases
     * 
     * @return boolean
     */        
    private static function paramIsPresent($paramName, array $stack, array $paramInfo = array(), $checkForAliases = true) {
        $isPresent = array_key_exists($paramName, $stack);
        
        if ($checkForAliases && array_key_exists('aliases', $paramInfo[$paramName])) {
            foreach($paramInfo[$paramName]['aliases'] as $alias) {
                if (array_key_exists($alias, $stack)) {
                	$isPresent = true;
                	break;
                }
            }
        }

        return $isPresent;
    }
	
	/**
	 * Returns the value of a parameter represented as key in the $stack.
	 * Also checks for the presence of aliases in the $mainParams array
	 * and returns the value of the alies unless specified not to. When
	 * no array key name match is found, false will be returned.
	 *
	 * @param string $paramName
	 * @param array $stack The values to search through
	 * @param array $paramInfo Contains meta data, including aliases, of the possible parameters.
	 * @param boolean $checkForAliases
	 * 
	 * @return the parameter value or false
	 */
	private static function getParamValue($paramName, array $stack, array $paramInfo = array(), $checkForAliases = true) {
		$paramValue = false;
		
		if (array_key_exists($paramName, $stack)) $paramValue = $stack[$paramName];
		
		if ($checkForAliases) {
			foreach($paramInfo[$paramName]['aliases'] as $alias) {
				if (array_key_exists($alias, $stack)) $paramValue = $stack[$alias];
				break;
			}
		}
		
		return $paramValue;		
	}		

}