<?php

/**
 * Class for geocoding requests with geocoder.us Service.
 *
 * @licence GNU GPL v2+
 */
final class MapsGeocoderusGeocoder extends \Maps\Geocoder {

	/**
	 * Registers the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 3.0
	 */
	public static function register() {
		\Maps\Geocoders::registerGeocoder( 'geocoderus', __CLASS__ );
		return true;
	}

	/**
	 * @see \Maps\Geocoder::getRequestUrl
	 * 
	 * @since 3.0
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */
	protected function getRequestUrl( $address ) {
		return 'http://geocoder.us/service/rest/?address=' . urlencode( $address );
	}

	/**
	 * @see \Maps\Geocoder::parseResponse
	 * 
	 * @since 3.0
	 * 
	 * @param string $address
	 * 
	 * @return array
	 */
	protected function parseResponse( $response ) {
		$lon = self::getXmlElementValue( $response, 'geo:long' );
		$lat = self::getXmlElementValue( $response, 'geo:lat' );

		// In case one of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return array(
			'lat' => (float)$lat,
			'lon' => (float)$lon
		);
	}
}
