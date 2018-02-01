<?php

namespace Maps\Geocoders;

use BagOStuff;
use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoder;

/**
 * @since 5.0
 *
 * @licence GNU GPL v2+
 * @author HgO < hgo@batato.be >
 */
class CachingGeocoder implements Geocoder {

	private $geocoder;
	private $cache;
	private $cacheTtl;

	public function __construct( Geocoder $geocoder, BagOStuff $cache, int $cacheTtl ) {
		$this->geocoder = $geocoder;
		$this->cache = $cache;
		$this->cacheTtl = $cacheTtl;
	}

	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address ) {
		// Wikia change - wfMemcKey for 1.19 compatibility
		$key = wfMemcKey( __CLASS__, $address );

		$coordinates = $this->cache->get( $key );

		// There was no entry in the cache, so we retrieve the coordinates
		if ( $coordinates === false ) {
			$coordinates = $this->geocoder->geocode( $address );

			$this->cache->set( $key, $coordinates, $this->cacheTtl );
		}

		return $coordinates;
	}
}
