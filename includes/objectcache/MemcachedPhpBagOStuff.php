<?php

/**
 * A wrapper class for the pure-PHP memcached client, exposing a BagOStuff interface.
 */
class MemcachedPhpBagOStuff extends BagOStuff {

	/**
	 * @var MemCachedClientforWiki
	 */
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
		global $wgMemCachedClass;

		if ( !isset( $params['servers'] ) ) {
			$params['servers'] = $GLOBALS['wgMemCachedServers'];
		}
		if ( !isset( $params['debug'] ) ) {
			$params['debug'] = $GLOBALS['wgMemCachedDebug'];
		}
		if ( !isset( $params['persistent'] ) ) {
			$params['persistent'] = $GLOBALS['wgMemCachedPersistent'];
		}
		if  ( !isset( $params['compress_threshold'] ) ) {
			$params['compress_threshold'] = 1500;
		}
		if ( !isset( $params['timeout'] ) ) {
			$params['timeout'] = $GLOBALS['wgMemCachedTimeout'];
		}
		if ( !isset( $params['connect_timeout'] ) ) {
			$params['connect_timeout'] = $GLOBALS['wgMemCachedConnectionTimeout'] ?: 0.5; # Wikia change (global introduced)
		}

		if (empty($wgMemCachedClass) || !class_exists($wgMemCachedClass)) {
			$wgMemCachedClass = 'MemCachedClientforWiki';
		}

		$this->client = new $wgMemCachedClass( $params );
	}

	/**
	 * @param $debug bool
	 */
	public function setDebug( $debug ) {
		$this->client->set_debug( $debug );
	}

	/**
	 * @param $key string
	 * @return Mixed
	 */
	public function get( $key ) {
		return $this->client->get( $this->encodeKey( $key ) );
	}

	/**
	 * @param $key string
	 * @param $value
	 * @param $exptime int If it's equal to zero, the item will never expire!
	 * @return bool
	 */
	public function set( $key, $value, $exptime = 0 ) {
		return $this->client->set( $this->encodeKey( $key ), $value, $exptime );
	}

	/**
	 * @param $key string
	 * @param $time int
	 * @return bool
	 */
	public function delete( $key, $time = 0 ) {
		return $this->client->delete( $this->encodeKey( $key ), $time );
	}

	/**
	 * @param $key
	 * @param $timeout int
	 * @return
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
	public function add( $key, $value, $exptime = 0 ) {
		return $this->client->add( $this->encodeKey( $key ), $value, $exptime );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @param $exptime
	 * @return Mixed
	 */
	public function replace( $key, $value, $exptime = 0 ) {
		return $this->client->replace( $this->encodeKey( $key ), $value, $exptime );
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
	 * Do a get_multi request and optionally return the data if required
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys
	 * @parma $returnData bool Return the data?
	 * @return array
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

