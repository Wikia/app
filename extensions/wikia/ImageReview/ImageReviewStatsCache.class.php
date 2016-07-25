<?php
/**
 * Created by PhpStorm.
 * User: harnas
 * Date: 25/07/16
 * Time: 13:26
 */


class ImageReviewStatsCache
{
	const CACHE_EXPIRE_TIME = 60 * 60;
	use Wikia\Logger\Loggable;

	/**
	 * Holds mapping between all available stats and Memcached keys used
	 * to store it's values.
	 * @var array
     */
	private $image_stats_cache_keys = [];

	const STATS_REVIEWER     = 'reviewer';
	const STATS_QUESTIONABLE = 'questionable';
	const STATS_REJECTED     = 'rejected';
	const STATS_INVALID      = 'invalid';
	const STATS_UNREVIEWED   = 'unreviewed';

	private $allowed_stats = [
		self::STATS_REVIEWER,
		self::STATS_QUESTIONABLE,
		self::STATS_REJECTED,
		self::STATS_INVALID,
		self::STATS_UNREVIEWED
	];

	/**
	 * global registry object
	 * @var $wg WikiaGlobalRegistry
	 */
	private $wg = null;

	/**
	 * ImageReviewStats constructor.
	 * @param $user_id string
	 * @param $wg WikiaGlobalRegistry
	 */
	public function __construct( $user_id, $wg ) {
		foreach ( $this->allowed_stats as $key ) {
			if ( $key == self::STATS_REVIEWER ) {
				$cache_key = wfSharedMemcKey( 'ImageReviewSpecialController', 'v2', 'image_stats', $user_id, $key );
			} else {
				$cache_key = wfSharedMemcKey( 'ImageReviewSpecialController', 'v2', 'image_stats', $key );
			}
			$this->image_stats_cache_keys[$key] = $cache_key;
		}
		$this->wg = $wg;
	}

	public function getStats() {
		$stats = [];
		foreach( $this->image_stats_cache_keys as $key => $cache_key ) {
			$value = $this->wg->memc->get( $cache_key );
			if ( !empty( $value ) ) {
				$stats[$key] = $value;
			}
		}
		return $stats;
	}

	public function setStats ( $new_stats ) {
		foreach ( $new_stats as $key => $value ) {
			if ( !in_array( $key, $this->allowed_stats ) ) {
				$this->warning( "ImageReviewLog", [
					'method' => __METHOD__,
					'message' => 'Incorrect cache stats key',
					'stats_key' => $key,
					'change' => $value,
				] );
				continue;
			}
			$this->wg->memc->set( $this->image_stats_cache_keys[$key], $value, self::CACHE_EXPIRE_TIME );
		}
	}

	/**
	 * This function is a wrapper over Memcached incr/decr to allow easy
	 * atomic incrementing or decrementing given stats without paying attention
	 * to the value. This is important since Memcached incr/decr only accepts
	 * unsigned integers.
	 *
	 * @param $key string key of the stats (see: $allowed_stats)
	 * @param $relative_change integer amount by which given stats should be changed
     */
	public function offsetStats ( $key, $relative_change ) {
		if ( !in_array( $key, $this->allowed_stats ) ) {
			$this->warning( "ImageReviewLog", [
				'method' => __METHOD__,
				'message' => 'Incorrect cache stats key',
				'stats_key' => $key,
				'change' => $relative_change,
			] );
			return;
		}

		if ( $relative_change > 0 ) {
			$this->wg->memc->incr( $this->image_stats_cache_keys[$key], $relative_change );
		} else {
			$this->wg->memc->decr( $this->image_stats_cache_keys[$key], -$relative_change );
		}
	}
}
