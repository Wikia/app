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
	 * @dataProvider testGetServerDataProvider
	 */
	public function testGetServer( $wgCityId, $expected ) {
		$this->mockGlobalVariable( 'wgCityId', $wgCityId );
		$this->mockStaticMethod( 'ChatHelper', 'getServerNodes', [
			'10.8.64.15:9001',
			'10.8.64.15:9002',
			'10.8.64.15:9003',
			'10.8.64.15:9004'
		] );

		$chatConfig = $this->helper->getServer( 'private' );

		$this->assertEquals( $expected, $chatConfig );
	}

	public function testGetServerDataProvider() {
		return [
			[
				'wgCityId' => 100,
				'expected' => [
					'serverIp' => '10.8.64.15:9001',
					'serverId' => 1
				]
			],
			[
				'wgCityId' => 101,
				'expected' => [
					'serverIp' => '10.8.64.15:9002',
					'serverId' => 2
				]
			],
			[
				'wgCityId' => 1,
				'expected' => [
					'serverIp' => '10.8.64.15:9002',
					'serverId' => 2
				]
			],
			[
				'wgCityId' => 0,
				'expected' => [
					'serverIp' => '10.8.64.15:9001',
					'serverId' => 1
				]
			],
			[
				'wgCityId' => '100',
				'expected' => [
					'serverIp' => '10.8.64.15:9001',
					'serverId' => 1
				]
			]
		];
	}
}
