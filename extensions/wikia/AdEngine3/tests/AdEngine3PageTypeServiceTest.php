<?php

class AdEngine3PageTypeServiceTest extends WikiaBaseTest {
	private function getAdsDeciderMock( $expects, $method, $willReturn ) {
		$mock = $this->getMock( 'AdsDeciderService', [ 'getNoAdsReason' ] );

		$mock->expects( $expects )
			->method( $method )
			->will( $willReturn );

		return $mock;
	}

	public function testGetPageType_withActionPage() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('action_page')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoExternals() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('noexternals_querystring')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoAds() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('noads_querystring')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withShowAdsWikiFactory() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('noads_wikifactory')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withNoExternalsWikiFactory() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('noexternals_wikifactory')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}

	public function testGetPageType_withWrongSkin() {
		$pageTypeService = new AdEngine3PageTypeService( $this->getAdsDeciderMock(
			$this->any(),
			'getNoAdsReason',
			$this->returnValue('wrong_skin')
		) );

		$this->assertEquals(AdEngine3PageTypeService::PAGE_TYPE_NO_ADS, $pageTypeService->getPageType());
	}
}
