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
		$mock->method( 'getMonetizationUnits' )->willReturn( [ 'below_category' => 'testing' ] );
		$mock->method( 'getWikiVertical' )->willReturn( 'other' );
		$mock->method( 'getCacheVersion' )->willReturn( 'v1' );
		$mock->method( 'canShowModule' )->willReturn( true );
		$this->mockClass( $name, $mock );
	}

	public function adContextDataProvider() {
		$defaultParameters = [
			'titleMockType' => 'article',
			'flags' => [ ],
			'expectedOpts' => [ ],
			'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
			'expectedProviders' => [ ],
			'expectedForceProviders' => null,
			'expectedSlots' => [ ],
			'verticals' => [ 'newVertical' => 'other', 'expectedMappedVertical' => 'life' ]
		];

		return [
			[ ],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgAdDriverEnableAdsInMaps' ],
				'expectedOpts' => [ 'enableAdsInMaps' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgAdDriverEnableInvisibleHighImpactSlot' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForceProviders' => null,
				'expectedSlots' => [ 'invisibleHighImpact' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgAdDriverForceTurtleAd' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForcedProvider' => 'turtle'
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgAdDriverTrackState' ],
				'expectedOpts' => [ 'trackSlotState' => true ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgAdDriverWikiIsTop1000' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ], 'wikiIsTop1000' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgEnableAdsInContent' ],
				'expectedOpts' => [ 'adsInContent' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgEnableOutboundScreenExt' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForceProviders' => null,
				'expectedSlots' => [ 'exitstitial' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgOutboundScreenRedirectDelay' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForceProviders' => null,
				'expectedSlots' => [ 'exitstitialRedirectDelay' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgEnableWikiaHomePageExt' ],
				'expectedOpts' => [ 'pageType' => 'corporate' ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ], 'wikiIsCorporate' => true ]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgEnableWikiaHubsV3Ext' ],
				'expectedOpts' => [ 'pageType' => 'corporate' ],
				'expectedTargeting' => [
					'newWikiCategories' => [ 'test' ],
					'pageIsHub' => true,
					'wikiIsCorporate' => true
				]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgWikiDirectedAtChildrenByFounder' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [
					'newWikiCategories' => [ 'test' ],
					'esrbRating' => 'ec'
				]
			],
			[
				'titleMockType' => 'article',
				'flags' => [ 'wgWikiDirectedAtChildrenByStaff' ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [
					'newWikiCategories' => [ 'test' ],
					'esrbRating' => 'ec'
				]
			],
			[
				'titleMockType' => 'mainpage',
				'flags' => [ ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ], 'pageType' => 'home' ]
			],
			[
				'titleMockType' => 'search',
				'flags' => [ ],
				'expectedOpts' => [ 'pageType' => 'search' ],
				'expectedTargeting' => [
					'newWikiCategories' => [ 'test' ],
					'pageType' => 'search',
					'pageName' => 'Special:Search'
				]
			],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'tv',
				'expectedMappedVertical' => 'ent'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'games',
				'expectedMappedVertical' => 'gaming'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'books',
				'expectedMappedVertical' => 'ent'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'comics',
				'expectedMappedVertical' => 'ent'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'lifestyle',
				'expectedMappedVertical' => 'life'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'newVertical' => 'not-existing',
				'expectedMappedVertical' => 'error'
			] ],

			$defaultParameters + [ 'expectedMappings' => [
				'oldVertical' => 'Wikia',
				'newVertical' => 'other',
				'expectedMappedVertical' => 'wikia' ]
			],

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test', 'test1' ] ],
				'categories' => [ 'old' => [ 'test' ], 'new' => [ 'test1' ] ]
			] ),

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 0 => 'test', 2 => 'test1' ] ],
				'categories' => [ 'old' => [ 'test' ], 'new' => [ 'test', 'test1' ] ]
			] ),

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 0 => 'test', 1 => 'test1', 4 => 'test2' ] ],
				'categories' => [ 'old' => [ 'test', 'test1' ], 'new' => [ 'test', 'test1', 'test2' ] ]
			] ),

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test2' ] ],
				'categories' => [ 'old' => [ 'test2' ] ]
			] ),

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test3' ] ],
				'categories' => [ 'new' => [ 'test3' ] ]
			] ),
		];
	}

	/**
	 * Test getContext
	 *
	 * @covers       AdEngine2ContextService::getContext
	 * @dataProvider adContextDataProvider
	 */
	public function testGetContext(
		$titleMockType = 'article',
		$flags = [ ],
		$expectedOpts = [ ],
		$expectedTargeting = [ 'newWikiCategories' => [ 'test' ] ],
		$expectedProviders = [ ],
		$expectedForcedProvider = null,
		$expectedSlots = [ ],
		$verticals = [ 'newVertical' => 'other', 'expectedMappedVertical' => 'life' ],
		$categories = [ ]
	) {
		$langCode = 'xx';
		$artId = 777;
		$artDbKey = 'articledbkey';
		$skinName = 'someskin';
		$vertical = $verticals['newVertical'];
		$dbName = 'mydbname';
		$cityId = 666;
		$customDartKvs = 'a=b;c=d';
		$catId = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
		$shortCat = 'shortcat';
		$expectedAdEngineResourceURLFormat = 'http://%s/__load/-/cb%3D%d%26debug%3Dfalse%26lang%3D%s%26only%3Dscripts%26skin%3Doasis/%s';
		$expectedPrebidBidderUrl = 'http://i2.john-doe.wikia-dev.com/__am/123/group/-/prebid_prod_js';

		$assetsManagerMock = $this->getMockBuilder( 'AssetsManager' )
			->disableOriginalConstructor()
			->setMethods( [ 'getURL' ] )
			->getMock();

		$assetsManagerMock->expects( $this->any() )
			->method( 'getURL' )
			->willReturn( $expectedPrebidBidderUrl );

		$this->mockStaticMethod( 'AssetsManager', 'getInstance', $assetsManagerMock );

		if ( $titleMockType === 'article' || $titleMockType === 'mainpage' ) {
			$expectedTargeting['pageArticleId'] = $artId;
			$expectedTargeting['pageIsArticle'] = true;
		}

		// Mock globals
		$this->mockGlobalVariable( 'wgCityId', $cityId );
		$this->mockGlobalVariable( 'wgDartCustomKeyValues', $customDartKvs );
		$this->mockGlobalVariable( 'wgDBname', $dbName );

		if ( !is_null( $expectedForcedProvider ) ) {
			$this->mockGlobalVariable( 'wgAdDriverForcedProvider', $expectedForcedProvider );
		}

		// Flags
		$this->mockGlobalVariable( 'wgAdDriverEnableAdsInMaps', false );
		$this->mockGlobalVariable( 'wgAdDriverEnableInvisibleHighImpactSlot', false );
		$this->mockGlobalVariable( 'wgAdDriverTrackState', false );
		$this->mockGlobalVariable( 'wgAdDriverUseMonetizationService', false );
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
		$wikiFactoryHubMock = $this->getMockBuilder( 'WikiFactoryHub' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCategoryId', 'getCategoryShort', 'getWikiVertical', 'getWikiCategoryNames' ] )
			->getMock();

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getCategoryId' )
			->willReturn( $catId );

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getCategoryShort' )
			->willReturn( $shortCat );

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getWikiVertical' )
			->willReturn( [ 'short' => $verticals['newVertical'] ] );

		if ( !empty($categories['old']) || !empty($categories['new']) ) {
			$wikiFactoryHubMock->expects( $this->any() )
				->method( 'getWikiCategoryNames' )
				->will( $this->onConsecutiveCalls( $categories['old'], $categories['new'] ) );
		} else {
			$wikiFactoryHubMock->expects( $this->any() )
				->method( 'getWikiCategoryNames' )
				->willReturn( [ 'test' ] );
		}

		$this->mockStaticMethod( 'WikiFactoryHub', 'getInstance', $wikiFactoryHubMock );

		// Mock HubService
		$this->mockStaticMethod( 'HubService', 'getCategoryInfoForCity', (object)[
			'cat_name' => !empty($verticals['oldVertical']) ? $verticals['oldVertical'] : $vertical
		] );

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
				'delayBtf' => true
			],
			'targeting' => [
				'esrbRating' => 'teen',
				'pageName' => $artDbKey,
				'pageType' => 'article',
				'skin' => $skinName,
				'wikiCategory' => $shortCat,
				'wikiCustomKeyValues' => $customDartKvs,
				'wikiDbName' => $dbName,
				'wikiLanguage' => $langCode,
				'wikiVertical' => $vertical,
				'mappedVerticalName' => $verticals['expectedMappedVertical']
			],
			'providers' => [
				'evolve2' => true
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

		if ( $expected['targeting']['pageType'] === 'article' ) {
			$expected['providers']['taboola'] = true;
		}

		// Check for SourcePoint URL
		$this->assertStringMatchesFormat( $expectedAdEngineResourceURLFormat, $result['opts']['sourcePointDetectionUrl'] );
		unset($result['opts']['sourcePointDetectionUrl']);

		// Check for PageFair URL
		$this->assertStringMatchesFormat( $expectedAdEngineResourceURLFormat, $result['opts']['pageFairDetectionUrl'] );
		unset($result['opts']['pageFairDetectionUrl']);

		// Check for PageFair URL
		$this->assertEquals( $expectedPrebidBidderUrl, $result['opts']['prebidBidderUrl'] );
		unset($result['opts']['prebidBidderUrl']);


		$expected['providers']['rubiconFastlane'] = true;

		// Extra check for Monetization Service
		if ( isset($expectedProviders['monetizationService']) ) {
			$this->assertTrue( is_array( $result['providers']['monetizationServiceAds'] ) );
			$this->assertNotEmpty( $result['providers']['monetizationServiceAds'] );
			unset($result['providers']['monetizationServiceAds']);
		}

		// Check Yavli URL format
		$this->assertStringMatchesFormat( $expectedAdEngineResourceURLFormat, $result['opts']['yavliUrl'] );
		unset($result['opts']['yavliUrl']);

		$this->assertEquals( $expected, $result );
	}
}
