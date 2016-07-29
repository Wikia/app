<?php

namespace Onoi\BlobStore\Tests\Integration;

use Onoi\Cache\CacheFactory;
use Doctrine\Common\Cache\RedisCache;

/**
 * @group onoi-blobstore
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DoctrineRedisIntegrationTest extends BlobStoreIntegrationTestCase {

	protected function setUp() {

		if ( !class_exists( '\Onoi\Cache\CacheFactory' ) ) {
			$this->markTestSkipped( 'CacheFactory is not available' );
		}

		if ( !class_exists( '\Redis' ) ) {
			$this->markTestSkipped( 'Requires redis php-class/extension to be available' );
		}

		$redis = new \Redis();

		if ( !$redis->connect( '127.0.0.1' ) ) {
			$this->markTestSkipped( 'Cannot connect to redis' );
		}

		if ( !class_exists( '\Doctrine\Common\Cache\RedisCache' ) ) {
			$this->markTestSkipped( 'RedisCache is not available' );
		}

		$redisCache = new RedisCache();
		$redisCache->setRedis( $redis );

		$cacheFactory = new CacheFactory();
		$this->cache = $cacheFactory->newDoctrineCache( $redisCache );
	}

}
