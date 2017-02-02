<?php

namespace Onoi\Cache;

use Doctrine\Common\Cache\Cache as DoctrineCacheClient;

/**
 * Doctrine Cache decorator
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DoctrineCache implements Cache {

	/**
	 * @var DoctrineCacheClient
	 */
	private $cache = null;

	/**
	 * @since 1.0
	 *
	 * @param DoctrineCacheClient $cache
	 */
	public function __construct( DoctrineCacheClient $cache ) {
		$this->cache = $cache;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {
		return $this->cache->fetch( $id );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {
		return $this->cache->contains( $id );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {
		$this->cache->save( $id, $data, $ttl );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {
		return $this->cache->delete( $id );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return $this->cache->getStats();
	}

	/**
	 * @since  1.2
	 *
	 * {@inheritDoc}
	 */
	public function getName() {
		return __CLASS__ . '::' . get_class( $this->cache );
	}

}
