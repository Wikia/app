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
		$urlArgs = [
			'address' => $address
		];
		if ( $GLOBALS['egMapsGMaps3ApiKey'] !== '' ) {
			$urlArgs['key'] = $GLOBALS['egMapsGMaps3ApiKey'];
		}
		if ( $GLOBALS['egMapsGMaps3ApiVersion'] !== '' ) {
			$urlArgs['v'] = $GLOBALS['egMapsGMaps3ApiVersion'];
		}

		return 'https://maps.googleapis.com/maps/api/geocode/xml?' . wfArrayToCgi($urlArgs);
	}
	
	/**
	 * @see \Maps\Geocoder::parseResponse
	 * 
	 * @since 0.7
	 * 
	 * @param string $response
	 * 
	 * @return array
	 */		
	protected function parseResponse( $response ) {
		$lon = self::getXmlElementValue( $response, 'lng' );
		$lat = self::getXmlElementValue( $response, 'lat' );

		// In case on of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return [
			'lat' => (float)$lat,
			'lon' => (float)$lon
		];
	}
	
	/**
	 * @see \Maps\Geocoder::getOverrides
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public static function getOverrides() {
		return [ 'googlemaps3' ];
	}
	
}
