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
		$this->mockGlobalVariable('wgAdEngineDisableLateQueue', true);
		$this->mockGlobalVariable('wgLoadLateAdsAfterPageLoad', true);
		$this->mockGlobalVariable('wgAdDriverTrackState', true);
		$this->mockGlobalVariable('wgEnableWikiaHubsV3Ext', true);
		$this->mockGlobalVariable('wgAdDriverSevenOneMediaOverrideSub2Site', true);
		$this->mockGlobalVariable('wgWikiDirectedAtChildren', true);
		$this->mockGlobalVariable('wgAdDriverUseSevenOneMedia', false);
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);
		$this->mockGlobalVariable('wgCityId', 3355); // recipes
		$this->mockGlobalVariable('wgDBname', 'mydbname');
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'a=b;c=d');
		$this->mockGlobalVariable('wgAdDriverEnableRemnantGptMobile', true);
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
				'disableLateQueue' => true,
				'lateAdsAfterPageLoad' => true,
				'pageType' => 'corporate',
				'showAds' => true,
				'trackSlotState' => true,
				'useDartForSlotsBelowTheFold' => true,
			],
			'targeting' => [
				'enableKruxTargeting' => true,
				'kruxCategoryId' => 'HixxTik3',
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
}
