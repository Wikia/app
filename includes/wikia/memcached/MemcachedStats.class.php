<?php

/**
 * Memcache stats collector
 *
 * @author macbre
 */
namespace Wikia\Memcached;

use Wikia\Util\Statistics\BernoulliTrial;

class MemcachedStats {

	// list of memcache keys to normalize by taking a look at the prefix
	// @see PLATFORM-1186
	private static $keyPrefixesToNormalize = [
		'wikia:talk_messages:',
		'wikicities:filepage:globalusage:',
		'wikicities:InterwikiDispatcher::isWikiExists:',
		'wikicities:UserCache:',
		'wikicities:wikifactory:variables:metadata:',
		'wikifactory:domains:by_domain_hash:',
		'*:pcache:idhash:',
	];

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

		wfProfileIn(__METHOD__);

		$stats = [
			'counts' => $client->stats,
			'keys' => []
		];

		foreach($client->keys_stats as $bucket => $keys) {
			$stats['keys'][$bucket] = !empty( $keys ) ? self::normalizeAndCountKeys( $keys ) : $keys;
		}

		wfProfileOut(__METHOD__);
		return $stats;
	}

	/**
	 * Normalizes the given set of keys and aggregates them
	 *
	 * @param array $keys
	 * @return array normalized and aggregated keys
	 */
	private static function normalizeAndCountKeys(Array $keys) {
		wfProfileIn(__METHOD__);

		$normalized = array_map([__CLASS__, 'normalizeKey'], $keys);

		$aggregated = [];
		foreach($normalized as $key) {
			if (!isset($aggregated[$key])) {
				$aggregated[$key] = 1;
			}
			else {
				$aggregated[$key]++;
			}
		}

		wfProfileOut(__METHOD__);
		return $aggregated;
	}

	/**
	 * Normalizes given key by removing the wiki-specific prefix and
	 * removing hashes and IDs parts from the key
	 *
	 * @param string $key
	 * @return string
	 */
	public static function normalizeKey($key) {
		// remove per-wiki prefix
		$prefix = wfWikiId() . ':';
		if (startsWith($key, $prefix)) {
			$key = str_replace($prefix, '*:', $key);
		}

		// check key prefixes
		foreach(self::$keyPrefixesToNormalize as $prefix) {
			if (startsWith($key, $prefix)) {
				return $prefix . '*';
			}
		}

		// normalize key parts separators
		$key = str_replace( '-', ':', $key );
		$key = str_replace( '_', ':', $key );

		$parts = array_map(
			function($part) {
				// replace IP addresses, IDs, "v1" suffixes and hashes with *
				return ctype_xdigit( strtr( $part, '.v', '00' ) ) ? '*' : $part;
			},
			explode( ':', $key )
		);

		return implode(':', $parts);
	}

	/**
	 * Bind to the last stage of MW response generation and send stats to the storage
	 *
	 * @return bool true - it's a hook
	 */
	public static function onRestInPeace() {
		// obey the sampling
		global $wgMemcacheStatsSampling;

		$trial = new BernoulliTrial($wgMemcacheStatsSampling / 100); // normalize percents to 0-1 range
		if (!$trial->shouldSample()) {
			return true;
		}

		$stats = self::getStats();

		// send generic stats
		foreach($stats['counts'] as $name => $value) {
			\Transaction::addEvent( \Transaction::EVENT_MEMCACHE_STATS_COUNTERS, [
				'name' => $name,
				'value' => $value,
			]);
		}

		// send top keys for misses and hits
		foreach($stats['keys'] as $bucket => $keys) {
			foreach($keys as $key => $count) {
				\Transaction::addRawEvent( \Transaction::EVENT_MEMCACHE_STATS_KEYS, [
					'bucket' => $bucket,
					'key' => $key,
					'count' => $count
				]);
			}
		}
		return true;
	}
}
