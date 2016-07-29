<?php

namespace Onoi\HttpRequest\Tests\Exception;

use Onoi\HttpRequest\CurlRequest;
use Onoi\HttpRequest\Exception\BadHttpResponseException;

/**
 * @covers \Onoi\HttpRequest\Exception\BadHttpResponseException
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class BadHttpResponseExceptionTest extends \PHPUnit_Framework_TestCase {

	private $httpRequest;

	protected function setUp() {
		parent::setUp();

		$this->httpRequest = $this->getMockBuilder( '\Onoi\HttpRequest\HttpRequest' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\Exception\BadHttpResponseException',
			new BadHttpResponseException( $this->httpRequest )
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\Exception\HttpConnectionException',
			new BadHttpResponseException( $this->httpRequest )
		);
	}

	public function testHttpError() {

		$this->httpRequest->expects( $this->once() )
			->method( 'getLastErrorCode' )
			->will( $this->returnValue( 22 ) );

		$this->httpRequest->expects( $this->once() )
			->method( 'getLastTransferInfo' )
			->with( $this->equalTo( CURLINFO_HTTP_CODE ) );

		new BadHttpResponseException( $this->httpRequest );
	}

	public function testLastError() {

		$this->httpRequest->expects( $this->once() )
			->method( 'getLastErrorCode' )
			->will( $this->returnValue( 42 ) );

		$this->httpRequest->expects( $this->once() )
			->method( 'getLastError' );

		new BadHttpResponseException( $this->httpRequest );
	}

	public function testForCurlRequest() {

		$curlRequest = new CurlRequest( curl_init( null ) );
		$curlRequest->setOption( CURLOPT_RETURNTRANSFER, true );

		$curlRequest->execute();

		$e = new BadHttpResponseException( $curlRequest );

		$this->assertContains(
			'error 3',
			$e->getMessage()
		);
	}

}
