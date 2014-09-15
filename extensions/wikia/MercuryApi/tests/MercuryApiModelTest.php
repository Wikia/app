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
	private function setupGlobals () {
		$this->mockGlobalVariable('wgLoadAdsInHead', true);
		$this->mockGlobalVariable('wgAdEngineDisableLateQueue', true);
		$this->mockGlobalVariable('wgLoadLateAdsAfterPageLoad', true);
		$this->mockGlobalVariable('wgAdDriverTrackState', true);
		$this->mockGlobalVariable('wgEnableWikiaHubsV3Ext', true);
		$this->mockGlobalVariable('wgAdDriverSevenOneMediaOverrideSub2Site', true);
		$this->mockGlobalVariable('wgWikiDirectedAtChildren', true);
		$this->mockGlobalVariable('wgAdDriverForceLiftiumAd', true);
		$this->mockGlobalVariable('wgAdDriverForceDirectGptAd', true);
		$this->mockGlobalVariable('wgAdDriverUseSevenOneMedia', false);
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);
		$this->mockGlobalVariable('wgAdDriverUseEbay', true);
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

		$wGReg = $this->getMock( 'WikiaGlobalRegistry' );

		$articleCategories = [
			[
				'title' => 'title 1'
			]
		];
		$expected = [
			'opts' => [
				'adsInHead' => true,
				'disableLateQueue' => true,
				'lateAdsAfterPageLoad' => true,
				'pageType' => 'corporate',
				'showAds' => true,
				'usePostScribe' => null,
				'trackSlotState' => true,
			],
			'targeting' => [
				'enableKruxTargeting' => true,
				'kruxCategoryId' => 'Hi0kPhMT',
				'pageArticleId' => 10,
				'pageCategories' => [
					'title 1'
				],
				'pageIsArticle' => true,
				'pageIsHub' => true,
				'pageName' => null,
				'pageType' => 'article',
				'sevenOneMediaSub2Site' => true,
				'skin' => 'mercury',
				'wikiCategory' => 'ent',
				'wikiDbName' => null,
				'wikiDirectedAtChildren' => true,
				'wikiLanguage' => 'en',
				'wikiVertical' => 'Wikia',
			],
			'providers' => [
				'ebay' => true,
				'sevenOneMedia' => null,
				'sevenOneMediaCombinedUrl' => null,
				'remnantGptMobile' => null,
			],
			'slots' => [
				'bottomLeaderboardImpressionCapping' => null,
			],
			'forceProviders' => [
				'directGpt' => true,
				'liftium' => true,
			],
 		];
		$result = $mercuryApi->getAdsContext( $title, $wGReg, $articleCategories );
		// Remove wikiCustomKeyValues from the test as it relies on hook call to NLP to add params
		unset($result['targeting']['wikiCustomKeyValues']);
		$this->assertEquals( $expected, $result );
	}

}
