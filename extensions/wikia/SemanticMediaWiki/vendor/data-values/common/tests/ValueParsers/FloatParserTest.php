<?php

namespace ValueParsers\Test;

use DataValues\NumberValue;

/**
 * Unit test FloatParser class.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 * @group FloatParserTest
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FloatParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array(
			'0' => 0,
			'1' => 1,
			'42' => 42,
			'01' => 01,
			'9001' => 9001,
			'-1' => -1,
			'-42' => -42,

			'0.0' => 0,
			'1.0' => 1,
			'4.2' => 4.2,
			'0.1' => 0.1,
			'90.01' => 90.01,
			'-1.0' => -1,
			'-4.2' => -4.2,
		);

		foreach ( $valid as $value => $expected ) {
			// Because PHP turns them into ints/floats using black magic
			$value = (string)$value;

			// Because 1 is an int but will come out as a float
			$expected = (float)$expected;

			$expected = new NumberValue( $expected );
			$argLists[] = array( $value, $expected );
		}

		return $argLists;
	}

	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = array(
			'foo',
			'',
			'--1',
			'1-',
			'1 1',
			'1,',
			',1',
			',1,',
			'one',
			'0x20',
			'+1',
			'1+1',
			'1-1',
			'1.2.3',
		);

		foreach ( $invalid as $value ) {
			$argLists[] = array( $value );
		}

		return $argLists;
	}

	/**
	 * @see ValueParserTestBase::getParserClass
	 *
	 * @return string
	 */
	protected function getParserClass() {
		return 'ValueParsers\FloatParser';
	}

}
