<?php

class WikiFactoryTest extends WikiaBaseTest {

	private $serverName = null;
	/**
	 * Only for holding original values
	 * @var array
	 */
	private $org_StagingList;

	public function setUp() {
		global $wgStagingList;
		$this->org_StagingList = $wgStagingList;
		$wgStagingList = ['teststagging'];
		if ( isset($_SERVER['SERVER_NAME'] ) ) {
			$this->serverName = $_SERVER['SERVER_NAME'];
		}
	}

	public function tearDown() {
		global $wgStagingList;
		$wgStagingList = $this->org_StagingList;
		if ( !empty($this->serverName) ) {
			$_SERVER['SERVER_NAME'] = $this->serverName;
		}
	}

	public function testIsCurrentStagingHostTrue()
	{
		$this->assertTrue(WikiFactory::isCurrentStagingHost('teststagging'));
		$this->assertTrue(WikiFactory::isCurrentStagingHost('dev-mtydevbox'));
	}

	public function testIsCurrentStagingHostFalse()
	{
		$this->assertFalse(WikiFactory::isCurrentStagingHost('production1'));
	}

	public function testGetCurrentStagingHostSandbox()
	{
		$this->assertEquals('teststagging.muppet.wikia.com',
			WikiFactory::getCurrentStagingHost('muppet','http://www.muppet.wikia.com/', 'teststagging'));
	}

	public function testGetCurrentStagingHostDevbox()
	{
		$this->assertEquals('muppet.mydevbox.wikia-dev.com',
			WikiFactory::getCurrentStagingHost('muppet','http://www.muppet.wikia.com/', 'dev-mydevbox'));
	}

	/**
	 * @dataProvider testGetLocalEnvURLDataProvider
	 */
	public function testGetLocalEnvURL($env, $url, $expected) {
		$_SERVER['SERVER_NAME'] = $env;
		$url = WikiFactory::getLocalEnvURL($url);
		$this->assertEquals($expected, $url);
		$_SERVER['SERVER_NAME'] = null;
	}

	public function testGetLocalEnvURLDataProvider() {
		return [
			[
				'env' => 'preview.wikia.com',
				'url' => 'http://muppet.wikia.com',
				'expected' => 'http://preview.muppet.wikia.com'
			],
			[
				'env' => 'verify.wikia.com',
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://verify.muppet.wikia.com/wiki/Muppet'
			],
			[
				'env' => '.test.wikia-dev.com',
				'url' => 'http://muppet.wikia.com/wiki',
				'expected' => 'http://muppet.test.wikia-dev.com/wiki'
			],
			[
				'env' => 'sandbox-s1.wikia.com',
				'url' => 'http://gta.wikia.com/Vehicles_in_GTA_III',
				'expected' => 'http://sandbox-s1.gta.wikia.com/Vehicles_in_GTA_III'
			],
			[
				'env' => 'verify.wikia.com',
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://verify.gta.wikia.com/wiki/test/test/test'
			],
			[
				'env' => '.dev.wikia-dev.com',
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.dev.wikia-dev.com'
			]
		];
	}
}
