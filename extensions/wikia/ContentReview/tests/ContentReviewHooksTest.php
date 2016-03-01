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
}
