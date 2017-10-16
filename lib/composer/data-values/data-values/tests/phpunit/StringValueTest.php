<?php

namespace DataValues\Tests;

use DataValues\StringValue;

/**
 * @covers DataValues\StringValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StringValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\StringValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 'foo' );
		$argLists[] = array( '' );
		$argLists[] = array( ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' );


		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( );
		$argLists[] = array( 42 );
		$argLists[] = array( array() );
		$argLists[] = array( false );
		$argLists[] = array( true );
		$argLists[] = array( null );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param StringValue $string
	 * @param array $arguments
	 */
	public function testGetValue( StringValue $string, array $arguments ) {
		$this->assertEquals( $arguments[0], $string->getValue() );
	}

}
