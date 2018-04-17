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
		yield [ 1, [ 'SERVER_NAME' => 'test1.wikia.com', 'REQUEST_URI' => 'http://test1.wikia.com/wiki/Test' ] ];
		yield [ 2, [ 'SERVER_NAME' => 'test1.wikia.com', 'REQUEST_URI' => 'http://test1.wikia.com/de/wiki/Bar' ] ];
		yield [ 8, [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/en/wiki/Stary_Rynek' ] ];
		yield [ 9, [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/wiki/Strona_główna' ] ];
		yield [ 9, [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/' ] ];
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
		yield [ 'http://test1.wikia.com/wiki/Foo', [ 'SERVER_NAME' => 'test1.wikicities.com', 'REQUEST_URI' => 'http://test1.wikicities.com/wiki/Foo' ] ];
		yield [ 'http://test1.wikia.com/de/wiki/Bar', [ 'SERVER_NAME' => 'einetest.wikia.com', 'REQUEST_URI' => 'http://einetest.wikia.com/wiki/Bar' ] ];
		yield [ 'http://test1.wikia.com/de/wiki/Bar', [ 'SERVER_NAME' => 'einetest.wikia.com', 'REQUEST_URI' => 'http://einetest.wikia.com/wiki/Bar' ] ];
		yield [ 'http://test1.wikia.com/wiki/Test', [ 'SERVER_NAME' => 'test1.wikia.com', 'REQUEST_URI' => 'http://test1.wikia.com/en/wiki/Test' ] ];
		yield [ 'http://poznan.wikia.com/wiki/Strona_główna', [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/pl/wiki/Strona_główna' ] ];
		yield [ 'http://poznan.wikia.com/', [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/pl' ] ];
		yield [ 'http://poznan.wikia.com/', [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/pl/' ] ];
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
		yield [ [ 'SERVER_NAME' => 'badwiki.wikia.com', 'REQUEST_URI' => 'http://badwiki.wikia.com/wiki/Foo' ], [] ];
		yield [ [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/de/wiki/Posen' ], [] ];
		yield [ [ 'SERVER_NAME' => 'zgubieni.wikia.com', 'REQUEST_URI' => 'http://zgubieni.wikia.com/en/wiki/London' ], [] ];
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
		yield [ [ 'SERVER_NAME' => 'zamkniete.wikia.com', 'REQUEST_URI' => 'http://zamkniete.wikia.com/api.php' ] ];
		yield [ [ 'SERVER_NAME' => 'spamtest.wikia.com', 'REQUEST_URI' => 'http://spamtest.wikia.com/wiki/Foo' ] ];
	}

	/**
	 * @dataProvider provideDisabledWikis
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 *
	 * @param array $server
	 */
	public function testReturnsFalseAndRedirectsWhenWikiIsDisabled( array $server ) {
		$wikiFactoryLoader = new WikiFactoryLoader( $server, [] );
		$result = $wikiFactoryLoader->execute();

		$headers = xdebug_get_headers();

		$this->assertFalse( $result );
		$this->assertContains( 'X-Redirected-By-WF: Dump', $headers );
	}

	public function provideDisabledWikis() {
		yield [ [ 'SERVER_NAME' => 'rekt.wikia.com', 'REQUEST_URI' => 'http://rekt.wikia.com/wiki/No_page' ] ];
		yield [ [ 'SERVER_NAME' => 'dead.wikia.com', 'REQUEST_URI' => 'http://dead.wikia.com/wiki/Special:Version' ] ];
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
		yield [ [ 'SERVER_NAME' => 'redirect.wikia.com', 'REQUEST_URI' => 'http://redirect.wikia.com/wiki/Test_redirect' ] ];
		yield [ [ 'SERVER_NAME' => 'redirect2.wikia.com', 'REQUEST_URI' => 'http://redirect2.wikia.com/wikia.php' ] ];
		yield [ [ 'SERVER_NAME' => 'redirect.wikia.com', 'REQUEST_URI' => 'http://redirect.wikia.com/en/wiki/Test_redirect' ] ];
		yield [ [ 'SERVER_NAME' => 'redirect2.wikia.com', 'REQUEST_URI' => 'http://redirect2.wikia.com/en/wikia.php' ] ];
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
		yield 'Request info takes precedence over SERVER_ID' => [ 9, [ 'SERVER_ID' => 1 ], [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI'	=> 'http://poznan.wikia.com/' ] ];
		yield 'Request info takes precedence over SERVER_DBNAME' => [ 9, [ 'SERVER_DBNAME' => 'test1' ], [ 'SERVER_NAME' => 'poznan.wikia.com', 'REQUEST_URI' => 'http://poznan.wikia.com/' ] ];
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
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/wiki_factory_loader.yaml' );
	}
}
