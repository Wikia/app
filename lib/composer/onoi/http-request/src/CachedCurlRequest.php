<?php

namespace Onoi\HttpRequest;

use Onoi\Cache\Cache;

/**
 * Simple cache layer from the client-side to avoid repeated requests to
 * the same target.
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CachedCurlRequest extends CurlRequest {

	/**
	 * Fixed constant
	 */
	const CACHE_PREFIX = 'onoi:http:';

	/**
	 * @var Cache
	 */
	private $cache;

	/**
	 * @var boolean
	 */
	private $isFromCache = false;

	/**
	 * @since  1.0
	 *
	 * @param resource $handle
	 * @param Cache $cache
	 */
	public function __construct( $handle, Cache $cache ) {
		parent::__construct( $handle );

		$this->cache = $cache;
		$this->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, 60 ); // 60 sec by default
		$this->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX, '' );
	}

	/**
	 * @deprecated since 1.3, use option ONOI_HTTP_REQUEST_RESPONSECACHE_TTL instead
	 * @since  1.0
	 *
	 * @param integer $expiry
	 */
	public function setExpiryInSeconds( $expiry ) {
		$this->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, (int)$expiry );
	}

	/**
	 * @deprecated since 1.3, use option ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX instead
	 * @since  1.0
	 *
	 * @param string $cachePrefix
	 */
	public function setCachePrefix( $cachePrefix ) {
		$this->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX, (string)$cachePrefix );
	}

	/**
	 * @deprecated since 1.3, use CachedCurlRequest::isFromCache instead
	 * @since  1.0
	 *
	 * @return boolean
	 */
	public function isCached() {
		return $this->isFromCache();
	}

	/**
	 * @since  1.3
	 *
	 * @return boolean
	 */
	public function isFromCache() {
		return $this->isFromCache;
	}

	/**
	 * @since  1.0
	 *
	 * @return mixed
	 */
	public function execute() {

		list( $key, $expiry ) = $this->getKeysFromOptions();
		$this->isFromCache = false;

		if ( $this->cache->contains( $key ) ) {
			$this->isFromCache = true;
			return $this->cache->fetch( $key );
		}

		$response = parent::execute();

		// Do not cache any failed response
		if ( $this->getLastErrorCode() !== 0 ) {
			return $response;
		}

		$this->cache->save(
			$key,
			$response,
			$expiry
		);

		return $response;
	}

	private function getKeysFromOptions() {

		// curl_init can provide the URL which will set the value to the
		// CURLOPT_URL option, ensure to have the URL as part of the options
		// independent from where/when it was set
		$this->setOption(
			CURLOPT_URL,
			$this->getLastTransferInfo( CURLINFO_EFFECTIVE_URL )
		);

		// Avoid an unsorted order that would create unstable keys
		ksort( $this->options );

		$expiry = $this->getOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL );
		$prefix = $this->getOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX );

		$key = $prefix . self::CACHE_PREFIX . md5(
			json_encode( $this->options )
		);

		// Reuse the handle but clear the options
		$this->options = array();

		return array( $key, $expiry );
	}

}
