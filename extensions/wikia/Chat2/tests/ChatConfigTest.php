<?php

class ChatConfigTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getApiServerDataProvider
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

	public function getApiServerDataProvider() {
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
