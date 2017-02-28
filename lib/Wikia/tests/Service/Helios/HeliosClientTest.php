<?php

namespace Wikia\Helios;

use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClientImpl;
use Wikia\Util\AssertionException;


class HeliosClientTest extends \WikiaBaseTest {

	public function setUp() {

		parent::setUp();
	}

	/**
	 * @expectedException AssertionException
	 */
	public function testCannotMakeRequests() {
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', false );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	/**
	 * @expectedException ClientException
	 * @expectedExceptionMessage Invalid Helios response
	 */
	public function testInvalidResponse() {
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( null );

		$requestMock->status = $this->getMock( '\Status', [ 'isOK', 'getErrorsArray', 'hasMessage' ] );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testSuccess() {
		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( '{}' );

		$requestMock->status = $this->getMock( '\Status', [ 'isOK', 'getErrorsArray', 'hasMessage' ] );
		$requestMock->status->expects( $this->any() )->method( 'hasMessage' )->willReturn( false );

		// With no error message, we expect no retries, hence \Http::request should be called only once.
		$this->getStaticMethodMock( '\Http', 'request' )->expects( $this->once() )
			->method( 'request' )
			->willReturn( $requestMock );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$this->assertInternalType( 'object', $client->request( 'resource', [], [], [] ) );
	}

	public function testRetry() {
		// To reduce the unit test time, mock the 'sleep' method called between retries.
		$this->mockGlobalFunction( 'sleep', null );

		$this->mockStaticMethod( '\MWHttpRequest', 'canMakeRequests', true );

		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( '{}' );

		$requestMock->status = $this->getMock( '\Status', [ 'isOK', 'getErrorsArray', 'hasMessage' ] );
		$requestMock->status->expects( $this->any() )->method( 'hasMessage' )->willReturn( true );

		// Retries are base on status->hasMessage value, so we expect two calls to \Http::request here.
		$this->getStaticMethodMock( '\Http', 'request' )->expects( $this->exactly( 2 ) )
			->method( 'request' )
			->willReturn( $requestMock );

		$client = new HeliosClientImpl( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

}
