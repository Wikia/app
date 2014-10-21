<?php

class AdEngine2ContextServiceTest extends WikiaBaseTest {

	private $mocks = [];

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php";
		parent::setUp();
	}

	private function getTitleMock( $type, $langCode, $artId, $artDbKey ) {
		$language = $this->getMock( 'Language' );
		$language->method( 'getCode' )->willReturn( $langCode );

		$title = $this->getMock( 'Title' );
		$title->method( 'getPageLanguage' )->willReturn( $language );

		if ( $type === 'mainpage' ) {
			$title->method( 'isMainpage' )->willReturn( true );
		}

		if ( $type === 'search' ) {
			$title->method( 'getDBkey' )->willReturn( 'Search' );
			$title->method( 'getPrefixedDbKey' )->willReturn( 'Special:Search' );
			$title->method( 'getNamespace' )->willReturn( -1 );
		} else {
			$title->method( 'getPrefixedDbKey' )->willReturn( $artDbKey );
			$title->method( 'getArticleId' )->willReturn( $artId );
		}

		return $title;
	}

	public function adContextDataProvider() {
		return [
			[ ],

			[ 'article', ['wgAdDriverEnableRemnantGptMobile'], [], [], ['remnantGptMobile' => true] ],
			[ 'article', ['wgAdDriverTrackState'], ['trackSlotState' => true], [] ],
			[ 'article', ['wgAdDriverUseDartForSlotsBelowTheFold'], ['useDartForSlotsBelowTheFold' => true], [] ],
			[ 'article', ['wgAdDriverUseSevenOneMedia'], [], [], ['sevenOneMedia' => true] ],
			[ 'article', ['wgAdEngineDisableLateQueue'], ['disableLateQueue' => true], [] ],
			[ 'article', ['wgEnableKruxTargeting'], [], ['enableKruxTargeting' => true] ],
			[ 'article', ['wgEnableWikiaHomePageExt'], ['pageType' => 'corporate'], [] ],
			[ 'article', ['wgEnableWikiaHubsV3Ext'], ['pageType' => 'corporate'], ['pageIsHub' => true] ],
			[ 'article', ['wgLoadLateAdsAfterPageLoad'], ['lateAdsAfterPageLoad' => true], [] ],
			[ 'article', ['wgWikiDirectedAtChildrenByFounder'], [], ['wikiDirectedAtChildren' => true] ],
			[ 'article', ['wgWikiDirectedAtChildrenByStaff'], [], ['wikiDirectedAtChildren' => true] ],

			[ 'mainpage', [], [], ['pageType' => 'home'] ],
			[ 'search', [], ['pageType' => 'search'], ['pageType' => 'search', 'pageName' => 'Special:Search'] ],
		];
	}

	/**
	 * Test getContext
	 *
	 * @covers AdEngine2ContextService::getContext
	 * @dataProvider adContextDataProvider
	 */
	public function testGetContext( $titleMockType = 'article', $flags = [], $expectedOpts = [], $expectedTargeting = [], $expectedProviders = [] ) {
		$langCode = 'xx';
		$artId = 777;
		$artDbKey = 'articledbkey';
		$skinName = 'someskin';
		$vertical = 'Fakevertical';
		$dbName = 'mydbname';
		$cityId = 666;
		$customDartKvs = 'a=b;c=d';
		$catId = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
		$shortCat = 'shortcat';
		$kruxId = WikiFactoryHub::getInstance()->getKruxId( $catId );
		$sevenOneMediaSub2Site = 'customsub2site';
		$expectedSevenOneMediaUrlFormat = 'http://%s/__load/-/cb%3D%d%26debug%3Dfalse%26lang%3Den%26only%3Dscripts%26skin%3Doasis/wikia.ext.adengine.sevenonemedia';

		if ( $titleMockType === 'article' || $titleMockType === 'mainpage' ) {
			$expectedTargeting['pageArticleId'] = $artId;
			$expectedTargeting['pageIsArticle'] = true;
		}

		// Mock globals
		$this->mockGlobalVariable( 'wgCityId', $cityId );
		$this->mockGlobalVariable( 'wgDartCustomKeyValues', $customDartKvs );
		$this->mockGlobalVariable( 'wgDBname', $dbName );
		$this->mockGlobalVariable( 'wgAdDriverSevenOneMediaOverrideSub2Site', $sevenOneMediaSub2Site );

		// Flags

		$this->mockGlobalVariable( 'wgAdDriverEnableRemnantGptMobile', false );
		$this->mockGlobalVariable( 'wgAdDriverTrackState', false );
		$this->mockGlobalVariable( 'wgAdDriverUseDartForSlotsBelowTheFold', false );
		$this->mockGlobalVariable( 'wgAdDriverUseSevenOneMedia', false );
		$this->mockGlobalVariable( 'wgAdEngineDisableLateQueue', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', false );
		$this->mockGlobalVariable( 'wgLoadLateAdsAfterPageLoad', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByStaff', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByFounder', false );
		$this->mockGlobalVariable( 'wgEnableKruxTargeting', false );

		foreach ( $flags as $flag ) {
			$this->mockGlobalVariable( $flag, true );
		}

		// Mock WikiFactoryHub
		$this->mockStaticMethod( 'WikiFactoryHub', 'getCategoryId', $catId );
		$this->mockStaticMethod( 'WikiFactoryHub', 'getCategoryShort', $shortCat );

		// Mock HubService
		$this->mockStaticMethod( 'HubService', 'getCategoryInfoForCity', (object) ['cat_name' => $vertical] );

		$adContextService = new AdEngine2ContextService();
		$result = $adContextService->getContext( $this->getTitleMock( $titleMockType, $langCode, $artId, $artDbKey ), $skinName );

		$expected = [
			'opts' => [
				'adsInHead' => true,
				'pageType' => 'all_ads',
				'showAds' => true,
			],
			'targeting' => [
				'kruxCategoryId' => $kruxId,
				'pageName' => $artDbKey,
				'pageType' => 'article',
				'sevenOneMediaSub2Site' => $sevenOneMediaSub2Site,
				'skin' => $skinName,
				'wikiCategory' => $shortCat,
				'wikiCustomKeyValues' => $customDartKvs,
				'wikiDbName' => $dbName,
				'wikiLanguage' => $langCode,
				'wikiVertical' => $vertical,
			],
			'providers' => [
			],
			'slots' => [
			],
			'forceProviders' => [
			],
		];

		foreach ( $expectedOpts as $var => $val ) {
			$expected['opts'][$var] = $val;
		}

		foreach ( $expectedTargeting as $var => $val ) {
			$expected['targeting'][$var] = $val;
		}

		foreach ( $expectedProviders as $var => $val ) {
			$expected['providers'][$var] = $val;
		}

		// Extra check for SevenOne Media URL
		if ( isset( $expectedProviders['sevenOneMedia'] ) ) {
			$this->assertStringMatchesFormat( $expectedSevenOneMediaUrlFormat, $result['providers']['sevenOneMediaCombinedUrl'] );
			unset( $result['providers']['sevenOneMediaCombinedUrl'] );
		}

		$this->assertEquals( $expected, $result );
	}
}
