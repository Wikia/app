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
		$userMock = $this->getUserMock( false );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLoadFromSessionIsStaffAndIPWhitelisted() {
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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$this->mockGlobalVariable( 'wgSessionIPWhitelist', [ '127.0.0.0/16' ] );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertTrue( $result === null );
	}

	public function testUserLoadFromSessionIsStaffAndIPNotWhitelisted() {
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

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$this->mockGlobalVariable( 'wgSessionIPWhitelist', [ '127.0.1.0/24' ] );

		$result = null;

		$restrictSessionsMock->onUserLoadFromSession( $userMock, $result );

		$this->assertFalse( $result );
	}

	public function testUserLogoutIsStaff() {
		$userMock = $this->getUserMock( true );

		$requestMock = $this->getMock( '\WebRequest', [ 'setSessionData' ] );

		$requestMock->expects( $this->once() )
			->method( 'setSessionData' )
			->with( RestrictSessionsHooks::IP_SESSION_KEY, null );

		$restrictSessionsMock = $this->getRestrictSessionsMock( $requestMock );

		$restrictSessionsMock->onUserLogout( $userMock );
	}

	public function testUserLogoutIsNotStaff() {
		$userMock = $this->getUserMock( false );

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

	private function getRestrictSessionsMock( $requestMock ) {
		$restrictSessionsMock = $this->getMock( '\RestrictSessions\RestrictSessionsHooks', [ 'getRequest' ] );

		$restrictSessionsMock->expects( $this->once() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );

		return $restrictSessionsMock;
	}

}
