<?php

namespace Wikia\Cache;

use Wikia\Logger\WikiaLogger;

/**
 * Class AsyncCache
 *
 * A class implementing an asynchronous cache.  That is, if a cache value was found in the cache, but it is expired,
 * this stale value will be returned and an asynchronous task will be started to regenerate the cache value.  This
 * eliminates the cache MISS time penalty for most cases.
 *
 * Example usage:
 *
 * $value = ( new AsyncCache() )
 *     ->key( 'video_views' )
 *     ->ttl( 300 )
 *     ->callback( 'SomeClass::someMethod' )->callbackParams( [ 1, 'cat', true ] )
 *     ->value();
 *
 * This will try to fetch the 'video_views' key from the cache.  If the key is not found in the cache, the callback
 * function will be executed as:
 *
 *   SomeClass::someMethod(1, 'cat', true);
 *
 * This will run immediately and will block the call to 'value()' from returning until a new value is generated.  This
 * value will then be stored in cache with a TTL of 300 seconds (5 minutes).
 *
 * If 'video_views' key is found in the cache and it is fresh (the TTL hasn't expired) the value will be returned.
 *
 * If 'video_views' key is found in the cache but it is stale (the TTL has expired), a task to generate the new value
 * will be created and the existing stale value will be immediately returned.
 *
 * If 'video_views' key is found in the cache but it is stale (the TTL has expired), AND the stale TTL has
 * expired (the default is 60 seconds to return stale values), the callback function will be executed and will block
 * the call to 'value()' until a new value is generated
 *
 */
class AsyncCache {

	// Some default TTLs

	// Default time for cache value to live
	const DEFAULT_TTL = 300;

	// Default time for negative cache responses (e.g. zero, null, etc) to live
	const DEFAULT_NEGATIVE_RESPONSE_TTL = 0;

	// Default time for a stale cache value to live (returned while async job is running)
	const DEFAULT_STALE_TTL = 60;

	// If the
	const UNLIMITED_TIME_REMAINING = -1;

	// Behavior to take on on a miss.  We can either block and return a value immediately
	// or return a stale value and generate a value asynchronously
	const ON_MISS_BLOCK = 1;
	const ON_MISS_STALE = 2;

	/** @var MemcachedPhpBagOStuff - The caching client */
	private $cache;

	/** @var string - Key to store value under */
	private $key;

	/** @var int - The cache value time to live */
	private $ttl;

	/** @var int - The cached negative response value time to live */
	private $negativeResponseTTL = 0;

	/** @var int - How to behave on a miss.  Default to return a stale value */
	private $onMiss = self::ON_MISS_STALE;

	/** @var int - How long to return stale values while waiting for new values to be generated.  Zero
	 			   means serve stale data as long as it takes to generate new data
	 */
	private $staleOnMissTTL = 0;

	/** @var callable - A function to run to generate new values */
	private $callback;
	/** @var array - Arguments to pass to the $callback function */
	private $callbackParams;

	/** @var bool - Whether the cache has been fetched yet */
	private $cacheFetched = false;

	/** @var bool - Whether the cache fetch returned a value */
	private $foundInCache = false;

	/** @var int - Whether the cache value is expired */
	private $cacheExpire;

	/** @var mixed - The value returned by the task */
	private $cacheValue;

	/** @var \Wikia\Cache\AsyncCacheTask - The task created to generate a new value */
	private $task;

	/** @var int - The current time.  Keeps us from calling time() over and over */
	private $currTime;

	/**
	 * @param \BagOStuff $cache - An alternate caching package
	 */
	public function __construct( $cache = null ) {
		$this->currTime = time();
		$this->ttl = self::DEFAULT_TTL;
		$this->negativeResponseTTL = self::DEFAULT_NEGATIVE_RESPONSE_TTL;

		$this->staleOnMissTTL = self::DEFAULT_STALE_TTL;

		$this->callbackParams = [];

		$this->cache = $cache ? $cache : \F::app()->wg->Memc;
	}

	/**
	 * Set the key to fetch
	 *
	 * @param string $cacheKey
	 *
	 * @return AsyncCache $this
	 */
	public function key( $cacheKey ) {
		$this->key = $cacheKey;
		return $this;
	}

	/**
	 * Set the TTL for the cache if a new cache value is generated
	 *
	 * @param int $secs
	 *
	 * @return AsyncCache $this
	 */
	public function ttl( $secs ) {
		$this->ttl = $secs;
		return $this;
	}

	/**
	 * Set the TTL for negative responses.  This is typically zero, or null, or some type of empty due to some type
	 * of error getting the data.  Typically a negative response should not be cached.  An exception might be if
	 * the negative response comes from a timeout (e.g. network problems) where caching an empty result would keep
	 * the timeout from backing up the rest of the calling code.
	 *
	 * @param int $secs
	 *
	 * @return AsyncCache $this
	 */
	public function negativeResponseTTL( $secs ) {
		$this->negativeResponseTTL = $secs;
		return $this;
	}

	/**
	 * Set the cache request to generate a value immediately on a miss, blocking execution until it finishes
	 *
	 * @return AsyncCache $this
	 */
	public function blockOnMiss() {
		$this->onMiss = self::ON_MISS_BLOCK;
		return $this;
	}

	/**
	 * Set the cache to return stale data on a miss.  The single optional argument gives the time in seconds the
	 * data is allowed to be stale
	 *
	 * @param int $secs
	 *
	 * @return AsyncCache $this
	 */
	public function staleOnMiss( $secs = self::DEFAULT_STALE_TTL ) {
		$this->onMiss = self::ON_MISS_STALE;
		$this->staleOnMissTTL = $secs;
		return $this;
	}

	/**
	 * A function to call that can regenerate the cache value
	 *
	 * @param callable $callback
	 * @param array|null $params
	 *
	 * @return AsyncCache $this
	 */
	public function callback( $callback, array $params = null ) {
		$this->callback = $callback;
		$this->callbackParams = $params;

		return $this;
	}

	/**
	 * Parameters to pass to the callback function
	 *
	 * @param array $params
	 *
	 * @return AsyncCache $this
	 */
	public function callbackParams( array $params ) {
		$this->callbackParams = $params;
		return $this;
	}

	/**
	 * Whether the value was found in cache or not.  Note that calling this method will trigger a fetch from cache.
	 *
	 * @return bool
	 */
	public function foundInCache() {
		$this->fetchFromCache();
		return $this->foundInCache;
	}

	/**
	 * How many seconds are left in the TTL.  Note that calling this method will trigger a fetch from cache.
	 *
	 * @return int
	 */
	public function ttlRemain() {
		if ( $this->isCacheStale() ) {
			return 0;
		} else {
			return $this->getCacheExpire() - $this->currTime;
		}
	}

	/**
	 * Whether the cache value is stale.  Note that calling this method will trigger a fetch from cache.
	 *
	 * @return bool
	 */
	public function isCacheStale() {
		return  $this->currTime > $this->getCacheExpire();
	}

	/**
	 * How many seconds a stale cache value can still be returned.  If our staleOnMissTTL is zero, this method will
	 * return '-1' meaning 'forever'.  Note that calling this method will trigger a fetch from cache.
	 *
	 * @return int - Seconds remaining
	 */
	public function staleTTLRemain() {
		if ( !$this->isCacheStale() ) {
			return self::UNLIMITED_TIME_REMAINING;
		}

		if ( $this->canReturnStale() ) {
			// If we can return stale forever, return a special remaining time
			if ( $this->staleOnMissTTL == 0 ) {
				return self::UNLIMITED_TIME_REMAINING;
			}

			return $this->getCacheExpire() + $this->staleOnMissTTL - $this->currTime;
		} else {
			return 0;
		}
	}

	/**
	 * Returns whether a task has been scheduled
	 *
	 * @return bool
	 */
	public function isTaskScheduled() {
		return !empty( $this->task );
	}

	/**
	 * Purge the give cache key from the cache
	 *
	 * @param string $key
	 */
	public function purge( $key ) {
		$this->cache->delete( $key );
	}

	/**
	 * Fetches the value from cache implementing all stale and asynchronous generation logic.
	 *
	 * @return mixed
	 */
	public function value() {

		// If we have a cache value and its fresh or there's still time to return a stale cache value while we
		// regenerate, then use the value we found.
		if ( $this->foundInCache() && ( !$this->isCacheStale() || $this->canReturnStale() ) ) {
			$value = $this->getCacheValue();

			// If we're stale but can wait on the fresh value, schedule a job
			if ( $this->isCacheStale() ) {
				$this->logInfo( 'AsyncCache HIT stale' );

				$this->scheduleValueGeneration();
			} else {
				$this->logInfo( 'AsyncCache HIT fresh' );
			}
		} else {
			$this->logInfo( 'AsyncCache MISS' );

			// If we're missing or stale and can't wait for a value, generate immediately
			$value = $this->generateValueNow();
		}

		return $value;
	}

	private function fetchFromCache() {
		if ( $this->cacheFetched ) {
			return;
		}

		$cacheData = $this->cache->get( $this->key );

		if ( $cacheData ) {
			list( $expire, $value ) = $cacheData;
			$this->cacheExpire = $expire;
			$this->cacheValue = $value;
			$this->foundInCache = true;
		} else {
			$this->foundInCache = false;
		}

		$this->cacheFetched = true;
	}

	private function getCacheExpire() {
		$this->fetchFromCache();

		return $this->cacheExpire;
	}

	private function getCacheValue() {
		$this->fetchFromCache();

		return $this->cacheValue;
	}

	private function canReturnStale() {
		// If we're always blocking on a miss, always return false
		if ( $this->onMiss == self::ON_MISS_BLOCK ) {
			return false;
		}

		// If we've got a zero stale on miss TTL, we gan return stale forever
		if ( $this->staleOnMissTTL == 0 ) {
			return true;
		}

		return $this->currTime - $this->getCacheExpire() < $this->staleOnMissTTL;
	}

	private function generateValueNow() {
		$task = new AsyncCacheTask();
		$value = $task->generate(
			$this->key,
			$this->callback,
			$this->callbackParams,
			[
				'ttl' => $this->ttl,
				'negativeResponseTTL' => $this->negativeResponseTTL
			]
		);

		return $value;
	}

	private function scheduleValueGeneration() {
		$this->task = ( new AsyncCacheTask() )->wikiId( \F::app()->wg->CityId );
		$this->task->dupCheck();
		$this->task->call( 'generate',
			$this->key, $this->callback, $this->callbackParams,
			[ 'ttl' => $this->ttl, 'negativeResponseTTL' => $this->negativeResponseTTL ] );
		$this->task->queue();
	}

	private function logInfo( $mesg ) {
		WikiaLogger::instance()->info( $mesg, [
			'key' => $this->key,
			'time' => $this->currTime,
			'expires' => $this->getCacheExpire(),
			'ttlRemain' => $this->ttlRemain(),
			'staleTTLRemain' => $this->staleTTLRemain(),
			'pastTTL' => $this->currTime - $this->cacheExpire,
		] );
	}
}