<?php

namespace Wikia\Helios;

use PHPUnit\Framework\TestCase;
use Wikia\Service\Helios\HeliosClient;


class HeliosClientTest extends TestCase {
	use \HttpIntegrationTest;

	/** @var HeliosClient $heliosClient */
	private $heliosClient;

	public function setUp() {
		parent::setUp();

		$this->heliosClient = new HeliosClient( "http://{$this->getMockUrl()}", 'secret' );
	}
	/**
	 * @expectedException \Wikia\Service\Helios\ClientException
	 * @expectedExceptionMessage Invalid Helios response
	 */
	public function testInvalidResponse() {
		$requestMock = $this->getMock( '\CurlHttpRequest', [ 'execute', 'getContent' ], [ 'http://example.com' ], '', false );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->willReturn( null );

		$requestMock->status = $this->getMock( '\Status', [ 'isOK', 'getErrorsArray', 'hasMessage' ] );

		$this->mockStaticMethod( '\Http', 'request', $requestMock );

		$client = new HeliosClient( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

	public function testSuccess() {
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

		$client = new HeliosClient( 'http://example.com', 'id', 'secret' );
		$this->assertInternalType( 'object', $client->request( 'resource', [], [], [] ) );
	}

	public function testRetry() {
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

		$client = new HeliosClient( 'http://example.com', 'id', 'secret' );
		$client->request( 'resource', [], [], [] );
	}

}
