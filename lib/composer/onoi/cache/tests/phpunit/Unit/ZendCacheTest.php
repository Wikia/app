<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\ZendCache;

/**
 * @covers \Onoi\Cache\ZendCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class ZendCacheTest extends \PHPUnit_Framework_TestCase {

	private $cache;

	protected function setUp() {
		parent::setUp();

		if ( !interface_exists( '\Zend\Cache\Storage\StorageInterface' ) ) {
			$this->markTestSkipped( 'Zend StorageInterface is not available' );
		}

		$this->cache = $this->getMockBuilder( '\Zend\Cache\Storage\StorageInterface' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\ZendCache',
		 new ZendCache( $this->cache )
		);
	}

	public function testGetName() {

		$instance = new ZendCache( $this->cache );

		$this->assertInternalType(
			'string',
			$instance->getName()
		);
	}

	public function testSave() {

		$adapterOptions = $this->getMockBuilder( '\Zend\Cache\Storage\Adapter\AdapterOptions' )
			->disableOriginalConstructor()
			->getMock();

		$this->cache->expects( $this->any() )
			->method( 'getOptions' )
			->will( $this->returnValue( $adapterOptions ) );

		$this->cache->expects( $this->once() )
			->method( 'setItem' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->equalTo( 'Bar' ) );

		$instance = new ZendCache( $this->cache );
		$instance->save( 'Foo', 'Bar', 42 );

		$expected = array(
			'inserts' => 1,
			'deletes' => 0,
			'hits'    => 0,
			'misses'  => 0
		);

		$this->assertEquals(
			$expected,
			$instance->getStats()
		);
	}

	public function testSaveBySetItemThrowingException() {

		$adapterOptions = $this->getMockBuilder( '\Zend\Cache\Storage\Adapter\AdapterOptions' )
			->disableOriginalConstructor()
			->getMock();

		$this->cache->expects( $this->any() )
			->method( 'getOptions' )
			->will( $this->returnValue( $adapterOptions ) );

		$this->cache->expects( $this->once() )
			->method( 'setItem' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->equalTo( 'Bar' ) )
			->will( $this->throwException( new \Exception() ) );

		$instance = new ZendCache( $this->cache );
		$instance->save( 'Foo', 'Bar', 42 );

		$expected = array(
			'inserts' => 0,
			'deletes' => 0,
			'hits'    => 0,
			'misses'  => 0
		);

		$this->assertEquals(
			$expected,
			$instance->getStats()
		);
	}

	public function testDelete() {

		$this->cache->expects( $this->once() )
			->method( 'removeItem' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new ZendCache( $this->cache );
		$instance->delete( 'Foo' );
	}

	public function testContains() {

		$this->cache->expects( $this->once() )
			->method( 'hasItem' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new ZendCache( $this->cache );
		$instance->contains( 'Foo' );
	}

	public function testFetch() {

		$this->cache->expects( $this->once() )
			->method( 'hasItem' )
			->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
			->method( 'getItem' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( 'Bar' ) );

		$instance = new ZendCache( $this->cache );

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'Foo' )
		);
	}

	public function testFetchForNonExistingItem() {

		$this->cache->expects( $this->once() )
			->method( 'hasItem' )
			->will( $this->returnValue( false ) );

		$this->cache->expects( $this->never() )
			->method( 'getItem' );

		$instance = new ZendCache( $this->cache );

		$this->assertFalse(
			$instance->fetch( 'Foo' )
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

		$instance = new ZendCache( $this->cache );

		$this->assertInternalType(
			'array',
			$instance->getStats()
		);
	}

}
