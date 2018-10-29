<?php

/**
 * @group Integration
 */
class WikiFactoryLoaderIntegrationTest extends WikiaDatabaseTest {

	/** @var string $dbName */
	private $dbName;

	protected function setUp() {
		parent::setUp();

		WikiFactory::isUsed( false );
		$GLOBALS['wgExtensionFunctions'] = [];
		$this->dbName = $GLOBALS['wgDBname'];
	}

	/**
	 * @dataProvider provideRequestDataForExistingWikis
	 *
	 * @param int $expectedCityId
	 * @param array $server
	 */
	public function testWikiLoadedWhenDomainExists(
		int $expectedCityId, array $server
	) {
		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$cityId = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $cityId );
		$this->assertTrue( WikiFactory::isUsed() );
	}

	public function provideRequestDataForExistingWikis() {
		yield [ 1, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => '/wiki/Test',
		] ];
		yield [ 2, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => '/de/wiki/Bar',
		] ];
		yield [ 8, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/en/wiki/Stary_Rynek',
		] ];
		yield [ 9, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/wiki/Strona_główna',
		] ];
		yield [ 9, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/',
		] ];
		// Test cases for PHP bug: https://bugs.php.net/bug.php?id=71646
		yield [ 1, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => '/wiki/Thread:24',
		] ];
		yield [ 2, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => '/de/wiki/Thread:24',
		] ];
		yield [ 8, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/en/wiki/Thread:24',
		] ];
		yield [ 2, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => 'http://test1.wikia.com/de/wiki/Bar',
		] ];
		yield [ 9, [
			'HTTP_X_MW_WIKI_ID' => '9',  // this header takes precedence
			'SERVER_NAME' => 'test1.wikia.com',
		] ];
	}

	/**
	 * @dataProvider provideEnvironmentDataForExistingWiki
	 *
	 * @param int $expectedCityId
	 * @param array $env
	 */
	public function testLoadExistingWikiFromEnvironmentServerIdOrDbName( int $expectedCityId, array $env ) {
		$wikiFactoryLoader = new WikiFactoryLoader( [], $env );
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
	 */
	public function testRedirectsToPrimaryDomainWhenAlternativeDomainUsed(
		string $expectedRedirect, array $server
	) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );

		$wikiFactoryLoader = new WikiFactoryLoader( $server, [], [ 'wikicities.com' ] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: NotPrimary', $headers );
		$this->assertContains( "Location: $expectedRedirect", $headers );
		$this->assertEquals( 301, http_response_code() );
	}

	public function provideRequestWithAlternativeDomain() {
		yield [ 'http://test1.wikia.com/wiki/Foo', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikicities.com',
			'REQUEST_URI' => '/wiki/Foo',
		] ];
		yield [ 'http://test1.wikia.com/de/wiki/Bar', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'einetest.wikia.com',
			'REQUEST_URI' => '/wiki/Bar',
		] ];
		yield [ 'http://test1.wikia.com/de/wiki/Bar', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'einetest.wikia.com',
			'REQUEST_URI' => '/wiki/Bar',
		] ];
		yield [ 'http://test1.wikia.com/wiki/Test', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'test1.wikia.com',
			'REQUEST_URI' => '/en/wiki/Test',
		] ];
		yield [ 'http://poznan.wikia.com/wiki/Strona_główna', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/pl/wiki/Strona_główna',
		] ];
		yield [ 'http://poznan.wikia.com/', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/pl',
		] ];
		yield [ 'http://poznan.wikia.com/', [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/pl/',
		] ];
	}

	/**
	 * @dataProvider provideNotExistingWikisRequests
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 */
	public function testRedirectsToNotValidPageWhenNoEntryForDomain(
		array $server
	) {
		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: NotAValidWikia', $headers );
	}

	public function provideNotExistingWikisRequests() {
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'badwiki.wikia.com',
			'REQUEST_URI' => '/wiki/Foo',
		], [] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/de/wiki/Posen',
		], [] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'zgubieni.wikia.com',
			'REQUEST_URI' => '/en/wiki/London',
		], [] ];
	}

	/**
	 * @dataProvider provideWikisMarkedForClosing
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsMarkedForClosing( array $server ) {
		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: MarkedForClosing', $headers );
	}

	public function provideWikisMarkedForClosing() {
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'zamkniete.wikia.com',
			'REQUEST_URI' => '/api.php',
		] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'spamtest.wikia.com',
			'REQUEST_URI' => '/wiki/Foo',
		] ];
	}

	/**
	 * @dataProvider provideDisabledWikis
	 *
	 * @param array $server
	 */
	public function testRegistersClosedWikiHandlerWhenWikiIsDisabled( int $expectedCityId, array $server ) {
		$this->mockGlobalVariable( 'wgCommandLineMode', false );

		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$result = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $result );
		$this->assertInstanceOf( true, $GLOBALS['wgIncludeClosedWikiHandler'] );
	}

	public function provideDisabledWikis() {
		yield [ 5, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'rekt.wikia.com',
			'REQUEST_URI' => '/wiki/No_page',
		] ];
		yield [ 6, [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'dead.wikia.com',
			'REQUEST_URI' => '/wiki/Special:Version',
		] ];
	}

	/**
	 * @dataProvider provideRedirectWikiRequests
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsFunctioningAsARedirect( array $server ) {
		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: 2', $headers );
		$this->assertContains( 'Location: http://redirect-target.wikia.com/', $headers );
		$this->assertEquals( 301, http_response_code() );
	}

	public function provideRedirectWikiRequests() {
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'redirect.wikia.com',
			'REQUEST_URI' => '/wiki/Test_redirect',
		] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'redirect2.wikia.com',
			'REQUEST_URI' => '/wikia.php',
		] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'redirect.wikia.com',
			'REQUEST_URI' => '/en/wiki/Test_redirect',
		] ];
		yield [ [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'redirect2.wikia.com',
			'REQUEST_URI' => '/en/wikia.php',
		] ];
	}

	/**
	 * @dataProvider provideNotExistingWikisEnvironmentOrDbName
	 * @param array $env
	 */
	public function testWikiIdZeroWhenIdDbNameProvidedAndWikiDoesNotExist( array $env ) {
		$wikiFactoryLoader = new WikiFactoryLoader( [], $env );
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
		$wikiFactoryLoader = new WikiFactoryLoader( [], $env );
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
		$wikiFactoryLoader = new WikiFactoryLoader( $server, $env );
		$result = $wikiFactoryLoader->execute();

		$this->assertEquals( $expectedCityId, $result );
	}

	public function providePrecedence() {
		yield 'Request info takes precedence over SERVER_ID' => [ 9, [ 'SERVER_ID' => 1 ], [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/',
		] ];
		yield 'Request info takes precedence over SERVER_DBNAME' => [ 9, [ 'SERVER_DBNAME' => 'test1' ], [
			'REQUEST_SCHEME' => 'http',
			'SERVER_NAME' => 'poznan.wikia.com',
			'REQUEST_URI' => '/',
		] ];
		yield 'SERVER_ID takes precedence over SERVER_DBNAME' => [ 1, [ 'SERVER_ID' => 1, 'SERVER_DBNAME' => 'poznan' ], [] ];
	}

	public function testExceptionThrownWhenNoDataProvided() {
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( "Cannot tell which wiki it is (neither SERVER_NAME, SERVER_ID nor SERVER_DBNAME is defined)" );

		new WikiFactoryLoader( [], [] );
	}

	protected function tearDown() {
		parent::tearDown();

		WikiFactory::isUsed( true );
		LBFactory::destroyInstance();
		$GLOBALS['wgDBname'] = $this->dbName;
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/wiki_factory_loader.yaml' );
	}
}
