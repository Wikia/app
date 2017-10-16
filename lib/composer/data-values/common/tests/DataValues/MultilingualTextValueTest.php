<?php

namespace DataValues\Tests;

use DataValues\MonolingualTextValue;
use DataValues\MultilingualTextValue;

/**
 * @covers DataValues\MultilingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MultilingualTextValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\MultilingualTextValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( array() );
		$argLists[] = array( array( new MonolingualTextValue( 'en', 'foo' ) ) );
		$argLists[] = array( array( new MonolingualTextValue( 'en', 'foo' ), new MonolingualTextValue( 'de', 'foo' ) ) );
		$argLists[] = array( array( new MonolingualTextValue( 'en', 'foo' ), new MonolingualTextValue( 'de', 'bar' ) ) );
		$argLists[] = array( array(
			new MonolingualTextValue( 'en', 'foo' ),
			new MonolingualTextValue( 'de', ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' )
		) );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( array( 42 ) );
		$argLists[] = array( array( false ) );
		$argLists[] = array( array( true ) );
		$argLists[] = array( array( null ) );
		$argLists[] = array( array( array() ) );
		$argLists[] = array( array( 'foo' ) );

		$argLists[] = array( array( 42 => 'foo' ) );
		$argLists[] = array( array( '' => 'foo' ) );
		$argLists[] = array( array( 'en' => 42 ) );
		$argLists[] = array( array( 'en' => null ) );
		$argLists[] = array( array( 'en' => true ) );
		$argLists[] = array( array( 'en' => array() ) );
		$argLists[] = array( array( 'en' => 4.2 ) );

		$argLists[] = array( array( new MonolingualTextValue( 'en', 'foo' ), false ) );
		$argLists[] = array( array( new MonolingualTextValue( 'en', 'foo' ), 'foobar' ) );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param MultilingualTextValue $texts
	 * @param array $arguments
	 */
	public function testGetTexts( MultilingualTextValue $texts, array $arguments ) {
		$actual = $texts->getTexts();

		$this->assertInternalType( 'array', $actual );
		$this->assertContainsOnlyInstancesOf( '\DataValues\MonolingualTextValue', $actual );
		$this->assertEquals( $arguments[0], array_values( $actual ) );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param MultilingualTextValue $texts
	 * @param array $arguments
	 */
	public function testGetValue( MultilingualTextValue $texts, array $arguments ) {
		$this->assertInstanceOf( $this->getClass(), $texts->getValue() );
	}

}
