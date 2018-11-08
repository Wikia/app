<?php

/**
 * A wrapper class for the PECL memcached client
 *
 * @see https://pecl.php.net/package/memcached
 * @ingroup Cache
 */
class MemcachedPeclBagOStuff extends MemcachedBagOStuff {

	// SUS-4749 | add a prefix to keys to avoid problems with incompatible serialization
	// ("lm" comes from libmemcached)
	const KEY_PREFIX = 'lm';

	/* @var Memcached $client */
	protected $client;

	/**
	 * @author wikia
	 * Internal memoization to avoid unnecessary network requests
	 * If a get() is done twice in a single request use the stored value
	 *
	 * Ported from MemcachedClient.php
	 */
	private $_dupe_cache = [];

	/**
	 * Constructor
	 *
	 * @param $params array
	 * @throws MWException
	 *
	 * Available parameters are:
	 *   - servers:             The list of IP:port combinations holding the memcached servers.
	 *   - persistent:          Whether to use a persistent connection
	 *   - compress_threshold:  The minimum size an object must be before it is compressed
	 *   - timeout:             The read timeout in microseconds
	 *   - connect_timeout:     The connect timeout in seconds
	 *   - serializer:          May be either "php" or "igbinary". Igbinary produces more compact 
	 *                          values, but serialization is much slower unless the php.ini option
	 *                          igbinary.compact_strings is off.
	 *   - use_binary_protocol  Whether to enable the binary protocol (default is ASCII) (boolean)
	 */
	function __construct( $params ) {
		$params = $this->applyDefaultParams( $params );

		if ( $params['persistent'] ) {
			$this->client = new Memcached( __CLASS__ );
		} else {
			$this->client = new Memcached;
		}

		if ( $params['use_binary_protocol'] ) {
			$this->client->setOption( Memcached::OPT_BINARY_PROTOCOL, true );
		}

		// The compression threshold is an undocumented php.ini option for some 
		// reason. There's probably not much harm in setting it globally, for 
		// compatibility with the settings for the PHP client.
		ini_set( 'memcached.compression_threshold', $params['compress_threshold'] );

		// Set timeouts
		$this->client->setOption( Memcached::OPT_CONNECT_TIMEOUT, $params['connect_timeout'] * 1000 );
		$this->client->setOption( Memcached::OPT_SEND_TIMEOUT, $params['timeout'] );
		$this->client->setOption( Memcached::OPT_RECV_TIMEOUT, $params['timeout'] );
		$this->client->setOption( Memcached::OPT_POLL_TIMEOUT, $params['timeout'] / 1000 );

		// Set libketama mode since it's recommended by the documentation and 
		// is as good as any. There's no way to configure libmemcached to use
		// hashes identical to the ones currently in use by the PHP client, and
		// even implementing one of the libmemcached hashes in pure PHP for 
		// forwards compatibility would require MWMemcached::get_sock() to be
		// rewritten.
		$this->client->setOption( Memcached::OPT_LIBKETAMA_COMPATIBLE, true );

		// SUS-4749 | add a prefix to all keys due to serialization incompatibility
		// with an old client
		$this->client->setOption( Memcached::OPT_PREFIX_KEY, self::KEY_PREFIX );

		// Set the serializer
		switch ( $params['serializer'] ) {
			case 'php':
				$this->client->setOption( Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_PHP );
				break;
			case 'igbinary':
				if ( !extension_loaded( 'igbinary' ) ) {
					throw new MWException( __CLASS__.': the igbinary extension is not loaded ' . 
						'but igbinary serialization was requested.' );
				}
				$this->client->setOption( Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_IGBINARY );
				break;
			default:
				throw new MWException( __CLASS__.': invalid value for serializer parameter' );
		}
		foreach ( $params['servers'] as $host ) {
			list( $ip, $port ) = IP::splitHostAndPort( $host );
			$this->client->addServer( $ip, $port );
		}
	}

	protected function applyDefaultParams( $params ) {
		$params = parent::applyDefaultParams( $params );

		if ( !isset( $params['use_binary_protocol'] ) ) {
			$params['use_binary_protocol'] = false;
		}

		if ( !isset( $params['serializer'] ) ) {
			$params['serializer'] = 'php';
		}

		return $params;
	}

	/**
	 * @param $key string
	 * @return Mixed
	 */
	public function get( $key ) {
		$this->debugLog( "get($key)" );

		wfProfileIn( __METHOD__ );
		wfProfileIn( __METHOD__ . "::$key" );

		// Wikia: Memoize duplicate memcache requests for the same key in the same request
		if( isset( $this->_dupe_cache[ $key ] ) ) {
			wfProfileIn( __METHOD__ . "::$key !DUPE" );
			wfProfileOut( __METHOD__ . "::$key !DUPE" );
			wfProfileOut( __METHOD__ . "::$key" );
			wfProfileOut( __METHOD__ );
			return $this->_dupe_cache[ $key ];
		}

		$res =  $this->checkResult( $key, parent::get( $key ) );

		wfProfileOut( __METHOD__ . "::$key" );
		wfProfileOut( __METHOD__ );

		// Wikia: Memoize duplicate memcache requests for the same key in the same request
		$this->_dupe_cache[$key] = $res;

		return $res;
	}

	/**
	 * @param $key string
	 * @param $value
	 * @param $exptime int
	 * @return bool
	 */
	public function set( $key, $value, $exptime = 0 ) {
		// Wikia: Memoize duplicate memcache requests for the same key in the same request
		$this->_dupe_cache[ $key ] = $value;

		$this->debugLog( "set($key)" );
		return $this->checkResult( $key, parent::set( $key, $value, $exptime ) );
	}

	/**
	 * @param $key string
	 * @param $time int
	 * @return bool
	 */
	public function delete( $key, $time = 0 ) {
		unset( $this->_dupe_cache[ $key ] ); // Wikia change

		$this->debugLog( "delete($key)" );
		return $this->checkResult( $key, parent::delete( $key, $time ) );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @param $exptime int
	 * @return Mixed
	 */
	public function add( $key, $value, $exptime = 0 ) {
		unset( $this->_dupe_cache[ $key ] ); // Wikia change

		$this->debugLog( "add($key)" );
		return $this->checkResult( $key, parent::add( $key, $value, $exptime ) );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @param $exptime
	 * @return Mixed
	 */
	public function replace( $key, $value, $exptime = 0 ) {
		unset( $this->_dupe_cache[ $key ] ); // Wikia change

		$this->debugLog( "replace($key)" );
		return $this->checkResult( $key, parent::replace( $key, $value, $exptime ) );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @return Mixed
	 */
	public function incr( $key, $value = 1 ) {
		unset( $this->_dupe_cache[ $key ] ); // Wikia change

		$this->debugLog( "incr($key)" );
		$result = $this->client->increment( $key, $value );
		return $this->checkResult( $key, $result );
	}

	/**
	 * @param $key string
	 * @param $value int
	 * @return Mixed
	 */
	public function decr( $key, $value = 1 ) {
		unset( $this->_dupe_cache[ $key ] ); // Wikia change

		$this->debugLog( "decr($key)" );
		$result = $this->client->decrement( $key, $value );
		return $this->checkResult( $key, $result );
	}

	/**
	 * Check the return value from a client method call and take any necessary 
	 * action. Returns the value that the wrapper function should return. At 
	 * present, the return value is always the same as the return value from
	 * the client, but some day we might find a case where it should be 
	 * different.
	 * 
	 * @param $key string The key used by the caller, or false if there wasn't one.
	 * @param $result mixed The return value
	 * @return mixed
	 */
	protected function checkResult( $key, $result ) {
		if ( $result !== false ) {
			return $result;
		}
		switch ( $this->client->getResultCode() ) {
			case Memcached::RES_SUCCESS:
				break;
			case Memcached::RES_DATA_EXISTS:
			case Memcached::RES_NOTSTORED:
			case Memcached::RES_NOTFOUND:
				$this->debugLog( "result: " . $this->client->getResultMessage() );
				break;
			default:
				$msg = $this->client->getResultMessage();
				if ( $key !== false ) {
					$server = $this->client->getServerByKey( $key );
					$serverName = "{$server['host']}:{$server['port']}";
					$msg = "Memcached error for key \"$key\" on server \"$serverName\": $msg";
				} else {
					$msg = "Memcached error: $msg";
				}

				// Wikia change
				Wikia\Logger\WikiaLogger::instance()->error (__METHOD__, [
					'exception' => new Exception( $msg ),
					'key' => $key,
					'caller' => wfGetCallerClassMethod( __CLASS__ )
				] );
		}
		return $result;
	}

	/**
	 * @param $keys array
	 * @return array
	 */
	public function getBatch( array $keys ) {
		$this->debugLog( 'getBatch(' . implode( ', ', $keys ) . ')' );
		$callback = array( $this, 'encodeKey' );
		$result = $this->client->getMulti( array_map( $callback, $keys ) );
		return $this->checkResult( false, $result );
	}

	public function encodeKey( $key ) {
		return parent::encodeKey( self::KEY_PREFIX . $key ); // Wikia change
	}

	/**
	 * Remove value from local cache which is associated with a given key
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $key
	 */
	public function clearLocalCache( $key ) {
		unset($this->_dupe_cache[$key]);
	}

	/* NOTE: there is no cas() method here because it is currently not supported 
	 * by the BagOStuff interface and other BagOStuff subclasses, such as 
	 * SqlBagOStuff.
	 */
}
