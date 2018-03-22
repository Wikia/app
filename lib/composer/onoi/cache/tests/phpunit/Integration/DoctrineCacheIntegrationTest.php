<?php

namespace Onoi\Cache\Tests\Integration;

use Doctrine\Common\Cache\ArrayCache;
use Onoi\Cache\DoctrineCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class DoctrineCacheIntegrationTest extends CacheIntegrationTestCase {

	protected $cache;

	protected function setUp() {

		if ( !class_exists( '\Doctrine\Common\Cache\ArrayCache' ) ) {
			$this->markTestSkipped( 'ArrayCache is not available' );
		}

		$this->cache = new DoctrineCache( new ArrayCache() );
	}

}
