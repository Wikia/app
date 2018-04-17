<?php

namespace SimpleCache\Cache;

/**
 * Very simple in memory cache. Entries are kept around until the object gets destructed.
 *
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleInMemoryCache implements Cache {

	protected $memoryCache = array();

	public function get( $key ) {
		return array_key_exists( $key, $this->memoryCache ) ? $this->memoryCache[$key] : null;
	}

	public function has( $key ) {
		return array_key_exists( $key, $this->memoryCache );
	}

	public function set( $key, $value ) {
		$this->memoryCache[$key] = $value;
	}

}
