<?php

/**
 * Google Geocoding Service info: http://code.google.com/apis/maps/documentation/services.html#Geocoding_Direct
 *
 * @file Maps_GoogleGeocoder.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Sergey Chernyshev
 * 
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsGoogleGeocoder extends MapsBaseGeocoder {
	
	/**
	 * @see MapsBaseGeocoder::geocode()
	 *
	 * @param string $address
	 */
	public static function geocode($address) {
		global $egGoogleMapsKey;

		// In case the google maps api key is not set, return false
		if (empty($egGoogleMapsKey)) return false;

		// Create the request url
		$requestURL = 'http://maps.google.com/maps/geo?q='.urlencode($address).'&output=csv&key='.urlencode($egGoogleMapsKey);

		$result = self::GetResponse($requestURL);
		
		//Check the Google Geocoder API Response code to ensure success
		if (substr($result, 0, 3) == '200') {
			$result =  explode(',', $result);
			
			//$precision = $result[1];
			$latitude = $result[2];
			$longitude = $result[3];

			return array(
						'lat' => $latitude,
						'lon' => $longitude
						);			
		}
		else { // When the request fails, return false
			return false;	
		}
	}
}