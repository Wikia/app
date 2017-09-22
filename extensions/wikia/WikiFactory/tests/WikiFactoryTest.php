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

	public function testGetCurrentStagingHostDevbox() {
		$this->mockGlobalVariable( 'wgDevDomain', 'mydevbox.wikia-dev.com' );
		$this->assertEquals('muppet.mydevbox.wikia-dev.com',
			WikiFactory::getCurrentStagingHost('muppet','http://www.muppet.wikia.com/', 'dev-mydevbox'));
	}

	/**
	 * @dataProvider getLocalEnvURLDataProvider
	 */
	public function testGetLocalEnvURL( $environment, $forcedEnv, $url, $expected ) {
		$this->mockEnvironment( $environment );
		$url = WikiFactory::getLocalEnvURL( $url, $forcedEnv );
		$this->assertEquals( $expected, $url );
	}

	/**
	 * @dataProvider getCurrentStagingHostDataProvider
	 */
	public function testGetCurrentStagingHost($host, $dbName, $devDomain, $expHost) {
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
		$this->mockGlobalVariable( 'wgDevDomain', $devDomain );

		$this->assertEquals($expHost, WikiFactory::getCurrentStagingHost($dbName, $default, $host));
	}

	/**
	 * @dataProvider prepareUrlToParseDataProvider
	 */
	public function testPrepareUrlToParse( $url, $expected ) {
		$url = WikiFactory::prepareUrlToParse( $url );
		$this->assertEquals( $expected, $url );
	}

	public function getCurrentStagingHostDataProvider() {
		return [
			[
				'demo-sony-s1',
				'muppet',
				'',
				'demo-sony.muppet.wikia.com'
			],
			[
				'demo-sony-s2',
				'muppet',
				'',
				'demo-sony.muppet.wikia.com'
			],
			[
				'preview',
				'muppet',
				'',
				'preview.muppet.wikia.com'
			],
			[
				'verify',
				'muppet',
				'',
				'verify.muppet.wikia.com',
			],
			[
				'dev-test',
				'muppet',
				'test.wikia-dev.com',
				'muppet.test.wikia-dev.com',
			],
			[
				'sandbox-s3',
				'muppet',
				'',
				'sandbox-s3.muppet.wikia.com'
			]
		];
	}

	public function getLocalEnvURLDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com',
				'expected' => 'http://preview.muppet.wikia.com'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://verify.muppet.wikia.com/wiki/Muppet'
			],
			[
				'env' => WIKIA_ENV_STABLE,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://stable.muppet.wikia.com/wiki/Muppet'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com/wiki',
				'expected' => 'http://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_SANDBOX,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/Vehicles_in_GTA_III',
				'expected' => 'http://sandbox-s1.gta.wikia.com/Vehicles_in_GTA_III'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://verify.gta.wikia.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_STAGING,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://gta.wikia-staging.com/wiki/test/test/test'
			],
			// @see PLATFORM-2400
			[
				'env' => WIKIA_ENV_STAGING,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia-staging.com/wiki/test/test/test',
				'expected' => 'http://gta.wikia-staging.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.' . static::MOCK_DEV_NAME . '.wikia-dev.us'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => WIKIA_ENV_PREVIEW,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://preview.gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => WIKIA_ENV_DEV,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://preview.gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'http://muupet.wikia.com/wiki/test/test/test',
				'expected' => 'http://muupet.wikia.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => WIKIA_ENV_PROD,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_STABLE,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://stable.gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_STABLE,
				'forcedEnv' => null,
				'url' => 'http://stable.gta.wikia.com/wiki/test',
				'expected' => 'http://stable.gta.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'https://www.wikia.com',
				'expected' => 'https://www.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'https://www.wikia.com/wiki/test',
				'expected' => 'https://www.wikia.com/wiki/test',
			],
			[
				'env' => WIKIA_ENV_STAGING,
				'forcedEnv' => null,
				'url' => 'https://fallout.wikia.com/wiki/test',
				'expected' => 'https://fallout.wikia-staging.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => null,
				'url' => 'https://fallout.wikia.com/wiki/test',
				'expected' => 'http://preview.fallout.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => null,
				'url' => 'https://muppet.wikia.com/wiki',
				'expected' => 'http://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'http://google.com',
				'expected' => 'http://google.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => 'https://mysecureddomain.com',
				'expected' => 'https://mysecureddomain.com'
			]
		];
	}

	public function prepareUrlToParseDataProvider() {
		return [
			[
				'http://www.community-name.wikia.com',
				'http://www.community-name.wikia.com',
			],
			[
				'http://community-name.wikia.com',
				'http://community-name.wikia.com',
			],
			[
				'www.community-name.wikia.com',
				'http://www.community-name.wikia.com',
			],
			[
				'community-name.wikia.com',
				'http://community-name.wikia.com',
			],
			[
				'http://www.community-name',
				'http://www.community-name.wikia.com',
			],
			[
				'www.community-name',
				'http://www.community-name.wikia.com',
			],
			[
				'community-name',
				'http://community-name.wikia.com',
			]
		];
	}

	public function testGetHostById() {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', 1 );
		$this->mockStaticMethod( 'WikiFactory', 'getLocalEnvURL', 'test_host/' );

		$this->assertEquals( 'test_host', WikiFactory::getHostById( 2 ) );
	}

	public function testRenderValueOfVariableWithoutValue() {
		$variable = new stdClass();

		$this->assertEquals( "", WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfStringVariable() {
		$variable = new stdClass();
		$variable->cv_value = serialize( "foo" );
		$variable->cv_variable_type = "string";

		$this->assertEquals( "foo", WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfIntegerVariable() {
		$variable = new stdClass();
		$variable->cv_value = serialize( 15 );
		$variable->cv_variable_type = "integer";

		$this->assertEquals( 15, WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfFloatVariable() {
		$variable = new stdClass();
		$variable->cv_value = serialize( 5.234 );
		$variable->cv_variable_type = "float";

		$this->assertEquals( 5.234, WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfArrayVariable() {
		$variable = new stdClass();
		$variable->cv_value = serialize( array( "a", "b", "c" ) );
		$variable->cv_variable_type = "array";

		$this->assertEquals( '[&quot;a&quot;,&quot;b&quot;,&quot;c&quot;]', WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfAssociativeArrayVariable() {
		$variable = new stdClass();
		$variable->cv_value = serialize( array( "foo" => "bar", "0" => "c" ) );
		$variable->cv_variable_type = "array";
		$expectedRender = <<<EOT
array (
  'foo' =&gt; 'bar',
  0 =&gt; 'c',
)
EOT;

		$this->assertEquals( $expectedRender, WikiFactory::renderValue( $variable ) );
	}

	public function testRenderValueOfAssociativeArrayVariable2() {
		$variable = new stdClass();
		$variable->cv_value = serialize( array( 1 => "foo", 15 => "bar" ) );
		$variable->cv_variable_type = "array";
		$expectedRender = <<<EOT
array (
  1 =&gt; 'foo',
  15 =&gt; 'bar',
)
EOT;

		$this->assertEquals( $expectedRender, WikiFactory::renderValue( $variable ) );
	}
}
