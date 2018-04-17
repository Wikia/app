<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Geocoders\Decorators;

use DataValues\Geo\Parsers\LatLongParser;
use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoder;
use ValueParsers\ParseException;

/**
 * Geocoder decorator that tries to parse the address as coordinates
 * and only upon failure does the actual geocoding.
 *
 * @since 5.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CoordinateFriendlyGeocoder implements Geocoder {

	private $geocoder;
	private $coordinateParser;

	public function __construct( Geocoder $geocoder ) {
		$this->geocoder = $geocoder;
		$this->coordinateParser = new LatLongParser();
	}

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address ) {
		try {
			return $this->coordinateParser->parse( $address );
		}
		catch ( ParseException $parseException ) {
			return $this->geocoder->geocode( $address );
		}
	}

}
