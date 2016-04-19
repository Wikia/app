<?php

class ContentReviewHooksTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
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
	 * @dataProvider addingImportJSScriptsProvider
	 */
	public function testAddingImportJSScripts( $jsEnabled, $importScripts, $bottomScriptsResult ) {
		$skinMock = $this->getMock( 'Skin' );
		$this->mockGlobalVariable( 'wgUseSiteJs', $jsEnabled );
		$importJSMock = $this->getMock( 'Wikia\ContentReview\ImportJS', [ 'getImportScripts' ] );

		$importJSMock->expects( $this->any() )
			->method( 'getImportScripts' )
			->will( $this->returnValue( $importScripts ) );

		$this->mockClass( 'Wikia\ContentReview\ImportJS', $importJSMock );

		$bottomScripts = '';

		( new Wikia\ContentReview\Hooks() )->onSkinAfterBottomScripts( $skinMock, $bottomScripts );

		$this->assertEquals( $bottomScripts, $bottomScriptsResult );
	}

	public function addingImportJSScriptsProvider() {
		return [
			[
				true,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
			],
			[
				false,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'',
			],
		];
	}
}
