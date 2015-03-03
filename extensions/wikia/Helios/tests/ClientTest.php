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
		$this->setExpectedException('Wikia\Util\AssertionException');

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', false );

		$oClient = new Client( 'http://example.com', 'id', 'secret' );
		$oClient->request( 'resource', [], [], [] );
	}

	public function testRequestFailed()
	{
		$this->setExpectedException('Wikia\Helios\ClientException','Request failed.');

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

		$oClient = new Client( 'http://example.com', 'id', 'secret' );
		$oClient->request( 'resource', [], [], [] );
	}

	public function testInvalidResponse()
	{
		$this->setExpectedException('Wikia\Helios\ClientException','Invalid response.');

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

		$oClient = new Client( 'http://example.com', 'id', 'secret' );
		$oClient->request( 'resource', [], [], [] );
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
