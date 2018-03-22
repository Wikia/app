<?php

namespace DataValues\Tests;

use DataValues\NumberValue;

/**
 * @covers DataValues\NumberValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NumberValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\NumberValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 42 );
		$argLists[] = array( -42 );
		$argLists[] = array( 4.2 );
		$argLists[] = array( -4.2 );
		$argLists[] = array( 0 );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 'foo' );
		$argLists[] = array( '' );
		$argLists[] = array( '0' );
		$argLists[] = array( '42' );
		$argLists[] = array( '-42' );
		$argLists[] = array( '4.2' );
		$argLists[] = array( '-4.2' );
		$argLists[] = array( false );
		$argLists[] = array( true );
		$argLists[] = array( null );
		$argLists[] = array( '0x20' );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param NumberValue $number
	 * @param array $arguments
	 */
	public function testGetValue( NumberValue $number, array $arguments ) {
		$this->assertEquals( $arguments[0], $number->getValue() );
	}

}
