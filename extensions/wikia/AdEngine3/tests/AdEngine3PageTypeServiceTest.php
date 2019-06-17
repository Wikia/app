<?php

class AdEngine3PageTypeServiceTest extends WikiaBaseTest {
	public function testGetPageType_withDeciderRejectingAds() {
		$this->mockGlobalWikiaPageType();

		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue('rejecting_ads' ) );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_corporatePageForAnon() {
		$this->mockGlobalWikiaPageType(true );

		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_CORPORATE, $pageTypeService->getPageType());
	}

	public function testGetPageType_corporatePageForLoggedIn() {
		$this->mockGlobalWikiaPageType(true );

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

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_CORPORATE, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularPageForAnon() {
		$this->mockGlobalWikiaPageType();

		$adsDeciderMock = $this->getMock( 'AdEngine3DeciderService', [ 'getNoAdsReason' ] );
		$adsDeciderMock->expects( $this->once() )
			->method( 'getNoAdsReason' )
			->will( $this->returnValue(null ) );

		$wgUserMock = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$wgUserMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue(false ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_ALL_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularPageForLoggedInWithAds() {
		$this->mockGlobalWikiaPageType();

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

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_ALL_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_regularForLoggedInWithoutAds() {
		$this->mockGlobalWikiaPageType();

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

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_mainPageForLoggedInWithoutAds() {
		$this->mockGlobalWikiaPageType(false, true);

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

		$this->mockGlobalVariable( 'wgPagesWithNoAdsForLoggedInUsersOverriden', [] );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isMainPage', true );

		$pageTypeService = new AdEngine3PageTypeService( $adsDeciderMock );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_HOMEPAGE_LOGGED, $pageTypeService->getPageType());
	}

	private function mockGlobalWikiaPageType($isCorporate = false, $isMain = false) {
		$this->mockStaticMethod( 'WikiaPageType', 'isFilePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isForum', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isSearch', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHub', false );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', $isCorporate );
		$this->mockStaticMethod( 'WikiaPageType', 'isMainPage', $isMain );
	}
}
