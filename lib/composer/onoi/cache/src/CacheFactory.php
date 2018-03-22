<?php

namespace Onoi\Cache;

use Doctrine\Common\Cache\Cache as DoctrineCacheClient;
use Zend\Cache\Storage\StorageInterface;
use BagOStuff;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CacheFactory {

	/**
	 * @var CacheFactory
	 */
	private static $instance = null;

	/**
	 * @since 1.0
	 *
	 * @return CacheFactory
	 */
	public static function getInstance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public static function clear() {
		self::$instance = null;
	}

	/**
	 * @since 1.0
	 *
	 * @param BagOStuff $cache
	 *
	 * @return MediaWikiCache
	 */
	public function newMediaWikiCache( BagOStuff $cache ) {
		return new MediaWikiCache( $cache );
	}

	/**
	 * @since 1.0
	 *
	 * @param DoctrineCacheClient $cache
	 *
	 * @return DoctrineCache
	 */
	public function newDoctrineCache( DoctrineCacheClient $cache ) {
		return new DoctrineCache( $cache );
	}

	/**
	 * @since 1.1
	 *
	 * @param integer $cacheSize
	 *
	 * @return FixedInMemoryLruCache
	 */
	public function newFixedInMemoryLruCache( $cacheSize = 500 ) {
		return new FixedInMemoryLruCache( $cacheSize );
	}

	/**
	 * @since 1.0
	 *
	 * @deprecated since 1.1, use CacheFactory::newFixedInMemoryLruCache
	 */
	public function newFixedInMemoryCache( $cacheSize = 500 ) {
		return $this->newFixedInMemoryLruCache( $cacheSize );
	}

	/**
	 * @since 1.0
	 *
	 * @param Cache[] $caches
	 *
	 * @return CompositeCache
	 */
	public function newCompositeCache( array $caches ) {
		return new CompositeCache( $caches );
	}

	/**
	 * @since 1.1
	 *
	 * @return NullCache
	 */
	public function newNullCache() {
		return new NullCache();
	}

	/**
	 * @since 1.1
	 *
	 * @param StorageInterface $cache
	 *
	 * @return ZendCache
	 */
	public function newZendCache( StorageInterface $cache ) {
		return new ZendCache( $cache );
	}

}
