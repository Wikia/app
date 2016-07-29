<?php

namespace Onoi\Cache;

/**
 * Implements a simple LRU (Least Recently Used) algorithm for a fixed in-memory
 * hashmap
 *
 * @note For a size of more than 10K it is suggested to use PHP's SplFixedArray
 * instead as it is optimized for large array sets
 *
 * @license GNU GPL v2+
 * @since 1.0
 */
class FixedInMemoryLruCache implements Cache {

	/**
	 * @var array
	 */
	private $cache = array();

	/**
	 * @var array
	 */
	private $ttl = array();

	/**
	 * @var integer
	 */
	private $maxCacheCount;

	/**
	 * @var integer
	 */
	private $count = 0;

	/**
	 * @var integer
	 */
	private $cacheInserts = 0;

	/**
	 * @var integer
	 */
	private $cacheDeletes = 0;

	/**
	 * @var integer
	 */
	private $cacheHits = 0;

	/**
	 * @var integer
	 */
	private $cacheMisses = 0;

	/**
	 * @since 1.0
	 *
	 * @param integer $maxCacheCount
	 */
	public function __construct( $maxCacheCount = 500 ) {
		$this->maxCacheCount = (int)$maxCacheCount;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {

		$contains = isset( $this->cache[ $id ] ) || array_key_exists( $id, $this->cache );

		if ( !$contains ) {
			return false;
		}

		if ( $this->ttl[ $id ] > 0 && $this->ttl[ $id ] <= microtime( true ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {

		if ( $this->contains( $id ) ) {
			$this->cacheHits++;
			return $this->moveToMostRecentlyUsedPosition( $id );
		}

		$this->cacheMisses++;
		return false;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $value, $ttl = 0 ) {

		$this->count++;
		$this->cacheInserts++;

		if ( $this->contains( $id ) ) {
			$this->count--;
			$this->moveToMostRecentlyUsedPosition( $id );
		} elseif ( $this->count > $this->maxCacheCount ) {
			$this->count--;
			reset( $this->cache );
			unset( $this->cache[ key( $this->cache ) ] );
		}

		$this->cache[ $id ] = $value;
		$this->ttl[ $id ] = $ttl > 0 ? microtime( true ) + $ttl : 0;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {

		if ( $this->contains( $id ) ) {
			$this->count--;
			$this->cacheDeletes++;
			unset( $this->cache[ $id ] );
			unset( $this->ttl[ $id ] );
			return true;
		}

		return false;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return array(
			'inserts' => $this->cacheInserts,
			'deletes' => $this->cacheDeletes,
			'max'     => $this->maxCacheCount,
			'count'   => $this->count,
			'hits'    => $this->cacheHits,
			'misses'  => $this->cacheMisses
		);
	}

	/**
	 * @since  1.2
	 *
	 * {@inheritDoc}
	 */
	public function getName() {
		return __CLASS__;
	}

	private function moveToMostRecentlyUsedPosition( $id ) {

		$value = $this->cache[ $id ];
		unset( $this->cache[ $id ] );
		$this->cache[ $id ] = $value;

		return $value;
	}

}
