<?php

namespace SimpleCache\Tests\Phpunit\Cache;

use SimpleCache\Cache\CombinatoryCache;

/**
 * @covers SimpleCache\Cache\CombinatoryCache
 *
 * @file
 * @ingroup SimpleCache
 * @group SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CombinatoryCacheTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider invalidConstructorArgumentProvider
	 */
	public function testCannotConstructWithNonCaches( $invalidCachesList ) {
		$this->setExpectedException( 'InvalidArgumentException' );

		new CombinatoryCache( $invalidCachesList );
	}

	public function invalidConstructorArgumentProvider() {
		$argLists = array();

		$containedCache = $this->getMock( 'SimpleCache\Cache\Cache' );

		$argLists[] = array( array() );
		$argLists[] = array( array( null ) );
		$argLists[] = array( array( $containedCache, 42 ) );
		$argLists[] = array( array( $containedCache, new \stdClass(), $containedCache ) );

		return $argLists;
	}

	public function testHasWithOneCache() {
		$containedCache = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache
			->expects( $this->exactly( 2 ) )
			->method( 'has' )
			->will( $this->returnValue( true ) );

		$cache = new CombinatoryCache( array( $containedCache ) );

		$this->assertTrue( $cache->has( 'foo' ) );
		$this->assertTrue( $cache->has( 'bar' ) );
	}

	public function testSetWithOneCache() {
		$containedCache = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache
			->expects( $this->exactly( 2 ) )
			->method( 'set' )
			->with(
				$this->equalTo( 'hax' ),
				$this->equalTo( 1337 )
			);

		$cache = new CombinatoryCache( array( $containedCache ) );

		$cache->set( 'hax', 1337 );
		$cache->set( 'hax', 1337 );
	}

	public function testGetWithOneCache() {
		$containedCache = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache
			->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->with(
				$this->equalTo( 'hax' )
			)
			->will( $this->returnValue( 1337 ) );

		$cache = new CombinatoryCache( array( $containedCache ) );

		$this->assertEquals( 1337, $cache->get( 'hax' ) );
		$this->assertEquals( 1337, $cache->get( 'hax' ) );
	}

	public function testSetHitsAllCaches() {
		$containedCache0 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache0
			->expects( $this->exactly( 2 ) )
			->method( 'set' );

		$containedCache1 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache1
			->expects( $this->exactly( 2 ) )
			->method( 'set' );

		$cache = new CombinatoryCache( array( $containedCache0, $containedCache1 ) );

		$cache->set( 'hax', 1337 );
		$cache->set( 'hax', 1337 );
	}

	public function testHasHitsCachesInCorrectOrder() {
		$containedCache0 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache0
			->expects( $this->once() )
			->method( 'has' )
			->will( $this->returnValue( false ) );

		$containedCache1 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache1
			->expects( $this->once() )
			->method( 'has' )
			->will( $this->returnValue( true ) );

		$containedCache2 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache2
			->expects( $this->never() )
			->method( 'has' );

		$cache = new CombinatoryCache( array( $containedCache0, $containedCache1, $containedCache2 ) );

		$cache->has( 'foo' );
	}

	public function testGetHitsCachesInCorrectOrder() {
		$containedCache0 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache0
			->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$containedCache0
			->expects( $this->any() )
			->method( 'has' )
			->will( $this->returnValue( false ) );

		$containedCache1 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache1
			->expects( $this->once() )
			->method( 'get' )
			->will( $this->returnValue( 42 ) );

		$containedCache2 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache2
			->expects( $this->never() )
			->method( 'get' );

		$cache = new CombinatoryCache( array( $containedCache0, $containedCache1, $containedCache2 ) );

		$this->assertEquals( 42, $cache->get( 'foo' ) );
	}

	public function testGetFromLowerCacheWritesToUpperOne() {
		$containedCache0 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache0
			->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$containedCache0
			->expects( $this->any() )
			->method( 'has' )
			->will( $this->returnValue( false ) );

		$containedCache0
			->expects( $this->once() )
			->method( 'set' )
			->with(
				$this->equalTo( 'foo' ),
				$this->equalTo( 42 )
			);

		$containedCache1 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache1
			->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$containedCache1
			->expects( $this->any() )
			->method( 'has' )
			->will( $this->returnValue( false ) );

		$containedCache1
			->expects( $this->never() )
			->method( 'set' );

		$containedCache2 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache2
			->expects( $this->once() )
			->method( 'get' )
			->will( $this->returnValue( 42 ) );

		$cache = new CombinatoryCache( array( $containedCache0, $containedCache1, $containedCache2 ) );

		$this->assertEquals( 42, $cache->get( 'foo' ) );
	}

	public function testMissingAllCachesReturnsNull() {
		$key = 'foo';

		$containedCache0 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache0
			->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$containedCache1 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache1
			->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$containedCache2 = $this->getMock( 'SimpleCache\Cache\Cache' );

		$containedCache2
			->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$cache = new CombinatoryCache( array( $containedCache0, $containedCache1, $containedCache2 ) );

		$this->assertNull( $cache->get( $key ) );
		$this->assertNull( $cache->get( $key ) );
	}

}
