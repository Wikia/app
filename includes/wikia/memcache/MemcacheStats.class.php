<?php

/**
 * Memcache stats collector
 *
 * @author macbre
 */
namespace Wikia\Memcache;

class MemcacheStats {

	/**
	 * Get memcache stats:
	 *  - top keys (both hits and misses)
	 *  - memcache operations counter (get, set, delete)
	 *
	 * @return array
	 */
	private static function getStats() {
		/* @var $wgMemc \MemcachedPhpBagOStuff */
		global $wgMemc;
		$client = $wgMemc->getClient();

		$stats = [
			'counts' => $client->stats,
			'keys' => $client->keys_stats,
		];

		return $stats;
	}

	/**
	 * Normalizes given key by removing the wiki-specific prefix and
	 * removing hashes and IDs parts from the key
	 *
	 * @param string $key
	 * @return string
	 */
	public static function normalizeMemcacheKey($key) {
		// remove per-wiki prefix
		$prefix = \F::app()->wf->WikiId() . ':';
		if (startsWith($key, $prefix)) {
			$key = str_replace($prefix, '*:', $key);
		}

		// remove IDs and hashes
		$key = preg_replace('#:[0-9a-f]+#', ':*', $key);

		return $key;
	}

	/**
	 * Bind to the last stage of MW response generation and send stats to the storgae
	 *
	 * @return bool true - it's a hook
	 */
	public static function onRestInPeace() {
		#$stats = self::getStats();

		#var_dump(__METHOD__); var_dump($stats); die;
		return true;
	}
}
