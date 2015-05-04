<?php

namespace Wikia\Helios;

class UserTest extends \WikiaBaseTest {

	private $webRequestMock;

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		$this->webRequestMock = $this->getMock( '\WebRequest', [ 'getHeader', 'getCookie' ], [], '', false );
		$this->mockGlobalVariable( 'wgHeliosLoginSamplingRate', 100 );
		$this->mockGlobalVariable( 'wgHeliosLoginShadowMode', false );
		User::purgeAuthenticationCache();

		parent::setUp();
	}

	public function testGetAccessTokenFromCookie()
	{
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $token );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $token );
	}

	public function testGetAccessTokenFromAuthorizationHeader()
	{
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( "Bearer $token" );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $token );
	}

	public function testGetAccessTokenFromCookieReturnsNull()
	{
		// No HTTP header
		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( '' );

		// Cookie with no value
		$this->webRequestMock->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( '' );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}

	public function testGetAccessTokenFromHeaderReturnsNull()
	{
		// No Cookie
		$this->webRequestMock->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( null );

		// Header with no value
		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( '' );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( null );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Bearer ' );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}


	public function testGetAccessTokenCookiePrecedenceIfBoth()
	{
		$tokenInCookie = 'qi8H8R7OM4xMUNMPuRAZxlY';
		$tokenInHeader = 'MUNMPuRAZxlYqi8H8R7OM4x';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $tokenInCookie );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( "Bearer $tokenInHeader" );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $tokenInCookie );
	}

	public function testGetAccessTokenNoCookieNoAuthorizationHeader()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}

	public function testGetAccessTokenNoCookieMalformedAuthorizationHeader()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Malformed' );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}

	public function testNewFromTokenAuthorizationGranted()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new \StdClass;
		$userInfo->user_id = 1;

		$oClientMock = $this->getMock( 'Client', [ 'info' ], [], '', false );
		$oClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$this->mockClass( 'Wikia\Helios\Client', $oClientMock );

		$this->assertEquals( User::newFromToken( $this->webRequestMock ), \User::newFromId( 1 ) );
	}

	public function testNewFromTokenAuthorizationDeclined()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new \StdClass;

		$clientMock = $this->getMock( 'Wikia\Helios\Client', [ 'info' ], [], '', false );
		$clientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$this->mockClass( 'Wikia\Helios\Client', $clientMock );

		$this->assertNull( User::newFromToken( $this->webRequestMock ) );
	}

	public function testAuthenticateAuthenticationFailed()
	{
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->getMock( 'Wikia\Helios\Client', [ 'login' ], [], '', false );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( new \StdClass );
		$this->mockClass( 'Wikia\Helios\Client', $client );

		$this->assertFalse( User::authenticate( $username, $password ) );
	}

	public function testAuthenticateAuthenticationImpossible()
	{
		$this->setExpectedException('Wikia\Helios\ClientException','test');
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->getMock( 'Wikia\Helios\Client', [ 'login' ], [], '', false );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->will( $this->throwException( new ClientException( 'test' ) ) );
		$this->mockClass( 'Wikia\Helios\Client', $client );

		User::authenticate( $username, $password );
	}

	public function testAuthenticateAuthenticationSucceded()
	{
		$username = 'SomeName';
		$password = 'Password';

		$loginInfo = new \StdClass;
		$loginInfo->access_token = 'orvb9pM6wX';

		$client = $this->getMock( 'Wikia\Helios\Client', [ 'login' ], [], '', false );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( $loginInfo );
		$this->mockClass( 'Wikia\Helios\Client', $client );

		$this->assertTrue( User::authenticate( $username, $password ) );
	}

}
