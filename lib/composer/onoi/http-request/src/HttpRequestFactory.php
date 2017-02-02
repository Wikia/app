<?php

namespace Onoi\HttpRequest;

use Onoi\Cache\Cache;
use Onoi\Cache\NullCache;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HttpRequestFactory {

	/**
	 * @var Cache
	 */
	private $cache = null;

	/**
	 * @since 1.0
	 *
	 * @param Cache|null $cache
	 */
	public function __construct( Cache $cache = null ) {
		$this->cache = $cache;

		if ( $this->cache === null ) {
			$this->cache = new NullCache();
		}
	}

	/**
	 * @since 1.0
	 *
	 * @return NullRequest
	 */
	public function newNullRequest() {
		return new NullRequest();
	}

	/**
	 * @since 1.0
	 *
	 * @param string|null $url
	 *
	 * @return CurlRequest
	 */
	public function newCurlRequest( $url = null ) {
		return new CurlRequest( curl_init( $url ) );
	}

	/**
	 * @since 1.0
	 *
	 * @param string|null $url
	 *
	 * @return CachedCurlRequest
	 */
	public function newCachedCurlRequest( $url = null ) {
		return new CachedCurlRequest( curl_init( $url ), $this->cache );
	}

	/**
	 * @since 1.0
	 *
	 * @return MultiCurlRequest
	 */
	public function newMultiCurlRequest() {
		return new MultiCurlRequest( curl_multi_init() );
	}

	/**
	 * @since 1.1
	 *
	 * @param string|null $url
	 *
	 * @return SocketRequest
	 */
	public function newSocketRequest( $url = null ) {
		return new SocketRequest( $url );
	}

}
