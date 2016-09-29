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
			[ null, false, "null should not be a valid boolean" ],
			[ true, true, "true should be a valid boolean" ],
			[ false, true, "false should be a valid boolean" ],
			[ 'true', true, "'true' should be a valid boolean" ],
			[ 'True', true, "'True' should be a valid boolean" ],
			[ 'false', true, "'false' should be a valid boolean" ],
			[ 'FALSE', true, "'FALSE' should be a valid boolean" ],
			[ 'fkesnfesjkf', false, "Random string should not be a valid boolean" ],
			[ 9999, false, "Number should not be a valid boolean" ],
			[ 0, false, "0 should not be a valid boolean" ],
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
			[ null, 0, 0, false, 'null is evaluated as a non-integer' ],
			[ 0, 0, 0, true, '0 is an integer in a range between 0 and 0' ],
			[ 1, 0, 2, true, '1 is an integer in a range between 0 and 2' ],
			[ 2.0, 1, 3, true, '2.0 is consciously evaluated as a integer in range between 1 and 3' ],
			[ '2.0', 1, 3, true, '"2.0" string is consciously evaluated as a integer in range between 1 and 3' ],
			[ '0', 0, 2, true, 'string number is evaluated as an integer in range' ],
			[ 0, 1, 2, false, '0 is not in a range between 1 and 2' ],
			[ 2.2, 1, 3, false, '2.2 is evaluated as a non-integer' ],
			[ 'a', 0, 1000, false, 'Char is evaluated as a non-integer' ],
		];
	}
}
