<?php

namespace Onoi\Cache;

use RuntimeException;

/**
 * Combines different cache instances into a combinatory cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CompositeCache implements Cache {

	/**
	 * @var array
	 */
	private $caches = array();

	/**
	 * @note The access hierarchy is determined by the order of the invoked cache
	 * instances and it is assumed that the faster cache is accessible first.
	 *
	 * @since 1.0
	 *
	 * @param Cache[] $caches
	 */
	public function __construct( array $caches ) {

		foreach ( $caches as $key => $cache ) {

			if ( !is_int( $key ) ) {
				throw new RuntimeException( 'Associative key is not permitted' );
			}

			if ( !$cache instanceOf Cache ) {
				throw new RuntimeException( 'The composite contains an invalid cache instance' );
			}
		}

		$this->caches = $caches;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {

		reset( $this->caches );

		foreach ( $this->caches as $key => $cache ) {

			if ( !$cache->contains( $id ) ) {
				continue;
			}

			$data = $cache->fetch( $id );

			// The data were not available in a previous instance and it is assumed
			// that a preceding cache is faster (in-memory lookup etc.) than the
			// current instance therefore the content is stored one level up for
			// the next lookup
			if ( $key > 0 ) {
				$this->caches[ $key - 1 ]->save( $id, $data );
			}

			return $data;
		}

		return false;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {

		foreach ( $this->caches as $cache ) {
			if ( $cache->contains( $id ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {
		foreach ( $this->caches as $cache ) {
			$cache->save( $id, $data, $ttl );
		}
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {
		foreach ( $this->caches as $cache ) {
			$cache->delete( $id );
		}
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {

		$stats = array();

		foreach ( $this->caches as $cache ) {
			$stats[$cache->getName()] = $cache->getStats();
		}

		return $stats;
	}

	/**
	 * @since  1.2
	 *
	 * {@inheritDoc}
	 */
	public function getName() {

		$name = '';

		foreach ( $this->caches as $cache ) {
			$name = $name . '::' . $cache->getName();
		}

		return __CLASS__ . $name;
	}

}
