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

	protected function randomSleep( $max = 20 ) {
		usleep( rand( 1, $max*1000 ) );
	}

	/**
	 * Modify the shared memcache entry after locking it. After this function gets the lock, it calls the $getDataCallback,
	 * which should return the value to be put into the memcache. In case the lock cannot be acquired, $lockFailCallback
	 * is called
	 * If the $getDataCallback returns null or false, no memcache data is set
	 * @param $getDataCallback - callback returning the data to be put in the memcache entry.
	 * @param $lockFailCallback - callback to execute on failure
	 */
	public function lockAndSetData( $getDataCallback, $lockFailCallback ) {
		// Try to update the data $count times before giving up
		$count = 5;
		while ( $count-- ) {
			if( $this->lock() ) {
				$data = $getDataCallback();
				$success = false;
				// Make sure we have data
				if ( isset( $data ) ) {
					// See if we can set it successfully
					if ( $this->set( $data ) ) {
						$success = true;
					}
				} else {
					// If there's no data don't bother doing anything
					$success = true;
				}
				$this->unlock();
				if ( $success ) {
					break;
				}
			} else {
				$this->randomSleep( $count );
			}
		}
		// If count is -1 it means we left the above loop failing to update
		if ( $count == -1 ) {
			$lockFailCallback();
		}
	}
}
