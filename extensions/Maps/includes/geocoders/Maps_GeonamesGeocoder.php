<?php

/**
 * Class for geocoding requests with the GeoNames webservice.
 * 
 * GeoNames Web Services Documentation: http://www.geonames.org/export/geonames-search.html
 *
 * @file Maps_GeonamesGeocoder.php
 * @ingroup Maps
 * @ingroup Geocoders
 *
 * @author Jeroen De Dauw
 * Thanks go to Joel Natividad for pointing me to the GeoNames services.
 */
final class MapsGeonamesGeocoder extends MapsGeocoder {
	
	/**
	 * Registeres the geocoder.
	 * 
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 0.7
	 */
	public static function register() {
		MapsGeocoders::registerGeocoder( 'geonames', __CLASS__ );
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
		return 'http://ws.geonames.org/search?q=' . urlencode( $address ) . '&maxRows=1&style=SHORT';
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
		$lon = self::getXmlElementValue( $response, 'lng' );
		$lat = self::getXmlElementValue( $response, 'lat' );

		// In case one of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return array(
			'lat' => $lat,
			'lon' => $lon
		);		
	}
	
}