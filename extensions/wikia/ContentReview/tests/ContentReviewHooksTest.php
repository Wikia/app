<?php

class ContentReviewHooksTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @covers \Wikia\ContentReview\Hooks::onUserLogoutComplete()
	 *
	 * In this test case the setSessionData() method should not be called
	 * because there are no IDs of wikias stored in a session under the test mode key.
	 */
	public function testDisableTestModeNoSessionData() {
		$requestMock = $this->getMock( 'WebRequest', [ 'getSessionData', 'setSessionData' ] );
		$requestMock->expects( $this->once() )
			->method( 'getSessionData' )
			->willReturn( [] );
		$requestMock->expects( $this->never() )
			->method( 'setSessionData' );

		$userMock = $this->getMock( 'User', [ 'getRequest' ] );
		$userMock->expects( $this->once() )
			->method( 'getRequest' )
			->willReturn( $requestMock );

		$injectHtml = '';

		( new Wikia\ContentReview\Hooks() )->onUserLogoutComplete( $userMock, $injectHtml, '' );
	}

	/**
	 * @covers \Wikia\ContentReview\Hooks::onUserLogoutComplete()
	 *
	 * In this test case the setSessionData() method should be called once
	 * because there are IDs of wikia under the test mode key.
	 */
	public function testDisableTestModeWithSessionData() {
		$requestMock = $this->getMock( 'WebRequest', [ 'getSessionData', 'setSessionData' ] );
		$requestMock->expects( $this->once() )
			->method( 'getSessionData' )
			->willReturn( [ 177 ] );
		$requestMock->expects( $this->once() )
			->method( 'setSessionData' );

		$userMock = $this->getMock( 'User', [ 'getRequest' ] );
		$userMock->expects( $this->once() )
			->method( 'getRequest' )
			->willReturn( $requestMock );

		$injectHtml = '';

		( new Wikia\ContentReview\Hooks() )->onUserLogoutComplete( $userMock, $injectHtml, '' );
	}

	/**
	 * @covers \Wikia\ContentReview\Hooks::onSkinAfterBottomScripts()
	 * @dataProvider addingImportJSScriptsProvider
	 */
	public function testAddingImportJSScripts( $jsEnabled, $userJsAllowed, $importScripts, $bottomScriptsResult ) {
		$this->mockGlobalVariable( 'wgUseSiteJs', $jsEnabled );

		$outputMock = $this->createMock( OutputPage::class );
		$outputMock->expects( $this->any() )
			->method( 'isUserJsAllowed' )
			->willReturn( $userJsAllowed );

		$skinMock = $this->getMockBuilder( '\Skin' )
			->disableOriginalConstructor()
			->getMock();
		$skinMock->expects( $this->any() )
			->method( 'getOutput' )
			->will( $this->returnValue( $outputMock ) );

		$cacheMock = new HashBagOStuff();
		$cacheMock->set( \Wikia\ContentReview\ImportJS::getImportJSMemcKey(), $importScripts );
		$this->mockGlobalVariable( 'wgMemc', $cacheMock );

		$bottomScripts = '';

		( new Wikia\ContentReview\Hooks() )->onSkinAfterBottomScripts( $skinMock, $bottomScripts );

		$this->assertEquals( $bottomScripts, $bottomScriptsResult );
	}

	public function addingImportJSScriptsProvider() {
		return [
			[
				true,
				true,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
			],
			[
				true,
				false,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				''
			],
			[
				false,
				true,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'',
			],
			[
				false,
				false,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'',
			],
		];
	}
}
