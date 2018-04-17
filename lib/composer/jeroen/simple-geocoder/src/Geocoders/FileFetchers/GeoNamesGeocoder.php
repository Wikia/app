<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Geocoders\FileFetchers;

use DataValues\Geo\Values\LatLongValue;
use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;
use Jeroen\SimpleGeocoder\Geocoder;

/**
 * @since 4.5
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeoNamesGeocoder implements Geocoder {

	private $fileFetcher;
	private $geoNamesUser;

	public function __construct( FileFetcher $fileFetcher, string $geoNamesUser ) {
		$this->fileFetcher = $fileFetcher;
		$this->geoNamesUser = $geoNamesUser;
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

		$lon = self::getXmlElementValue( $response, 'lng' );
		$lat = self::getXmlElementValue( $response, 'lat' );

		if ( !$lon || !$lat ) {
			return null;
		}

		return new LatLongValue( (float)$lat, (float)$lon );
	}

	private function getRequestUrl( string $address ): string {
		return 'http://api.geonames.org/search?q='
			. urlencode( $address )
			. '&maxRows=1&username='
			. urlencode( $this->geoNamesUser );
	}

	private function getXmlElementValue( string $xml, string $tagName ) {
		$match = [];
		preg_match( "/<$tagName>(.*?)<\/$tagName>/", $xml, $match );
		return count( $match ) > 1 ? $match[1] : false;
	}

}
