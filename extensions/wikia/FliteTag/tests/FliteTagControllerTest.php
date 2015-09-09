<?php

class FliteTagControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/FliteTag/FliteTag.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getIsTagParamValidData
	 */
	public function testValidateAttributes( $desc, $mockedIsValid, $mockedAttributes, $expectedErrors ) {
		$mockedError = $this->getMockBuilder( 'stdObject' )
			->disableOriginalConstructor()
			->setMethods( [ 'getMsg' ] )
			->getMock();

		$mockedError->expects( $this->any() )
			->method( 'getMsg' )
			->willReturn( 'error' );

		$mockedWikiaValidator = $this->getMockBuilder( 'WikiaValidator' )
			->setMockClassName( 'WikiaValidatorNumeric' )
			->disableOriginalConstructor()
			->setMethods( [ 'isValid', 'getError' ] )
			->getMock();

		$mockedWikiaValidator->expects( $this->any() )
			->method( 'isValid' )
			->willReturn( $mockedIsValid );

		$mockedWikiaValidator->expects( $this->any() )
			->method( 'getError' )
			->willReturn( $mockedError );

		$mockedController = $this->getMockBuilder( 'FliteTagController' )
			->disableOriginalConstructor()
			->setMethods( [ 'buildParamValidator' ] )
			->getMock();

		$mockedController->expects( $this->any() )
			->method( 'buildParamValidator' )
			->willReturn( $mockedWikiaValidator );

		/** @var FliteTagController $mockedController */
		$actual = $mockedController->validateAttributes( $mockedAttributes );
		$this->assertEquals( $expectedErrors, $actual, $desc );
	}

	public function getIsTagParamValidData() {
		return [
			[
				'validator returns true',
				true,
				[
					'guid' => 'valid',
					'height' => 'valid',
					'width' => 'valid'
				],
				[],
			],
			[
				'validator returns false',
				false,
				[
					'guid' => 'invalid',
					'height' => 'invalid',
					'width' => 'invalid'
				],
				[
					(object) [ 'message' => 'error' ],
					(object) [ 'message' => 'error' ],
					(object) [ 'message' => 'error' ]
				]
			],
			[
				'no attributes but we still check the whitelisted',
				false,
				[],
				[
					(object) [ 'message' => 'error' ],
					(object) [ 'message' => 'error' ],
					(object) [ 'message' => 'error' ]
				]
			],
		];
	}
}
