<?php

namespace Serializers\Tests\Phpunit\Serializers;

use Serializers\DispatchingSerializer;

/**
 * @covers Serializers\DispatchingSerializer
 *
 * @group Serialization
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testConstructWithNoSerializers() {
		$serializer = new DispatchingSerializer( array() );

		$this->assertFalse( $serializer->isSerializerFor( 'foo' ) );
		$this->assertFalse( $serializer->isSerializerFor( null ) );

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );

		$serializer->serialize( 'foo' );
	}

	public function testConstructWithInvalidArgumentsCausesException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new DispatchingSerializer( array( new \stdClass() ) );
	}

	public function testCanSerialize() {
		$subSerializer = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer->expects( $this->exactly( 4 ) )
			->method( 'isSerializerFor' )
			->will( $this->returnCallback( function( $value ) {
				return $value > 9000;
			} ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->assertFalse( $serializer->isSerializerFor( 0 ) );
		$this->assertFalse( $serializer->isSerializerFor( 42 ) );
		$this->assertTrue( $serializer->isSerializerFor( 9001 ) );
		$this->assertTrue( $serializer->isSerializerFor( 31337 ) );
	}

	public function testSerializeWithSerializableValues() {
		$subSerializer = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer->expects( $this->any() )
			->method( 'isSerializerFor' )
			->will( $this->returnValue( true ) );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
		$this->assertEquals( 42, $serializer->serialize( null ) );
	}

	public function testSerializeWithUnserializableValue() {
		$subSerializer = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer->expects( $this->once() )
			->method( 'isSerializerFor' )
			->will( $this->returnValue( false ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( 0 );
	}

	public function testSerializeWithMultipleSubSerializers() {
		$subSerializer0 = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer0->expects( $this->any() )
			->method( 'isSerializerFor' )
			->will( $this->returnValue( true ) );

		$subSerializer0->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$subSerializer1 = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer1->expects( $this->any() )
			->method( 'isSerializerFor' )
			->will( $this->returnValue( false ) );

		$subSerializer2 = clone $subSerializer1;

		$serializer = new DispatchingSerializer( array( $subSerializer1, $subSerializer0, $subSerializer2 ) );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
	}

	public function testAddSerializer() {
		$serializer = new DispatchingSerializer( array() );

		$subSerializer = $this->getMock( 'Serializers\DispatchableSerializer' );

		$subSerializer->expects( $this->any() )
			->method( 'isSerializerFor' )
			->will( $this->returnValue( true ) );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$serializer->addSerializer( $subSerializer );

		$this->assertEquals(
			42,
			$serializer->serialize( null )
		);
	}

}
