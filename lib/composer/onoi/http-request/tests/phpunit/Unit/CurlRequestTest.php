<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\CurlRequest;

/**
 * @covers \Onoi\HttpRequest\CurlRequest
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CurlRequestTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new CurlRequest( curl_init() );

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\CurlRequest',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\HttpRequest',
			$instance
		);
	}

	public function testWrongResourceTypeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new CurlRequest( curl_multi_init() );
	}

	public function testPing() {

		$instance = new CurlRequest( curl_init() );

		$this->assertFalse(
			$instance->ping()
		);

		$instance->setOption( CURLOPT_URL, 'http://example.org' );

		$this->assertInternalType(
			'boolean',
			$instance->ping()
		);
	}

	public function testGetLastError() {

		$instance = new CurlRequest( curl_init() );

		$this->assertInternalType(
			'string',
			$instance->getLastError()
		);
	}

	public function testGetLastErrorCode() {

		$instance = new CurlRequest( curl_init() );

		$this->assertInternalType(
			'integer',
			$instance->getLastErrorCode()
		);
	}

	public function testExecuteForNullUrl() {

		$instance = new CurlRequest( curl_init( null ) );
		$instance->setOption( CURLOPT_RETURNTRANSFER, true );

		$this->assertTrue(
			$instance->getOption( CURLOPT_RETURNTRANSFER )
		);

		$this->assertFalse(
			$instance->execute()
		);

		$this->assertNull(
			$instance->getOption( CURLOPT_RETURNTRANSFER )
		);

		$this->assertEmpty(
			$instance->getLastTransferInfo( CURLINFO_HTTP_CODE )
		);
	}

	public function testSetOptionUsingOnoiSpecificConstantDoesNotCauseAnyFailureWithCurl_Setopt() {

		$instance = new CurlRequest( curl_init( null ) );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, 42 );

		$this->assertEquals(
			42,
			$instance->getOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL )
		);
	}

}
