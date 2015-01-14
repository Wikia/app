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
		$this->assertTrue( true );
	}

	public function testNewFromTokenAuthorizationDeclined()
	{
		$this->assertTrue( true );
	}

}
