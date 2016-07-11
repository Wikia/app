<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\CompositeCache;

/**
 * @covers \Onoi\Cache\CompositeCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CompositeCacheTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$this->assertInstanceOf(
			'\Onoi\Cache\CompositeCache',
			new CompositeCache( array( $cache ) )
		);
	}

	public function testConstructForInvalidArrayKeyThrowsException() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$this->setExpectedException( 'RuntimeException' );
		new CompositeCache( array( 'cache' => $cache ) );
	}

	public function testConstructForInvalidCacheInstanceThrowsException() {

		$this->setExpectedException( 'RuntimeException' );
		new CompositeCache( array( 'Foo' ) );
	}

	public function testGetName() {

		$first = $this->getMockBuilder( '\Onoi\Cache\ZendCache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second = $this->getMockBuilder( '\Onoi\Cache\DoctrineCache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertInternalType(
			'string',
			$instance->getName()
		);
	}

	public function testSave() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->anything() );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->anything() );

		$instance = new CompositeCache( array( $first, $second ) );
		$instance->save( 'Foo', 'Bar' );
	}

	public function testDelete() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'Foo' ) );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new CompositeCache( array( $first, $second ) );
		$instance->delete( 'Foo' );
	}

	public function testGetStats() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'getStats' );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'getStats' );

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertInternalType(
			'array',
			$instance->getStats( 'Foo' )
		);
	}

	public function testContainsIsTrueForFirstCache() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( true ) );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->never() )
			->method( 'contains' );

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertTrue(
			$instance->contains( 'Foo' )
		);
	}

	public function testContainsIsFalseForFirstCache() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'contains' );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( false ) );

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

	public function testFetchToReturnNoResultForFirstCache() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'contains' );

		$first->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->anything() );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'contains' )
			->will( $this->returnValue( true ) );

		$second->expects( $this->once() )
			->method( 'fetch' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( 'Bar' ) );

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'Foo' )
		);
	}

	public function testFetchForToReturnNoResultForAll() {

		$first = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$first->expects( $this->once() )
			->method( 'contains' );

		$second = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$second->expects( $this->once() )
			->method( 'contains' );

		$instance = new CompositeCache( array( $first, $second ) );

		$this->assertFalse(
			$instance->fetch( 'Foo' )
		);
	}

}
