<?php
class WeiboTagValidatorTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../WeiboTag.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testValidateAttributesDataProvider
	 * @param array $passedAttributes
	 * @param boolean $expectedResult
	 */
	public function testValidateAttributes( $passedAttributes, $expectedResult ) {
		$validator = new WeiboTagValidator();
		$this->assertEquals( $validator->validateAttributes( $passedAttributes ), $expectedResult );
	}

	public function testValidateAttributesDataProvider() {
		return [
			[ [ ], false ],
			[ [ 'foo' ], false ],
			[ [ 'uids' ], false ],
			[ [ 'uids' => '' ], false ],
			[ [ 'uids' => 'fizz' ], true ],
		];
	}
}
