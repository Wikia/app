<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Geocoders\FileFetchers;

use DataValues\Geo\Values\LatLongValue;
use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;
use Jeroen\SimpleGeocoder\Geocoder;

/**
 * Webservice documentation: http://wiki.openstreetmap.org/wiki/Nominatim
 *
 * @since 3.8
 *
 * @licence GNU GPL v2+
 * @author Peter Grassberger < petertheone@gmail.com >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NominatimGeocoder implements Geocoder {

	private $fileFetcher;

	public function __construct( FileFetcher $fileFetcher ) {
		$this->fileFetcher = $fileFetcher;
	}

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address ) {
		try {
			$response = $this->fileFetcher->fetchFile( $this->getRequestUrl( $address ) );
		}
		catch ( FileFetchingException $ex ) {
			return null;
		}

		$jsonResponse = json_decode( $response );

		if ( !is_array( $jsonResponse ) || count( $jsonResponse ) < 1 ) {
			return null;
		}

		$location = $jsonResponse[0];

		if ( !isset( $location->lat ) || !isset( $location->lon ) ) {
			return null;
		}

		return new LatLongValue( (float)$location->lat, (float)$location->lon );
	}

	private function getRequestUrl( string $address ): string {
		return 'https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=' . urlencode( $address );
	}

}
