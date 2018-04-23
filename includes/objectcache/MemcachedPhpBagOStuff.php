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
	 * Do a get_multi request and optionally return the data if required
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys
	 * @param $returnData bool Return the data?
	 * @return array|true
	 */
	protected function getMultiInternal( $keys, $returnData ) {
		$map = array();
		foreach ($keys as $key) {
			$map[$this->encodeKey($key)] = $key;
		}
		$mappedData = $this->client->get_multi( array_keys( $map ) );

		if ( !$returnData ) {
			return true;
		}

		$data = array();
		foreach ($mappedData as $k => $v) {
			$data[$map[$k]] = $v;
		}

		return $data;
	}

	/**
	 * Get multiple items at once
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys
	 * @return array Data associated with given keys, no data is indicated by "false"
	 */
	public function getMulti( $keys ) {
		global $wgEnableMemcachedBulkMode;
		if ( empty( $wgEnableMemcachedBulkMode ) ) {
			return parent::getMulti($keys);
		}

		return $this->getMultiInternal($keys,true);
	}

	/**
	 * Prefetch the following keys if local cache is enabled, otherwise don't do anything
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys to prefetch
	 */
	public function prefetch( $keys ) {
		global $wgEnableMemcachedBulkMode;
		if ( empty( $wgEnableMemcachedBulkMode ) ) {
			parent::prefetch($keys);
		}

		$this->getMultiInternal($keys,false);
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

