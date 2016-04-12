<?php

class ChatEntryPointTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @param array $params
	 * @dataProvider testInfoboxParamsPassValidationDataProvider
	 */
	public function testInfoboxParamsPassValidation ( $isOasis, $expected ) {
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$templateName = ChatEntryPoint::getTemplateName();

		$this->assertEquals( $templateName, $expected );
	}

	public function testInfoboxParamsPassValidationDataProvider() {
		return [
			[
				'isOasis' => true,
				'expected' => 'entryPointTag.mustache'
			],
			[
				'isOasis' => false,
				'expected' => 'entryPointTagMonobook.mustache'
			]
		];
	}
}
