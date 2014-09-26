<?php

namespace RestrictSessions\Test;

use RestrictSessions\RestrictSessionsHooks;

class RestrictSessionsTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../RestrictSessions.setup.php';
		parent::setUp();
	}

	public function testUserSetCookiesIsStaff() {
		$userMock = $this->getMock( '\User', [ 'isAllowed' ] );

		$userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'restrictsession' )
			->will( $this->returnValue( true ) );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$sessions = [];
		$cookies = [];

		$restrictSessionsMock->onUserSetCookies( $userMock, $sessions, $cookies );

		$this->assertTrue(
			array_key_exists( RestrictSessionsHooks::IP_SESSION_KEY, $sessions ) &&
				$sessions[RestrictSessionsHooks::IP_SESSION_KEY] === '127.0.0.1'
		);
	}

	public function testUserSetCookiesNotStaff() {
		$userMock = $this->getMock( '\User', [ 'isAllowed' ] );

		$userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'restrictsession' )
			->will( $this->returnValue( false ) );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP' ] );

		$requestMock->expects( $this->never() )
			->method( 'getIP' );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$sessions = [];
		$cookies = [];

		$restrictSessionsMock->onUserSetCookies( $userMock, $sessions, $cookies );

		$this->assertTrue( !array_key_exists( RestrictSessionsHooks::IP_SESSION_KEY, $sessions ) );
	}

	public function testUserLoadFromSessionIsStaffAndIPMatches() {
		$userMock = $this->getUserMock( true, false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, null ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '127.0.0.1' ]
				]
			) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionIsStaffAndIPDoesNotMatch() {
		$userMock = $this->getUserMock( true, false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, null ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionIsStaffAndIPNotInSession() {
		$userMock = $this->getUserMock( true, false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie',
			'getSessionData', 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, null ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, null ]
				]
			) );

		$requestMock->expects( $this->never() )
			->method( 'setSessionData' );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	/**
	 * Test that if a staff member has checked "stay logged in" and has a valid
	 * token cookie, that the session successfully loads and the IP session data
	 * is set.
	 */
	public function testUserLoadFromSessionIsStaffAndLogInRemembered() {
		$userMock = $this->getUserMock( true, false, 'sometokenstring' );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie',
			'getSessionData', 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, 'sometokenstring' ],
				]
			) );

		$sessionData = [];

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnCallback( function ( $sessionKey ) use ( &$sessionData ) {
				if ( $sessionKey === 'wsUserID' ) {
					return null;
				} elseif ( $sessionKey === RestrictSessionsHooks::IP_SESSION_KEY ) {
					return $sessionData[RestrictSessionsHooks::IP_SESSION_KEY];
				}
			} ) );

		$requestMock->expects( $this->once() )
			->method( 'setSessionData' )
			->with( RestrictSessionsHooks::IP_SESSION_KEY, '127.0.0.1' )
			->will( $this->returnCallback( function ( $sessionKey, $sessionValue ) use ( &$sessionData ) {
				$sessionData[$sessionKey] = $sessionValue;
			} ) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	/**
	 * Test that if a staff member has checked "stay logged in" but has an invalid
	 * token cookie, that the session fails to load.
	 */
	public function testUserLoadFromSessionIsStaffAndLogInRememberedInvalidToken() {
		$userMock = $this->getUserMock( true, false, 'sometokenstring' );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie',
			'getSessionData', 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, 'someothertokenstring' ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', null ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, null ]
				]
			) );

		$requestMock->expects( $this->never() )
			->method( 'setSessionData' );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionNotStaff() {
		$userMock = $this->getUserMock( false, false );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionInvalidCookieSessionIsStaff() {
		$userMock = $this->getUserMock( true, true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->never() )
			->method( 'getIP' );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( null ) );

		$requestMock->expects( $this->once() )
			->method( 'getSessionData' )
			->with( 'wsUserID' )
			->will( $this->returnValue( 1234 ) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionInvalidCookieUserAndNullSession() {
		$userMock = $this->getUserMock( false, true );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->never() )
			->method( 'getIP' );

		$requestMock->expects( $this->once() )
			->method( 'getCookie' )
			->with( 'UserID' )
			->will( $this->returnValue( 0 ) );

		$requestMock->expects( $this->once() )
			->method( 'getSessionData' )
			->with( 'wsUserID' )
			->will( $this->returnValue( null ) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionIsStaffSessionMismatch() {
		$userMock = $this->getUserMock( true, false );

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
			->will( $this->returnValue( 2345 ) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionIsStaffAndIPWhitelisted() {
		$userMock = $this->getUserMock( true, false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, null ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$this->mockGlobalVariable( 'wgSessionIPWhitelist', [ '127.0.0.0/16' ] );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionIsStaffAndIPNotWhitelisted() {
		$userMock = $this->getUserMock( true, false );

		$requestMock = $this->getMock( '\WebRequest', [ 'getIP', 'getCookie', 'getSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'getIP' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$requestMock->expects( $this->any() )
			->method( 'getCookie' )
			->will( $this->returnValueMap(
				[
					[ 'UserID', null, null, 1234 ],
					[ 'Token', null, null, null ],
				]
			) );

		$requestMock->expects( $this->any() )
			->method( 'getSessionData' )
			->will( $this->returnValueMap(
				[
					[ 'wsUserID', 1234 ],
					[ RestrictSessionsHooks::IP_SESSION_KEY, '0.0.0.0' ]
				]
			) );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$this->mockGlobalVariable( 'wgSessionIPWhitelist', [ '127.0.1.0/24' ] );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLogoutIsStaff() {
		$userMock = $this->getMock( '\User', [ 'isAllowed' ] );

		$userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'restrictsession' )
			->will( $this->returnValue( true ) );

		$requestMock = $this->getMock( '\WebRequest', [ 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'setSessionData' )
			->with( RestrictSessionsHooks::IP_SESSION_KEY, null );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$restrictSessionsMock->onUserLogout( $userMock );
	}

	public function testUserLogoutIsNotStaff() {
		$userMock = $this->getMock( '\User', [ 'isAllowed' ] );

		$userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'restrictsession' )
			->will( $this->returnValue( false ) );

		$requestMock = $this->getMock( '\WebRequest', [ 'setSessionData' ] );

		$requestMock->expects( $this->never() )
			->method( 'setSessionData' );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$restrictSessionsMock->onUserLogout( $userMock );
	}

	/**
	 * @dataProvider isWhiteListedProvider
	 */
	public function testIsWhiteListed( $whiteList, $ipAddress, $expectedResult ) {
		$this->mockGlobalVariable( 'wgSessionIPWhitelist', $whiteList );

		$restrictSessions = new RestrictSessionsHooks();
		$result = $restrictSessions->isWhiteListedIP( $ipAddress );

		$this->assertTrue( $result === $expectedResult );
	}

	public function isWhiteListedProvider() {
		return [
			// IP in whitelist range
			[ [ '127.0.0.0/16' ], '127.0.0.1', true ],
			// IP not in whitelist range
			[ [ '127.0.1.0/24' ], '127.0.0.1', false ],
			// Single IP whitelisted
			[ [ '127.0.1.0/24', '127.0.0.1' ], '127.0.0.1', true ],
			// Empty whitelist
			[ [], '127.0.0.1', false ],
		];
	}

	private function getUserMock( $isAllowedResult, $isAnon, $token = false ) {
		$userMock = $this->getMock( '\User', [ 'isAllowed', 'isAnon', 'getToken' ] );

		$userMock->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );

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

		if ( $token === false ) {
			$userMock->expects( $this->never() )
				->method( 'getToken' );
		} else {
			$userMock->expects( $this->once() )
				->method( 'getToken' )
				->will( $this->returnValue( $token ) );
		}

		$this->mockClass( '\User', $userMock, 'newFromId' );

		return $userMock;
	}

	private function getRestrictSessionsMock( $requestMock ) {
		$restrictSessionsMock = $this->getMock( '\RestrictSessions\RestrictSessionsHooks', [ 'getRequest' ] );

		$restrictSessionsMock->expects( $this->once() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );

		return $restrictSessionsMock;
	}

}
