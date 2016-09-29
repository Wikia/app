<?php

class AttributesValidatorTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../AttributesValidator.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider boolishDataProvider
	 */
	public function testIsBoolish( $value, $expected, $message ) {
		$result = AttributesValidator::isBoolish( $value );
		$this->assertEquals( $expected, $result, $message );
	}

	public function boolishDataProvider() {
		return [
			// value, expected, message
			[ null, false, "null should be false" ],
			[ true, true, "True should be true" ],
			[ false, true, "False should be true" ],
			[ 'true', true, "'True' sting should be true" ],
			[ 'True', true, "'True' sting should be true" ],
			[ 'false', true, "'false' string should be true" ],
			[ 'FALSE', true, "'false' string should be true" ],
			[ 'fkesnfesjkf', false, "Random string should be false" ],
			[ 9999, false, "Number should be false" ],
			[ 0, false, "0 should be false" ],
		];
	}

	/**
	 * @dataProvider isInRangeDataProvider
	 */
	public function testIsInRange( $value, $min, $max, $expected, $message ) {
		$result = AttributesValidator::isIntegerInRange( $value, $min, $max );
		$this->assertEquals( $expected, $result, $message );
	}

	public function isInRangeDataProvider() {
		return [
			// value, min, max, expected, message
			[ null, 0, 0, false, 'null should be false' ],
			[ 0, 0, 0, true, '0 is in a range between 0 and 0' ],
			[ 1, 0, 2, true, '1 is in a range between 0 and 2' ],
			[ 2.0, 1, 3, true, '2.0 is not integer but will be evaluated to one and accepted' ],
			[ '2.0', 1, 3, true, '2.0 is not integer but will be evaluated to one and accepted' ],
			[ '0', 0, 2, true, 'string number is in range' ],
			[ 0, 1, 2, false, '0 is not in a range between 1 and 2' ],
			[ 2.2, 1, 3, false, '2.2 is not integer' ],
			[ 'a', 1, 2, false, 'value is not a number' ],
			[ 'a', 0, 1000, false, 'Char is not a number in range' ],
		];
	}
}
