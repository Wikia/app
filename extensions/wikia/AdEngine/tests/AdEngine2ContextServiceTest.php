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

	private function mockMonetizationModule() {
		$name = 'MonetizationModuleHelper';
		$mock = $this->getMock( $name );
		$mock->method( 'getMonetizationUnits' )->willReturn( ['below_category' => 'testing'] );
		$mock->method( 'getWikiVertical' )->willReturn( 'other' );
		$mock->method( 'getCacheVersion' )->willReturn( 'v1' );
		$this->mockClass( $name, $mock );
		$this->mockStaticMethod( $name, 'canShowModule', true );
	}

	public function adContextDataProvider() {
		$defaultParameters = [
			'titleMockType' => 'article',
			'flags' => [],
			'expectedOpts' => [],
			'expectedTargeting' => [],
			'expectedProviders' => [],
			'expectedForceProviders' => null,
			'expectedSlots' => [],
		];

		return [
			[ ],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverEnableAdsInMaps'],
				'expectedOpts' => ['enableAdsInMaps' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverEnableInvisibleHighImpactSlot'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => [],
				'expectedForceProviders' => null,
				'expectedSlots' => ['invisibleHighImpact' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverForceTurtleAd'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => [],
				'expectedForcedProvider' => 'turtle'
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverTrackState'],
				'expectedOpts' => ['trackSlotState' => true],
				'expectedTargeting' => []
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverUseMonetizationService', 'wgEnableMonetizationModuleExt'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => ['monetizationService' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverUseSevenOneMedia'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => ['sevenOneMedia' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgAdDriverWikiIsTop1000'],
				'expectedOpts' => [],
				'expectedTargeting' => ['wikiIsTop1000' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgEnableAdsInContent'],
				'expectedOpts' => ['adsInContent' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgEnableOutboundScreenExt'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => [],
				'expectedForceProviders' => null,
				'expectedSlots' => ['exitstitial' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgOutboundScreenRedirectDelay'],
				'expectedOpts' => [],
				'expectedTargeting' => [],
				'expectedProviders' => [],
				'expectedForceProviders' => null,
				'expectedSlots' => ['exitstitialRedirectDelay' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgEnableWikiaHomePageExt'],
				'expectedOpts' => ['pageType' => 'corporate'],
				'expectedTargeting' => ['wikiIsCorporate' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgEnableWikiaHubsV3Ext'],
				'expectedOpts' => ['pageType' => 'corporate'],
				'expectedTargeting' => ['pageIsHub' => true, 'wikiIsCorporate' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgWikiDirectedAtChildrenByFounder'],
				'expectedOpts' => [],
				'expectedTargeting' => ['wikiDirectedAtChildren' => true]
			],
			[
				'titleMockType' => 'article',
				'flags' => ['wgWikiDirectedAtChildrenByStaff'],
				'expectedOpts' => [],
				'expectedTargeting' => ['wikiDirectedAtChildren' => true]
			],
			[
				'titleMockType' => 'mainpage',
				'flags' => [],
				'expectedOpts' => [],
				'expectedTargeting' => ['pageType' => 'home']
			],
			[
				'titleMockType' => 'search',
				'flags' => [],
				'expectedOpts' => ['pageType' => 'search'],
				'expectedTargeting' => ['pageType' => 'search', 'pageName' => 'Special:Search']
			],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'tv',
				'expectedMappedVertical' => 'ent'
			]],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'games',
				'expectedMappedVertical' => 'gaming'
			]],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'books',
				'expectedMappedVertical' => 'ent'
			]],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'comics',
				'expectedMappedVertical' => 'ent'
			]],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'lifestyle',
				'expectedMappedVertical' => 'life'
			]],

			$defaultParameters + ['expectedMappings' => [
				'sourceVertical' => 'not-existing',
				'expectedMappedVertical' => 'error'
			]],

			$defaultParameters + ['expectedMappings' => [
				'verticalFromCategoryInfo' => 'Wikia',
				'sourceVertical' => 'other',
				'expectedMappedVertical' => 'wikia']
			],
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
		$expectedForcedProvider = null,
		$expectedSlots = [],
		$verticals = ['sourceVertical' => 'other', 'expectedMappedVertical' => 'life']
	) {
		$langCode = 'xx';
		$artId = 777;
		$artDbKey = 'articledbkey';
		$skinName = 'someskin';
		$vertical = isset($verticals['verticalFromCategoryInfo']) ? $verticals['verticalFromCategoryInfo'] : 'Fakevertical';
		$dbName = 'mydbname';
		$cityId = 666;
		$customDartKvs = 'a=b;c=d';
		$catId = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
		$shortCat = 'shortcat';
		$sevenOneMediaSub2Site = 'customsub2site';
		$expectedSevenOneMediaUrlFormat = 'http://%s/__load/-/cb%3D%d%26debug%3Dfalse%26lang%3D%s%26only%3Dscripts%26skin%3Doasis/wikia.ext.adengine.sevenonemedia';
		$expectedSourcePointUrlFormat = 'http://%s/__load/-/cb%3D%d%26debug%3Dfalse%26lang%3D%s%26only%3Dscripts%26skin%3Doasis/wikia.ext.adengine.sourcepoint';

		if ( $titleMockType === 'article' || $titleMockType === 'mainpage' ) {
			$expectedTargeting['pageArticleId'] = $artId;
			$expectedTargeting['pageIsArticle'] = true;
		}

		// Mock globals
		$this->mockGlobalVariable( 'wgCityId', $cityId );
		$this->mockGlobalVariable( 'wgDartCustomKeyValues', $customDartKvs );
		$this->mockGlobalVariable( 'wgDBname', $dbName );
		$this->mockGlobalVariable( 'wgAdDriverSevenOneMediaOverrideSub2Site', $sevenOneMediaSub2Site );

		if ( !is_null( $expectedForcedProvider ) ) {
			$this->mockGlobalVariable( 'wgAdDriverForcedProvider', $expectedForcedProvider );
		}

		// Flags
		$this->mockGlobalVariable( 'wgAdDriverEnableAdsInMaps', false );
		$this->mockGlobalVariable( 'wgAdDriverEnableInvisibleHighImpactSlot', false );
		$this->mockGlobalVariable( 'wgAdDriverTrackState', false );
		$this->mockGlobalVariable( 'wgAdDriverUseMonetizationService', false );
		$this->mockGlobalVariable( 'wgAdDriverUseSevenOneMedia', false );
		$this->mockGlobalVariable( 'wgEnableAdsInContent', false );
		$this->mockGlobalVariable( 'wgEnableKruxTargeting', false );
		$this->mockGlobalVariable( 'wgEnableMonetizationModuleExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', false );
		$this->mockGlobalVariable( 'wgEnableOutboundScreenExt', false );
		$this->mockGlobalVariable( 'wgOutboundScreenRedirectDelay', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByFounder', false );
		$this->mockGlobalVariable( 'wgWikiDirectedAtChildrenByStaff', false );

		foreach ( $flags as $flag ) {
			$this->mockGlobalVariable( $flag, true );
		}

		// Mock WikiFactoryHub
		$this->mockStaticMethod( 'WikiFactoryHub', 'getCategoryId', $catId );
		$this->mockStaticMethod( 'WikiFactoryHub', 'getCategoryShort', $shortCat );
		$this->mockStaticMethod( 'WikiFactoryHub', 'getWikiVertical', ['short'=>$verticals['sourceVertical']] );

		// Mock HubService
		$this->mockStaticMethod( 'HubService', 'getCategoryInfoForCity', (object) ['cat_name' => $vertical] );

		// Mock MonetizationModule
		if ( in_array( 'wgAdDriverUseMonetizationService', $flags ) ) {
			$this->mockMonetizationModule();
		}

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
				'mappedVerticalName' => $verticals['expectedMappedVertical']
			],
			'providers' => [
			],
			'slots' => [
			],
			'forcedProvider' => $expectedForcedProvider
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

		foreach ( $expectedSlots as $var => $val ) {
			$expected['slots'][$var] = $val;
		}

		// Check for SourcePoint URL
		if ( $skinName === 'oasis' ) {
			$this->assertStringMatchesFormat( $expectedSourcePointUrlFormat, $result['opts']['sourcePointUrl'] );
			unset( $result['opts']['sourcePointUrl'] );
		}

		// Extra check for SevenOne Media URL
		if ( isset( $expectedProviders['sevenOneMedia'] ) ) {
			$this->assertStringMatchesFormat( $expectedSevenOneMediaUrlFormat, $result['providers']['sevenOneMediaCombinedUrl'] );
			unset( $result['providers']['sevenOneMediaCombinedUrl'] );
		}

		// Extra check for Monetization Service
		if ( isset( $expectedProviders['monetizationService'] ) ) {
			$this->assertTrue( is_array( $result['providers']['monetizationServiceAds'] ) );
			$this->assertNotEmpty( $result['providers']['monetizationServiceAds'] );
			unset( $result['providers']['monetizationServiceAds'] );
		}

		$this->assertEquals( $expected, $result );
	}
}
