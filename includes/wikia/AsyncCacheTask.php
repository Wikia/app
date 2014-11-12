<?php

namespace Wikia\Cache;

use Wikia\Tasks\Tasks\BaseTask;

/**
 * Class AsyncCacheTask
 *
 * @package Wikia\Cache
 */
class AsyncCacheTask extends BaseTask {

	/**
	 * This method calls code ($func) that will generate a new value to cache and then caches it.
	 *
	 * @param string $key - The key to cache the result under
	 * @param callable $func - Function to generate new value
	 * @param array $args - The args for $func
	 * @param array $options - Any additional options send back from the caching object
	 *
	 * @return \Status
	 */
	public static function generate( $key, $func, array $args, array $options ) {

		// Get TTLs to use for positive response and negative (empty) response
		$ttl = empty( $options[ 'ttl' ] ) ? AsyncCache::DEFAULT_TTL : $options[ 'ttl' ];
		$negTTL = empty( $options[ 'negativeResponseTTL' ] )
			? AsyncCache::DEFAULT_NEGATIVE_RESPONSE_TTL
			:  $options[ 'negativeResponseTTL' ];

		// The function has the ability to determine what it considers to be a negative response since
		// sometimes zero or null are valid responses (e.g., count of videos on a wiki can be zero) where as other times
		// a non-zero, non-null response can be invalid (e.g. an error response)
		$value = null;
		try {
			$value = call_user_func_array( $func, $args );
		} catch ( NegativeResponseException $e ) {
			$ttl = $negTTL;
		}

		// Include the time
		$payload = [ time() + $ttl, $value ];

		// If our TTL isn't zero (e.g. don't cache) then cache the result
		if ( $ttl != 0 ) {
			\F::app()->wg->memc->set( $key, $payload );
		}

		return $value;
	}
}

/**
 * Class AsyncCacheTestGenerator
 *
 * A simple generator to test the AsyncCacheTask class
 *
 * @package Wikia\Cache
 */
class AsyncCacheTestGenerator {
	public static function getValue( $value = 'test-value', $sleep = 0, $negResponse = false ) {
		if ( $sleep ) {
			sleep( $sleep );
		}

		if ( $negResponse ) {
			throw new NegativeResponseException();
		} else {
			return $value;
		}
	}
}

/**
 * Class NegativeResultException
 *
 * @package Wikia\Cache
 */
class NegativeResponseException extends \Exception { }