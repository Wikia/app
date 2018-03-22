<?php

namespace Onoi\HttpRequest\Tests\Integration;

use Onoi\HttpRequest\HttpRequestFactory;
use Onoi\Cache\CacheFactory;
use RuntimeException;

/**
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class RequestToPhpHttpdTest extends \PHPUnit_Framework_TestCase {

	private static $pid;

	/**
	 * @note Using the PHP in-build webserver to serve a slow/fast page response for
	 * validation of the async response
	 *
	 * Options defined in phpunit.xml.dist
	 * @see https://github.com/vgno/tech.vg.no-1812/blob/master/features/bootstrap/FeatureContext.php
	 */
	public static function setUpBeforeClass() {

		$command = sprintf( 'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
			WEB_SERVER_HOST,
			WEB_SERVER_PORT,
			WEB_SERVER_DOCROOT
		);

		$output = array();
		exec( $command, $output );

		self::$pid = (int) $output[0];
	}

	public static function tearDownAfterClass() {
	//	exec( 'kill ' . (int) self::$pid );
	}

	public function testQueuedResponse() {

		$this->connectToHttpd();
		$expectedToCount = 5;

		$httpRequestFactory = new HttpRequestFactory();
		$multiCurlRequest = $httpRequestFactory->newMultiCurlRequest();

		for ( $i = 0; $i < $expectedToCount; $i++ ) {
			$multiCurlRequest->addHttpRequest(
				$httpRequestFactory->newCurlRequest( $this->getHttpdRequestUrl( $i ) )
			);
		}

		$this->assertCount(
			$expectedToCount,
			$multiCurlRequest->execute()
		);
	}

	public function testCachedMultiCurlQueuedResponse() {

		$this->connectToHttpd();
		$expectedToCount = 5;

		$cacheFactory = new CacheFactory();

		$httpRequestFactory = new HttpRequestFactory(
			$cacheFactory->newFixedInMemoryLruCache()
		);

		$multiCurlRequest = $httpRequestFactory->newMultiCurlRequest();

		for ( $i = 0; $i < $expectedToCount; $i++ ) {
			$multiCurlRequest->addHttpRequest(
				$httpRequestFactory->newCachedCurlRequest( $this->getHttpdRequestUrl( $i ) )
			);
		}

		$this->assertCount(
			$expectedToCount,
			$multiCurlRequest->execute()
		);
	}

	public function testMultiCurlForCallbackResponse() {

		$this->connectToHttpd();
		$expectedToCount = 5;

		$asyncCallbackResponseMock = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'run' ) )
			->getMock();

		$asyncCallbackResponseMock->expects( $this->exactly( $expectedToCount ) )
			->method( 'run' );

		$httpRequestFactory = new HttpRequestFactory();
		$multiCurlRequest = $httpRequestFactory->newMultiCurlRequest();

		$multiCurlRequest->setOption( ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK, function( $requestResponse ) use ( $asyncCallbackResponseMock ) {
			$asyncCallbackResponseMock->run( $requestResponse );
		} );

		for ( $i = 0; $i < $expectedToCount; $i++ ) {
			$multiCurlRequest->addHttpRequest(
				$httpRequestFactory->newCurlRequest( $this->getHttpdRequestUrl( $i ) )
			);
		}

		$multiCurlRequest->execute();
	}

	public function testSocketResponse() {

		$this->connectToHttpd();
		$expectedToCount = 1;

		$asyncCallbackResponseMock = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'run' ) )
			->getMock();

		$asyncCallbackResponseMock->expects( $this->exactly( $expectedToCount ) )
			->method( 'run' );

		$httpRequestFactory = new HttpRequestFactory();
		$socketRequest = $httpRequestFactory->newSocketRequest();

		$socketRequest->setOption( ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT, 5 );
		$socketRequest->setOption( ONOI_HTTP_REQUEST_CONNECTION_FAILURE_REPEAT, 2 );

		$socketRequest->setOption( ONOI_HTTP_REQUEST_METHOD, 'GET' );
		$socketRequest->setOption( ONOI_HTTP_REQUEST_URL, WEB_SERVER_HOST . ':' .  WEB_SERVER_PORT . '/plain.php' );

		$socketRequest->ping();

		$socketRequest->setOption( ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK, function( $requestResponse ) use ( $asyncCallbackResponseMock ) {
			$asyncCallbackResponseMock->run( $requestResponse );
		} );

		$socketRequest->execute();
	}

	private function getHttpdRequestUrl( $id ) {

		// slow/fast example used from https://gist.github.com/Xeoncross/2362936

		if ( $id % 2 ) {
			return WEB_SERVER_HOST . ':' .  WEB_SERVER_PORT . '/slow.php?id=' . $id;
		}

		return WEB_SERVER_HOST . ':' .  WEB_SERVER_PORT . '/fast.php?id=' . $id;
	}

	private function connectToHttpd() {

		$start = microtime(true);

		// Try to connect
		while ( microtime( true ) - $start <= 10 ) {
			if ( $this->canConnectToHttpd() ) {
				break;
			}
		}
	}

	private function canConnectToHttpd() {

		$sp = @fsockopen( WEB_SERVER_HOST, WEB_SERVER_PORT );

		if ( $sp === false ) {
			return false;
		}

		fclose( $sp );

		return true;
	}

}
