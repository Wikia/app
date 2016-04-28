<?php

class ChatConfigTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testGetPublicHostDataProvider
	 */
	public function testGetPublicHost( $environment, $wgChatPublicHostOverride, $expected ) {
		$this->mockGlobalVariable( 'wgChatPublicHost', 'chat.wikia-services.com:80' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $environment );
		$this->mockGlobalVariable( 'wgChatPublicHostOverride', $wgChatPublicHostOverride );

		$chatConfig = ChatConfig::getPublicHost();

		$this->assertEquals( $expected, $chatConfig );
	}

	public function testGetPublicHostDataProvider() {
		return [
			[
				'environment' => 'dev',
				'wgChatPublicHostOverride' => '',
				'expected' => 'dev-chat.wikia-services.com:80'
			],
			[
				'environment' => 'dev',
				'wgChatPublicHostOverride' => 'dev-test:8080',
				'expected' => 'dev-test:8080'
			],
			[
				'environment' => 'sandbox',
				'wgChatPublicHostOverride' => null,
				'expected' => 'sandbox-chat.wikia-services.com:80'
			],
			[
				'environment' => 'sandbox',
				'wgChatPublicHostOverride' => 'sandbox-s1:9101',
				'expected' => 'sandbox-s1:9101'
			],
			[
				'environment' => 'preview',
				'wgChatPublicHostOverride' => null,
				'expected' => 'preview-chat.wikia-services.com:80'
			],
			[
				'environment' => 'preview',
				'wgChatPublicHostOverride' => 'sandbox-test:9101',
				'expected' => 'sandbox-test:9101'
			],
			[
				'environment' => 'prod',
				'wgChatPublicHostOverride' => null,
				'expected' => 'chat.wikia-services.com:80'
			],
			[
				'environment' => 'prod',
				'wgChatPublicHostOverride' => 'chat-machine:8000',
				'expected' => 'chat-machine:8000'
			],
		];
	}

	/**
	 * @dataProvider testGetApiServerDataProvider
	 */
	public function testGetApiServer( $wgChatPrivateServerOverride, $expected ) {
		$this->mockGlobalVariable( 'wgChatPrivateServerOverride', $wgChatPrivateServerOverride );

		$consulHosts = [
			'1.1.1.1:80',
			'1.1.1.1:81',
			'1.1.1.1:82',
			'1.1.1.1:83',
		];

		// Consul client class mock
		$consulMock = $this->getMockBuilder( 'Wikia\Consul\Client' )
			->disableOriginalConstructor()
			->setMethods( [ 'getNodes' ] )
			->getMock();

		$consulMock
			->expects( empty( $wgChatPrivateServerOverride ) ? $this->once() : $this->never() )
			->method( 'getNodes' )
			->with( 'chat-private' )
			->will( $this->returnValue( $consulHosts ) );
		$this->mockClass( 'Wikia\Consul\Client', $consulMock );

		$server = ChatConfig::getApiServer();

		$this->assertContains( $server, $expected );
	}

	public function testGetApiServerDataProvider() {
		return [
			[
				'wgChatPrivateServerOverride' => '',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'wgChatPrivateServerOverride' => '3.3.3.3:80',
				'expected' => [
					'3.3.3.3:80'
				]
			],
		];
	}
}
