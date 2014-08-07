<?php

namespace RestrictSessions\Test;

use RestrictSessions\RestrictSessionsHooks;

class RestrictSessionsTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../RestrictSessions.setup.php';
		parent::setUp();
	}

	public function testUserSetCookiesIsStaff() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$this->setupRequestContextMock( $requestMock );

		$sessions = [];
		$cookies = [];

		RestrictSessionsHooks::onUserSetCookies( $userMock, $sessions, $cookies );

		$this->assertTrue(
			array_key_exists( RestrictSessionsHooks::IP_SESSION_KEY, $sessions ) &&
				$sessions[RestrictSessionsHooks::IP_SESSION_KEY] === '127.0.0.1'
		);
	}

	public function testUserSetCookiesNotStaff() {
		$userMock = $this->getUserMock( false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP' ] );

		$requestMock->expects( $this->never() )
			->method( 'getIP' );

		$this->setupRequestContextMock( $requestMock );

		$sessions = [];
		$cookies = [];

		RestrictSessionsHooks::onUserSetCookies( $userMock, $sessions, $cookies );

		$this->assertTrue( !array_key_exists( RestrictSessionsHooks::IP_SESSION_KEY, $sessions ) );
	}

	public function testUserLoadFromSessionIsStaffAndIPMatches() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '127.0.0.1' ]
				]
			) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionIsStaffAndIPDoesNotMatch() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionIsStaffAndIPNotInSession() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, null ]
				]
			) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionNotStaff() {
		$userMock = $this->getUserMock( false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->never() )
			->method( 'getIP' );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->once() )
			->method( 'getSessionData' )
			->with( 'wsUserID' )
			->will( $this->returnValue( 1234 ) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionCookieIsStaff() {
		$userMock = $this->getUserMock( [ true, false ] );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 2345 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionSessionIsStaff() {
		$userMock = $this->getUserMock( [ false, true ] );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 1234 ) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 2345 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$this->setupRequestContextMock( $requestMock );

		$result = null;

		RestrictSessionsHooks::onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLogoutIsStaff() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'setSessionData' )
			->with( RestrictSessionsHooks::IP_SESSION_KEY, null );

		$this->setupRequestContextMock( $requestMock );

		RestrictSessionsHooks::onUserLogout( $userMock );
	}

	public function testUserLogoutIsNotStaff() {
		$userMock = $this->getUserMock( false );

		$requestMock = $this->getMock( '\WebRequest', [ 'setSessionData' ] );

		$requestMock->expects( $this->never() )
			->method( 'setSessionData' );

		$this->setupRequestContextMock( $requestMock );

		RestrictSessionsHooks::onUserLogout( $userMock );
	}

	private function getUserMock( $isAllowedResult ) {
		$userMock = $this->getMock( '\User', [ 'isAllowed' ] );

		if ( is_array( $isAllowedResult ) ) {
			$userMock->expects( $this->any() )
				->method( 'isAllowed' )
				->with( 'restrictsession' )
				->will( $this->onConsecutiveCalls( $isAllowedResult[0], $isAllowedResult[1] ) );
		} else {
			$userMock->expects( $this->any() )
				->method( 'isAllowed' )
				->with( 'restrictsession' )
				->will( $this->returnValue( $isAllowedResult ) );
		}

		$this->mockClass( '\User', $userMock, 'newFromId' );

		return $userMock;
	}

	private function setupRequestContextMock( $requestMock ) {
		$requestContextMock = $this->getMock( '\RequestContext', [ 'getRequest' ] );

		$requestContextMock->expects( $this->once() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );

		$this->mockClass( '\RequestContext', $requestContextMock, 'getMain' );
	}

}
