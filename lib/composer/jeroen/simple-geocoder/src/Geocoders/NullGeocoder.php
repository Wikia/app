<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Geocoders;

use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoder;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullGeocoder implements Geocoder {

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address ) {
		return null;
	}

}
