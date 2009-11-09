<?php

/** 
 * Geocoding class. Provides methods to geocode a string to a pair of coordinates
 * using one of the available geocoding services.
 *
 * @file Maps_Geocoder.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Sergey Chernyshev
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsGeocoder {

	/**
	 * Holds if geocoded data should be cached or not.
	 *
	 * @var boolean
	 */
	private static $mEnableCache = true;
	
	/**
	 * The geocoder cache, holding geocoded data when enabled.
	 *
	 * @var array
	 */
	private static $mGeocoderCache = array();
	
	/**
	 * Geocodes an address with the provided geocoding service and returns the result 
	 * as a string with the optionally provided format, or false when the geocoding failed.
	 * 
	 * @param string $address
	 * @param string $service
	 * @param string $mappingService
	 * @param string $format
	 * @return formatted coordinate string or false
	 */
	public static function geocodeToString($address, $service = '', $mappingService = '', $format = '%1$s, %2$s') {
		$geovalues = MapsGeocoder::geocode($address, $service, $mappingService);
		return $geovalues ? sprintf($format, $geovalues['lat'], $geovalues['lon']) : false;
	}

	/**
	 * Geocodes an address with the provided geocoding service and returns the result 
	 * as an array, or false when the geocoding failed.
	 *
	 * @param string $address
	 * @param string $service
	 * @param string $mappingService
	 * @return array with coordinates or false
	 */
	public static function geocode($address, $service, $mappingService) {
		global $egMapsAvailableGeoServices, $wgAutoloadClasses, $egMapsIP, $IP;
		
		// If the adress is already in the cache and the cache is enabled, return the coordinates.
		if (self::$mEnableCache && array_key_exists($address, MapsGeocoder::$mGeocoderCache)) {
			return self::$mGeocoderCache[$address];
		}
		
		$coordinates = false;
		
		$service = self::getValidGeoService($service, $mappingService);
		
		// Make sure the needed class is loaded.
		$file = $egMapsAvailableGeoServices[$service]['local'] ? $egMapsIP . '/' . $egMapsAvailableGeoServices[$service]['file'] : $IP . '/extensions/' . $egMapsAvailableGeoServices[$service]['file'];
		$wgAutoloadClasses[$egMapsAvailableGeoServices[$service]['class']] = $file;
		
		// Call the geocode function in the spesific geocoder class.
		$phpAtLeast523 = MapsUtils::phpVersionIsEqualOrBigger('5.2.3');
		$coordinates = call_user_func(array($egMapsAvailableGeoServices[$service]['class'], 'geocode'), $phpAtLeast523 ? $address : array($address));

		// Add the obtained coordinates to the cache when there is a result and the cache is enabled.
		if (self::$mEnableCache && $coordinates) {
			MapsGeocoder::$mGeocoderCache[$address] = $coordinates;
		}

		return $coordinates;
	}
	
	/**
	 * Makes sure that the geo service is one of the available ones.
	 * Also enforces licencing restrictions when no geocoding service is explicitly provided.
	 *
	 * @param string $service
	 * @param string $mappingService
	 * @return string
	 */
	private static function getValidGeoService($service, $mappingService) {
		global $egMapsAvailableGeoServices, $egMapsDefaultGeoService;
		
		if (strlen($service) < 1) {
			// If no service has been provided, check if there are overrides for the default.
			foreach ($egMapsAvailableGeoServices as $geoService => $serviceData) {
				if (in_array($mappingService, $serviceData))  {
					$service = $geoService; // Use the override
					continue;
				}
			}	
			
			// If no overrides where applied, use the default mapping service.
			if (strlen($service) < 1) $service = $egMapsDefaultGeoService;
		}
		else {
			// If a service is provided, but is not supported, use the default.
			if(!array_key_exists($service, $egMapsAvailableGeoServices)) $service = $egMapsDefaultGeoService;
		}

		return $service;
	}	
}



