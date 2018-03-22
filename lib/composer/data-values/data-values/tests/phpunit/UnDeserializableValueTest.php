<?php

namespace DataValues\Tests;

use DataValues\DataValue;
use DataValues\UnDeserializableValue;
use DataValues\UnknownValue;

/**
 * @covers DataValues\UnDeserializableValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class UnDeserializableValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\UnDeserializableValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( null, null, 'No type and no data' );
		$argLists[] = array( null, 'string', 'A type but no data' );
		$argLists[] = array( array( 'stuff' ), 'string', 'A type and bad data' );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( new \stdClass(), null, 'No type and no data' );
		$argLists[] = array( null, 42, 'No type and no data' );
		$argLists[] = array( null, false, 'No type and no data' );
		$argLists[] = array( null, array(), 'No type and no data' );
		$argLists[] = array( null, null, null );
		$argLists[] = array( null, null, true );
		$argLists[] = array( null, null, array() );

		return $argLists;
	}


	/**
	 * @dataProvider instanceProvider
	 *
	 * @param UnDeserializableValue $value
	 * @param array $arguments
	 */
	public function testGetValue( UnDeserializableValue $value, array $arguments ) {
		$this->assertEquals( $arguments[0], $value->getValue() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @param UnDeserializableValue $value
	 * @param array $arguments
	 */
	public function testGetArrayValue( UnDeserializableValue $value, array $arguments ) {
		$this->assertEquals( $arguments[0], $value->getArrayValue() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @param UnDeserializableValue $value
	 * @param array $arguments
	 */
	public function testGetTargetType( UnDeserializableValue $value, array $arguments ) {
		$this->assertEquals( $arguments[1], $value->getTargetType() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testToArray( DataValue $value, array $arguments ) {
		$array = $value->toArray();

		$this->assertInternalType( 'array', $array );

		$this->assertTrue( array_key_exists( 'type', $array ) );
		$this->assertTrue( array_key_exists( 'value', $array ) );

		$this->assertEquals( $value->getTargetType(), $array['type'] );
		$this->assertEquals( $value->getValue(), $array['value'] );
	}

	/**
	 * Dummy implementation, there's nothing to test here.
	 *
	 * @return array
	 */
	public static function dummyProvider() {
		return array(
			array( new UnknownValue( 'dummy' ), array() )
		);
	}

	/**
	 * @dataProvider dummyProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testNewFromArray( DataValue $value, array $arguments ) {
		$this->assertFalse( method_exists( $this->getClass(), 'newFromArray' ) );
	}

}
