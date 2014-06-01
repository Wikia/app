<?php

/**
 * @author Tomasz Odrobny
 * @copyright GPLv2
 *
 * @brife: Used to allow more then one "worker" oparate on one memcache key. It allow to put mutex on memc key/code block.
 *
 */

class MemcacheSync{
	/** @var MemcachedPhpBagOStuff */
	var $memc = null;
	var $key;
	var $lockKey;
	var $instance; 
	function __construct( $cache, $key ) {
		$this->memc = $cache;
		if(empty($key)) {
			throw new Exception('Key is empty');
		}
		$this->key = $key;
		$this->lockKey = wfSharedMemcKey('MemcacheSyncLock', $key);
		$this->instance = uniqid ('', true);
	}

	function lock($time = 5) {
		if ($this->memc->add($this->lockKey, $this->instance, $time)) {
			return true;
		} else {
			return false;
		}
	}

	function unlock() {
		$this->memc->delete($this->lockKey);
	}

	function isMy() {
		$lock = $this->getLockStatus();
		if($lock == $this->instance) {
			return true;
		} else {
			return false;
		}
	}

	function getLockStatus() {
		$this->memc->clearLocalCache($this->lockKey);
		return $this->memc->get($this->lockKey, false);
	}

	function get($val = null) {
		return $this->memc->get($this->key, $val);
	}

	function set($val, $time = 0) {
		if($this->isMy()) {
			$this->memc->set($this->key, $val, $time);
			return true;
		} else {
			return false;
		}
	}

	function delete() {
		$this->memc->delete($this->key);
	}
}
