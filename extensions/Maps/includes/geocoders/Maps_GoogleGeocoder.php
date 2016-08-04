<?php

/**
 * Class for geocoding requests with the Google Geocoding Service (v3).
 * 
 * Webservice documentation: http://code.google.com/apis/maps/documentation/geocoding/
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Sergey Chernyshev
 * @author Desiree Gennaro
 */
final class MapsGoogleGeocoder extends \Maps\Geocoder {
	
	/**
	 * Registers the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 0.7
	 */
	public static function register() {
		\Maps\Geocoders::registerGeocoder( 'google', __CLASS__ );
		return true;
	}		
	
	/**
	 * @see \Maps\Geocoder::getRequestUrl
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */	
	protected function getRequestUrl( $address ) {
		return 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode( $address ) . '&sensor=false';
	}
	
	/**
	 * @see \Maps\Geocoder::parseResponse
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return array
	 */		
	protected function parseResponse( $response ) {
		$lon = self::getXmlElementValue( $response, 'lng' );
		$lat = self::getXmlElementValue( $response, 'lat' );

		// In case on of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return array(
			'lat' => (float)$lat,
			'lon' => (float)$lon
		);
	}
	
	/**
	 * @see \Maps\Geocoder::getOverrides
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public static function getOverrides() {
		return array( 'googlemaps3' );
	}
	
}