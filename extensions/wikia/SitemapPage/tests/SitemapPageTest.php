<?php

class SitemapPageTest extends WikiaBaseTest {

	const TEST_CITY_ID = 79860;
	const TEST_ARTICLE = 'test 123';
	const TEST_ARTICLE_SITEMAP = 'sitemap';

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ).'/../SitemapPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getLimitPerPageDataProvider
	 */
	public function testGetLimitPerPage( $totalWikis, $exp ) {
		$mock = $this->getMock( 'SitemapPageModel', [ 'getTotalWikis' ] );
		$mock->expects( $this->any() )
			->method( 'getTotalWikis' )
			->will( $this->returnValue( $totalWikis ) );
		$limit = $mock->getLimitPerPage();
		$this->assertEquals( $exp, $limit );
	}

	public function getLimitPerPageDataProvider() {
		return [
			[ 0, 100 ],
			[ '100', 100 ],
			[ 999999, 100 ],
			[ '1000000', 100 ],
			[ '1000001', 150 ]
		];
	}

	/**
	 * @dataProvider getLimitPerListDataProvider
	 */
	public function testGetLimitPerList( $level, $exp ) {
		$limitPerPage = 100;
		$mock = $this->getMock( 'SitemapPageModel', [ 'getLimitPerPage' ] );
		$mock->expects( $this->any() )
			->method( 'getLimitPerPage' )
			->will( $this->returnValue( $limitPerPage ) );
		$limit = $mock->getLimitPerList( $level );
		$this->assertEquals( $exp, $limit );
	}

	public function getLimitPerListDataProvider() {
		return [
			[ 1, 10000 ],
			[ 2, 100 ],
			[ 3, 1 ],
			[ 7, 1 ],
			[ 0, 1 ],
			[ -1, 1 ]
		];
	}

	/**
	 * @dataProvider isSitemapPageDataProvider
	 */
	public function testIsSitemapPage( $enableHomePage, $articleName, $exp ) {
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', $enableHomePage );
		$title = Title::newFromText( $articleName );
		$sitemap = new SitemapPageModel();
		$isSitemapPage = $sitemap->isSitemapPage( $title );
		$this->assertEquals( $exp, $isSitemapPage );
	}

	public function isSitemapPageDataProvider() {
		return [
			[ false, self::TEST_ARTICLE, false ],
			[ false, self::TEST_ARTICLE_SITEMAP, false ],
			[ true, self::TEST_ARTICLE, false ],
			[ true, self::TEST_ARTICLE_SITEMAP, true ]
		];
	}

	/**
	 * @dataProvider getVerticalNameDataProvider
	 */
	public function testGetVerticalName( $verticals, $exp ) {
		$verticalId = 1;
		$mock = $this->getMock( 'SitemapPageModel', [ 'getVerticals' ] );
		$mock->expects( $this->any() )
			->method( 'getVerticals' )
			->will( $this->returnValue( $verticals ) );
		$name = $mock->getVerticalName( $verticalId );
		$this->assertEquals( $exp, $name );
	}

	public function getVerticalNameDataProvider() {
		$expUnknown = 'Unknown';
		$verticals1[0] = [ 'id' => '0', 'name' => 'Other' ];
		$verticals2[1] = [ 'id' => '1' ];
		$verticals3[1] = [ 'id' => '1', 'name' => 'TV' ];
		return [
			[ null, $expUnknown ],
			[ $verticals1, $expUnknown ],
			[ $verticals2, $expUnknown ],
			[ $verticals3, 'TV' ],
		];
	}

}
