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
			$title->method( 'getArticleId' )->willReturn( 0 );
		} else {
			$title->method( 'getPrefixedDbKey' )->willReturn( $artDbKey );
			$title->method( 'getArticleId' )->willReturn( $artId );
		}

		return $title;
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
				'flags' => [ ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForceProviders' => null
			],
			[
				'titleMockType' => 'article',
				'flags' => [ ],
				'expectedOpts' => [ ],
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ] ],
				'expectedProviders' => [ ],
				'expectedForceProviders' => null
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

			array_merge( $defaultParameters, [
				'expectedTargeting' => [ 'newWikiCategories' => [ 'test' ], 'hasPortableInfobox' => true ],
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
		// mech: using %S for hostname as RL can produce local links when $wgEnableLocalResourceLoaderLinks is set to true
		$expectedAdEngineResourceURLFormat = '%S/__load/-/cb%3D%d%26debug%3Dfalse%26lang%3D%s%26only%3Dscripts%26skin%3Doasis/%s';
		$expectedPrebidBidderUrl = 'http://i2.john-doe.wikia-dev.com/__am/123/group/-/pr3b1d_prod_js';

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

		if ( isset( $expectedTargeting['hasPortableInfobox'] ) && $expectedTargeting['hasPortableInfobox'] === true ) {
			$wikiaMock = $this->getMockBuilder( 'Wikia' )
				->disableOriginalConstructor()
				->setMethods( [ 'getProps' ] )
				->getMock();

			$wikiaMock->expects( $this->any() )
				->method( 'getProps' )
				->willReturn( true );

			$this->mockStaticMethod( 'Wikia', 'getProps', $wikiaMock );
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
		$this->mockGlobalVariable( 'wgEnableAdsInContent', false );
		$this->mockGlobalVariable( 'wgEnableKruxTargeting', false );
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

		if ( !empty( $categories['old'] ) || !empty( $categories['new'] ) ) {
			$wikiFactoryHubMock->expects( $this->any() )
				->method( 'getWikiCategoryNames' )
				->will( $this->onConsecutiveCalls(
						empty( $categories['old'] ) ? [] : $categories['old'],
						empty( $categories['new'] ) ? [] : $categories['new'] )
					);
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

		$adContextService = new AdEngine2ContextService();
		$result = $adContextService->getContext( $this->getTitleMock( $titleMockType, $langCode, $artId, $artDbKey ), $skinName );

		$expected = [
			'opts' => [
				'pageType' => 'all_ads',
				'showAds' => true,
				'delayBtf' => true,
				'sourcePointMMSDomain' => 'mms.bre.wikia-dev.com',
				'sourcePointRecovery' => true,
				'pageFairRecovery' => true,
				'instartLogicRecovery' => true
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

		// Check for SourcePoint URL
		$this->assertStringMatchesFormat( $expectedAdEngineResourceURLFormat, $result['opts']['sourcePointDetectionUrl'] );
		unset($result['opts']['sourcePointDetectionUrl']);

		// Check for PageFair URL
		$this->assertStringMatchesFormat( $expectedAdEngineResourceURLFormat, $result['opts']['pageFairDetectionUrl'] );
		unset($result['opts']['pageFairDetectionUrl']);

		// Check for Prebid.js URL
		$this->assertEquals( $expectedPrebidBidderUrl, $result['opts']['prebidBidderUrl'] );
		unset($result['opts']['prebidBidderUrl']);

		$this->assertEquals( $expected, $result );
	}

	/**
	 * @param $expected
	 * @param $wgEnableArticleFeaturedVideo
	 * @param $mediaId
	 * @param $message
	 *
	 * @dataProvider featuredVideoDataProvider
	 */
	public function testFeaturedVideoInContext(
		$expected,
		$wgEnableArticleFeaturedVideo,
		$mediaId,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );

		$titleMock = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getArticleID' ] )
			->getMock();
		$titleMock->method( 'getArticleID' )
			->willReturn( 123 );

		$this->mockStaticMethod( 'ArticleVideoService', 'getFeatureVideoForArticle', $mediaId );

		$adContextService = new AdEngine2ContextService();
		$result = $adContextService->getContext( $titleMock, 'test' );

		$this->assertEquals(
			$expected,
			isset( $result['targeting']['hasFeaturedVideo'] ) && $result['targeting']['hasFeaturedVideo'],
			$message
		);
	}

	public function featuredVideoDataProvider() {
		return [
			// hasFeaturedVideo result,
			// wgEnableArticleFeaturedVideo,
			// mediaId
			// message
			[ false, false, '', 'hasFeaturedVideo is set when extension disabled' ],
			[ false, true, '', 'hasFeaturedVideo is set when no data available' ],
			[ true, true, 'aksdjlfkjsdlf', 'hasFeaturedVideo is not set when correct data available' ],
			[ false, false, 'aksdjlfkjsdlf', 'hasFeaturedVideo is set when data is set but extension is disabled' ],
		];
	}
}
