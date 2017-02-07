<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\NullCache;

/**
 * @covers \Onoi\Cache\NullCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class NullCacheTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\NullCache',
			new NullCache()
		);
	}

	public function testGetName() {

		$instance = new NullCache();

		$this->assertEmpty(
			$instance->getName()
		);
	}

	public function testSave() {

		$instance = new NullCache();
		$instance->save( 'Foo', 'Bar', 42 );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

	public function testDelete() {

		$instance = new NullCache();
		$instance->delete( 'Foo' );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

	public function testContains() {

		$instance = new NullCache();

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

	public function testFetch() {

		$instance = new NullCache();

		$this->assertFalse(
			$instance->fetch( 'Foo' )
		);
	}

	public function testGetStats() {

		$instance = new NullCache();

		$this->assertEmpty(
			$instance->getStats()
		);
	}

}
