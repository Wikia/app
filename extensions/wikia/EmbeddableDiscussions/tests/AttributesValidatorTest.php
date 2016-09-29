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
			[ true, true, "True should be true" ],
			[ false, true, "False should be true" ],
			[ 'true', true, "'True' sting should be true" ],
			[ 'false', true, "'false' string should be true" ],
			[ 'fkesnfesjkf', false, "Random string should be false" ],
			[ 9999, false, "Number should be false" ],
		];
	}
}
