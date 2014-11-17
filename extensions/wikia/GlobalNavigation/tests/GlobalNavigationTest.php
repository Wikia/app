<?php
class GlobalNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../GlobalNavigation.setup.php';
		parent::setUp();
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

		$globalNavMock = $this->getMock( 'GlobalNavigationController', ['getCentralWikiTitleForLang'] );
		$globalNavMock->expects( $this->any() )
			->method( 'getCentralWikiTitleForLang' )->will( $this->returnValue( $globalTitleMock ) );

		$result = $globalNavMock->getCentralUrlForLang( $lang );
		$this->assertEquals( $expectedUrl, $result, 'Wiki Central server url is different than expected' );
	}

	public function testGetCentralServerUrlDataProvider() {
		return [
			['de', 'http://de.wikia.com'],
			['en', 'http://www.wikia.com'],
			['it', 'http://www.wikia.com'],
			['zh', 'http://www.wikia.com'],
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
			['de', 'http://de.wikia.com', '/wiki/Spezial:Suche', 'http://de.wikia.com/wiki/Spezial:Suche'],
			['en', 'http://www.wikia.com', '/wiki/Special:Search', 'http://www.wikia.com/wiki/Special:Search'],
			['it', 'http://www.wikia.com', null, 'http://www.wikia.com/wiki/Special:Search'],
			['zh', 'http://www.wikia.com', null, 'http://www.wikia.com/wiki/Special:Search'],
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
			['de', 'http://www.wikia.com/Special:CreateNewWiki?uselang=de'],
			['en', 'http://www.wikia.com/Special:CreateNewWiki'],
			['it', 'http://www.wikia.com/Special:CreateNewWiki?uselang=it'],
			['zh', 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh'],
		];
	}
}
