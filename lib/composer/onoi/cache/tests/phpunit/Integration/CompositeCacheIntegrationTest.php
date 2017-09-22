<?php

namespace Onoi\Cache\Tests\Integration;

use HashBagOStuff;
use Doctrine\Common\Cache\ArrayCache;
use Onoi\Cache\CacheFactory;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.2
 *
 * @author mwjames
 */
class CompositeCacheIntegrationTest extends CacheIntegrationTestCase {

	protected $cache;

	protected function setUp() {

		$cache = array();
		$cacheFactory = new CacheFactory();

		$cache[] = $cacheFactory->newFixedInMemoryLruCache();

		if ( class_exists( '\HashBagOStuff' ) ) {
			$cache[] = $cacheFactory->newMediaWikiCache( new HashBagOStuff() );
		}

		if ( class_exists( '\Doctrine\Common\Cache\ArrayCache' ) ) {
			$cache[] = $cacheFactory->newDoctrineCache( new ArrayCache() );
		}

		$this->cache = $cacheFactory->newCompositeCache( $cache );
	}

}
