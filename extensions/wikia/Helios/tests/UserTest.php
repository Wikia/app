<?php

namespace Wikia\Helios;

class UserTest extends \WikiaBaseTest {

	private $oRequest;

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		parent::setUp();
		$this->oRequest = $this->getMock( '\WebRequest', [ 'getHeader' ], [], '', false );
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

}
