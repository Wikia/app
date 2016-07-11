<?php

namespace Onoi\HttpRequest\Tests\Exception;

use Onoi\HttpRequest\CurlRequest;
use Onoi\HttpRequest\Exception\HttpConnectionException;

/**
 * @covers \Onoi\HttpRequest\Exception\HttpConnectionException
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HttpConnectionExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\Exception\HttpConnectionException',
			new HttpConnectionException()
		);
	}

	public function testErrorMessage() {

		$e = new HttpConnectionException( 'foo', 42 );

		$this->assertContains(
			'foo',
			$e->getMessage()
		);
	}

}
