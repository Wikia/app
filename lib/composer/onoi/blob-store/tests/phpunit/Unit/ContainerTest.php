<?php

namespace Onoi\BlobStore\Tests;

use Onoi\BlobStore\Container;

/**
 * @covers \Onoi\BlobStore\Container
 *
 * @group onoi-blobstore
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class ContainerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\BlobStore\Container',
			new Container( 'Foo', array() )
		);
	}

	public function testTryToConstructForInvalidIdThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new Container( array(), array() );
	}

	public function testGetIdAndData() {

		$expected = array( 'Bar' => new \stdClass );

		$instance = new Container(
			'Foo',
			$expected
		);

		$this->assertEquals(
			'Foo',
			$instance->getId()
		);

		$this->assertEquals(
			$expected,
			$instance->getData()
		);

		$this->assertFalse(
			$instance->isEmpty()
		);
	}

	public function testExpiry() {

		$instance = new Container(
			'Foo',
			array()
		);

		$instance->setExpiryInSeconds( 42 );

		$this->assertSame(
			42,
			$instance->getExpiry()
		);
	}

	public function testGetAndSet() {

		$expected = array( 'Bar' => new \stdClass );

		$instance = new Container(
			'Foo',
			$expected
		);

		$this->assertFalse(
			$instance->get( 'foobar' )
		);

		$this->assertEquals(
			new \stdClass,
			$instance->get( 'Bar' )
		);

		$instance->set( 'Bar', 42 );

		$this->assertEquals(
			42,
			$instance->get( 'Bar' )
		);

		$instance->append( 'Bar', 1001 );

		$this->assertEquals(
			array( 42 , 1001 ),
			$instance->get( 'Bar' )
		);

		$instance->append( 'foobar', 1001 );

		$this->assertEquals(
			array( 1001 ),
			$instance->get( 'foobar' )
		);
	}

	public function testHasAndDelete() {

		$expected = array( 'Bar' => new \stdClass );

		$instance = new Container(
			'Foo',
			$expected
		);

		$this->assertTrue(
			$instance->has( 'Bar' )
		);

		$instance->delete( 'Bar' );

		$this->assertFalse(
			$instance->has( 'Bar' )
		);
	}

	public function testAddToLinkedList() {

		$instance = new Container(
			'Foo'
		);

		$instance->addToLinkedList( 'Bar' );
		$instance->addToLinkedList( 'Bar' );

		$this->assertEquals(
			array( 'Bar' ),
			$instance->getLinkedList()
		);
	}

}
