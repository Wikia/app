<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\MultiCurlRequest;
use Onoi\HttpRequest\CurlRequest;

/**
 * @covers \Onoi\HttpRequest\MultiCurlRequest
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class MultiCurlRequestTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\HttpRequest',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\MultiCurlRequest',
			$instance
		);
	}

	public function testWrongResourceTypeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new MultiCurlRequest( curl_init() );
	}

	public function testPingForEmptyHttpRequest() {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$this->assertFalse(
			$instance->ping()
		);
	}

	/**
	 * @dataProvider pingConnectionStateProvider
	 */
	public function testPingConnectionState( $connectionState ) {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$httpRequest = $this->getMockBuilder( '\Onoi\HttpRequest\CurlRequest' )
			->disableOriginalConstructor()
			->getMock();

		$httpRequest->expects( $this->once() )
			->method( 'ping' )
			->will( $this->returnValue( $connectionState ) );

		$instance->addHttpRequest(
			$httpRequest
		);

		$this->assertEquals(
			$connectionState,
			$instance->ping()
		);
	}

	public function testSetGetOption() {

		// https://github.com/facebook/hhvm/issues/5761
		if ( !defined( 'CURLMOPT_MAXCONNECTS' ) ) {
			$this->markTestSkipped( "Option is not supported for current PHP version" );
		}

		$instance = new MultiCurlRequest( curl_multi_init() );

		$instance->setOption(
			CURLMOPT_MAXCONNECTS,
			5
		);

		$this->assertSame(
			5,
			$instance->getOption( CURLMOPT_MAXCONNECTS )
		);
	}

	public function testExecuteForResponse() {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$instance->addHttpRequest(
			new CurlRequest( curl_init() )
		);

		$this->assertInternalType(
			'array',
			$instance->execute()
		);

		$this->assertInternalType(
			'string',
			$instance->getLastError()
		);

		// http://php.net/manual/en/function.curl-multi-info-read.php
		$this->assertFalse(
			$instance->getLastTransferInfo()
		);
	}

	public function testDeprecatedSetCallback() {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$instance->addHttpRequest(
			new CurlRequest( curl_init() )
		);

		$requestResponse = null;

		$instance->setCallback( function( $requestResponseCompleted ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseCompleted;
		} );

		$instance->execute();

		$this->assertRequestResponse( $requestResponse );
	}

	public function testOnCompletedCallback() {

		$instance = new MultiCurlRequest( curl_multi_init() );

		$instance->addHttpRequest(
			new CurlRequest( curl_init() )
		);

		$requestResponse = null;

		$instance->setOption( ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK, function( $requestResponseCompleted ) use ( &$requestResponse ) {
			$requestResponse = $requestResponseCompleted;
		} );

		$instance->execute();

		$this->assertSame(
			0,
			$instance->getLastErrorCode()
		);

		$this->assertRequestResponse( $requestResponse );
	}

	private function assertRequestResponse( $requestResponse ) {

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\RequestResponse',
			$requestResponse
		);

		$expectedRequestResponseFields = array(
			'contents',
			'info'
		);

		foreach ( $expectedRequestResponseFields as $field ) {
			$this->assertTrue( $requestResponse->has( $field ) );
		}
	}

	public function pingConnectionStateProvider() {

		$provider[] = array(
			true
		);

		$provider[] = array(
			false
		);

		return $provider;
	}

}
