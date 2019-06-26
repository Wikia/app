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
	public function testGetLocalEnvURL( $environment, $url, $expected ) {
		$this->mockEnvironment( $environment );
		$url = WikiFactory::getLocalEnvURL( $url );
		$this->assertEquals( $expected, $url );
	}

	public function getLocalEnvURLDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_PREVIEW,
				'url' => 'http://muppet.wikia.com',
				'expected' => 'http://muppet.preview.wikia.com'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'url' => 'http://muppet.wikia.com/wiki/Muppet',
				'expected' => 'http://muppet.verify.wikia.com/wiki/Muppet'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'http://muppet.wikia.com/wiki',
				'expected' => 'http://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_SANDBOX,
				'url' => 'http://gta.wikia.com/Vehicles_in_GTA_III',
				'expected' => 'http://gta.sandbox-s1.wikia.com/Vehicles_in_GTA_III'
			],
			[
				'env' => WIKIA_ENV_VERIFY,
				'url' => 'http://gta.wikia.com/wiki/test/test/test',
				'expected' => 'http://gta.verify.wikia.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.' . static::MOCK_DEV_NAME . '.wikia-dev.us'
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.preview.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => 'http://gta.wikia.com/',
				'expected' => 'http://gta.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => 'http://muupet.wikia.com/wiki/test/test/test',
				'expected' => 'http://muupet.wikia.com/wiki/test/test/test'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => 'https://www.wikia.com',
				'expected' => 'https://www.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => 'https://www.wikia.com/wiki/test',
				'expected' => 'https://www.wikia.com/wiki/test',
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'url' => 'https://fallout.wikia.com/wiki/test',
				'expected' => 'https://fallout.preview.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'https://muppet.wikia.com/wiki',
				'expected' => 'https://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'https://muppet.fandom.com/wiki',
				'expected' => 'https://muppet.' . static::MOCK_DEV_NAME . '.fandom-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => '//www.wikia.com/wiki/test',
				'expected' => '//www.wikia.com/wiki/test',
			],
			[
				'env' => WIKIA_ENV_PREVIEW,
				'url' => '//fallout.wikia.com/wiki/test',
				'expected' => '//fallout.preview.wikia.com/wiki/test'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => '//muppet.wikia.com/wiki',
				'expected' => '//muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'url' => 'http://google.com',
				'expected' => 'http://google.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
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

	/**
	 * @dataProvider prepareUrlToParseDataProvider
	 */
	public function testPrepareUrlToParse( $url, $expected ) {
		$url = WikiFactory::prepareUrlToParse( $url );
		$this->assertEquals( $expected, $url );
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

	/**
	 * @dataProvider provideArrayVariables
	 *
	 * @param array $value
	 * @param string $expected
	 */
	public function testRenderValueOfArrayVariable( array $value, string $expected ) {
		$variable = new stdClass();
		$variable->cv_value = serialize( $value );
		$variable->cv_variable_type = "array";

		$this->assertJsonStringEqualsJsonString( $expected, WikiFactory::renderValue( $variable ) );
	}

	public function provideArrayVariables() {
		yield [ [ "a", "b", "c" ], '["a","b","c"]' ];
		yield [ [ "foo" => "bar", "0" => "c" ], '{"foo":"bar","0":"c"}' ];
		yield [ [ 1 => 'foo', 15 => 'bar' ], '{"1":"foo","15":"bar"}' ];
	}

	/**
	 * @dataProvider provideCityUrlToDomain
	 *
	 * @param string $cityUrl
	 * @param string $domain
	 */
	public function testCityUrlToDomain( $cityUrl, $domain ) {
		$this->assertEquals( $domain, WikiFactory::cityUrlToDomain( $cityUrl ) );
	}

	public function provideCityUrlToDomain() {
		yield [ 'http://gta.wikia.com', 'http://gta.wikia.com' ];
		yield [ 'http://gta.wikia.com/de', 'http://gta.wikia.com' ];
	}

	/**
	 * @dataProvider provideCityUrlToLanguagePath
	 *
	 * @param string $cityUrl
	 * @param string $languagePath
	 */
	public function testCityUrlToLanguagePath( $cityUrl, $languagePath ) {
		$this->assertEquals( $languagePath, WikiFactory::cityUrlToLanguagePath( $cityUrl ) );
	}

	public function provideCityUrlToLanguagePath() {
		yield [ 'http://gta.wikia.com', '' ];
		yield [ 'http://gta.wikia.com/de', '/de' ];
	}

	/**
	 * @dataProvider provideCityUrlToWgScript
	 *
	 * @param string $cityUrl
	 * @param string $wgScript
	 */
	public function testCityUrlToWgScript( $cityUrl, $wgScript ) {
		$this->assertEquals( $wgScript, WikiFactory::cityUrlToWgScript( $cityUrl ) );
	}

	public function provideCityUrlToWgScript() {
		yield [ 'http://gta.wikia.com', '/index.php' ];
		yield [ 'http://gta.wikia.com/de', '/de/index.php' ];
	}

	/**
	 * @dataProvider provideCityIDToUrl
	 *
	 * @param $environment
	 * @param string $cityUrl url stored in database
	 * @param string $expected expected result of the WikiFactory::cityIDtoUrl method
	 */
	public function testCityIDToUrl( $environment, $cityUrl, $expected ) {
		$this->mockStaticMethod( WikiFactory::class, 'getWikiById', (object)[ 'city_url' => $cityUrl ] );
		$this->mockEnvironment( $environment );
		$this->assertEquals( $expected, WikiFactory::cityIDtoUrl( 0 ) );
	}

	public function provideCityIDToUrl() {
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com', 'http://gta.wikia.com' ];
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/', 'http://gta.wikia.com' ]; // trims the trailing slash
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/de', 'http://gta.wikia.com/de' ];
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/de/', 'http://gta.wikia.com/de' ];
		yield [ WIKIA_ENV_PREVIEW, 'http://gta.wikia.com/de', 'http://gta.preview.wikia.com/de' ];
		yield [ WIKIA_ENV_PREVIEW, 'http://gta.wikia.com/de/', 'http://gta.preview.wikia.com/de' ];
		yield [ WIKIA_ENV_DEV, 'http://gta.wikia.com/de', 'http://gta.mockdevname.wikia-dev.us/de' ];
		yield [ WIKIA_ENV_DEV, 'http://gta.wikia.com/de/', 'http://gta.mockdevname.wikia-dev.us/de' ];
	}

	/**
	 * Test for extracting $wgServer from city url stored in db
	 *
	 * @dataProvider provideCityIDtoDomain
	 *
	 * @param $environment
	 * @param string $cityUrl url stored in database
	 * @param string $expected expected result of the WikiFactory::cityIDtoUrl method
	 */
	public function testCityIDtoDomain( $environment, $cityUrl, $expected ) {
		$this->mockStaticMethod( WikiFactory::class, 'getWikiById', (object)[ 'city_url' => $cityUrl ] );
		$this->mockEnvironment( $environment );
		$this->assertEquals( $expected, WikiFactory::cityIDtoDomain( 0 ) );
	}

	public function provideCityIDtoDomain() {
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com', 'http://gta.wikia.com' ];
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/', 'http://gta.wikia.com' ]; // trims the trailing slash
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/de', 'http://gta.wikia.com' ];
		yield [ WIKIA_ENV_PROD, 'http://gta.wikia.com/de/', 'http://gta.wikia.com' ];
		yield [ WIKIA_ENV_PREVIEW, 'http://gta.wikia.com/de', 'http://gta.preview.wikia.com' ];
		yield [ WIKIA_ENV_PREVIEW, 'http://gta.wikia.com/de/', 'http://gta.preview.wikia.com' ];
		yield [ WIKIA_ENV_DEV, 'http://gta.wikia.com/de', 'http://gta.mockdevname.wikia-dev.us' ];
		yield [ WIKIA_ENV_DEV, 'http://gta.wikia.com/de/', 'http://gta.mockdevname.wikia-dev.us' ];
	}

}
