<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder;

use DataValues\Geo\Values\LatLongValue;

/**
 * @since 3.8
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Geocoder {

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address );

}