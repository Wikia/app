<?php

namespace Wikia\Cache\Memcache;

use BagOStuff;

class Memcache {

	const BAG_O_STUFF = "memcache_bag_o_stuff";

	/** @var BagOStuff */
	private $cache;

	/**
	 * @Inject({
	 *    Wikia\Cache\Memcache\Memcache::BAG_O_STUFF})
	 * @param BagOStuff $cache;
	 */
	public function __construct($cache) {
		$this->cache = $cache;
	}

	public function get($key) {
		return $this->cache->get($key);
	}

	public function set($key, $value, $expires = 0) {
		return $this->cache->set($key, $value, $expires);
	}

	public function delete($key, $time=0) {
		return $this->cache->delete($key, $time);
	}
}
