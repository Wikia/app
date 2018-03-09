<?php

/**
 * @group Integration
 */
class WikiFactoryLoaderIntegrationTest extends WikiaDatabaseTest {

	protected function setUp() {
		parent::setUp();

		WikiFactory::isUsed( false );
	}

	/**
	 * @dataProvider provideRequestDataForExistingWikis
	 *
	 * @param int $expectedCityId
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testWikiLoadedWhenDomainExists(
		int $expectedCityId, array $server, array $requestParams
	) {
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams );
		$cityId = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $cityId );
		$this->assertTrue( WikiFactory::isUsed() );
	}

	public function provideRequestDataForExistingWikis() {
		yield [ 1, [ 'SERVER_NAME' => 'test1.wikia.com' ], [] ];
		yield [ 1, [ 'SERVER_NAME' => 'test1.wikia.com' ], [ 'langpath' => 'en' ] ];
		yield [ 2, [ 'SERVER_NAME' => 'test1.wikia.com' ], [ 'langpath' => 'de' ] ];
		yield [ 8, [ 'SERVER_NAME' => 'poznan.wikia.com' ], [] ];
		yield [ 8, [ 'SERVER_NAME' => 'poznan.wikia.com' ], [ 'langpath' => 'en' ] ];
		yield [ 9, [ 'SERVER_NAME' => 'poznan.wikia.com' ], [ 'langpath' => 'pl' ] ];
	}

	/**
	 * @dataProvider provideEnvironmentDataForExistingWiki
	 *
	 * @param int $expectedCityId
	 * @param array $env
	 */
	public function testLoadExistingWikiFromEnvironmentServerIdOrDbName( int $expectedCityId, array $env ) {
		$requestParams = [];
		$getParams = [];
		$wikiFactoryLoader = new WikiFactoryLoader( [], $requestParams, $getParams, $env );
		$cityId = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $cityId );
		$this->assertTrue( WikiFactory::isUsed() );
	}

	public function provideEnvironmentDataForExistingWiki() {
		yield [ 1, [ 'SERVER_ID' => 1 ] ];
		yield [ 1, [ 'SERVER_DBNAME' => 'test1' ] ];
	}

	/**
	 * @dataProvider provideRequestWithAlternativeDomain
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param string $expectedRedirect
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testRedirectsToPrimaryDomainWhenAlternativeDomainUsed(
		string $expectedRedirect, array $server, array $requestParams
	) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams, [], [ 'wikicities.com' ] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: NotPrimary', $headers );
		$this->assertContains( "Location: $expectedRedirect", $headers );
		$this->assertEquals( 301, http_response_code() );
	}

	public function provideRequestWithAlternativeDomain() {
		yield [ 'http://test1.wikia.com/', [ 'SERVER_NAME' => 'test1.wikicities.com' ], [] ];
		yield [ 'http://test1.wikia.com/de/', [ 'SERVER_NAME' => 'einetest.wikia.com' ], [] ];
		yield [ 'http://test1.wikia.com/de/', [ 'SERVER_NAME' => 'test1.wikicities.com' ], [ 'langpath' => 'de' ] ];
		yield [ 'http://poznan.wikia.com/pl/', [ 'SERVER_NAME' => 'poznan.wikicities.com' ], [ 'langpath' => 'pl' ] ];
		yield [ 'http://poznan.wikia.com/', [ 'SERVER_NAME' => 'poznan.wikicities.com' ], [ 'langpath' => 'en' ] ];
		yield [ 'http://poznan.wikia.com/', [ 'SERVER_NAME' => 'poznan.wikicities.com' ], [] ];
	}

	/**
	 * @dataProvider provideNotExistingWikisRequests
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testRedirectsToNotValidPageWhenNoEntryForDomain(
		array $server, array $requestParams
	) {
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: NotAValidWikia', $headers );
	}

	public function provideNotExistingWikisRequests() {
		yield [ [ 'SERVER_NAME' => 'badwiki.wikia.com' ], [] ];
		yield [ [ 'SERVER_NAME' => 'poznan.wikia.com' ], [ 'langpath' => 'de' ] ];
		yield [ [ 'SERVER_NAME' => 'zgubieni.wikia.com' ], [] ];
		yield [ [ 'SERVER_NAME' => 'zgubieni.wikia.com' ], [ 'langpath' => 'en' ] ];
	}

	/**
	 * @dataProvider provideWikisMarkedForClosing
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsMarkedForClosing(
		array $server, array $requestParams
	) {
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: MarkedForClosing', $headers );
	}
	
	public function provideWikisMarkedForClosing() {
		yield [ [ 'SERVER_NAME' => 'zamkniete.wikia.com' ], [ 'langpath' => 'pl' ] ];
		yield [ [ 'SERVER_NAME' => 'spamtest.wikia.com' ], [] ];
		yield [ [ 'SERVER_NAME' => 'spamtest.wikia.com' ], [ 'langpath' => 'en' ] ];
	}

	/**
	 * @dataProvider provideDisabledWikis
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsDisabled( array $server, array $requestParams ) {
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: Dump', $headers );
	}

	public function provideDisabledWikis() {
		yield [ [ 'SERVER_NAME' => 'rekt.wikia.com' ], [] ];
		yield [ [ 'SERVER_NAME' => 'rekt.wikia.com' ], [ 'langpath' => 'en' ] ];
		yield [ [ 'SERVER_NAME' => 'dead.wikia.com' ], [] ];
		yield [ [ 'SERVER_NAME' => 'dead.wikia.com' ], [ 'langpath' => 'en' ] ];
		yield [ [ 'SERVER_NAME' => 'umarła.wikia.com' ], [ 'langpath' => 'pl' ] ];
	}

	/**
	 * @dataProvider provideRedirectWikiRequests
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param string $expectedRedirectUrl
	 * @param array $server
	 * @param array $requestParams
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsFunctioningAsARedirect(
		string $expectedRedirectUrl, array $server, array $requestParams
	) {
		$getParams = $requestParams;
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: 2', $headers );
		$this->assertContains( "Location: $expectedRedirectUrl", $headers );
		$this->assertEquals( 301, http_response_code() );
	}

	public function provideRedirectWikiRequests() {
		yield [ 'http://redirect-target.wikia.com/', [ 'SERVER_NAME' => 'redirect.wikia.com' ], [] ];
		yield [ 'http://redirect-target.wikia.com/', [ 'SERVER_NAME' => 'redirect2.wikia.com' ], [ 'langpath' => 'en' ] ];
		yield [ 'http://redirect-target.wikia.com/pl/', [ 'SERVER_NAME' => 'redirect.wikia.com' ], [ 'langpath' => 'pl' ] ];
		yield [ 'http://redirect-target.wikia.com/pl/', [ 'SERVER_NAME' => 'dawaj.wikia.com' ], [] ];
	}

	/**
	 * @dataProvider provideNotExistingWikisEnvironmentOrDbName
	 * @param array $env
	 */
	public function testWikiIdZeroWhenIdDbNameProvidedAndWikiDoesNotExist( array $env ) {
		$requestParams = [];
		$getParams = [];
		$wikiFactoryLoader = new WikiFactoryLoader( [], $requestParams, $getParams, $env );
		$result = $wikiFactoryLoader->execute();

		$this->assertEquals( 0, $result );
	}

	public function provideNotExistingWikisEnvironmentOrDbName() {
		yield [ [ 'SERVER_ID' => 930 ] ];
		yield [ [ 'SERVER_DBNAME' => 'baz' ] ];
	}

	/**
	 * @dataProvider provideDisabledMarkedForCloseOrRedirectWikisIdDbName
	 *
	 * @param $expectedCityId
	 * @param array $env
	 */
	public function testWikiIdLoadedWhenIdDbNameProvidedAndWikiIsMarkedForClosingIsDisabledOrIsRedirect(
		int $expectedCityId, array $env
	) {
		$requestParams = [];
		$getParams = [];
		$wikiFactoryLoader = new WikiFactoryLoader( [], $requestParams, $getParams, $env );
		$result = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $result );
	}

	public function provideDisabledMarkedForCloseOrRedirectWikisIdDbName() {
		yield [ 4, [ 'SERVER_ID' => 4 ] ];
		yield [ 4, [ 'SERVER_DBNAME' => 'spamtest' ] ];
		yield [ 5, [ 'SERVER_ID' => 5 ] ];
		yield [ 6, [ 'SERVER_DBNAME' => 'dead' ] ];
		yield [ 7, [ 'SERVER_ID' => 7 ] ];
		yield [ 7, [ 'SERVER_DBNAME' => 'redirect' ] ];
	}

	/**
	 * @dataProvider providePrecedence
	 *
	 * @param int $expectedCityId
	 * @param array $env
	 * @param array $server
	 */
	public function testRequestInfoOverridesServerIdOverridesDbName( int $expectedCityId, array $env, array $server ) {
		$requestParams = [];
		$getParams = [];
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $requestParams, $getParams, $env );
		$result = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $result );
	}

	public function providePrecedence() {
		yield 'Request info takes precedence over SERVER_ID' => [ 8, [ 'SERVER_ID' => 1 ], [ 'SERVER_NAME' => 'poznan.wikia.com' ] ];
		yield 'Request info takes precedence over SERVER_DBNAME' => [ 8, [ 'SERVER_DBNAME' => 'test1' ], [ 'SERVER_NAME' => 'poznan.wikia.com' ] ];
		yield 'SERVER_ID takes precedence over SERVER_DBNAME' => [ 1, [ 'SERVER_ID' => 1, 'SERVER_DBNAME' => 'poznan' ], [] ];
	}

	public function testExceptionThrownWhenNoDataProvided() {
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( "Cannot tell which wiki it is (neither SERVER_NAME, SERVER_ID nor SERVER_DBNAME is defined)" );

		new WikiFactoryLoader( [] );
	}

	public function testLangPathIsRemovedFromParams() {
		$requestParams = [ 'langpath' => 'pl' ];
		$getParams = [ 'langpath' => 'pl' ];
		new WikiFactoryLoader( [ 'SERVER_NAME' => 'poznan.wikia.com' ], $requestParams, $getParams, [ 'SERVER_ID' => 1 ] );
		$this->assertArrayNotHasKey( 'langpath', $requestParams );
		$this->assertArrayNotHasKey( 'langpath', $getParams );
	}

	protected function tearDown() {
		parent::tearDown();

		WikiFactory::isUsed( true );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/wiki_factory_loader.yaml' );
	}
}
