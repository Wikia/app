<?php

namespace DataValues\Tests;

use DataValues\BooleanValue;

/**
 * @covers DataValues\BooleanValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BooleanValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\BooleanValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( false );
		$argLists[] = array( true );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( );
		$argLists[] = array( 42 );
		$argLists[] = array( array() );
		$argLists[] = array( '1' );
		$argLists[] = array( '' );
		$argLists[] = array( 0 );
		$argLists[] = array( 1 );
		$argLists[] = array( 'foo' );
		$argLists[] = array( null );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param BooleanValue $boolean
	 * @param array $arguments
	 */
	public function testGetValue( BooleanValue $boolean, array $arguments ) {
		$this->assertEquals( $arguments[0], $boolean->getValue() );
	}

}
