<?php

namespace ParamProcessor\Tests;

use DataValues\Tests\DataValueTest;
use ParamProcessor\MediaWikiTitleValue;

/**
 * @covers ParamProcessor\MediaWikiTitleValue
 *
 * @group Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiTitleValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getClass() {
		return 'ParamProcessor\MediaWikiTitleValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( \Title::newMainPage() );
		$argLists[] = array( \Title::newFromText( 'Foobar' ) );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array();
		$argLists[] = array( 42 );
		$argLists[] = array( array() );
		$argLists[] = array( false );
		$argLists[] = array( true );
		$argLists[] = array( null );
		$argLists[] = array( 'foo' );
		$argLists[] = array( '' );
		$argLists[] = array( ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param MediaWikiTitleValue $titleValue
	 * @param array $arguments
	 */
	public function testGetValue( MediaWikiTitleValue $titleValue, array $arguments ) {
		$this->assertEquals( $arguments[0]->getFullText(), $titleValue->getValue()->getFullText() );
	}

}