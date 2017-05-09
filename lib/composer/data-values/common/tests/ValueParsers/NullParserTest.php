<?php

namespace ValueParsers\Test;

use DataValues\UnknownValue;
use ValueParsers\NullParser;
use ValueParsers\ValueParser;

/**
 * @covers ValueParsers\NullParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullParserTest extends ValueParserTestBase {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return NullParser
	 */
	protected function getInstance() {
		return new NullParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		$values = array(
			'42',
			42,
			false,
			array(),
			'ohi there!',
			null,
			4.2,
		);

		foreach ( $values as $value ) {
			$argLists[] = array(
				$value,
				new UnknownValue( $value )
			);
		}

		return $argLists;
	}

	/**
	 * @see ValueParserTestBase::invalidInputProvider
	 */
	public function invalidInputProvider() {
		return array(
			array( null )
		);
	}

	/**
	 * @see ValueParserTestBase::testParseWithInvalidInputs
	 *
	 * @dataProvider invalidInputProvider
	 * @param mixed $value
	 * @param ValueParser|null $parser
	 */
	public function testParseWithInvalidInputs( $value, ValueParser $parser = null ) {
		$this->markTestSkipped( 'NullParser has no invalid inputs' );
	}

}
