<?php

namespace Onoi\BlobStore\Tests\Integration;

use Onoi\BlobStore\BlobStore;

/**
 * @group onoi-blobstore
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
abstract class BlobStoreIntegrationTestCase extends \PHPUnit_Framework_TestCase {

	protected $cache;

	public function testStorageAndRetrieval() {

		$blobStore = new BlobStore( 'Foo', $this->cache );
		$container = $blobStore->read( 'bar' );

		$some = new \stdClass;
		$some->foo = 42;

		$container->set( 'one', $some );

		$this->assertEquals(
			$some,
			$container->get( 'one' )
		);

		$blobStore->save( $container );

		$container = $blobStore->read( 'foobar' );
		$container->set( 'two', 'anotherText' );

		$container->append(
			'two',
			$blobStore->read( 'bar' )->get( 'one' )
		);

		$container->append(
			'two',
			$some
		);

		$this->assertEquals(
			array( 'anotherText', $some, $some ),
			$container->get( 'two' )
		);
	}

	public function testDeleteSingleContainer() {

		$blobStore = new BlobStore( 'Foo', $this->cache );

		$container = $blobStore->read( 'foobar' );
		$container->set( 'one', 42 );
		$blobStore->save( $container );

		$this->assertTrue(
			$blobStore->exists( 'foobar' )
		);

		$blobStore->delete( 'foobar' );

		$this->assertFalse(
			$blobStore->exists( 'foobar' )
		);
	}

	public function testExpiry() {

		$blobStore = new BlobStore( 'Foo', $this->cache );
		$blobStore->setExpiryInSeconds( 4 );

		$container = $blobStore->read( 'bar' );
		$container->set( 'one', 1001 );
		$blobStore->save( $container );

		$container = $blobStore->read( 'foo' );
		$container->set( 'one', 42 );
		$blobStore->save( $container );

		$this->assertTrue(
			$blobStore->exists( 'bar' )
		);

		$this->assertTrue(
			$blobStore->exists( 'foo' )
		);

		sleep( 5 );

		$this->assertFalse(
			$blobStore->exists( 'bar' )
		);

		$this->assertFalse(
			$blobStore->exists( 'foo' )
		);
	}

}
