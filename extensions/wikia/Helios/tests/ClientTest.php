<?php

namespace Wikia\Helios;

class ClientTest extends \WikiaBaseTest {

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		parent::setUp();
	}

	public function testCannotMakeRequests()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', false );

		try {
			$oClient = new Client( 'http://example.com', 'id', 'secret' );
			$oClient->request( 'resource', [], [], [] );
		}

		catch ( \Wikia\Util\AssertionException $e ) {
			return;
		}

		$this->fail( 'An expected exception has not been raised.' );
	}

	public function testRequestFailed()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$oStatusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$oStatusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( false );

		$oRequestMock = $this->getMock( '\CurlHttpRequest', [ 'execute' ], [ 'http://example.com' ], '', false );
		$oRequestMock->expects( $this->once() )
			->method( 'execute' )
			->willReturn( $oStatusMock );

		$this->mockStaticMethod( '\MWHttpRequest', 'factory', $oRequestMock );

		try {
			$oClient = new Client( 'http://example.com', 'id', 'secret' );
			$oClient->request( 'resource', [], [], [] );
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			if ( $e->getMessage() == 'Request failed.' ) {
				return;
			}
			$this->fail( "Wrong exception message. Expected: 'Request failed., actual: '{$e->getMessage()}'." );
		}

		$this->fail( 'An expected exception has not been raised.' );
	}

	public function testInvalidResponse()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$oStatusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$oStatusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( true );

		$oRequestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$oRequestMock->expects( $this->once() )
			->method( 'execute' )
			->willReturn( $oStatusMock );
		$oRequestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( null );

		$this->mockStaticMethod( '\MWHttpRequest', 'factory', $oRequestMock );

		try {
			$oClient = new Client( 'http://example.com', 'id', 'secret' );
			$oClient->request( 'resource', [], [], [] );
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			if ( $e->getMessage() == 'Invalid response.' ) {
				return;
			}
			$this->fail( "Wrong exception message. Expected: 'Invalid response., actual: '{$e->getMessage()}'." );
		}

		$this->fail( 'An expected exception has not been raised.' );
	}

	public function testSuccess()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$oStatusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$oStatusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( true );

		$oRequestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$oRequestMock->expects( $this->once() )
			->method( 'execute' )
			->willReturn( $oStatusMock );
		$oRequestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( '{}' );

		$this->mockStaticMethod( '\MWHttpRequest', 'factory', $oRequestMock );

		$oClient = new Client( 'http://example.com', 'id', 'secret' );
		$this->assertInternalType( 'object', $oClient->request( 'resource', [], [], [] ) );
	}

}
