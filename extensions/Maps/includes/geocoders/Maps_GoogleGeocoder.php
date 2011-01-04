<?php

/**
 * Class for geocoding requests with the Google Geocoding Service (v2).
 * 
 * Webservice documentation: http://code.google.com/apis/maps/documentation/services.html#Geocoding_Direct
 *
 * @file Maps_GoogleGeocoder.php
 * @ingroup Maps
 * @ingroup Geocoders
 *
 * @author Jeroen De Dauw
 * @author Sergey Chernyshev
 */
final class MapsGoogleGeocoder extends MapsGeocoder {
	
	/**
	 * Registeres the geocoder.
	 * 
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 0.7
	 */
	public static function register() {
		MapsGeocoders::registerGeocoder( 'google', __CLASS__ );
		return true;
	}		
	
	/**
	 * @see MapsGeocoder::getRequestUrl
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */	
	protected function getRequestUrl( $address ) {
		global $egGoogleMapsKey;
		return 'http://maps.google.com/maps/geo?q=' . urlencode( $address ) . '&output=csv&key=' . urlencode( $egGoogleMapsKey );
	}
	
	/**
	 * @see MapsGeocoder::parseResponse
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return array
	 */		
	protected function parseResponse( $response ) {
		// Check the Google Geocoder API Response code to ensure success.
		if ( substr( $response, 0, 3 ) == '200' ) {
			$result =  explode( ',', $response );
			
			// $precision = $result[1];

			return array(
				'lat' => $result[2],
				'lon' => $result[3]
			);
		}
		else { // When the request fails, return false.
			return false;
		}		
	}
	
	/**
	 * @see MapsGeocoder::getOverrides
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public function getOverrides() {
		return array( 'googlemaps2', 'googlemaps3' );
	}
	
}