<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\SocketRequest;

/**
 * @covers \Onoi\HttpRequest\SocketRequest
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class SocketRequestTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new SocketRequest();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\SocketRequest',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\HttpRequest',
			$instance
		);
	}

	public function testPing() {

		$instance = new SocketRequest();

		$this->assertFalse(
			$instance->ping()
		);

		$instance->setOption( ONOI_HTTP_REQUEST_URL, 'http://example.org' );

		$this->assertInternalType(
			'boolean',
			$instance->ping()
		);
	}

	public function testExecute() {

		$instance = new SocketRequest();
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 1 );
		$instance->setOption( ONOI_HTTP_REQUEST_URL, 'http://localhost:8888' );

		$this->assertInternalType(
			'boolean',
			$instance->execute()
		);
	}

	public function testGetLastError() {

		$instance = new SocketRequest();
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 1 );

		$instance->execute();

		$this->assertInternalType(
			'string',
			$instance->getLastError()
		);
	}

	public function testGetLastErrorCode() {

		$instance = new SocketRequest();

		$this->assertInternalType(
			'integer',
			$instance->getLastErrorCode()
		);
	}

	public function testGetLastTransferInfo() {

		$instance = new SocketRequest();

		$this->assertInternalType(
			'string',
			$instance->getLastTransferInfo()
		);
	}

	public function testCallbackOnRequestNotCompleted() {

		$instance = new SocketRequest();
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 0.1 );

		$requestResponse = null;

		$instance->setOption( ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK, function( $requestResponseFailed ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseFailed;
		} );

		$instance->execute();

		$this->assertRequestResponse( $requestResponse );
	}

	public function testCallbackOnRequestCompleted() {

		$url = 'http://localhost:8080/';

		$instance = new SocketRequest( $url );
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 2 );
		$instance->setOption( ONOI_HTTP_REQUEST_METHOD, 'HEAD' );

		if ( !$instance->ping() ) {
			$this->markTestSkipped( "Skip test because {$url} was not reachable" );
		}

		$requestResponse = null;

		$instance->setOption( ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK, function( $requestResponseCompleted ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseCompleted;
		} );

		$instance->execute();

		$this->assertRequestResponse( $requestResponse );
	}

	public function testTryInvalidCallbackOnRequestCompleted() {

		$instance = new SocketRequest();

		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 0.1 );
		$instance->setOption( ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK, 'foo' );

		$this->assertFalse(
			$instance->execute()
		);
	}

	public function testCallbackOnRequestFailed() {

		$instance = new SocketRequest();
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 0.1 );

		$requestResponse = null;

		$instance->setOption( ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK, function( $requestResponseFailed ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseFailed;
		} );

		$instance->execute();

		$this->assertRequestResponse( $requestResponse );
	}

	public function testCallbackOnRequestNotAccepted() {

		$instance = new SocketRequest();
		$instance->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 2 );

		$instance->ping();

		$requestResponse = null;

		$instance->setOption( ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK, function( $requestResponseFailed ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseFailed;
		} );

		$instance->execute();
		$this->assertRequestResponse( $requestResponse );
	}

	private function assertRequestResponse( $requestResponse ) {

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\RequestResponse',
			$requestResponse
		);

		$expectedRequestResponseFields = array(
			'wasCompleted',
			'responseMessage',
			'host',
			'port',
			'path',
			'connectionFailure',
			'requestProcTime'
		);

		foreach ( $expectedRequestResponseFields as $field ) {
			$this->assertTrue( $requestResponse->has( $field ), 'Failed for ' . $field );
		}
	}

	public function testDefinedConstants() {

		$constants = array(
			'ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK',
			'ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK',
			'ONOI_HTTP_REQUEST_SOCKET_CLIENT_FLAGS',
			'ONOI_HTTP_REQUEST_URL',
			'ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT',
			'ONOI_HTTP_REQUEST_CONNECTION_FAILURE_REPEAT',
			'ONOI_HTTP_REQUEST_CONTENT',
			'ONOI_HTTP_REQUEST_CONTENT_TYPE',
			'ONOI_HTTP_REQUEST_METHOD',
			'ONOI_HTTP_REQUEST_PROTOCOL_VERSION',
			'ONOI_HTTP_REQUEST_SSL_VERIFYPEER',
			'ONOI_HTTP_REQUEST_FOLLOWLOCATION'
		);

		$instance = new SocketRequest();

		foreach ( $constants as $constant ) {
			$this->assertTrue( defined( $constant ) );
		}
	}

}
