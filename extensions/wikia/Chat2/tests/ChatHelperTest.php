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

	/**
	 * @dataProvider testGetServerNodesDataProvider
	 */
	public function testGetServerNodes( $type, $chatServersOverride, $expectedType, $expected ) {
		$this->mockGlobalVariable( 'wgChatServersOverride', $chatServersOverride );

		// Consul client class mock
		$consulMock = $this->getMockBuilder( 'Wikia\Consul\Client' )
			->disableOriginalConstructor()
			->setMethods( [ 'getNodes' ] )
			->getMock();
		$consulMock->expects(
			$this->any() )
			->method( 'getNodes' )
			->with( $expectedType )
			->will( $this->returnValue( [
				'1.1.1.1:80',
				'1.1.1.1:81',
				'1.1.1.1:82',
				'1.1.1.1:83',
			] ) );
		$this->mockClass( 'Wikia\Consul\Client', $consulMock );

		$servers = $this->helper->getServerNodes( $type );

		$this->assertEquals( $expected, $servers );
	}

	public function testGetServerNodesDataProvider() {
		return [
			[
				'type' => 'public',
				'chatServersOverride' => '',
				'expectedType' => 'chat-public',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'type' => 'public',
				'chatServersOverride' => [
					'public' => ''
				],
				'expectedType' => 'chat-public',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'type' => 'public',
				'chatServersOverride' => [
					'private' => ''
				],
				'expectedType' => 'chat-public',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'type' => 'private',
				'chatServersOverride' => [
					'public' => '',
					'private' => ''
				],
				'expectedType' => 'chat-private',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'type' => 'public',
				'chatServersOverride' => [
					'public' => [],
					'private' => ['3.3.3.3:80', '3.3.3.3:80'],
				],
				'expectedType' => 'chat-public',
				'expected' => [
					'1.1.1.1:80',
					'1.1.1.1:81',
					'1.1.1.1:82',
					'1.1.1.1:83',
				]
			],
			[
				'type' => 'private',
				'chatServersOverride' => [
					'public' => ['2.2.2.2:80', '2.2.2.2:80'],
					'private' => ['3.3.3.3:80', '3.3.3.3:80'],
				],
				'expectedType' => 'chat-private',
				'expected' => [
					'3.3.3.3:80',
					'3.3.3.3:80'
				]
			],
			[
				'type' => 'public',
				'chatServersOverride' => [
					'public' => ['2.2.2.2:80', '2.2.2.2:80'],
					'private' => ['3.3.3.3:80', '3.3.3.3:80'],
				],
				'expectedType' => 'chat-public',
				'expected' => [
					'2.2.2.2:80',
					'2.2.2.2:80'
				]
			],
		];
	}
}
