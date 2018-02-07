<?php

namespace SimpleCache\Tests\Phpunit\Cache;

use SimpleCache\Cache\MediaWikiCache;

/**
 * @covers SimpleCache\Cache\MediaWikiCache
 *
 * @file
 * @ingroup SimpleCache
 * @group SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiCacheTest extends \PHPUnit_Framework_TestCase {

	public function testSetValue() {
		$value = 'foobar';
		$key = 'foo';
		$expiryTime = 42;

		$bagOfStuff = $this->getMock( 'BagOStuff', array( 'set' ) );

		$bagOfStuff->expects( $this->once() )
			->method( 'set' )
			->with(
				$this->equalTo( $key ),
				$this->equalTo( $value ),
				$this->equalTo( $expiryTime )
			);

		$cache = new MediaWikiCache( $bagOfStuff, $expiryTime );

		$cache->set( $key, $value );
	}

	public function testGetValueWithReturnFoobarAsValue() {
		$key = 'foo';
		$value = 'foobar';

		$bagOfStuff = $this->getMock( 'BagOStuff', array( 'get' ) );

		$bagOfStuff->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->with(
				$this->equalTo( $key )
			)
			->will( $this->returnValue( $value ) );

		$cache = new MediaWikiCache( $bagOfStuff );

		$this->assertEquals( $value, $cache->get( $key ) );
		$this->assertTrue( $cache->has( $key ) );
	}

	public function testGetValueWithReturnFalseAsValue() {
		$key = 'foo';

		$bagOfStuff = $this->getMock( 'BagOStuff', array( 'get' ) );

		$bagOfStuff->expects( $this->exactly( 2 ) )
			->method( 'get' )
			->with(
				$this->equalTo( $key )
			)
			->will( $this->returnValue( false ) );

		$cache = new MediaWikiCache( $bagOfStuff );

		$this->assertNull( $cache->get( $key ) );
		$this->assertFalse( $cache->has( $key ) );
	}

}
