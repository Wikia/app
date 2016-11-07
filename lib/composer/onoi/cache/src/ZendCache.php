<?php

namespace Onoi\Cache;

use Zend\Cache\Storage\StorageInterface;

/**
 * ZF2 Cache adapter
 *
 * @note http://framework.zend.com/manual/current/en/modules/zend.cache.storage.adapter.html
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class ZendCache implements Cache {

	/**
	 * @var StorageInterface
	 */
	private $cache = null;

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
	 * @since 1.1
	 *
	 * @param StorageInterface $cache
	 */
	public function __construct( StorageInterface $cache ) {
		$this->cache = $cache;
	}

	/**
	 * @since 1.1
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {

		if ( $this->contains( $id ) ) {
			$this->cacheHits++;
			return $this->cache->getItem( $id );
		}

		$this->cacheMisses++;
		return false;
	}

	/**
	 * @since 1.1
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {
		return $this->cache->hasItem( $id );
	}

	/**
	 * @note ZF2 doesn't support per-item ttl storage therefore we use
	 * https://github.com/zendframework/zf2/pull/5386#issuecomment-43191005
	 *
	 * - ttl with 0 means an item never expires
	 *
	 * @since 1.1
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {

		$options = $this->cache->getOptions();
		$oldTtl  = $options->getTtl( $ttl );
		$options->setTtl( $ttl );

		try {
			$this->cacheInserts++;
			$this->cache->setItem( $id, $data );
		} catch ( \Exception $e ) {
			// Don't re-throw any exception, the consumer
			// should not care about this
			$this->cacheInserts--;
		}

		$options->setTtl( $oldTtl );
	}

	/**
	 * @since 1.1
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {
		$this->cacheDeletes++;
		return $this->cache->removeItem( $id );
	}

	/**
	 * @since 1.1
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return array(
			'inserts' => $this->cacheInserts,
			'deletes' => $this->cacheDeletes,
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
		return __CLASS__ . '::' . get_class( $this->cache );
	}

}
