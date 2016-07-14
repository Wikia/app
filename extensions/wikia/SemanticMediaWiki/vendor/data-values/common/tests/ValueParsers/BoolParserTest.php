<?php

namespace ValueParsers\Test;

use DataValues\BooleanValue;

/**
 * Unit test BoolParser class.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BoolParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array(
			'yes' => true,
			'on' => true,
			'1' => true,
			'true' => true,
			'no' => false,
			'off' => false,
			'0' => false,
			'false' => false,

			'YeS' => true,
			'ON' => true,
			'No' => false,
			'OfF' => false,
		);

		foreach ( $valid as $value => $expected ) {
			$expected = new BooleanValue( $expected );
			$argLists[] = array( (string)$value, $expected );
		}

		return $argLists;
	}

	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = array(
			'foo',
			'2',
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
		return 'ValueParsers\BoolParser';
	}

}
