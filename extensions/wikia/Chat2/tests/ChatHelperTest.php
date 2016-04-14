<?php

class ChatHelperTest extends WikiaBaseTest {
	private $helper;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();

		$this->helper = new ChatHelper();
	}

	/**
	 * @dataProvider testGetChatConfigDataProvider
	 */
	public function testGetChatConfig( $type, $wgWikiaEnvironment, $expected ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $wgWikiaEnvironment );
		$chatConfig = $this->helper->getChatConfig( $type );

		$this->assertEquals( $expected, $chatConfig );
	}

	public function testGetChatConfigDataProvider() {
		return [
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'dev',
				'expected' => []
			],
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'prod',
				'expected' => []
			],
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'prod',
				'expected' => []
			]
		];
	}
}
