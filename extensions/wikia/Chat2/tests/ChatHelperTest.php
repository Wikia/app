<?php

class ChatHelperTest extends WikiaBaseTest {
	/** @var ChatHelper */
	private $helper;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();

		$this->helper = new ChatHelper();
	}

	/**
	 * @dataProvider testGetChatHostDataProvider
	 */
	public function testGetChatHost( $environment, $chatServerHostOverride, $expected ) {
		$this->mockGlobalVariable( 'wgChatServerHost', 'chat.wikia-services.com:80' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $environment );
		$this->mockGlobalVariable( 'wgChatServerHostOverride', $chatServerHostOverride );

		$chatConfig = $this->helper->getChatHost();

		$this->assertEquals( $expected, $chatConfig );
	}

	public function testGetChatHostDataProvider() {
		return [
			[
				'environment' => 'dev',
				'chatServerHostOverride' => '',
				'expected' => 'dev-chat.wikia-services.com:80'
			],
			[
				'environment' => 'dev',
				'chatServerHostOverride' => 'dev-test:8080',
				'expected' => 'dev-test:8080'
			],
			[
				'environment' => 'sandbox',
				'chatServerHostOverride' => null,
				'expected' => 'sandbox-chat.wikia-services.com:80'
			],
			[
				'environment' => 'sandbox',
				'chatServerHostOverride' => 'sandbox-s1:9101',
				'expected' => 'sandbox-s1:9101'
			],
			[
				'environment' => 'preview',
				'chatServerHostOverride' => null,
				'expected' => 'preview-chat.wikia-services.com:80'
			],
			[
				'environment' => 'preview',
				'chatServerHostOverride' => 'sandbox-test:9101',
				'expected' => 'sandbox-test:9101'
			],
			[
				'environment' => 'prod',
				'chatServerHostOverride' => null,
				'expected' => 'chat.wikia-services.com:80'
			],
			[
				'environment' => 'prod',
				'chatServerHostOverride' => 'chat-machine:8000',
				'expected' => 'chat-machine:8000'
			],
		];
	}
}
