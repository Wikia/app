<?php

/** 
 * A class that holds static helper functions for common functionality that is not map-spesific.
 *
 * @file Maps_Mapper.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsMapper {
	
	/**
	 * Array holding the allowed main parameters and their alias. 
	 * The array keys hold the main name, and the values are arrays holding the aliases.
	 *
	 * @var array
	 */
	private static $mainParams = array
			(
			'service' => array(),
			'geoservice' => array(),
			'coordinates' => array('coords', 'location', 'locations'),
			'zoom' => array(),
			'centre' => array('center'),
			'width' => array(),
			'height' => array(),
			'controls' => array(),
			'label' => array(),
			'title' => array()				
			);
	
	/**
	 * Gets if a provided name is present in the aliases array of a parameter
	 * name in the $mainParams array.
	 *
	 * @param string $name
	 * @param string $mainParamName
	 * @param string $compareMainName
	 * @return boolean
	 */
	public static function inParamAliases($name, $mainParamName, $compareMainName = true) {
		$equals = $compareMainName && $mainParamName == $name;

		if (array_key_exists($mainParamName, self::$mainParams)) {
			$equals = $equals || in_array($name, self::$mainParams[$mainParamName]);
		}

		return $equals;
	}
	
	/**
	 * Gets if a parameter is present as key in the $stack. Also checks for
	 * the presence of aliases in the $mainParams array unless specified not to.
	 *
	 * @param string $paramName
	 * @param array $stack
	 * @param boolean $checkForAliases
	 * @return boolean
	 */		
	public static function paramIsPresent($paramName, array $stack, $checkForAliases = true) {
		$isPresent = array_key_exists($paramName, $stack);
		
		if ($checkForAliases) {
			foreach(self::$mainParams[$paramName] as $alias) {
				if (array_key_exists($alias, $stack)) $isPresent = true;
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
	 * @param array $stack
	 * @param boolean $checkForAliases
	 * @return the parameter value or false
	 */
	public static function getParamValue($paramName, array $stack, $checkForAliases = true) {
		$paramValue = false;
		
		if (array_key_exists($paramName, $stack)) $paramValue = $stack[$paramName];
		
		if ($checkForAliases) {
			foreach(self::$mainParams[$paramName] as $alias) {
				if (array_key_exists($alias, $stack)) $paramValue = $stack[$alias];
			}
		}
		
		return $paramValue;		
	}
			
	/**
	 * Sets the default map properties and returns the new array.
	 * This function also ensures all the properties are present, even when being empty,
	 * which is important for the weakly typed classes using them.
	 *
	 * @param array $params Array containing the current set of pareters.
	 * @param array $serviceDefaults Array with the default parameters and their values for the used mapping service.
	 * @param boolean $strict If set to false, values which a key that does not
	 * exist in the $map array will be retained.
	 * @return array
	 */
	public static function setDefaultParValues(array $params, array $serviceDefaults, $strict = true) {
		global $egMapsMapLat, $egMapsMapLon, $egMapsMapWidth, $egMapsMapHeight, $egMapsDefaultService;

        $mapDefaults = array(
            'service' => $egMapsDefaultService,
        	'geoservice' => '',
            'coordinates' => "$egMapsMapLat, $egMapsMapLon",
        	'zoom' => '',
        	'centre' => '',
            'width' => $egMapsMapWidth,
            'height' => $egMapsMapHeight,  
        	'controls' => array(),
        	'title' => '',
        	'label' => ''
            );	

        $map = array_merge($mapDefaults, $serviceDefaults);
		
		foreach($params as $paramName => $paramValue) {
			if(array_key_exists($paramName, $map) || !$strict) $map[$paramName] = $paramValue;
		}
		
		return $map;
	}
	
	/**
	 * Returns the JS version (true/false as string) of the provided boolean parameter.
	 *
	 * @param boolean $bool
	 * @return string
	 */
	public static function getJSBoolValue($bool) {		
		return $bool ? 'true' : 'false';
	}	
	
	/**
	 * Turns the provided values into an array by splitting it on comma's if
	 * it's not an array yet.
	 *
	 * @param unknown_type $values
	 * @param string $delimeter
	 */
	public static function enforceArrayValues(&$values, $delimeter = ',') {
		if (!is_array($values)) $values = split($delimeter, $values); // If not an array yet, split the values
		for ($i = 0; $i < count($values); $i++) $values[$i] = trim($values[$i]); // Trim all values
	}
	
	/**
	 * Checks if the items array has members, and sets it to the default when this is not the case.
	 * Then returns an imploded/joined, comma seperated, version of the array as string.
	 *
	 * @param array $items
	 * @param array $defaultItems
	 * @param boolean $asStrings
	 * @return string
	 */
	public static function createJSItemsString(array $items, array $defaultItems = null, $asStrings = true, $toLower = true) {
		if (count($items) < 1 && isset($defaultItems)) $items = $defaultItems;
		$itemString = $asStrings ? "'" . implode("','", $items) . "'" : implode(',', $items);
		if ($toLower) $itemString = strtolower($itemString);
		return $itemString;
	}		
	
	/**
	 * Returns a valid version of the provided parameter array. Paramaters that are not allowed will
	 * be ignored, and alias parameter names will be changed to main parameter names, using getMainParamName().
	 *
	 * @param array $paramz
	 * @param array $serviceParameters
	 * @return array
	 */
	public static function getValidParams(array $paramz, array $serviceParameters, $strict = true) {
		$validParams = array();
		
		$allowedParms = array_merge(self::$mainParams, $serviceParameters);
		
		foreach($paramz as $paramName => $paramValue) {		
			$paramName = self::getMainParamName($paramName, $allowedParms);
			if(array_key_exists($paramName, $allowedParms) || !$strict) $validParams[$paramName] = $paramValue;
		}
		
		return $validParams;		
	}
	
	/**
	 * Checks if the patameter name is an alias for an actual parameter,
	 * and changes it into the main paremeter name if this is the case.
	 *
	 * @param string $paramName
	 * @param array $allowedParms
	 * @return string
	 */
	private static function getMainParamName($paramName, array $allowedParms) {
		if (!array_key_exists($paramName, $allowedParms)) {
			foreach ($allowedParms as $name => $aliases) {
				if (in_array($paramName, $aliases)) {
					$paramName = $name;
				}
			}
		}
		return $paramName;
	}		
		
	/**
	 * Returns a valid service. When an invalid service is provided, the default one will be returned.
	 * Aliases are also chancged into the main service names @see MapsMapper::getMainServiceName().
	 *
	 * @param string $service
	 * @return string
	 */
	public static function getValidService($service, $feature = '') {
		global $egMapsAvailableServices, $egMapsDefaultService, $egMapsDefaultServices, $egMapsServices;
		
		$service = self::getMainServiceName($service);
		
		if ($feature != '') {
			$shouldChange = ! array_key_exists($service, $egMapsServices);
			if (! $shouldChange) $shouldChange = ! array_key_exists($feature, $egMapsServices[$service]);
			
			if ($shouldChange) {
				$service = array_key_exists($feature, $egMapsDefaultServices) ? $egMapsDefaultServices[$feature] : $egMapsDefaultService;
			}
		}
		
		if(! in_array($service, $egMapsAvailableServices)) $service = $egMapsDefaultService;
		
		return $service;
	}
	
	/**
	 * Checks if the service name is an alias for an actual service,
	 * and changes it into the main service name if this is the case.
	 *
	 * @param string $service
	 * @return string
	 */
	public static function getMainServiceName($service) {
		global $egMapsServices;
		
		if (! array_key_exists($service, $egMapsServices)) {
			foreach ($egMapsServices as $serviceName => $serviceInfo) {
				if (in_array($service, $serviceInfo['aliases'])) {
					 $service = $serviceName;
				}
			}
		}
		
		return $service;
	}
	
	/**
	 * Returns a valid version of the types.
	 *
	 * @param array $types
	 * @param array $defaults
	 * @param boolean $defaultsAreValid
	 * @param function $validationFunction
	 * @return array
	 */
	public static function getValidTypes(array $types, array &$defaults, &$defaultsAreValid, $validationFunction) {
		$validTypes = array();
		$phpAtLeast523 = MapsUtils::phpVersionIsEqualOrBigger('5.2.3');
		
		// Ensure every type is valid and uses the relevant map API's name.
		for($i = 0 ; $i < count($types); $i++) {
			$type = call_user_func($validationFunction, $phpAtLeast523 ? $types[$i] : array($types[$i]));
			if ($type) $validTypes[] = $type; 
		}
		
		$types = $validTypes;
		
		// If there are no valid types, add the default ones.
		if (count($types) < 1) {
			$validTypes = array();
			
			// If the default ones have not been checked,
			// ensure every type is valid and uses the relevant map API's name.
			if (empty($defaultsAreValid)) {
				for($i = 0 ; $i < count($defaults); $i++) {
					$type = call_user_func($validationFunction, $phpAtLeast523 ? $defaults[$i] : array($defaults[$i]));
					if ($type) $validTypes[] = $type; 
				}
				
				$defaults = $validTypes;
				$defaultsAreValid = true;
			}
			
			$types = $defaults;
		}

		return $types;
	}
	

}
