<?php

/**
 * Class for geocoding requests with the GeoNames webservice.
 * 
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsGeonamesGeocoder extends \Maps\Geocoder {
	
	/**
	 * Registers the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 1.0
	 */
	public static function register() {
		global $egMapsGeoNamesUser;
		
		if ( $egMapsGeoNamesUser !== '' ) {
			\Maps\Geocoders::registerGeocoder( 'geonames', __CLASS__ );
		}
		
		return true;
	}	
	
	/**
	 * @see \Maps\Geocoder::getRequestUrl
	 * 
	 * @since 1.0
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */	
	protected function getRequestUrl( $address ) {
		global $egMapsGeoNamesUser;
		return 'http://api.geonames.org/search?q=' . urlencode( $address ) . '&maxRows=1&username=' . urlencode( $egMapsGeoNamesUser );
	}
	
	/**
	 * @see \Maps\Geocoder::parseResponse
	 * 
	 * @since 1.0
	 * 
	 * @param string $address
	 * 
	 * @return array
	 */		
	protected function parseResponse( $response ) {
		$lon = self::getXmlElementValue( $response, 'lng' );
		$lat = self::getXmlElementValue( $response, 'lat' );

		// In case one of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return array(
			'lat' => (float)$lat,
			'lon' => (float)$lon
		);		
	}
	
}