<?php

namespace SimpleCache\Tests\Phpunit\Cache;

use SimpleCache\Cache\SimpleInMemoryCache;

/**
 * @covers SimpleCache\Cache\SimpleInMemoryCache
 *
 * @file
 * @ingroup SimpleCache
 * @group SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleInMemoryCacheTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider valueProvider
	 */
	public function testSetAndGetOneValue( $value ) {
		$key = 'foo';

		$cache = new SimpleInMemoryCache();

		$this->assertFalse( $cache->has( $key ) );

		$cache->set( $key, $value );

		$this->assertEquals(
			$value,
			$cache->get( $key )
		);

		$this->assertTrue( $cache->has( $key ) );
	}

	public function valueProvider() {
		$argLists = array();

		$argLists[] = array( true );
		$argLists[] = array( false );
		$argLists[] = array( 0 );
		$argLists[] = array( '' );
		$argLists[] = array( '1' );
		$argLists[] = array( '0' );
		$argLists[] = array( 'foo bar baz bah' );
		$argLists[] = array( array() );
		$argLists[] = array( (object)array() );
		$argLists[] = array( (object)array( 'foo' => 'bar' ) );
		$argLists[] = array( array( 42, 4 => '2', 13.37 ) );

		return $argLists;
	}

}
