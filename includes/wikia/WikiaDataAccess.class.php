<?php
use \Wikia\Logger\WikiaLogger;

/**
 * Abstraction classes for SQL data access (or any other external resource)
 * Intended to simplify code that retrieves data from SQL and caches results
 * Supports few methods of caching
 *
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
class WikiaDataAccess {

	/***********************************
	 * Configuration
	 **********************************/

	const LOCK_TIMEOUT = 60; // lock for at most 60s
	const LOCK_WAIT_INTERVAL_START = 10; // start with 10ms delay
	const LOCK_WAIT_INTERVAL_MAX = 1000; // max. delay between lock checks = 1s
	const CACHE_TIME_FACTOR_FOR_LOCK = 2; // How many times longer cache should be valid when using cacheWithLock

	/**
	 * WikiaDataAccess::USE_CACHE - does not have to be passed to cache or cacheWithLock [default]
	 * WikiaDataAccess::SKIP_CACHE - is equivalent of mcache=none for one variable - use this option wisely
	 * WikiaDataAccess::REFRESH_CACHE - is equivalent of mcache=writeonly for one variable - use this option wisely
	 */
	const USE_CACHE = 0;
	const SKIP_CACHE = 1;
	const REFRESH_CACHE = 2;

	// Default cache time of 5 minutes
	const DEFAULT_TTL = 300;

	/***********************************
	 * Public Interface
	 **********************************/

	/**
	 * Returns cached data if possible (up to $cacheTTL old) otherwise gets the data and saves the result in cache
	 * before returning it
	 *
	 * @param String $key memcached key
	 * @param Integer $cacheTTL TTL of memcached data in seconds
	 * @param callable $getData function name (http://php.net/manual/en/language.types.callable.php)
	 * @param Integer $command check description of constants above - USE_CACHE, SKIP_CACHE, REFRESH_CACHE
	 *
	 * @return Mixed|null
	 *
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */
	static function cache( $key, $cacheTTL, $getData, $command = self::USE_CACHE ) {
		return self::cacheWithOptions( $key, $getData, [
			'command' => $command,
			'cacheTTL' => $cacheTTL,
		]);
	}

	/**
	 * @param string $key The key to use for storing/retrieving this data.
	 * @param callable $getData A function to call that will return the data to cache.
	 * @param Array $options An array of other options to control cache behavior.  Keys are:
	 * 	[
	 * 		command => The caching command to use.  Options are class constants USE_CACHE, SKIP_CACHE, REFRESH_CACHE above.
	 * 		cacheTTL => The time in seconds to cache.  Default is class constant DEFAULT_TTL
	 * 		negativeCacheTTL => The time in seconds to cache a zero|null|empty result.  Default is cacheTTL
	 * 	]
	 *
	 * @return Mixed|null
	 */
	public static function cacheWithOptions( $key, callable $getData, Array $options = [] ) {
		$wg = F::app()->wg;

		// Set the default command to USE_CACHE
		$command = empty( $options['command'] ) ? self::USE_CACHE : $options['command'];

		// Get the cache TTL
		$cacheTTL = empty( $options['cacheTTL'] ) ? self::DEFAULT_TTL : $options['cacheTTL'];

		// Get the negative TTL, defaulting to the positive TTL.  Allow for a negative TTL of zero.
		$negativeCacheTTL = isset( $options['negativeCacheTTL'] ) ? $options['negativeCacheTTL'] : $cacheTTL;

		if ( $command == self::SKIP_CACHE ) {
			WikiaLogger::instance()->error( "WikiaDataAccess: cache disabled" , [
				'key' => $key,
				'exception' => new Exception()
			] );
		}

		$result = ($command == self::USE_CACHE) ? $wg->Memc->get( $key ) : null;

		if ( is_null( $result ) || $result === false ) {
			$result = $getData();
			$ttl = empty( $result ) ? $negativeCacheTTL : $cacheTTL;

			self::setCache( $key, $result, $ttl, $command );
		}

		return $result;
	}

	/**
	 * Purges cached object
	 * intended to use with function WikiaDataAccess::cache
	 *
	 * @param string $key Key to purge from the cache
	 *
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 */
	static function cachePurge( $key ) {
		F::app()->wg->Memc->delete( $key );
	}

	/**
	 * Helper to set cache along
	 * with Logging if getting was skipped
	 * but refresh is made
	 *
	 * @param String $key memcached key
	 * @param Mixed $result returned result of the callback function which gets data
	 * @param Integer $cacheTime TTL of memcached data in seconds
	 * @param Integer $command check description of constants above - USE_CACHE, SKIP_CACHE, REFRESH_CACHE
	 * 
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */
	static private function setCache( $key, $result, $cacheTime, $command = self::USE_CACHE ) {
		if ( $command == self::USE_CACHE || $command == self::REFRESH_CACHE ) {
			F::app()->wg->Memc->set( $key, $result, $cacheTime );
		}
	}

	/**
	 * Returns cached data if possible
	 * if cached data is older than $cacheTime but fresher than twice that time
	 *  - first thread to request it will start getting data
	 *  - other threads in the meantime will continue receiving old data
	 * if there's no cached data fresher than double of $cacheTime
	 *  - first thread to request it will start getting data
	 *  - other threads will wait for the first thread to finish, afterwards they will receive
	 *    the same data as the first thread
	 *
	 * @param string $key memcached key
	 * @param int $cacheTime TTL of cache in seconds
	 * @param callable $getData Function used to get data to cache
	 * @param int $command Whether to fully cache, write-only cache or skip cache (see method cache())
	 * @param int $lockTimeout Time out in seconds to wait for lock
	 *
	 * @throws MWException
	 * @return Mixed
	 *
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */
	static function cacheWithLock( $key, $cacheTime, $getData, $command = self::USE_CACHE, $lockTimeout = self::LOCK_TIMEOUT ) {
		wfProfileIn( __METHOD__ );
		$app = F::app();

		if ( $command == self::SKIP_CACHE ) {
			Wikia::log( __METHOD__, 'debug', "Cache disabled for key:{$key}, if this is on production please contact the author of the code.", true);
		}

		$baseKey = $key;
		$keyLock = $key . ':lock';
		$key .= '-withDate';

		$startTime = microtime(true);

		$result = ($command == self::USE_CACHE) ? static::getDataAndVerify($app, $key) : null;

		if ( is_null( $result ) ) {

			list($gotLock, $wasLocked) = self::lock( $keyLock, true, $lockTimeout );

			// give it a try and check if the data is present
			$result = ($command == self::USE_CACHE) ? static::getDataAndVerify($app, $key, true) : null;

			if ( is_null( $result ) ) {
				// no luck, let's see what we can do
				if ( $gotLock ) {
					// if we got a lock regenerate data
					$result = array(
						'data' => $getData(),
						'time' => wfTimestamp( TS_UNIX )
					);
					self::setCache( $key, $result, $cacheTime * self::CACHE_TIME_FACTOR_FOR_LOCK, $command );
				} else {
					// fail early and do not blow the entire system
					WikiaLogger::instance()->debug("WikiaDataAccess could not obtain lock to generate data for: {$baseKey}",[
						'wasLocked' => $wasLocked,
						'timeProcessed' => microtime(true) - $startTime,
						'key' => $baseKey,
					]);
					throw new MWException("WikiaDataAccess could not obtain lock to generate data for: {$baseKey}");
				}
			}

			if( $gotLock ) self::unlock( $keyLock );

		} else {
			$now = wfTimestamp( TS_UNIX );
			if( $result['time'] >= $now - $cacheTime ) {
				// still fresh enough
			} else {
				// we could use the data, but maybe we should regenerate
				list($gotLock, $wasLocked) = self::lock( $keyLock, false );

				if( $gotLock && !$wasLocked ) {
					// we are the first thread to find that data older than $cacheTime but fresher than $oldCacheTime
					// let's try to get new data
					// because we hold the lock other threads won't try to generate it at the same time
					$result = array(
						'data' => $getData(),
						'time' => wfTimestamp( TS_UNIX )
					);
					self::setCache( $key, $result, $cacheTime * self::CACHE_TIME_FACTOR_FOR_LOCK, $command );
				} else {
					// what we already have in $result is good enough
					// and another thread is generating that data anyway for future requests
				}
				if( $gotLock ) {
					self::unlock( $keyLock );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $result['data'];
	}

	/**
	 * Purges cached object
	 * Forces object regeneration even if another thread hold the lock
	 * intended to use with function WikiaDataAccess::cacheWithLock
	 *
	 * @param string $key
	 *
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 */
	static function cacheWithLockPurge( $key ) {
		$Memc = F::app()->wg->Memc;
		$keyLock = $key . ':lock';
		$key .= '-withDate';
		$Memc->delete( $keyLock );
		$Memc->delete( $key );
	}

	/***********************************
	 * Private functions
	 **********************************/

	/**
	 * @param string $key
	 * @param bool $waitForLock
	 * @param int $lockTimeout Lock timeout (in seconds)
	 *
	 * @return array
	 */
	static private function lock( $key, $waitForLock = true, $lockTimeout =  self::LOCK_TIMEOUT   ) {
		$app = F::app();
		$wasLocked = false;
		$start = microtime(true);
		$timeout = $waitForLock ? ( $start + $lockTimeout ) : 0;
		$interval = self::LOCK_WAIT_INTERVAL_START;
		while ( !($gotLock = $app->wg->Memc->add( $key, 1, $lockTimeout )) && microtime(true) < $timeout ) {
			$wasLocked = true;
			usleep($interval * 1000); // convert ms to us
			$interval = min( $interval * 2, self::LOCK_WAIT_INTERVAL_MAX );
		}

		if ( mt_rand( 1, 100 ) <= 5 ) {  // 5% sampling
			$lockTime = (int)( ( microtime( true ) - $start ) * 1000000 );

			WikiaLogger::instance()->debug( 'WikiaDataAccessLock', [ 'waitForLock' => $waitForLock, 'gotLock' => $gotLock,
				'wasLocked' => $wasLocked, 'lockTime' => $lockTime, 'key' => $key ] );
		}

		return array($gotLock, $wasLocked);
	}

	static private function unlock( $key ) {
		F::app()->wg->Memc->delete( $key );
	}

	/**
	 * Internal use by cacheWithLock code-path
	 *
	 * @param WikiaApp $app
	 * @param string $key
	 * @param bool $clearLocalCache set it to true to force checking for updated value
	 *
	 * @return null
	 */
	static private function getDataAndVerify( $app, $key, $clearLocalCache = false ) {
		if ( $clearLocalCache ) {
			$app->wg->Memc->clearLocalCache( $key );
		}
		$result = $app->wg->Memc->get( $key );
		if( !is_array($result) || !array_key_exists('data',$result) || !array_key_exists('time',$result)) {
			$result = null;
		}
		return $result;
	}

	/**
	 * Execute given function in pseudo critical section.
	 *
	 * Two processes can enter pseudo critical section when:
	 * - memcached servers are misbehaving (locks are acquired on different memcached instances)
	 * - critical section execution time exceeds $timeout (seconds)
	 *
	 * Note: Fatal errors in the callback will prevent lock from being released.
	 *
	 * @param string $key Lock key (must be a memcached key-compatible string)
	 * @param int $timeout Lock timeout (in seconds)
	 * @param callable $fn Function to be executed in pseudo critical section
	 *
	 * @return mixed
	 * @throws CannotAcquireLockException
	 */
	static public function pseudoCriticalSection( $key, $timeout, callable $fn ) {
		$key .= ':CRITICAL_SECTION';
		list( $gotLock, $wasLocked ) = self::lock( $key, true, $timeout );

		if ( !$gotLock ) {
			throw new CannotAcquireLockException('Could not acquire critical section lock for: ' . $key);
		}

		try {
			$result = $fn();
		} finally {
			self::unlock( $key );
		}

		return $result;
	}

}

/*
////////////////////////////////
//       EXAMPLE USAGES
////////////////////////////////

// Example 1:
// Callback as a variable

$getData = function () {
	$app = F::app();

	$db = wfGetDB(DB_SLAVE);

	$result = $db->select('page', '*', array('page_id' => '(SELECT MIN(page_id) from page'));

	$data = array();

	while ($row = $db->fetchObject($result)) {
		$data[] = get_object_vars($row);
	}

	return $data;
};

$key = 'MyModule:MyFunction-version:1-user:Abc';
$cacheTime = 5;  // seconds

$myPreciousData = WikiaDataAccess::cache($key, $cacheTime, $getData);


 // Example 2:
 // Passing a param to the callback function using closure

	function getData ($id) {
		$app = F::app();
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
		$result = $db->select('city_list', '*', array('city_id > ' . $id));
		$data = array();
		while ($row = $db->fetchObject($result)) {
			$data[] = get_object_vars($row);
		}
		return $data;
	};

	$myPreciousData = WikiaDataAccess::cache($key, $cacheTime, function () use ($id) {
		return getData($id);
	});


 // Example 3:
 // Passing an object method as a callback

	class DataGetter {
		public function getData () {
			$app = F::app();
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
			$result = $db->select('city_list', '*', array());
			$data = array();
			while ($row = $db->fetchObject($result)) {
				$data[] = get_object_vars($row);
			}
			return $data;
		}
	}

	$dataGetter = new dataGetter();
	$myPreciousData = WikiaDataAccess::cache($key, $cacheTime, array($dataGetter, 'getData'));


 // Example 4:
 // Passing a param to the object method using closure

	class DataGetter1 {
		public function getData ($id) {
			$app = F::app();
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
			$result = $db->select('city_list', '*', array('city_id > ' . $id));
			$data = array();
			while ($row = $db->fetchObject($result)) {
				$data[] = get_object_vars($row);
			}
			return $data;
		}
	}

	$myPreciousData = WikiaDataAccess::cache($key, $cacheTime, function () use ($id) {
		$dataGetter = new DataGetter1();
		return $dataGetter->getData($id);
	});

*/