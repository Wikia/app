<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\FixedInMemoryLruCache;
use Onoi\Cache\FixedInMemoryCache;

/**
 * @covers \Onoi\Cache\FixedInMemoryLruCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class FixedInMemoryLruCacheTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\FixedInMemoryLruCache',
			new FixedInMemoryLruCache()
		);
	}

	public function testGetName() {

		$instance = new FixedInMemoryLruCache( 5 );

		$this->assertInternalType(
			'string',
			$instance->getName()
		);
	}

	public function testItemRemoval() {

		$instance = new FixedInMemoryLruCache( 5 );

		$instance->save( 'foo', array( 'foo' ) );
		$instance->save( 42, null );

		$this->assertTrue( $instance->contains( 'foo' ) );
		$this->assertTrue( $instance->contains( 42 ) );

		$stats = $instance->getStats();
		$this->assertEquals(
			2,
			$stats['count']
		);

		$instance->delete( 'foo' );

		$this->assertFalse( $instance->contains( 'foo' ) );
		$this->assertFalse( $instance->delete( 'foo' ) );

		$stats = $instance->getStats();

		$this->assertEquals(
			1,
			$stats['count']
		);

		$this->assertEquals(
			1,
			$stats['deletes']
		);
	}

	public function testLeastRecentlyUsedShiftForLimitedCacheSize() {

		$instance = new FixedInMemoryLruCache( 5 );
		$instance->save( 'abcde', array( 'abcde' ) );

		$this->assertEquals(
			array( 'abcde' ),
			$instance->fetch( 'abcde' )
		);

		foreach ( array( 'éèêë', 'アイウエオ', 'АБВГД', 'αβγδε', '12345' ) as $alphabet ) {
			$instance->save( $alphabet, array( $alphabet ) );
		}

		// 'éèêë' was added and removes 'abcde' from the cache
		$this->assertFalse( $instance->fetch( 'abcde' ) );

		$stats = $instance->getStats();

		$this->assertEquals(
			5,
			$stats['count']
		);

		$this->assertEquals(
			6,
			$stats['inserts']
		);

		// 'éèêë' moves to the top (last postion as most recently used) and
		// 'アイウエオ' becomes the next LRU candidate
		$this->assertEquals(
			array( 'éèêë' ),
			$instance->fetch( 'éèêë' )
		);

		$instance->save( '@#$%&', '@#$%&' );
		$this->assertFalse( $instance->fetch( 'アイウエオ' ) );

		// АБВГД would be the next LRU slot but setting it again will move it to MRU
		// and push αβγδε into the next LRU position
		$instance->save( 'АБВГД', 'АБВГД' );

		$instance->save( '-+=<>', '-+=<>' );
		$this->assertFalse( $instance->fetch( 'αβγδε' ) );

		$stats = $instance->getStats();

		$this->assertEquals(
			5,
			$stats['count']
		);
	}

	public function testFetchTtlBasedItem() {

		$instance = new FixedInMemoryLruCache( 5 );

		$instance->save( 'foo', 'Bar', 3 );

		$this->assertTrue(
			$instance->contains( 'foo' )
		);

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'foo' )
		);

		sleep( 4 );

		$this->assertFalse(
			$instance->contains( 'foo' )
		);

		$this->assertFalse(
			$instance->fetch( 'foo' )
		);
	}

}
