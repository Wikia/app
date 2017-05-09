<?php

namespace Onoi\Cache\Tests\Integration;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.2
 *
 * @author mwjames
 */
abstract class CacheIntegrationTestCase extends \PHPUnit_Framework_TestCase {

	protected $cache;

	public function testStorageAndRetrieval() {

		$this->assertFalse(
			$this->cache->contains( 'Foo' )
		);

		$this->cache->save( 'Foo', 'Bar', 42 );

		$this->assertTrue(
			$this->cache->contains( 'Foo' )
		);

		$this->assertEquals(
			'Bar',
			$this->cache->fetch( 'Foo' )
		);

		$this->cache->delete( 'Foo' );

		$this->assertFalse(
			$this->cache->contains( 'Foo' )
		);
	}

}
