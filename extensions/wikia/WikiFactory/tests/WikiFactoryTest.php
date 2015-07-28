<?php

class WikiFactoryTest extends WikiaBaseTest {

	private $serverName = null;
	/**
	 * Only for holding original values
	 * @var array
	 */
	private $org_StagingList;

	public function setUp() {
		parent::setUp();

		global $wgStagingList;
		$this->org_StagingList = $wgStagingList;
		$wgStagingList = ['teststagging'];
		if ( isset($_SERVER['SERVER_NAME'] ) ) {
			$this->serverName = $_SERVER['SERVER_NAME'];
		}
	}

	public function tearDown() {
		parent::tearDown();

		global $wgStagingList;
		$wgStagingList = $this->org_StagingList;
		if ( !empty($this->serverName) ) {
			$_SERVER['SERVER_NAME'] = $this->serverName;
		}
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
	public function testGetLocalEnvURL( $environment, $url, $expected ) {
		$this->mockEnvironment( $environment );
		$url = WikiFactory::getLocalEnvURL( $url );
		$this->assertEquals( $expected, $url );
	}

	/**
	 * @dataProvider testGetCurrentStagingHostDataProvider
	 */
	public function testGetCurrentStagingHost($host, $dbName, $expHost) {
		$default = 'defaulthost';
		$this->mockGlobalVariable('wgStagingList', ['preview',
			'verify',
			'sandbox-s1',
			'sandbox-s2',
			'sandbox-s3',
			'sandbox-s4',
			'sandbox-s5',
			'sandbox-sony',
			'externaltest',
			'sandbox-qa01',
			'sandbox-qa02',
			'sandbox-qa03',
			'sandbox-qa04',
			'demo-sony',
		] );

		$this->assertEquals($expHost, WikiFactory::getCurrentStagingHost($dbName, $default, $host));
	}

	public function testGetCurrentStagingHostDataProvider() {
		return [
			[
				'demo-sony-s1',
				'muppet',
				'demo-sony.muppet.wikia.com'
			],
			[
				'demo-sony-s2',
				'muppet',
				'demo-sony.muppet.wikia.com'
			],
			[
				'preview',
				'muppet',
				'preview.muppet.wikia.com'
			],
			[
				'verify',
				'muppet',
				'verify.muppet.wikia.com'
			],
			[
				'dev-test',
				'muppet',
				'muppet.test.wikia-dev.com'
			],
			[
				'sandbox-s3',
				'muppet',
				'sandbox-s3.muppet.wikia.com'
			]
		];
	}

	public function testGetLocalEnvURLDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_PREVIEW,
				'url' => 'http://muppet.wikia.com',
				'expected' => 'http://preview.muppet.wikia.com'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://verify.muppet.wikia.com/wiki/Muppet'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'http://muppet.wikia.com/wiki',
				'expected' => 'http://muppet.' . self::MOCK_DEV_NAME . '.wikia-dev.com/wiki'
			],
			[
				'env' => WIKIA_ENV_SANDBOX,
				'url' => 'http://gta.wikia.com/Vehicles_in_GTA_III',
				'expected' => 'http://sandbox-s1.gta.wikia.com/Vehicles_in_GTA_III'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://verify.gta.wikia.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.' . self::MOCK_DEV_NAME . '.wikia-dev.com'
			]
		];
	}
}
