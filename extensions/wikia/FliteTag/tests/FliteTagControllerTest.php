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
	public function testIsTagParamValid( $desc, $mockedIsValid, $mockedErrorMsg, $expected ) {
		$controller = new FliteTagController();

		$mockError = $this->getMockBuilder( 'stdObject' )
			->disableOriginalConstructor()
			->setMethods( [ 'getMsg' ] )
			->getMock();

		$mockError->expects( $this->any() )
			->method( 'getMsg' )
			->willReturn( $mockedErrorMsg );

		$mockWikiaValidator = $this->getMockBuilder( 'WikiaValidator' )
			->setMockClassName( 'WikiaValidatorNumeric' )
			->disableOriginalConstructor()
			->setMethods( [ 'isValid', 'getError' ] )
			->getMock();

		$mockWikiaValidator->expects( $this->once() )
			->method( 'isValid' )
			->willReturn( $mockedIsValid );

		$mockWikiaValidator->expects( $this->any() )
			->method( 'getError' )
			->willReturn( $mockError );

		$errorMsg = '';
		$actual = $controller->isTagParamValid( 'param', $mockWikiaValidator, $errorMsg );

		$this->assertEquals( $expected, $actual, $desc );
		$this->assertEquals( $mockedErrorMsg, $errorMsg );
	}

	public function getIsTagParamValidData() {
		return [
			[
				'validator returns true',
				true,
				'', //No validator error.
				true
			],
			[
				'validator returns false',
				false,
				'An validator error occurred.',
				false
			]
		];
	}
}
