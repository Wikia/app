<?php

/**
 * MapsGeocodeUtils holds static functions to geocode values when needed.
 *
 * @file Maps_GeocodeUtils.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsGeocodeUtils {
	/**
	 * This function first determines wether the provided string is a pair or coordinates 
	 * or an address. If it's the later, an attempt to geocode will be made. The function will
	 * return the coordinates or false, in case a geocoding attempt was made but failed. 
	 * 
	 * @param $coordsOrAddress
	 * @param $geoservice
	 * @param $service
	 * 
	 * @return string or boolean
	 */
	public static function attemptToGeocode($coordsOrAddress, $geoservice, $service, $checkForCoords = true) {
		if ($checkForCoords) {
			if (MapsGeocodeUtils::isCoordinate($coordsOrAddress)) {
				$coords = $coordsOrAddress;
			}
			else {
				$coords = MapsGeocoder::geocodeToString($coordsOrAddress, $geoservice, $service);
			}
		}
		else {
			$coords = MapsGeocoder::geocodeToString($coordsOrAddress, $geoservice, $service);
		}
		
		return $coords;
	}	
	
	/**
	 * Returns a boolean indication if a provided value is a valid coordinate.
	 * 
	 * @param string $coordsOrAddress
	 * 
	 * @return boolean
	 */
	public static function isCoordinate($coordsOrAddress) {
		$coordRegexes = array(
			'/^(-)?\d{1,3}(\.\d{1,20})?,(\s)?(-)?\d{1,3}(\.\d{1,20})?$/', // Floats
			'/^(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,2}(″|"))?)(N|S)(\s)?(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,2}(″|"))?)(E|W)$/', // DMS 
			'/^(-)?\d{1,3}(|\.\d{1,20})°,(\s)?(-)?(\s)?\d{1,3}(|\.\d{1,20})°$/', // DD
			'/^\d{1,3}(|\.\d{1,20})°(\s)?(N|S),(\s)?(\s)?\d{1,3}(|\.\d{1,20})°(\s)(E|W)?$/', // DD (directional)
			'/(-)?\d{1,3}°\d{1,3}(\.\d{1,20}\')?,(\s)?(-)?\d{1,3}°\d{1,3}(\.\d{1,20}\')?$/', // DM
			); 
			
		$isCoordinate = false;
		
		foreach ($coordRegexes as $coordRegex) {
			if (preg_match($coordRegex, trim($coordsOrAddress))) {
				$isCoordinate = true;
				continue;
			}		
		}

		return $isCoordinate;
	}	
	
}