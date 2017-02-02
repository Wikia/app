<?php

namespace Onoi\BlobStore\Tests\Integration;

use Onoi\BlobStore\BlobStore;
use Onoi\Cache\CacheFactory;

/**
 * @group onoi-blobstore
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class FixedInMemoryIntegrationTest extends BlobStoreIntegrationTestCase {

	protected function setUp() {

		if ( !class_exists( '\Onoi\Cache\CacheFactory' ) ) {
			$this->markTestSkipped( 'CacheFactory is not available' );
		}

		$cacheFactory = new CacheFactory();
		$this->cache = $cacheFactory->newFixedInMemoryLruCache( 500 );
	}

}
