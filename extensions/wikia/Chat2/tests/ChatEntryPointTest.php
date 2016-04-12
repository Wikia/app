<?php

class ChatEntryPointTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testGetChatTemplateNameDataProvider
	 */
	public function testGetChatTemplateName ( $isOasis, $expected ) {
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$templateName = ChatEntryPoint::getChatTemplateName();

		$this->assertEquals( $templateName, $expected );
	}

	public function testGetChatTemplateNameDataProvider() {
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
