<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\DoctrineCache;

/**
 * @covers \Onoi\Cache\DoctrineCache
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DoctrineCacheTest extends \PHPUnit_Framework_TestCase {

	private $cache;

	protected function setUp() {
		parent::setUp();

		if ( !interface_exists( '\Doctrine\Common\Cache\Cache' ) ) {
			$this->markTestSkipped( 'Doctrine cache interface is not available' );
		}

		$this->cache = $this->getMockBuilder( '\Doctrine\Common\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\DoctrineCache',
			new DoctrineCache( $this->cache )
		);
	}

	public function testGetName() {

		$instance = new DoctrineCache( $this->cache );

		$this->assertInternalType(
			'string',
			$instance->getName()
		);
	}

	public function testSave() {

		$this->cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->anything(),
				$this->equalTo( 42 ) );

		$instance = new DoctrineCache( $this->cache );
		$instance->save( 'Foo', 'Bar', 42 );
	}

	public function testDelete() {

		$this->cache->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new DoctrineCache( $this->cache );
		$instance->delete( 'Foo' );
	}

	public function testContains() {

		$this->cache->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new DoctrineCache( $this->cache );
		$instance->contains( 'Foo' );
	}

	public function testFetch() {

		$this->cache->expects( $this->once() )
			->method( 'fetch' )
			->with(
				$this->equalTo( 'Foo' ) )
			->will( $this->returnValue( 'Bar' ) );

		$instance = new DoctrineCache( $this->cache );

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'Foo' )
		);
	}

	public function testGetStats() {

		$this->cache->expects( $this->once() )
			->method( 'getStats' );

		$instance = new DoctrineCache( $this->cache );

		$this->assertEquals(
			null,
			$instance->getStats()
		);
	}

}
