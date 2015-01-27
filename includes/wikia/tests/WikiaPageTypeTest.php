<?php

class WikiaPageTypeTest extends WikiaBaseTest {
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08448 ms
	 * @covers WikiaSearchController::isCorporateWiki
	 */
	public function testIsCorporatePage() {
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', false );

		$this->assertFalse(WikiaPageType::isCorporatePage());

		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', null );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', null );

		$this->assertFalse(WikiaPageType::isCorporatePage());

		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', true );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', false );

		$this->assertTrue(WikiaPageType::isCorporatePage());

		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', true );

		$this->assertTrue(WikiaPageType::isCorporatePage());

		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', true );

		$this->assertTrue(WikiaPageType::isCorporatePage());
	}
}
