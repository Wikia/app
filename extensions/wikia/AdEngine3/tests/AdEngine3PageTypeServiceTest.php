<?php

class AdEngine3PageTypeServiceTest extends WikiaBaseTest {
	public function testGetPageType_withDeciderRejectingAds() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue('rejecting_ads' ) );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_corporatePageForAnon() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', true );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_CORPORATE, $pageTypeService->getPageType());
	}

	public function testGetPageType_corporatePageForLoggedIn() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(true ) );
		$wgUserMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue(true ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', true );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_CORPORATE, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularPageForAnon() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isSearch', false );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_ALL_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularPageForLoggedInWithAds() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(true ) );
		$wgUserMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue(true ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isSearch', false );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_ALL_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularForLoggedInWithoutAds() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(true ) );
		$wgUserMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isMainPage', false );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_mainPageForLoggedInWithoutAds() {
		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(true ) );
		$wgUserMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isMainPage', true );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_HOMEPAGE_LOGGED, $pageTypeService->getPageType());
	}
}
