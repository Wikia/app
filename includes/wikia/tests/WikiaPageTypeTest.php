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

	public function testIsWikiaHubMain() {
		/* @var Title $title */
		$title = $this->mockClassWithMethods( 'Title', [
			'getText' => 'Foo_Article',
			'getNamespace' => NS_MAIN,
		] );

		$this->mockGlobalVariable( 'wgEnableWikiaHubsV3Ext', true );

		// test the default behavior: using wgTitle
		$this->mockGlobalVariable( 'wgTitle', $title );
		$this->assertEquals( false, WikiaPageType::isWikiaHubMain() );

		// test passing a "custom" title
		$this->mockGlobalVariable( 'wgTitle', null );
		$this->assertEquals( false, WikiaPageType::isWikiaHubMain( $title ) );

		// now mock the main page title and assert that our title is the main page
		$this->mockStaticMethod( 'WikiaPageType', 'getMainPageName', $title->getText() );
		$this->assertEquals( true, WikiaPageType::isWikiaHubMain( $title ) );
	}

	/**
	 * @expectedException Wikia\Util\AssertionException
	 */
	public function testIsWikiaHubMainFailedAssert() {
		$this->mockGlobalVariable( 'wgTitle', null );
		$this->assertEquals( false, WikiaPageType::isWikiaHubMain() );
	}
}
