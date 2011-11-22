<?php

/**
 * libmemcached based class implementing BagOStuff interface
 *
 * @file
 * @ingroup Cache
 * @author Władysław Bodzek
 */

class LibmemcachedBagOStuff extends BagOStuff {

	protected $keyPrefix = 'lm-';
	
	protected $servers;
	protected $persistent = false;
	
	protected $compression = true;
	protected $binary = true;
	
	protected $cache = array();
	
	/**
	 * Memcache initializer
	 *
	 * @param   array    $args    Associative array of settings
	 *
	 * @return  mixed
	 */
	public function __construct( $args ) {
		global $wgMemCachedTimeout;
		$this->timeout = intval( $wgMemCachedTimeout / 1000 );
		$this->stats = array();
		$this->persistent = $args['persistant'];
		
		// setup servers list
		$list = $args['servers'];
		$servers = array();
		if (is_array($list)) {
			foreach ($list as $srv) {
				list( $host, $port ) = explode(':',$srv);
				$servers[] = array( $host, $port, 1 );
			}
		}
		$this->servers = $servers;
	}
	
	/**
	 * Adds a key/value to the memcache server if one isn't already set with
	 * that key
	 *
	 * @param   string  $key     Key to set with data
	 * @param   mixed   $val     Value to store
	 * @param   integer $exp     (optional) Time to expire data at
	 *
	 * @return  boolean
	 */
	public function add( $key, $val, $exp = 0 ) {
		$this->prefixKeys($key);
		unset($this->cache[$key]);
//		xxlog("MEMC ADD    $key ".xxcl()."\n");
		return $this->getMemcachedObject()->add($key,$val,$exp);
	}
	
	/**
	 * Decriment a value stored on the memcache server
	 *
	 * @param   string   $key     Key to decriment
	 * @param   integer  $amt     (optional) Amount to decriment
	 *
	 * @return  mixed    FALSE on failure, value on success
	 */
	public function decr( $key, $amt = 1 ) {
		$this->prefixKeys($key);
		unset($this->cache[$key]);
		$value = $this->getMemcachedObject()->decrement($key,$amt);
		return isset($value) ? $value : null;
	}
	
	/**
	 * Deletes a key from the server, optionally after $time
	 *
	 * @param   string   $key     Key to delete
	 * @param   integer  $time    (optional) How long to wait before deleting
	 *
	 * @return  boolean  TRUE on success, FALSE on failure
	 */
	public function delete( $key, $time = 0 ) {
		$this->prefixKeys($key);
		unset($this->cache[$key]);
//		xxlog("MEMC DEL    $key ".xxcl()."\n");
		return $this->getMemcachedObject()->delete($key,$time);
	}
	
	
	/**
	 * Retrieves the value associated with the key from the memcache server
	 *
	 * @param  string   $key     Key to retrieve
	 *
	 * @return  mixed
	 */
	public function get( $key ) {
		$this->prefixKeys($key);
		if (array_key_exists($key,$this->cache)) {
//			xxlog("MEMC GET[C] $key ".xxcl()."\n");
			return $this->cache[$key];
		}
		
		$value = $this->getMemcachedObject()->get($key);
		
		
		switch ($this->getMemcachedObject()->getResultCode()) {
			case Memcached::RES_NOTFOUND:
				// key doesn't exist
//				xxlog("MEMC GET[M] $key ".xxcl()."\n");
				return null;
			case Memcached::RES_SUCCESS:
				// value has been found
				$this->cache[$key] = $value;
//				xxlog("MEMC GET[H] $key ".xxcl()."\n");
				return $value;
			default:
				// error accessing server
				return false;
		}
		return $value;
	}
	
	/**
	 * Get multiple keys from the server(s)
	 *
	 * @param   array    $keys    Keys to retrieve
	 *
	 * @return  array
	 */
	public function get_multi( $keys ) {
		@$this->stats['get_multi']++;
		$this->prefixKeys($keys);
		
		$values = array();
		$keys2 = array();
		foreach ($keys as $k => $key) {
			if (array_key_exists($key,$this->cache)) {
				$values[$key] = $this->cache[$key];
			} else {
				$keys2[] = $key;
			}
		}
		
		if (count($keys2) > 0) {
			$values2 = $this->getMemcachedObject()->getMulti($keys);
			
			$this->cache = array_merge( $this->cache, $values2 );
			$values = array_merge( $values, $values2 );
		}
		
		return $this->unprefixKeys($values);
	}
	
	/**
	 * Increments $key (optionally) by $amt
	 *
	 * @param   string   $key     Key to increment
	 * @param   integer  $amt     (optional) amount to increment
	 *
	 * @return  integer  New key value?
	 */
	public function incr( $key, $amt = 1 ) {
		@$this->stats['incr']++;
		$this->prefixKeys($key);
		unset($this->cache[$key]);
		$value = $this->getMemcachedObject()->increment($key,$amt);
		return isset($value) ? $value : null;
	}
	
	/**
	 * Overwrites an existing value for key; only works if key is already set
	 *
	 * @param   string   $key     Key to set value as
	 * @param   mixed    $value   Value to store
	 * @param   integer  $exp     (optional) Experiation time
	 *
	 * @return  boolean
	 */
	public function replace( $key, $value, $exp = 0 ) {
		@$this->stats['replace']++;
		$this->prefixKeys($key);
		$this->cache[$key] = $value;
//		xxlog("MEMC REPL   $key ".xxcl()."\n");
		$value = $this->getMemcachedObject()->replace($key,$value,$exp);
		return $value;
	}
	
	/**
	 * Passes through $cmd to the memcache server connected by $sock; returns
	 * output as an array (null array if no output)
	 *
	 * NOTE: due to a possible bug in how PHP reads while using fgets(), each
	 *       line may not be terminated by a \r\n.  More specifically, my testing
	 *       has shown that, on FreeBSD at least, each line is terminated only
	 *       with a \n.  This is with the PHP flag auto_detect_line_endings set
	 *       to falase (the default).
	 *
	 * @param   resource $sock    Socket to send command on
	 * @param   string   $cmd     Command to run
	 *
	 * @return  array    Output array
	 * @access  public
	 */
	function run_command( $sock, $cmd ) {
		throw new Exception("Not implemented");
	}
	
	/**
	 * Unconditionally sets a key to a given value in the memcache.  Returns true
	 * if set successfully.
	 *
	 * @param   string   $key     Key to set value as
	 * @param   mixed    $value   Value to set
	 * @param   integer  $exp     (optional) Experiation time
	 *
	 * @return  boolean  TRUE on success
	 */
	public function set( $key, $value, $exp = 0 ) {
		@$this->stats['set']++;
		$this->prefixKeys($key);
		$this->cache[$key] = $value;
//		xxlog("MEMC SET    $key ".xxcl()."\n");
		return $this->getMemcachedObject()->set($key,$value,$exp);
	}
	
	
	
	// NON-PUBLIC PART
	
	protected $memcached;
	
	protected function getPersistentId() {
		return md5(serialize($this->servers));
	}
	
	protected function getMemcachedObject() {
		if (!$this->memcached) {
			// clear the cache
			$this->cache = array();
			// create the Memcached object
			if ($this->persistent) {
				$memcached = new Memcached($this->getPersistentId());
			} else {
				$memcached = new Memcached();
			}
			
			// set options as desired
			$memcached->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE,true);
			// the line above sets the next 2 options automatically
			//$memcached->setOption(Memcached::OPT_HASH,Memcached::HASH_MD5);
			//$memcached->setOption(Memcached::OPT_DISTRIBUTION,Memcached::DISTRIBUTION_CONSISTENT);
			$memcached->setOption(Memcached::OPT_SERIALIZER,Memcached::SERIALIZER_IGBINARY);
			$memcached->setOption(Memcached::OPT_COMPRESSION,$this->compression);
			$memcached->setOption(Memcached::OPT_BINARY_PROTOCOL,$this->binary);
			$memcached->setOption(Memcached::OPT_CONNECT_TIMEOUT,10);
			$memcached->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT,2);
			$memcached->setOption(Memcached::OPT_SEND_TIMEOUT,$this->timeout);
			$memcached->setOption(Memcached::OPT_RECV_TIMEOUT,$this->timeout);
			$memcached->setOption(Memcached::OPT_POLL_TIMEOUT,$this->timeout);
// 			$memcached->setOption();
			
			// allow settings override in configuration (eg. enable igbinary serializer)
			global $wgLibMemCachedOptions;
			if (is_array($wgLibMemCachedOptions)) {
				foreach ($wgLibMemCachedOptions as $key => $val) {
					$memcached->setOption($key,$val);
				}
			}
			
			// add servers if required
			if (!count($memcached->getServerList())) {
				$memcached->addServers($this->servers);
			}
			$this->memcached = $memcached;
		}
		return $this->memcached;
	}
	
	protected function prefixKeys( &$keys ) {
		if (is_array($keys)) {
			$keys = array_map(array($this,'prefixKeys'), $keys);
		} else {
			$keys = $this->keyPrefix . $keys;
		}
		return $keys;
	}
	
	protected function unprefixKeys( &$multi ) {
		$l = strlen($this->keyPrefix);
		$data = array();
		foreach ($multi as $k => $v) {
			if (substr($k,0,$l) == $this->keyPrefix) {
				$k = substr($k,$l);
			}
			$data[$k] = $v;
		}
		return $data;
	}







}