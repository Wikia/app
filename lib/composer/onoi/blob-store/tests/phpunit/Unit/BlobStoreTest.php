<?php

namespace Onoi\BlobStore\Tests;

use Onoi\BlobStore\BlobStore;
use Onoi\BlobStore\Container;

/**
 * @covers \Onoi\BlobStore\BlobStore
 *
 * @group onoi-blobstore
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class BlobStoreTest extends \PHPUnit_Framework_TestCase {

	private $cache;

	protected function setUp() {

		$this->cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\BlobStore\BlobStore',
			new BlobStore( 'Foo', $this->cache )
		);
	}

	public function testInvalidNamespaceInConstructorThrowsException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		new BlobStore(
			array(),
			$this->cache
		);
	}

	public function testInvalidKeyForContainerThrowsException() {

		$instance = new BlobStore(
			'Foo',
			$this->cache
		);

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->read( array() );
	}

	public function testCanUse() {

		$instance = new BlobStore( 'Foo', $this->cache );

		$this->assertTrue(
			$instance->canUse()
		);

		$instance->setUsageState( false );

		$this->assertFalse(
			$instance->canUse()
		);
	}

	public function testReadContainerForUnknownId() {

		$container = new Container( 'blobstore:Foo:bar', array() );

		$instance = new BlobStore( 'Foo', $this->cache );

		$this->assertInstanceOf(
			'\Onoi\BlobStore\Container',
			$instance->read( 'bar' )
		);

		$this->assertEquals(
			$container,
			$instance->read( 'bar' )
		);
	}

	public function testReadContainerForKnownId() {

		$container = new Container( 'coffee:Foo:bar', array() );

		$this->cache->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'coffee:Foo:bar' ) )
			->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
			->method( 'fetch' )
			->will( $this->returnValue( serialize( array() ) ) );

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->setNamespacePrefix( 'coffee' );

		$this->assertEquals(
			$container,
			$instance->read( 'bar' )
		);
	}

	public function testReadContainerForKnownIdToAlwaysReturnArrayType() {

		$container = new Container( 'blobstore:Foo:bar', array( false ) );

		$this->cache->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'blobstore:Foo:bar' ) )
			->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
			->method( 'fetch' )
			->will( $this->returnValue( serialize( false ) ) );

		$instance = new BlobStore( 'Foo', $this->cache );

		$this->assertEquals(
			$container,
			$instance->read( 'bar' )
		);
	}

	public function testGetStats() {

		$this->cache->expects( $this->once() )
			->method( 'getStats' )
			->will( $this->returnValue( array() ) );

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->getStats();
	}

	public function testSaveContainer() {

		$container = array( 'Foobar', new \stdClass, array() );

		$this->cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo:bar' ),
				$this->equalTo( serialize( $container ) ),
				$this->equalTo( 0 ) );

		$container = new Container( 'Foo:bar', $container );

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->save( $container );
	}

	public function testSaveContainerWithExpiry() {

		$container = array( 'Foobar', new \stdClass, array() );

		$this->cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo:bar' ),
				$this->anything(),
				$this->equalTo( 42 ) );

		$container = new Container( 'Foo:bar', $container );
		$container->setExpiryInSeconds( 42 );

		$instance = new BlobStore( 'Foo', $this->cache );

		$instance->save( $container );
	}

	public function testTransferExpiry() {

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->setExpiryInSeconds( 42 );

		$container = $instance->read( 'Bar' );

		$this->assertEquals(
			42,
			$container->getExpiry()
		);
	}

	public function testDeleteContainerForSpecificId() {

		$this->cache->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'blobstore:Foo:bar' ) );

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->delete( 'bar' );
	}

	public function testDropDoesNothing() {

		$this->cache->expects( $this->never() )
			->method( 'fetch' );

		$this->cache->expects( $this->never() )
			->method( 'delete' );

		$instance = new BlobStore( 'Foo', $this->cache );
		$instance->drop();
	}

	public function testDeleteMembersOfLinkedListAsWell() {

		$linkedContainer = serialize(
			array( '@linkedList' => array( 'a42b' => true ) )
		);

		$this->cache->expects( $this->once() )
			->method( 'contains' )
			->with( $this->equalTo( 'blobstore:Foo:Bar' ) )
			->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
			->method( 'fetch' )
			->will( $this->returnValue( $linkedContainer ) );

		$this->cache->expects( $this->at( 2 ) )
			->method( 'delete' )
			->with(	$this->equalTo( 'blobstore:Foo:a42b' ) );

		$this->cache->expects( $this->at( 3 ) )
			->method( 'delete' )
			->with( $this->equalTo( 'blobstore:Foo:Bar' ) );

		$instance = new BlobStore( 'Foo', $this->cache );

		$instance->delete( 'Bar' );
	}

}
