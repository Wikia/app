<?php

namespace Wikia\Helios;

class UserTest extends \WikiaBaseTest {

	private $webRequestMock;

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		$this->webRequestMock = $this->getMock( '\WebRequest', [ 'getHeader' ], [], '', false );
		$this->mockGlobalVariable( 'wgHeliosLoginSamplingRate', 100 );
		$this->mockGlobalVariable( 'wgHeliosLoginShadowMode', false );
		User::purgeAuthenticationCache();

		parent::setUp();
	}

	public function testNewFromTokenNoAuthorizationHeader()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( false );

		$this->assertNull( User::newFromToken( $this->webRequestMock ) );
	}

	public function testNewFromTokenMalformedAuthorizationHeader()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Malformed' );

		$this->assertNull( User::newFromToken( $this->webRequestMock ) );
	}

	public function testNewFromTokenAuthorizationGranted()
	{
		$this->webRequestMock->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Bearer qi8H8R7OM4xMUNMPuRAZxlY' );

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
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Bearer qi8H8R7OM4xMUNMPuRAZxlY' );

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
