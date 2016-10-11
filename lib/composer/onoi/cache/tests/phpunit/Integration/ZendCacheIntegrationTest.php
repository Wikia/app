<?php

namespace Onoi\Cache\Tests\Integration;

use Zend\Cache\StorageFactory;
use Onoi\Cache\ZendCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class ZendCacheIntegrationTest extends CacheIntegrationTestCase {

	protected $cache;

	protected function setUp() {

		if ( !class_exists( '\Zend\Cache\StorageFactory' ) ) {
			$this->markTestSkipped( 'StorageFactory is not available' );
		}

		$memoryCache = StorageFactory::factory( array(
			'adapter' => array(
				'name'    => 'memory',
				'options' => array( 'ttl' => 100 ),
			),
				'plugins' => array(
				'exception_handler' => array( 'throw_exceptions' => false ),
			),
		) );

		$this->cache = new ZendCache( $memoryCache );
	}

}
