<?php
class MercuryApiModelTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * Setup global variables used to generate Ads context
	 */
	private function setupGlobals() {
		$this->mockGlobalVariable('wgLoadAdsInHead', true);
		$this->mockGlobalVariable('wgAdDriverEnableRemnantGptMobile', true);
		$this->mockGlobalVariable('wgAdDriverSevenOneMediaOverrideSub2Site', true);
		$this->mockGlobalVariable('wgAdDriverTrackState', true);
		$this->mockGlobalVariable('wgAdEngineDisableLateQueue', true);
		$this->mockGlobalVariable('wgLoadLateAdsAfterPageLoad', true);
		$this->mockGlobalVariable('wgEnableWikiaHubsV3Ext', true);
		$this->mockGlobalVariable('wgWikiDirectedAtChildren', true);
		$this->mockGlobalVariable('wgAdDriverUseSevenOneMedia', false);
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);
		$this->mockGlobalVariable('wgCityId', 3355); // recipes
		$this->mockGlobalVariable('wgDBname', 'mydbname');
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'a=b;c=d');
		$this->mockGlobalVariable('wgAdPageLevelCategoryLangs', ['en']);

	}

	/**
	 * Test getAdsContext
	 *
	 * @covers MercuryApi::getAdsContext
	 */
	public function testGetAdsContext() {
		$this->setupGlobals();
		$mercuryApi = new MercuryApi();

		$language = $this->getMock( 'Language' );
		$language->method( 'getCode' )
			->willReturn( 'en' );

		$title = $this->getMock( 'Title' );
		$title->method( 'getPageLanguage' )
			->willReturn( $language );
		$title->method( 'getArticleId' )
			->willReturn( 10 );
		$title->method( 'getPrefixedDbKey' )
			->willReturn( 'articledbkey' );

		$expected = [
			'opts' => [
				'adsInHead' => true,
				'adsInContent' => true,
				'disableLateQueue' => true,
				'enableAdsInMaps' => true,
				'lateAdsAfterPageLoad' => true,
				'pageType' => 'corporate',
				'showAds' => true,
				'trackSlotState' => true,
			],
			'targeting' => [
				'enableKruxTargeting' => true,
				'enablePageCategories' => true,
				'pageArticleId' => 10,
				'pageIsArticle' => true,
				'pageIsHub' => true,
				'pageName' => 'articledbkey',
				'pageType' => 'article',
				'sevenOneMediaSub2Site' => true,
				'skin' => 'mercury',
				'wikiCategory' => 'life',
				'wikiCustomKeyValues' => 'a=b;c=d',
				'wikiDbName' => 'mydbname',
				'wikiDirectedAtChildren' => true,
				'wikiIsCorporate' => true,
				'wikiLanguage' => 'en',
				'wikiVertical' => 'Lifestyle',
			],
			'providers' => [
				'remnantGptMobile' => true,
			],
			'slots' => [
			],
			'forceProviders' => [
			],
		];
		$result = $mercuryApi->getAdsContext( $title );
		$this->assertEquals( $expected, $result );
	}

	/**
	 * @dataProvider getSitenameDataProvider
	 */
	public function testGetSiteName( $expected, $isDisabled, $textMock, $wgSitenameMock ) {
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( [ 'inContentLanguage', 'isDisabled', 'text' ] )
			->getMock();

		$messageMock->expects( $this->once() )
			->method( 'isDisabled' )
			->willReturn( $isDisabled );

		$messageMock->expects( $this->any() )
			->method( 'text' )
			->willReturn( $textMock );

		$messageMock->expects( $this->once() )
			->method( 'inContentLanguage' )
			->willReturn( $messageMock );

		$this->mockGlobalVariable( 'wgSitename', $wgSitenameMock );
		$this->mockGlobalFunction( 'wfMessage', $messageMock );

		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getSitename() );
	}

	public function getSiteNameDataProvider() {
		return [
			[
				'$expected' => 'Test Wiki',
				'$isDisabled' => false,
				'$textMock' => 'Test Wiki',
				'$wgSitenameMock' => 'A test wikia'
			],
			[
				'$expected' => 'A test wikia',
				'$isDisabled' => true,
				'$textMock' => 'Test Wiki',
				'$wgSitenameMock' => 'A test wikia'
			]
		];
	}

	/**
	 * @dataProvider getResourceTypeDataProvider
	 */
	public function testGetResourceType( $uri, $articlePath, $expected ) {
		$this->mockGlobalVariable( 'wgArticlePath', $articlePath );
		$this->mockGlobalVariable( 'wgContentNamespaces', [ '0' ] );

		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getResourceType( $uri ) );
	}

	public function getResourceTypeDataProvider() {
		$mainPageTitle = Title::newMainPage()->getPrefixedDBkey();

		return [
			// wiki/Title
			[
				'$uri' => 'wiki/Title',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			[
				'$uri' => 'wiki/Title',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			// /wiki/Title
			[
				'$uri' => '/wiki/Title',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			[
				'$uri' => '/wiki/Title',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			// Title
			[
				'$uri' => 'Title',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			[
				'$uri' => 'Title',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Title'
				]
			],
			// /Title
			[
				'$uri' => '/Title',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Title'
				]
			],
			[
				'$uri' => '/Title',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Title'
				]
			],
			// /wiki
			[
				'$uri' => '/wiki',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => null
				]
			],
			[
				'$uri' => '/wiki',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/wiki'
				]
			],
			// wiki
			[
				'$uri' => 'wiki',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => null
				]
			],
			[
				'$uri' => 'wiki',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'Wiki'
				]
			],
			// wiki/
			[
				'$uri' => 'wiki/',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => $mainPageTitle
				]
			],
			[
				'$uri' => 'wiki/',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => $mainPageTitle
				]
			],
			// /wiki/
			[
				'$uri' => '/wiki/',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => $mainPageTitle
				]
			],
			[
				'$uri' => '/wiki/',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => $mainPageTitle
				]
			],
			// WIKI
			[
				'$uri' => 'WIKI',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => null
				]
			],
			[
				'$uri' => 'WIKI',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'WIKI'
				]
			],
			// WIKI/
			[
				'$uri' => 'WIKI/',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => null
				]
			],
			[
				'$uri' => 'WIKI/',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => 'WIKI/'
				]
			],
			// /WIKI/
			[
				'$uri' => '/WIKI/',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => null
				]
			],
			[
				'$uri' => '/WIKI/',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/WIKI/'
				]
			],
			// wiki/Special:UserLogin
			[
				'$uri' => 'wiki/Special:UserLogin',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			[
				'$uri' => 'wiki/Special:UserLogin',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			// /wiki/Special:UserLogin
			[
				'$uri' => '/wiki/Special:UserLogin',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			[
				'$uri' => '/wiki/Special:UserLogin',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			// /wiki//Special:UserLogin
			[
				'$uri' => '/wiki//Special:UserLogin',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Special:UserLogin'
				]
			],
			[
				'$uri' => '/wiki//Special:UserLogin',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Special:UserLogin'
				]
			],
			// Special:UserLogin
			[
				'$uri' => 'Special:UserLogin',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			[
				'$uri' => 'Special:UserLogin',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => false,
					'title' => 'Special:UserLogin'
				]
			],
			// /Special:UserLogin
			[
				'$uri' => '/Special:UserLogin',
				'$articlePath' => '/wiki/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Special:UserLogin'
				]
			],
			[
				'$uri' => '/Special:UserLogin',
				'$articlePath' => '/$1',
				'$expected' => [
					'isArticle' => true,
					'title' => '/Special:UserLogin'
				]
			],
		];
	}
}
