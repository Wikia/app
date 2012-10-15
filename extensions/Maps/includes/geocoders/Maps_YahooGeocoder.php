<?php

/**
 * Class for geocoding requests with the Yahoo! Geocoding Service.
 * 
 * Yahoo! Geocoding Service info: http://developer.yahoo.com/geo/geoplanet/
 *
 * @file Maps_YahooGeocoder.php
 * @ingroup Maps
 * @ingroup Geocoders
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsYahooGeocoder extends MapsGeocoder {
	
	/**
	 * Registeres the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 0.7
	 */
	public static function register() {
		MapsGeocoders::registerGeocoder( 'yahoo', __CLASS__ );
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
		global $egYahooMapsKey;
		return "http://where.yahooapis.com/v1/places.q('" . urlencode( $address ) . "')?appid=" . urlencode( $egYahooMapsKey ) . '&format=xml';
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
		$lon = self::getXmlElementValue( $response, 'longitude' );
		$lat = self::getXmlElementValue( $response, 'latitude' );

		// In case one of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return array(
			'lat' => (float)$lat,
			'lon' => (float)$lon
		);	
	}
	
	/**
	 * @see MapsGeocoder::getOverrides
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public static function getOverrides() {
		return array( 'yahoomaps' );
	}
	
}