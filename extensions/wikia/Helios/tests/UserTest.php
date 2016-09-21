<?php

namespace Wikia\Helios;

use DI\Container;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;

class UserTest extends \WikiaBaseTest {

	private $webRequestMock;

	/** @var Container */
	private $container;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Helios.setup.php';
		parent::setUp();
		$this->webRequestMock = $this->getMock( '\WebRequest', [ 'getHeader', 'getCookie' ], [ ], '', false );
		$this->mockGlobalVariable( 'wgHeliosLoginSamplingRate', 100 );
		$this->mockGlobalVariable( 'wgHeliosLoginShadowMode', false );
		User::purgeAuthenticationCache();

		$this->container = ( new InjectorBuilder() )
			->bind( HeliosClient::class )->to( function () {
				return
					$this->getMock( 'Wikia\Service\Helios\HeliosClient',
						[ ],
						[ ],
						'',
						false );
			} )->build();

		$this->mockStaticMethod( '\Wikia\Helios\User', 'getHeliosClient', $this->container->get( HeliosClient::class ) );


	}

	public function testGetAccessTokenFromCookie() {
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $token );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $token );
	}

	public function testGetAccessTokenFromAuthorizationHeader() {
		$token = 'qi8H8R7OM4xMUNMPuRAZxlY';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( $token );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $token );
	}

	public function testGetAccessTokenFromCookieReturnsNull() {
		// No HTTP header
		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
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

	public function testGetAccessTokenFromHeaderReturnsNull() {
		// No Cookie
		$this->webRequestMock->expects( $this->any() )
			->method( 'getCookie' )
			->willReturn( null );

		// Header with no value
		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( '' );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( null );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}


	public function testGetAccessTokenCookiePrecedenceIfBoth() {
		$tokenInCookie = 'qi8H8R7OM4xMUNMPuRAZxlY';
		$tokenInHeader = 'MUNMPuRAZxlYqi8H8R7OM4x';

		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( $tokenInCookie );

		$this->webRequestMock->expects( $this->any() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( $tokenInHeader );

		$this->assertEquals( User::getAccessToken( $this->webRequestMock ), $tokenInCookie );
	}

	public function testGetAccessTokenNoCookieNoAuthorizationHeader() {
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}

	public function testGetAccessTokenNoCookieMalformedAuthorizationHeader() {
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( null );

		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( User::ACCESS_TOKEN_HEADER_NAME )
			->willReturn( false );

		$this->assertNull( User::getAccessToken( $this->webRequestMock ) );
	}

	public function testNewFromTokenAuthorizationGranted() {
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new \StdClass;
		$userInfo->user_id = 1;

		$oClientMock = $this->container->get( HeliosClient::class );
		$oClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $oClientMock );

		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getGlobalFlag' ] )
			->getMock();
		$userMock->expects( $this->once() )
			->method( 'getGlobalFlag' )
			->with( $this->equalTo( 'disabled' ) )
			->will( $this->returnValue( false ) );

		$this->mockClass( 'User', $userMock );

		$this->assertEquals( User::newFromToken( $this->webRequestMock ), \User::newFromId( 1 ) );
	}

	public function testNewFromTokenAuthorizationDeclined() {
		$this->webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new \StdClass;

		$clientMock = $this->container->get( HeliosClient::class );
		$clientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $clientMock );

		$this->assertNull( User::newFromToken( $this->webRequestMock ) );
	}

	public function testAuthenticateAuthenticationFailed() {
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [\WikiaResponse::RESPONSE_CODE_OK, new \StdClass] );
		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $client );

		$this->assertFalse( User::authenticate( $username, $password ) );
	}

	public function testAuthenticateAuthenticationImpossible() {
		$this->setExpectedException( 'Wikia\Service\Helios\ClientException', 'test' );
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->will( $this->throwException( new ClientException( 'test' ) ) );
		$this->mockClass( 'Wikia\Helios\Client', $client );

		User::authenticate( $username, $password );
	}

	public function testAuthenticateAuthenticationSucceded() {
		$username = 'SomeName';
		$password = 'Password';

		$loginInfo = new \StdClass;
		$loginInfo->access_token = 'orvb9pM6wX';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [\WikiaResponse::RESPONSE_CODE_OK, $loginInfo] );
		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $client );

		$this->assertTrue( User::authenticate( $username, $password ) );
	}

}
