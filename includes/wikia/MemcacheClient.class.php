<?php
/**
 * MemcacheClient
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

abstract class MemcacheClient {
	const SERIALIZED = 1;
	const COMPRESSED = 2;
	const COMPRESSION_SAVINGS = 0.20;

	/**
	 * list of memcache servers. each entry is either a string in the form <host>:<port>
	 * or an array where the first entry is <host>:<port> and the second entry is a number
	 * indicating the weight of the server (higher weight means higher probability it will
	 * be chosen for server selection)
	 * @var array
	 */
	protected $serverList;
	protected $activeServers;

	protected $debug;

	protected $cacheEnabled;

	protected $compressionEnabled;
	protected $zlibEnabled;
	protected $compressThreshold;

	private $buckets;
	private $bucketCount;
	private $cache;

	public function __construct($args) {
		$this->set_servers(isset($args['servers']) ? $args['servers'] : array());
		$this->set_debug(isset($args['debug']) ? $args['debug'] : false);
		$this->compressThreshold = isset($args['compress_threshold']) ? $args['compress_threshold'] : 0;
		$this->cacheEnabled = isset($args['cache_enabled']) ? $args['cache_enabled'] : true;
		$this->zlibEnabled = function_exists('gzcompress');
		$this->compressionEnabled = true;
		$this->resetCache();
	}

	abstract public function add( $key, $val, $exp = 0 );
	abstract public function incr($key, $amount=1);
	abstract public function decr( $key, $amount = 1 );
	abstract public function delete( $key );
	abstract public function lock($key, $timeout);
	abstract public function unlock($key);
	abstract public function get($key);
	abstract public function get_multi($keys);
	abstract public function replace( $key, $value, $exp = 0 );
	abstract public function set( $key, $value, $exp = 0 );

	abstract protected function getMemcacheConnection($host);

	public function set_debug($debug) {
		$this->debug = $debug;
	}

	public function set_servers($serverList) {
		$this->serverList = $serverList;
		$this->activeServers = count($serverList);
		$this->buckets = null;
		$this->bucketCount = -1;
	}

	/**
	 * @param $key
	 * @param $returnHost
	 * @return Memcache|array
	 */
	protected function getConnection($key, $returnHost=false) {
		$hash = $this->getHash($key);
		$buckets = $this->buckets();
		$realKey = is_array($key) ? $key[1] : $key;

		for ($i = 0; $i < 20; ++$i) {
			$host = $buckets[$hash % $this->bucketCount()];
			$server = $this->getMemcacheConnection($host);
			if ($server !== null) {
				return $returnHost ? [$server, $host] : $server;
			}

			$hash = $this->getHash($key.$realKey);
		}

		return $returnHost ? [null, null] : null;
	}

	/**
	 * Creates a hash integer based on the $key
	 *
	 * @param $key String: key to hash
	 *
	 * @return Integer: hash value
	 * @access private
	 */
	protected function getHash( $key ) {
		# Hash function must on [0,0x7ffffff]
		# We take the first 31 bits of the MD5 hash, which unlike the hash
		# function used in a previous version of this client, works
		return hexdec( substr( md5( $key ), 0, 8 ) ) & 0x7fffffff;
	}

	protected function buckets() {
		if ($this->buckets === null) {
			$this->buckets = [];

			foreach ($this->serverList as $server) {
				if (is_array($server)) {
					for ($i = 0; $i < $server[1]; ++$i) {
						$this->buckets[] = $server[0];
					}
				} else {
					$this->buckets[] = $server;
				}
			}

			$this->bucketCount = count($this->buckets);
		}

		return $this->buckets;
	}

	protected function bucketCount() {
		if ($this->bucketCount == -1) {
			$this->buckets();
		}

		return $this->bucketCount;
	}

	protected function buildCacheEntry(&$val, &$flags) {
		if (!is_scalar($val)) {
			$val = serialize($val);
			$flags |= self::SERIALIZED;
			if ($this->debug) {
				$this->debugPrint(sprintf( "client: serializing data as it is not scalar\n" ));
			}
		}

		$length = strlen($val);
		if ($this->zlibEnabled && $this->compressionEnabled && $this->compressThreshold && $length > $this->compressThreshold) {
			$candidateValue = gzcompress($val, 9);
			$candidateLength = strlen($candidateValue);

			if ($candidateLength < $length*(1 - self::COMPRESSION_SAVINGS)) {
				$val = $candidateValue;
				$flags |= self::COMPRESSED;
				if ( $this->debug ) {
					$this->debugPrint( sprintf( "client: compressing data; was %d bytes is now %d bytes\n", $length, $candidateLength ) );
				}
			}
		}
	}

	protected function setCompressThreshold($threshold) {
		$this->compressThreshold = $threshold;
	}

	protected function debugPrint($message) {
		echo $message;
	}

	protected function addToCache($key, $value) {
		if ($this->cacheEnabled) {
			$this->cache[$key] = $value;
		}
	}

	protected function cacheContains($key) {
		return $this->cacheEnabled && array_key_exists($key, $this->cache);
	}

	protected function getFromCache($key) {
		return $this->cacheContains($key) ? $this->cache[$key] : false;
	}

	protected function setCacheEnabled($enabled) {
		$this->cacheEnabled = $enabled;
	}

	public function deleteFromCache($key) {
		unset($this->cache[$key]);
	}

	protected function resetCache() {
		$this->cache = array();
	}
}