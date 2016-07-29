<?php

namespace DataValues\Tests;

use DataValues\MonolingualTextValue;

/**
 * @covers DataValues\MonolingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\MonolingualTextValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 'en', 'foo' );
		$argLists[] = array( 'en', ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 42 );
		$argLists[] = array( array() );
		$argLists[] = array( false );
		$argLists[] = array( true );
		$argLists[] = array( null );
		$argLists[] = array( 'foo' );
		$argLists[] = array( 'en' );
		$argLists[] = array( 'en', 42 );
		$argLists[] = array( 'en', false );
		$argLists[] = array( 'en', array() );
		$argLists[] = array( 'en', null );
		$argLists[] = array( '', 'foo' );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param MonolingualTextValue $text
	 * @param array $arguments
	 */
	public function testGetText( MonolingualTextValue $text, array $arguments ) {
		$this->assertEquals( $arguments[1], $text->getText() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param MonolingualTextValue $text
	 * @param array $arguments
	 */
	public function testGetLanguageCode( MonolingualTextValue $text, array $arguments ) {
		$this->assertEquals( $arguments[0], $text->getLanguageCode() );
	}

}
