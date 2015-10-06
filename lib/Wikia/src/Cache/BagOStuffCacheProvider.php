<?php

namespace Wikia\Cache;

use BagOStuff;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;

class BagOStuffCacheProvider extends CacheProvider {
	/** @var BagOStuff */
	private $cache;

	public function __construct(BagOStuff $cache) {
		$this->cache = $cache;
	}

	protected function doFetch($id) {
		return $this->cache->get($id);
	}

	protected function doContains($id) {
		return $this->cache->get($id) != false;
	}

	protected function doSave($id, $data, $lifeTime = 0) {
		return $this->cache->set($id, $data, $lifeTime);
	}

	protected function doDelete($id) {
		return $this->cache->delete($id);
	}

	protected function doFetchMultiple(array $keys) {
		return $this->cache->getMulti($keys);
	}

	protected function doFlush() {
		// unsupported
		return false;
	}

	protected function doGetStats() {
		// BagOStuff does not provide any stats
		return [
			Cache::STATS_HITS => 0,
			Cache::STATS_MISSES => 0,
			Cache::STATS_UPTIME => 0,
			Cache::STATS_MEMORY_USAGE => 0,
			Cache::STATS_MEMORY_AVAILABLE => 0,
		];
	}
}
