<?php

namespace Wikia\Helios;

use Wikia\Service\Helios\HeliosClientImpl;


class HeliosClientTest extends \WikiaBaseTest {

	public function setUp()
	{

		parent::setUp();
	}

	public function testCannotMakeRequests()
	{
		$this->setExpectedException('Wikia\Util\AssertionException');

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', false );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testInvalidResponse()
	{
		$this->setExpectedException('Wikia\Service\Helios\ClientException','Invalid Helios response.');

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( null );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testSuccess()
	{
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( '{}' );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$this->assertInternalType( 'object', $client->request( 'resource', [], [], [] ) );
	}

}
