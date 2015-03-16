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

		$client = new Client( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testRequestFailed()
	{
		$this->setExpectedException('Wikia\Helios\ClientException','Request failed.');

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$statusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$statusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( false );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute' ], [ 'http://example.com' ], '', false );
		$requestMock->status = $statusMock;

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new Client( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testInvalidResponse()
	{
		$this->setExpectedException('Wikia\Helios\ClientException','Invalid response.');

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$statusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$statusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->status = $statusMock;
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( null );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new Client( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testSuccess()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$statusMock = $this->getMock( '\Status', [ 'isGood' ], [], '', true );
		$statusMock->expects( $this->once() )
			->method( 'isGood' )
			->willReturn( true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->status = $statusMock;
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( '{}' );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new Client( 'http://example.com', 'id', 'secret' );
		$this->assertInternalType( 'object', $client->request( 'resource', [], [], [] ) );
	}

}
