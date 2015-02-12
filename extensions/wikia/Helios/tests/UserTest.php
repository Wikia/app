<?php

namespace Wikia\Helios;

class UserTest extends \WikiaBaseTest {

	private $oRequest;

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		$this->oRequest = $this->getMock( '\WebRequest', [ 'getHeader' ], [], '', false );
		$this->mockGlobalVariable( 'wgHeliosLoginSamplingRate', 100 );
		$this->mockGlobalVariable( 'wgHeliosLoginShadowMode', false );
		parent::setUp();
	}

	public function testNewFromTokenNoAuthorizationHeader()
	{
		$this->oRequest->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( false );

		$this->assertNull( User::newFromToken( $this->oRequest ) );
	}

	public function testNewFromTokenMalformedAuthorizationHeader()
	{
		$this->oRequest->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Malformed' );

		$this->assertNull( User::newFromToken( $this->oRequest ) );
	}

	public function testNewFromTokenAuthorizationGranted()
	{
		$this->oRequest->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Bearer qi8H8R7OM4xMUNMPuRAZxlY' );

		$oUser = new \StdClass;
		$oUser->user_id = 1;

		$oClientMock = $this->getMock( 'Client', [ 'info' ], [], '', false );
		$oClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $oUser );

		$this->mockClass( 'Wikia\Helios\Client', $oClientMock );

		$this->assertEquals( User::newFromToken( $this->oRequest ), \User::newFromId( 1 ) );
	}

	public function testNewFromTokenAuthorizationDeclined()
	{
		$this->oRequest->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'AUTHORIZATION' )
			->willReturn( 'Bearer qi8H8R7OM4xMUNMPuRAZxlY' );

		$oUser = new \StdClass;

		$oClientMock = $this->getMock( 'Client', [ 'info' ], [], '', false );
		$oClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $oUser );

		$this->mockClass( 'Wikia\Helios\Client', $oClientMock );

		$this->assertNull( User::newFromToken( $this->oRequest ) );
	}

	public function testAuthenticateAuthenticationFailed()
	{
		$sUserName = 'SomeName';
		$sPassword = 'Password';


		$oClient = $this->getMock( 'Client', [ 'login' ], [], '', false );
		$oClient->expects( $this->once() )
			->method( 'login' )
			->with( 'SomeName', 'Password' )
			->willReturn( new \StdClass );
		$this->mockClass( 'Wikia\Helios\Client', $oClient );

		$this->assertFalse( User::authenticate( $sUserName, $sPassword ) );
	}

	public function testAuthenticateAuthenticationImpossible()
	{
		$sUserName = 'SomeName';
		$sPassword = 'Password';

		$oClient = $this->getMock( 'Client', [ 'login' ], [], '', false );
		$oClient->expects( $this->once() )
			->method( 'login' )
			->with( 'SomeName', 'Password' )
			->will( $this->throwException( new ClientException ) );
		$this->mockClass( 'Wikia\Helios\Client', $oClient );

		$this->assertFalse( User::authenticate( $sUserName, $sPassword ) );
	}

	public function testAuthenticateAuthenticationSucceded()
	{
		$sUserName = 'SomeName';
		$sPassword = 'Password';

		$oLogin = new \StdClass;
		$oLogin->access_token = 'orvb9pM6wX';

		$oClient = $this->getMock( 'Client', [ 'login' ], [], '', false );
		$oClient->expects( $this->once() )
			->method( 'login' )
			->with( 'SomeName', 'Password' )
			->willReturn( $oLogin );
		$this->mockClass( 'Wikia\Helios\Client', $oClient );

		$this->assertTrue( User::authenticate( $sUserName, $sPassword ) );
	}

}
