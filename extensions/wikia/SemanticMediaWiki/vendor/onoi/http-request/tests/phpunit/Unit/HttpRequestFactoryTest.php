<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\HttpRequestFactory;

/**
 * @covers \Onoi\HttpRequest\HttpRequestFactory
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HttpRequestFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new HttpRequestFactory();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\HttpRequestFactory',
			$instance
		);
	}

	public function testCanConstructNullRequest() {

		$instance = new HttpRequestFactory();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\NullRequest',
			$instance->newNullRequest()
		);
	}

	public function testCanConstructCurlRequest() {

		$instance = new HttpRequestFactory();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\CurlRequest',
			$instance->newCurlRequest()
		);
	}

	public function testCanConstructCachedCurlRequest() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance = new HttpRequestFactory( $cache );

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\CachedCurlRequest',
			$instance->newCachedCurlRequest()
		);
	}

	public function testCanConstructMultiCurlRequest() {

		$instance = new HttpRequestFactory();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\MultiCurlRequest',
			$instance->newMultiCurlRequest()
		);
	}

	public function testCanConstructSocketRequest() {

		$instance = new HttpRequestFactory();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\SocketRequest',
			$instance->newSocketRequest()
		);
	}

}
