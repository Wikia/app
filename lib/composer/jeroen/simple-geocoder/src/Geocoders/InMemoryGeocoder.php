<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Geocoders;

use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoder;

/**
 * @since 3.8
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class InMemoryGeocoder implements Geocoder {

	private $locations;

	/**
	 * @param LatLongValue[] $locations
	 */
	public function __construct( array $locations ) {
		$this->locations = $locations;
	}

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address ) {
		if ( array_key_exists( $address, $this->locations ) ) {
			return $this->locations[$address];
		}

		return null;
	}

}
