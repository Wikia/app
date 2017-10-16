<?php

namespace Onoi\HttpRequest\Tests\Integration;

use Onoi\HttpRequest\CachedCurlRequest;
use Onoi\HttpRequest\CurlRequest;
use Onoi\Cache\FixedInMemoryLruCache;

/**
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class RequestToExternalUrlTest extends \PHPUnit_Framework_TestCase {

	public function testCachedRequestToExternalUrl() {

		$target = 'http://example.org/';

		$cache = new FixedInMemoryLruCache();

		$instance = new CachedCurlRequest(
			curl_init( $target ),
			$cache
		);

		if ( !$instance->ping() ) {
			$this->markTestSkipped( "Can't connect to " . $target );
		}

		$instance->setOption( CURLOPT_RETURNTRANSFER, true );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, 42 );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX, 'foo' );

		$this->assertInternalType(
			'string',
			$instance->execute()
		);

		$this->assertFalse(
			$instance->isFromCache()
		);

		// Repeated request
		$instance->setOption( CURLOPT_RETURNTRANSFER, true );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, 42 );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX, 'foo' );

		$instance->execute();

		$this->assertTrue(
			$instance->isFromCache()
		);
	}

}
