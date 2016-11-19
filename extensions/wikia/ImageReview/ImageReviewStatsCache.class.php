<?php

class ImageReviewStatsCache {
	const CACHE_EXPIRE_TIME = 60 * 60;
	use Wikia\Logger\Loggable;

	/**
	 * Holds mapping between all available stats and Memcached keys used
	 * to store it's values.
	 * @var array
     */
	private $imageStatsCacheKeys = [];

	const STATS_REVIEWER     = 'reviewer';
	const STATS_QUESTIONABLE = 'questionable';
	const STATS_REJECTED     = 'rejected';
	const STATS_INVALID      = 'invalid';
	const STATS_UNREVIEWED   = 'unreviewed';

	private $allowedStats = [
		self::STATS_REVIEWER,
		self::STATS_QUESTIONABLE,
		self::STATS_REJECTED,
		self::STATS_INVALID,
		self::STATS_UNREVIEWED
	];

	/**
	 * global registry object
	 * @var $wg MemcachedPhpBagOStuff
	 */
	private $memc;

	/**
	 * ImageReviewStats constructor.
	 * @param $userId string
	 */
	public function __construct( $userId ) {
		foreach ( $this->allowedStats as $key ) {
			if ( $key == self::STATS_REVIEWER ) {
				$cache_key = wfSharedMemcKey( 'ImageReviewSpecialController', 'v2', 'image_stats', $userId, $key );
			} else {
				$cache_key = wfSharedMemcKey( 'ImageReviewSpecialController', 'v2', 'image_stats', $key );
			}
			$this->imageStatsCacheKeys[$key] = $cache_key;
		}
		$this->memc = F::app()->wg->Memc;
	}

	/**
	 * @return array
     */
	public function getAllowedStats() {
		return $this->allowedStats;
	}

	public function getStatsKey( $key ) {
		if ( !in_array( $key, $this->allowedStats ) ) {
			$this->warning( "ImageReviewLog", [
				'method' => __METHOD__,
				'message' => 'Incorrect cache stats key',
				'stats_key' => $key,
			] );
			return '';
		}
		return $this->imageStatsCacheKeys[$key];
	}

	public function getStats() {
		$stats = [];
		foreach( $this->imageStatsCacheKeys as $key => $cacheKey ) {
			$value = $this->memc->get( $cacheKey );
			if ( !empty( $value ) ) {
				$stats[$key] = $value;
			}
		}
		return $stats;
	}
	
	public function setStats( $newStats ) {
		foreach ( $newStats as $key => $value ) {
			$cacheKey = $this->getStatsKey( $key );
			if ( empty( $cacheKey ) ) {
				continue;
			}

			$this->memc->set( $cacheKey, $value, self::CACHE_EXPIRE_TIME );
		}
	}

	public function clearStats() {
		foreach( $this->imageStatsCacheKeys as $key => $cacheKey ) {
			$this->memc->delete( $cacheKey );
		}
	}
	
	/**
	 * This function is a wrapper over Memcached incr/decr to allow easy
	 * atomic incrementing or decrementing given stats without paying attention
	 * to the value. This is important since Memcached incr/decr only accepts
	 * unsigned integers.
	 *
	 * @param $key string key of the stats (see: $allowed_stats)
	 * @param $relativeChange integer amount by which given stats should be changed
     */
	public function offsetStats ( $key, $relativeChange ) {
		$cacheKey = $this->getStatsKey( $key );
		if ( empty( $cacheKey ) ) {
			return;
		}

		if ( $relativeChange > 0 ) {
			$this->memc->incr( $cacheKey, $relativeChange );
		} else {
			$this->memc->decr( $cacheKey, -$relativeChange );
		}
	}
}
