<?php

namespace DataValues\Tests;

use DataValues\DataValue;

/**
 * Base for unit tests for DataValue implementing classes.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DataValueTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Returns the name of the concrete class tested by this test.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public abstract function getClass();

	public abstract function validConstructorArgumentsProvider();

	public abstract function invalidConstructorArgumentsProvider();

	/**
	 * Creates and returns a new instance of the concrete class.
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function newInstance() {
		$reflector = new \ReflectionClass( $this->getClass() );
		$args = func_get_args();
		$instance = $reflector->newInstanceArgs( $args );
		return $instance;
	}

	/**
	 * @since 0.1
	 *
	 * @return array [instance, constructor args]
	 */
	public function instanceProvider() {
		$instanceBuilder = array( $this, 'newInstance' );

		return array_map(
			function( array $args ) use ( $instanceBuilder ) {
				return array(
					call_user_func_array( $instanceBuilder, $args ),
					$args
				);
			},
			$this->validConstructorArgumentsProvider()
		);
	}

	/**
	 * @dataProvider validConstructorArgumentsProvider
	 *
	 * @since 0.1
	 */
	public function testConstructorWithValidArguments() {
		$dataItem = call_user_func_array(
			array( $this, 'newInstance' ),
			func_get_args()
		);

		$this->assertInstanceOf( $this->getClass(), $dataItem );
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 *
	 * @since 0.1
	 */
	public function testConstructorWithInvalidArguments() {
		$this->setExpectedException( 'Exception' );

		call_user_func_array(
			array( $this, 'newInstance' ),
			func_get_args()
		);
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testImplements( DataValue $value, array $arguments ) {
		$this->assertInstanceOf( '\Immutable', $value );
		$this->assertInstanceOf( '\Hashable', $value );
		$this->assertInstanceOf( '\Comparable', $value );
		$this->assertInstanceOf( '\Serializable', $value );
		$this->assertInstanceOf( '\Copyable', $value );
		$this->assertInstanceOf( '\DataValues\DataValue', $value );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testGetType( DataValue $value, array $arguments ) {
		$valueType = $value->getType();
		$this->assertInternalType( 'string', $valueType );
		$this->assertTrue( strlen( $valueType ) > 0 );

		// Check whether using getType statically returns the same as called from an instance:
		$staticValueType = call_user_func( array( $this->getClass(), 'getType' ) );
		$this->assertEquals( $staticValueType, $valueType );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testSerialization( DataValue $value, array $arguments ) {
		$serialization = serialize( $value );
		$this->assertInternalType( 'string', $serialization );

		$unserialized = unserialize( $serialization );
		$this->assertInstanceOf( '\DataValues\DataValue', $unserialized );

		$this->assertTrue( $value->equals( $unserialized ) );
		$this->assertEquals( $value, $unserialized );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testEquals( DataValue $value, array $arguments ) {
		$this->assertTrue( $value->equals( $value ) );

		foreach ( array( true, false, null, 'foo', 42, array(), 4.2 ) as $otherValue ) {
			$this->assertFalse( $value->equals( $otherValue ) );
		}
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testGetHash( DataValue $value, array $arguments ) {
		$hash = $value->getHash();

		$this->assertInternalType( 'string', $hash );
		$this->assertEquals( $hash, $value->getHash() );
		$this->assertEquals( $hash, $value->getCopy()->getHash() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testGetCopy( DataValue $value, array $arguments ) {
		$copy = $value->getCopy();

		$this->assertInstanceOf( '\DataValues\DataValue', $copy );
		$this->assertTrue( $value->equals( $copy ) );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testGetValueSimple( DataValue $value, array $arguments ) {
		$value->getValue();
		$this->assertTrue( true );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataValue $value
	 * @param array $arguments
	 */
	public function testGetArrayValueSimple( DataValue $value, array $arguments ) {
		$value->getArrayValue();
		$this->assertTrue( true );
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

		$this->assertEquals( $value->getType(), $array['type'] );
		$this->assertEquals( $value->getArrayValue(), $array['value'] );
	}

}
