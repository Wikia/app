<?php

/**
 * A wrapper class for the pure-PHP memcached client, exposing a BagOStuff interface.
 */
class MemcachedPhpBagOStuff extends MemcachedBagOStuff {

	protected $client;

	/**
	 * Constructor.
	 *
	 * Available parameters are:
	 *   - servers:             The list of IP:port combinations holding the memcached servers.
	 *   - debug:               Whether to set the debug flag in the underlying client.
	 *   - persistent:          Whether to use a persistent connection
	 *   - compress_threshold:  The minimum size an object must be before it is compressed
	 *   - timeout:             The read timeout in microseconds
	 *   - connect_timeout:     The connect timeout in seconds
	 *
	 * @param $params array
	 */
	function __construct( $params ) {
		$params = $this->applyDefaultParams( $params );

		$this->client = new MemCachedClientforWiki( $params );
		$this->client->set_servers( $params['servers'] );
		$this->client->set_debug( $params['debug'] );
	}

	/**
	 * @param $debug bool
	 */
	public function setDebug( $debug ) {
		$this->client->set_debug( $debug );
	}

	/**
	 * @param $key
	 * @param $timeout int
	 * @return bool
	 */
	public function lock( $key, $timeout = 0 ) {
		return $this->client->lock( $this->encodeKey( $key ), $timeout );
	}

	/**
	 * @param $key string
	 * @return Mixed
	 */
	public function unlock( $key ) {
		return $this->client->unlock( $this->encodeKey( $key ) );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @return Mixed
	 */
	public function incr( $key, $value = 1 ) {
		return $this->client->incr( $this->encodeKey( $key ), $value );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @return Mixed
	 */
	public function decr( $key, $value = 1 ) {
		return $this->client->decr( $this->encodeKey( $key ), $value );
	}

	/**
	 * Get the underlying client object. This is provided for debugging 
	 * purposes.
	 *
	 * @return MemCachedClientforWiki
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Encode a key for use on the wire inside the memcached protocol.
	 *
	 * We encode spaces and line breaks to avoid protocol errors. We encode 
	 * the other control characters for compatibility with libmemcached 
	 * verify_key. We leave other punctuation alone, to maximise backwards
	 * compatibility.
	 */
	public function encodeKey( $key ) {
		return preg_replace_callback( '/[\x00-\x20\x25\x7f]+/', 
			array( $this, 'encodeKeyCallback' ), $key );
	}

	protected function encodeKeyCallback( $m ) {
		return rawurlencode( $m[0] );
	}

	/**
	 * Decode a key encoded with encodeKey(). This is provided as a convenience 
	 * function for debugging.
	 *
	 * @param $key string
	 *
	 * @return string
	 */
	public function decodeKey( $key ) {
		return urldecode( $key );
	}

	/**
	 * Remove value from local cache which is associated with a given key
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $key
	 */
	public function clearLocalCache( $key ) {
		unset($this->client->_dupe_cache[$key]);
	}

}
