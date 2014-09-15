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
		global $wgLoadAdsInHead, $wgAdEngineDisableLateQueue, $wgLoadLateAdsAfterPageLoad,
		$wgAdDriverTrackState, $wgEnableWikiaHubsV3Ext, $wgAdDriverSevenOneMediaOverrideSub2Site,
		$wgWikiDirectedAtChildren, $wgAdDriverForceLiftiumAd, $wgAdDriverForceDirectGptAd, $wgAdDriverUseSevenOneMedia,
		$wgWikiDirectedAtChildrenByStaff, $wgAdDriverUseEbay, $wgDartCustomKeyValues;

		$wgLoadAdsInHead = true;
		$wgAdEngineDisableLateQueue = true;
		$wgLoadLateAdsAfterPageLoad = true;
		$wgAdDriverTrackState = true;
		$wgEnableWikiaHubsV3Ext = true;
		$wgAdDriverSevenOneMediaOverrideSub2Site = true;
		$wgWikiDirectedAtChildren = true;
		$wgAdDriverForceLiftiumAd = true;
		$wgAdDriverForceDirectGptAd = true;
		$wgAdDriverUseSevenOneMedia = false;
		$wgWikiDirectedAtChildrenByStaff = true;
		$wgAdDriverUseEbay = true;
		$wgDartCustomKeyValues = 'dart';
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
		unset($result['targeting']['wikiCustomKeyValues']);
		$this->assertEquals( $expected, $result );
	}

}
