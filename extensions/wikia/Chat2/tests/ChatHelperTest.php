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
	 * @dataProvider testGetChatConfigDataProvider
	 */
	public function testGetChatConfig( $type, $wgWikiaEnvironment, $expected ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $wgWikiaEnvironment );
		$chatConfig = $this->helper->getServerNodes( $type );

		$this->assertEquals( $expected, $chatConfig );
	}

	public function testGetChatConfigDataProvider() {
		return [
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'prod',
				'expected' => []
			],
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'preview',
				'expected' => []
			],
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'verify',
				'expected' => []
			],
			[
				'type' => 'private',
				'wgWikiaEnvironment' => 'dev',
				'expected' => []
			],
			[
				'type' => 'public',
				'wgWikiaEnvironment' => 'prod',
				'expected' => []
			],
			[
				'type' => 'public',
				'wgWikiaEnvironment' => 'preview',
				'expected' => []
			],
			[
				'type' => 'public',
				'wgWikiaEnvironment' => 'verify',
				'expected' => []
			],
			[
				'type' => 'public',
				'wgWikiaEnvironment' => 'dev',
				'expected' => []
			]
		];
	}
}
