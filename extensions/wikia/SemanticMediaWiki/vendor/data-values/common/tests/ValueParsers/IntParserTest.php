<?php

namespace ValueParsers\Test;

use DataValues\NumberValue;

/**
 * Unit test IntParser class.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IntParserTest extends StringValueParserTest {

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
		);

		foreach ( $valid as $value => $expected ) {
			// Because PHP turns them into ints using black magic
			$value = (string)$value;

			$expected = new NumberValue( $expected );
			$argLists[] = array( $value, $expected );
		}

		return $argLists;
	}

	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = array(
			'foo',
			'4.2',
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
		return 'ValueParsers\IntParser';
	}

}
