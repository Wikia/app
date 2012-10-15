<?php

/**
 * Class for geocoding requests with the GeoNames webservice.
 * @deprecated
 * 
 * GeoNames Web Services Documentation: http://www.geonames.org/export/geonames-search.html
 *
 * @file Maps_GeonamesGeocoder.php
 * @ingroup Maps
 * @ingroup Geocoders
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * 
 * Thanks go to Joel Natividad for pointing me to the GeoNames services.
 */
final class MapsGeonamesOldGeocoder extends MapsGeocoder {
	
	/**
	 * Registeres the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 0.7
	 */
	public static function register() {
		global $egMapsGeoNamesUser;
		
		MapsGeocoders::registerGeocoder( $egMapsGeoNamesUser === '' ? 'geonames' : 'geonamesold', __CLASS__ );
		
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