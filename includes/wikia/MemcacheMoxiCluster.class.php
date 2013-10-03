<?php
/**
 * MemcacheMoxiCluster
 *
 * moxi (https://github.com/zbase/moxi) is a memcache proxy server that maintains a persistent connection
 * to memcache. zynga's php pecl memcache extension (https://github.com/zbase/php-pecl-memcache-zynga) allows moxi
 * interaction through the native php memcache extension. This class is a wrapper for php memcache that mirrors the
 * methods and some additions (hashing mechanism) in the MWMemcached class so they can be easily interchanged
 * without causing a huge spike in cache misses. This means we do not use memcache's built-in hashing strategy
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 * @see MWMemcached
 */

class MemcacheMoxiCluster extends MemcacheClient {
	const MULTI_GET_CHUNK_SIZE = 15; // # of keys to get at a time when using multi get

	public function __construct($args) {
		parent::__construct($args);
		$this->compressionEnabled = false; // memcached extension compresses for us
	}

	public function add($key, $value, $expires=0) {
		return $this->_set('add', $key, $value, $expires);
	}

	public function set($key, $value, $expires=0) {
		return $this->_set('set', $key, $value, $expires);
	}

	public function replace($key, $value, $expires=0) {
		return $this->_set('replace', $key, $value, $expires);
	}

	public function get($key) {
		$key = is_array($key) ? $key[1] : $key;
		$result = $this->get_multi([$key]);
		return is_array($result) && array_key_exists($key, $result) ? $result[$key] : false;
	}

	public function get_multi($keys) {
		global $wgAllowMemcacheDisable, $wgAllowMemcacheReads;

		if ($wgAllowMemcacheDisable && !$wgAllowMemcacheReads) {
			return false;
		}

		$values = [];
		foreach ($keys as $i => $key) {
			if ($this->cacheContains($key)) {
				$values[$key] = $this->getFromCache($key);
				unset($keys[$i]);
			}
		}

		if (empty($keys)) {
			return $values;
		}

		$buckets = [];
		foreach ($keys as $key) {
			list($memcache, $bucket) = $this->getConnection($key, true);
			if (!$memcache) {
				continue;
			}

			if (!isset($buckets[$bucket])) {
				$buckets[$bucket] = [
					'memcache' => $memcache,
					'keys' => [],
				];
			}

			$buckets[$bucket]['keys'][] = $key;
		}

		foreach ($buckets as $bucketData) {
			/** @var Memcache $memcache */
			$memcache = $bucketData['memcache'];
			$chunks = array_chunk($bucketData['keys'], self::MULTI_GET_CHUNK_SIZE);
			foreach ($chunks as $chunk) {
				$chunkValues = $memcache->get($chunk);
				foreach ($chunkValues as $key => $value) {
					$this->addToCache($key, $value);
					$values[$key] = $value;
				}
			}
		}

		return $values;
	}

	public function delete($key) {
		$memcache = $this->getConnection($key);
		if (!$memcache) {
			return false;
		}

		$this->deleteFromCache($key);
		$key = is_array($key) ? $key[1] : $key;

		return $memcache->delete($key);
	}

	public function lock($key, $timeout) {
		return true;
	}

	public function unlock($key) {
		return true;
	}

	public function incr($key, $amount=1) {

	}

	public function decr($key, $amount=1) {

	}

	private function _set($method, $key, $value, $expires=0) {
		$memcache = $this->getConnection($key);
		if (!$memcache) {
			return false;
		}

		$this->buildCacheEntry($value, $flags);
		$result = $memcache->$method($key, $value, $flags, $expires);

		if ($result) {
			$this->addToCache($key, $value);
		}

		return $result;
	}

	protected function getMemcacheConnection($host) {
		static $connections = array();

		if (!isset($connections[$host])) {
			list($host, $port) = explode(':', $host);

			$memcache = new Memcache();
			$memcache->connect($host, $port); // TODO - work timeout and "dead" hosts into this

			if ($this->compressionEnabled) {
				$memcache->setCompressThreshold($this->compressThreshold);
			}

			$connections[$host] = $memcache;
		}

		return $connections[$host];
	}
}