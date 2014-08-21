<?php
class GlobalNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../GlobalNavigation.setup.php';
		parent::setUp();
	}

	/**
	 * @param $lang
	 * @param $expectedUrl
	 * @param $appendLocalUrl
	 * @dataProvider testGetCentralUrlDataProvider
	 */
	public function testGetCentralUrl( $lang, $expectedUrl, $appendLocalUrl ) {
		$languageMock = $this->getMock( 'Language', ['getCode'] );
		$languageMock->expects( $this->any() )
			->method( 'getCode' )
			->will( $this->returnValue( $lang ) );

		$globalNavigation = new GlobalNavigationController();
		$result = $globalNavigation->getCentralUrl( $lang , $appendLocalUrl );
		$this->assertEquals( $expectedUrl, $result, 'Wiki Central url is different than expected' );
	}

	public function testGetCentralUrlDataProvider() {
		return [
			['en', 'http://www.wikia.com', false],
			['en', 'http://www.wikia.com/Wikia', true],
			['de', 'http://de.wikia.com/wiki/Wikia', false],
			['de', 'http://de.wikia.com/wiki/Wikia', true],
			['zh', 'http://www.wikia.com?uselang=zh', false],
			['zh', 'http://www.wikia.com/Wikia?uselang=zh', true]
		];
	}

	/**
	 * @param $lang
	 * @param $expectedSuffix
	 * @dataProvider testGetCreateNewWikiUrlDataProvider
	 */
	public function testGetCreateNewWikiUrl( $lang, $expectedSuffix ) {
		$languageMock = $this->getMock( 'Language', ['getCode'] );
		$languageMock->expects( $this->any() )
			->method( 'getCode' )
			->will( $this->returnValue( $lang ) );

		$globalNavigation = new GlobalNavigationController();
		$result = $globalNavigation->getCreateNewWikiUrl( $lang );
		$this->assertStringEndsWith( $expectedSuffix, $result, 'Create New Wiki URL is different than expected' );
	}

	public function testGetCreateNewWikiUrlDataProvider() {
		return [
			['en', 'Special:CreateNewWiki'],
			['de', 'Special:CreateNewWiki?uselang=de'],
			['zh', 'Special:CreateNewWiki?uselang=zh'],
		];
	}
}
