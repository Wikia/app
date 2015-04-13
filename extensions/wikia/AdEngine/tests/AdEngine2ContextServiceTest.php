<?php

class AdEngine2ContextServiceTest extends WikiaBaseTest {

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
			$title->method( 'isSpecialPage' )->willReturn( true );
		} else {
			$title->method( 'getPrefixedDbKey' )->willReturn( $artDbKey );
			$title->method( 'getArticleId' )->willReturn( $artId );
		}

		return $title;
	}

	public function adContextDataProvider() {
		return [
			[ ],

			[ 'article', ['wgAdDriverEnableAdsInMaps'], ['enableAdsInMaps' => true] ],
			[ 'article', ['wgAdDriverForceTurtleAd'], [], [], [], ['turtle' => true] ],
			[ 'article', ['wgAdDriverTrackState'], ['trackSlotState' => true], [] ],
			[ 'article', ['wgAdDriverUseSevenOneMedia'], [], [], ['sevenOneMedia' => true] ],
			[ 'article', ['wgAdDriverWikiIsTop1000'], [], ['wikiIsTop1000' => true] ],
			[ 'article', ['wgAdEngineDisableLateQueue'], ['disableLateQueue' => true] ],
			[ 'article', ['wgEnableAdsInContent'], ['adsInContent' => true] ],
			[ 'article', ['wgEnableKruxTargeting'], [], ['enableKruxTargeting' => true] ],
			[ 'article', ['wgEnableWikiaHomePageExt'], ['pageType' => 'corporate'], ['wikiIsCorporate' => true] ],
			[ 'article', ['wgEnableWikiaHubsV3Ext'], ['pageType' => 'corporate'], ['pageIsHub' => true, 'wikiIsCorporate' => true] ],
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
	public function testGetContext(
		$titleMockType = 'article',
		$flags = [],
		$expectedOpts = [],
		$expectedTargeting = [],
		$expectedProviders = [],
		$expectedForceProviders = []
	) {
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
		$this->mockGlobalVariable( 'wgAdDriverEnableAdsInMaps', false );
		$this->mockGlobalVariable( 'wgAdDriverForceTurtleAd', false );
		$this->mockGlobalVariable( 'wgAdDriverTrackState', false );
		$this->mockGlobalVariable( 'wgAdDriverUseSevenOneMedia', false );
		$this->mockGlobalVariable( 'wgAdEngineDisableLateQueue', false );
		$this->mockGlobalVariable( 'wgEnableAdsInContent', false );
		$this->mockGlobalVariable( 'wgEnableKruxTargeting', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByFounder', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByStaff', false );

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
				'pageType' => 'all_ads',
				'showAds' => true,
			],
			'targeting' => [
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

		foreach ( $expectedForceProviders as $var => $val ) {
			$expected['forceProviders'][$var] = $val;
		}

		// Extra check for SevenOne Media URL
		if ( isset( $expectedProviders['sevenOneMedia'] ) ) {
			$this->assertStringMatchesFormat( $expectedSevenOneMediaUrlFormat, $result['providers']['sevenOneMediaCombinedUrl'] );
			unset( $result['providers']['sevenOneMediaCombinedUrl'] );
		}

		$this->assertEquals( $expected, $result );
	}
}
