<?php

namespace SimpleCache\Cache;

use InvalidArgumentException;

/**
 * Allows combining multiple caches.
 *
 * The caches first in the list are hit first. Therefore cheap caches
 * (ie in memory caches) should be placed before more expensive ones
 * (ie memcached).
 *
 * When a cache entry is requested and is not found in the first cache,
 * a new entry will be written to this cache. In case the requested entry
 * was found in a later cache, its value will be written to the first one.
 *
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CombinatoryCache implements Cache {

	/**
	 * @var Cache[]
	 */
	protected $caches;

	protected $hasMoreThenOneCache;

	public function __construct( array $caches ) {
		$this->assertCachesListIsValid( $caches );

		$this->caches = $caches;
		$this->hasMoreThenOneCache = count( $this->caches ) > 1;
	}

	protected function assertCachesListIsValid( array $caches ) {
		$this->assertNotEmpty( $caches );
		$this->assertAreCaches( $caches );
	}

	protected function assertNotEmpty( $caches ) {
		if ( empty( $caches ) ) {
			throw new InvalidArgumentException( 'The caches list needs to contain at least one cache' );
		}
	}

	protected function assertAreCaches( $caches ) {
		foreach ( $caches as $cache ) {
			if ( !is_object( $cache ) || !( $cache instanceof Cache ) ) {
				throw new InvalidArgumentException( 'The cache list can only contain instances of Cache' );
			}
		}
	}

	public function get( $key ) {
		reset( $this->caches );
		$firstCacheIndex = key( $this->caches );

		foreach ( $this->caches as $currentIndex => $cache ) {
			$value = $cache->get( $key );

			if ( $value !== null ) {
				if ( $currentIndex !== $firstCacheIndex ) {
					$this->setInFirstCache( $firstCacheIndex, $key, $value );
				}

				return $value;
			}
		}

		return null;
	}

	protected function setInFirstCache( $firstCacheIndex, $key, $value ) {
		$this->caches[$firstCacheIndex]->set( $key, $value );
	}

	public function has( $key ) {
		foreach ( $this->caches as $cache ) {
			if ( $cache->has( $key ) ) {
				return true;
			}
		}

		return false;
	}

	public function set( $key, $value ) {
		foreach ( $this->caches as $cache ) {
			$cache->set( $key, $value );
		}
	}

}
