<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\MediaWikiCache;

/**
 * @covers \Onoi\Cache\MediaWikiCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class MediaWikiCacheTest extends \PHPUnit_Framework_TestCase {

	private $cache;

	protected function setUp() {
		parent::setUp();

		if ( !class_exists( '\BagOstuff' ) ) {
			$this->markTestSkipped( 'BagOstuff interface is not available' );
		}

		$this->cache = $this->getMockBuilder( '\BagOstuff' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\MediaWikiCache',
			new MediaWikiCache( $this->cache )
		);
	}

	public function testGetName() {

		$instance = new MediaWikiCache( $this->cache );

		$this->assertInternalType(
			'string',
			$instance->getName()
		);
	}

	public function testSave() {

		$this->cache->expects( $this->once() )
			->method( 'set' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->anything(),
				$this->equalTo( 42 ) );

		$instance = new MediaWikiCache( $this->cache );
		$instance->save( 'Foo', 'Bar', 42 );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

	public function testDelete() {

		$this->cache->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new MediaWikiCache( $this->cache );
		$instance->delete( 'Foo' );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);

		$expected = array(
			'inserts' => 0,
			'deletes' => 1,
			'hits'    => 0,
			'misses'  => 0
		);

		$this->assertEquals(
			$expected,
			$instance->getStats()
		);
	}

	public function testContains() {

		$this->cache->expects( $this->once() )
			->method( 'get' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new MediaWikiCache( $this->cache );
		$instance->contains( 'Foo' );

		// Internally the access is cached
		$this->assertTrue(
			$instance->contains( 'Foo' )
		);
	}

	public function testFetch() {

		$this->cache->expects( $this->once() )
			->method( 'get' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( 'Bar' ) );

		$instance = new MediaWikiCache( $this->cache );

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'Foo' )
		);

		// Internally the access is cached
		$this->assertTrue(
			$instance->contains( 'Foo' )
		);
	}

	public function testFetchForFalse() {

		$this->cache->expects( $this->once() )
			->method( 'get' );

		$instance = new MediaWikiCache( $this->cache );

		$this->assertFalse(
			$instance->fetch( 'Bar' )
		);

		$expected = array(
			'inserts' => 0,
			'deletes' => 0,
			'hits'    => 0,
			'misses'  => 1
		);

		$this->assertEquals(
			$expected,
			$instance->getStats()
		);
	}

	public function testGetStats() {

		$this->cache->expects( $this->once() )
			->method( 'get' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( 'Bar' ) );

		$instance = new MediaWikiCache( $this->cache );
		$instance->fetch( 'Foo' );

		$expected = array(
			'inserts' => 0,
			'deletes' => 0,
			'hits'    => 1,
			'misses'  => 0
		);

		$this->assertEquals(
			$expected,
			$instance->getStats()
		);
	}

}
