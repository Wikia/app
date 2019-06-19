<?php
class AdEngine3DeciderServiceTest extends WikiaBaseTest {

	public function testGetNoAdsReason_onActionPage() {
		$this->mockGlobalWikiaPageType();
		$this->mockStaticMethod( 'WikiaPageType', 'isActionPage', true );

		$this->assertEquals(AdEngine3DeciderService::REASON_ACTION_PAGE, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onNoExternalQueryString() {
		$this->mockGlobalWikiaPageType();

		$mockWebRequest = $this->getMock( 'WebRequest', [ 'getBool' ] );
		$mockWebRequest->expects( $this->any() )
			->method( 'getBool' )
			->will( $this->returnValue(true ) );
		$this->mockGlobalVariable( 'wgRequest', $mockWebRequest );

		$this->assertEquals(AdEngine3DeciderService::REASON_NOEXTERNALS_QUERYSTRING, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onNoExternalWikiFactory() {
		$this->mockGlobalWikiaPageType();

		$this->mockGlobalVariable( 'wgNoExternals', true );

		$this->assertEquals(AdEngine3DeciderService::REASON_NOEXTERNALS_WIKIFACTORY, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onNoAdsQueryString() {
		$this->mockGlobalWikiaPageType();

		$mockWebRequest = $this->getMock( 'WebRequest', [ 'getBool' ] );
		$mockWebRequest->expects( $this->any() )
			->method( 'getBool' )
			->will( $this->onConsecutiveCalls( false, true ) );
		$this->mockGlobalVariable( 'wgRequest', $mockWebRequest );

		$this->assertEquals(AdEngine3DeciderService::REASON_NOADS_QUERYSTRING, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onNoAdsWikiFactory() {
		$this->mockGlobalWikiaPageType();

		$this->mockGlobalVariable( 'wgShowAds', false );

		$this->assertEquals(AdEngine3DeciderService::REASON_NOADS_WIKIFACTORY, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onWrongSkin() {
		$this->mockGlobalWikiaPageType();

		$mockApp = $this->getMock( 'WikiaApp', [ 'checkSkin' ] );
		$mockApp->expects( $this->once() )
			->method( 'checkSkin' )
			->will( $this->returnValue(false) );
		$this->mockStaticMethod( 'WikiaApp', 'app', $mockApp );

		$this->assertEquals(AdEngine3DeciderService::REASON_WRONG_SKIN, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onNoAdsPage() {
		$this->mockGlobalWikiaPageType();

		$mockTitle = $this->getMock( 'Title', [ 'getNamespace' ] );
		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue('test-namespace') );

		$this->mockGlobalVariable( 'wgContentNamespaces', [ 'everything-except-test-namespace' ] );
		$this->mockGlobalVariable( 'wgTitle', $mockTitle );

		$this->assertEquals(AdEngine3DeciderService::REASON_NO_ADS_PAGE, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	public function testGetNoAdsReason_onLoggedIn() {
		$this->mockGlobalWikiaPageType();

		$mockTitle = $this->getMock( 'Title', [ 'getNamespace' ] );
		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue('test-namespace') );

		$this->mockGlobalVariable( 'wgContentNamespaces', [ 'test-namespace' ] );
		$this->mockGlobalVariable( 'wgTitle', $mockTitle );

		$mockUser = $this->getMock( 'User', [ 'isLoggedIn', 'getGlobalPreference' ] );
		$mockUser->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( true ) );
		$this->mockGlobalVariable( 'wgUser', $mockUser );

		$this->assertEquals(AdEngine3DeciderService::REASON_NO_ADS_USER, (new AdEngine3DeciderService())->getNoAdsReason());
	}

	private function mockGlobalWikiaPageType() {
		$this->mockStaticMethod( 'WikiaPageType', 'isFilePage', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isForum', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isSearch', false );
		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHub', false );
	}
}
