<?php
class GlobalNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../GlobalNavigation.setup.php';
		parent::setUp();
	}

	/**
	 * @param $lang
	 * @param $fullUrl
	 * @param $expectedUrl
	 * @dataProvider testGetCentralFullUrlDataProvider
	 */
	public function testGetCentralFullUrl( $lang, $fullUrl, $expectedUrl ) {
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getFullURL'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getFullURL' )
			->will( $this->returnValue( $fullUrl ) );

		$globalNavMock = $this->getMock( 'GlobalNavigationController', ['getGlobalTitleForLang'] );
		$globalNavMock->expects( $this->any() )
			->method( 'getGlobalTitleForLang' )->will( $this->returnValue( $globalTitleMock ) );

		$result = $globalNavMock->getCentralUrlForLang( $lang , true );
		$this->assertEquals( $expectedUrl, $result, 'Wiki Central full url is different than expected' );
	}

	public function testGetCentralFullUrlDataProvider() {
		return [
			['en', 'http://www.wikia.com/Wikia', 'http://www.wikia.com/Wikia'],
			['zh', 'http://www.wikia.com/Wikia', 'http://www.wikia.com/Wikia?uselang=zh'],
			['de', 'http://de.wikia.com/Wikia', 'http://de.wikia.com/Wikia'],
		];
	}

	/**
	 * @param $lang
	 * @param $expectedUrl
	 * @dataProvider testGetCentralServerUrlDataProvider
	 */
	public function testGetCentralServerUrl( $lang, $expectedUrl ) {
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( $expectedUrl ) );

		$globalNavMock = $this->getMock( 'GlobalNavigationController', ['getGlobalTitleForLang'] );
		$globalNavMock->expects( $this->any() )
			->method( 'getGlobalTitleForLang' )->will( $this->returnValue( $globalTitleMock ) );

		$result = $globalNavMock->getCentralUrlForLang( $lang , false );
		$this->assertEquals( $expectedUrl, $result, 'Wiki Central server url is different than expected' );
	}

	public function testGetCentralServerUrlDataProvider() {
		return [
			['en', 'http://www.wikia.com'],
			['zh', 'http://www.wikia.com'],
			['de', 'http://de.wikia.com'],
		];
	}

	/**
	 * @param $lang
	 * @param $centralUrl
	 * @param $searchLocalUrl
	 * @param $expectedUrl
	 * @dataProvider testGetGlobalSearchUrlDataProvider
	 */
	public function testGetGlobalSearchUrl( $lang, $centralUrl, $searchLocalUrl, $expectedUrl ) {
		$globalNavMock = $this->getMock( 'GlobalNavigationController', ['getTitleForSearch'] );
		$globalNavMock->expects( $this->any() )
			->method( 'getTitleForSearch' )
			->will( $this->returnValue( $searchLocalUrl ) );

		$result = $globalNavMock->getGlobalSearchUrl( $centralUrl, $lang );
		$this->assertEquals( $expectedUrl, $result, 'Global Search url is different than expected' );
	}

	public function testGetGlobalSearchUrlDataProvider() {
		return [
			['en', 'http://www.wikia.com', '/wiki/Special:Search', 'http://www.wikia.com/wiki/Special:Search'],
			['zh', 'http://www.wikia.com', null, 'http://www.wikia.com/wiki/Special:Search'],
			['de', 'http://de.wikia.com', '/wiki/Spezial:Suche', 'http://de.wikia.com/wiki/Spezial:Suche'],
		];
	}

	/**
	 * @param $lang
	 * @param $expectedUrl
	 * @dataProvider testGetCreateNewWikiUrlDataProvider
	 */
	public function testGetCreateNewWikiUrl( $lang, $expectedUrl ) {
		$globalNavMock = $this->getMock( 'GlobalNavigationController', ['getCreateNewWikiFullUrl'] );
		$globalNavMock->expects( $this->any() )
			->method( 'getCreateNewWikiFullUrl' )
			->will( $this->returnValue( 'http://www.wikia.com/Special:CreateNewWiki' ) );

		$result = $globalNavMock->getCreateNewWikiUrl( $lang );
		$this->assertEquals( $expectedUrl, $result, 'Create New Wiki URL is different than expected' );
	}

	public function testGetCreateNewWikiUrlDataProvider() {
		return [
			['en', 'http://www.wikia.com/Special:CreateNewWiki'],
			['de', 'http://www.wikia.com/Special:CreateNewWiki?uselang=de'],
			['zh', 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh'],
		];
	}
}
