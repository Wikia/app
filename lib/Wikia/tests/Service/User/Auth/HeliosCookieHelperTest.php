<?php

namespace Wikia\Service\User\Auth;

use PHPUnit\Framework\TestCase;
use Wikia\Domain\UserObject;
use Wikia\HTTP\Response;
use Wikia\Service\Helios\HeliosClient;

class HeliosCookieHelperTest extends TestCase {

	const TEST_USER_ID = 12345;
	const TEST_TOKEN = 'abcdefghijk';

	private $helios;
	private $response;
	private $cookieHelper;

	public function setUp() {
		$this->response = $this->getMockBuilder( Response::class )
			->setMethods( ['setcookie'] )
			->disableOriginalConstructor()
			->getMock();
		$this->helios = $this->getMockBuilder( HeliosClient::class )
			->disableOriginalConstructor()
			->getMock();

		$this->request = $this->createMock( \WebRequest::class );

		$this->cookieHelper = new CookieHelper( $this->helios );
	}

	public function testSetAuthenticationCookie() {
		$tokenData = (object)array( CookieHelper::ACCESS_TOKEN_COOKIE_NAME => self::TEST_TOKEN );
		$this->helios->expects( $this->once() )
			->method( 'generateToken' )
			->with( self::TEST_USER_ID )
			->willReturn( $tokenData );

		$this->response->expects( $this->once() )
			->method( 'setcookie' )
			->with(
			 	CookieHelper::ACCESS_TOKEN_COOKIE_NAME,
				$tokenData->access_token,
				$this->isType('int'),
				CookieHelper::COOKIE_PREFIX
		 	);

		$this->cookieHelper->setAuthenticationCookieWithUserId( self::TEST_USER_ID, $this->response );
	}

	public function testClearAuthenticationCookie() {
		$this->response->expects( $this->once() )
			->method( 'setcookie' )
			->with(
			 	CookieHelper::ACCESS_TOKEN_COOKIE_NAME,
				"",
				$this->isType('int'),
				CookieHelper::COOKIE_PREFIX
		 	);

		$this->cookieHelper->clearAuthenticationCookie( $this->response );
	}

	public function testGetAccessTokenFromCookie() {
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->request->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $token );

		$this->assertEquals( $this->cookieHelper->getAccessToken( $this->request ), $token );
	}

	public function testGetAccessTokenFromAuthorizationHeader() {
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->request->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->request->expects( $this->once() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( $token );

		$this->assertEquals( $this->cookieHelper->getAccessToken( $this->request ), $token );
	}

	public function testGetAccessTokenFromCookieReturnsNull() {
		// No HTTP header
		$this->request->expects( $this->any() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( '' );

		// Cookie with no value
		$this->request->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( '' );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );

		$this->request->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( false );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );

		$this->request->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );
	}

	public function testGetAccessTokenFromHeaderReturnsNull() {
		// No Cookie
		$this->request->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( null );

		// Header with no value
		$this->request->expects( $this->any() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( '' );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );

		$this->request->expects( $this->any() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );

		$this->request->expects( $this->any() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( null );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );
	}


	public function testGetAccessTokenCookiePrecedenceIfBoth() {
		$tokenInCookie = 'qi8H8R7OM4xMUNMPuRAZxlY';
		$tokenInHeader = 'MUNMPuRAZxlYqi8H8R7OM4x';

		$this->request->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $tokenInCookie );

		$this->request->expects( $this->any() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( $tokenInHeader );

		$this->assertEquals( $this->cookieHelper->getAccessToken( $this->request ), $tokenInCookie );
	}

	public function testGetAccessTokenNoCookieNoAuthorizationHeader() {
		$this->request->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->request->expects( $this->once() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );
	}

	public function testGetAccessTokenNoCookieMalformedAuthorizationHeader() {
		$this->request->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->request->expects( $this->once() )
			->method( 'getHeader' )
			->with( CookieHelper::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( $this->cookieHelper->getAccessToken( $this->request ) );
	}

}
