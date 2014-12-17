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
	 *  - memcache operations counter (get, set, miss, delete, add)
	 *
	 * @return array
	 */
	private static function getStats() {
		/* @var $wgMemc \MemcachedPhpBagOStuff */
		global $wgMemc;
		$client = $wgMemc->getClient();

		$stats = [
			'counts' => $client->stats,
			'keys' => [
				'hits' => self::normalizeMemcacheKeys($client->keys_stats['hits']),
				'misses' => self::normalizeMemcacheKeys($client->keys_stats['misses']),
			]
		];

		return $stats;
	}

	/**
	 * Normalizes the given set of keys
	 *
	 * @param array $keys
	 * @return array normalized keys
	 */
	private static function normalizeMemcacheKeys(Array $keys) {
		return array_map([__CLASS__, 'normalizeMemcacheKey'], $keys);
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

		$parts = array_map(
			function($part) {
				// replace IDs and hashes with *
				return ctype_xdigit($part) ? '*' : $part;
			},
			explode(':', $key)
		);

		return implode(':', $parts);
	}

	/**
	 * Bind to the last stage of MW response generation and send stats to the storgae
	 *
	 * @return bool true - it's a hook
	 */
	public static function onRestInPeace() {
		$stats = self::getStats();

		var_dump(__METHOD__); var_dump($stats); die;
		return true;
	}
}
