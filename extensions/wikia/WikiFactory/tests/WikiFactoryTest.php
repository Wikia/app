<?php

class WikiFactoryTest extends WikiaBaseTest {

	private $serverName = null;

	public function setUp() {
		parent::setUp();

		if ( isset($_SERVER['SERVER_NAME'] ) ) {
			$this->serverName = $_SERVER['SERVER_NAME'];
		}
	}

	public function tearDown() {
		parent::tearDown();

		if ( !empty($this->serverName) ) {
			$_SERVER['SERVER_NAME'] = $this->serverName;
		}
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
	 * @dataProvider prepareUrlToParseDataProvider
	 */
	public function testPrepareUrlToParse( $url, $expected ) {
		$url = WikiFactory::prepareUrlToParse( $url );
		$this->assertEquals( $expected, $url );
	}

	public function getLocalEnvURLDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com',
				'expected' => 'http://muppet.preview.wikia.com'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://muppet.verify.wikia.com/wiki/Muppet'
			],
			[
				'env' => WIKIA_ENV_STABLE,
				'forcedEnv' => null,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://muppet.stable.wikia.com/wiki/Muppet'
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
				'expected' => 'http://gta.sandbox-s1.wikia.com/Vehicles_in_GTA_III'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'forcedEnv' => null,
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://gta.verify.wikia.com/wiki/test/test/test'
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
				'expected' => 'http://gta.preview.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => WIKIA_ENV_DEV,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.preview.wikia.com'
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
				'expected' => 'http://gta.stable.wikia.com'
			],
			[
				'env' => WIKIA_ENV_STABLE,
				'forcedEnv' => null,
				'url' => 'http://gta.stable.wikia.com/wiki/test',
				'expected' => 'http://gta.stable.wikia.com/wiki/test'
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
				'expected' => 'https://fallout.preview.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => null,
				'url' => 'https://muppet.wikia.com/wiki',
				'expected' => 'https://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'forcedEnv' => null,
				'url' => '//www.wikia.com/wiki/test',
				'expected' => '//www.wikia.com/wiki/test',
			],
			[
				'env' => WIKIA_ENV_STAGING,
				'forcedEnv' => null,
				'url' => '//fallout.wikia.com/wiki/test',
				'expected' => '//fallout.wikia-staging.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'forcedEnv' => null,
				'url' => '//fallout.wikia.com/wiki/test',
				'expected' => '//fallout.preview.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'forcedEnv' => null,
				'url' => '//muppet.wikia.com/wiki',
				'expected' => '//muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
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
