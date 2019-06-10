<?php

class AdEngine3PageTypeServiceTest extends WikiaBaseTest {
	public function testGetPageType_withActionPage() {
		$this->mockStaticMethod( WikiaPageType::class,
			'isActionPage',
			true
		);

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoExternals() {
		$requestMock = $this->getMock( 'WebRequest', [ 'getBool' ] );
		$requestMock->expects( $this->any() )
			->method( 'getBool' )
			->will( $this->onConsecutiveCalls( true, false) );

		$this->mockGlobalVariable( 'wgRequest', $requestMock);

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoAds() {
		$requestMock = $this->getMock( 'WebRequest', [ 'getBool' ] );
		$requestMock->expects( $this->any() )
			->method( 'getBool' )
			->will( $this->onConsecutiveCalls( false, true) );

		$this->mockGlobalVariable( 'wgRequest', $requestMock);

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withShowAdsWikiFactory() {
		$this->mockGlobalVariable( 'wgShowAds', false );

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoExternalsWikiFactory() {
		$this->mockGlobalVariable( 'wgNoExternals', true );

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withWrongSkin() {
		$appMock = $this->getMock( 'WikiaApp', [ 'checkSkin' ] );
		$appMock->expects( $this->any() )
			->method( 'checkSkin' )
			->will( $this->returnValue(false) );

		$this->mockStaticMethod( WikiaApp::class,
			'app',
			$appMock
		);

		$pageTypeService = new AdEngine3PageTypeService();

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}
}
