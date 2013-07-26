<?php

/**
 * Abstraction classes for SQL data access (or any other external resource)
 * Intended to simplify code that retrieves data from SQL and caches results
 * Supports few methods of caching
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

class WikiaDataAccess {

	/***********************************
	 * Configuration
	 **********************************/

	const LOCK_TIMEOUT = 60; // lock for at most 60s
	const CACHE_TIME_FACTOR_FOR_LOCK = 2; // How many times longer cache should be valid when using cacheWithLock

	/**
	 * WikiaDataAccess::USE_CACHE - does not have to be passed to cache or cacheWithLock [default]
	 * WikiaDataAccess::SKIP_CACHE - is equivalent of mcache=none for one variable
	 * WikiaDataAccess::REFRESH_CACHE - is equivalent of mcache=writeonly for one variable
	 */
	const USE_CACHE = 0;
	const SKIP_CACHE = 1;
	const REFRESH_CACHE = 2;

	/***********************************
	 * Public Interface
	 **********************************/


	/**
	 * Simple direct data getter
	 * Provider here for consistency
	 * Should not be used - does not cache results
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 */
	static function simpleDirect( $getData ) {
		return $getData();
	}


	/**
	 * returns cached data if possible (up to $cacheTime old)
	 * otherwise gets the data and saves the result in cache before returning it
	 *
	 * @params String $key memcached key
	 * @params Integer $cacheTime TTL of memcached data in seconds
	 * @params Callback $getData function name (http://php.net/manual/en/language.types.callable.php)
	 * @param $skipCache Integer
	 * 
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */
	static function cache( $key, $cacheTime, $getData, $command = self::USE_CACHE ) {
		$wg = F::app()->wg;

		if ( $command == self::SKIP_CACHE ) {
			Wikia::log( __METHOD__, 'debug', "Cache disabled for key:{$key}, if this is on production please contact the author of the code.", true);
		}

		$result = ($command == self::USE_CACHE) ? $wg->Memc->get( $key ) : null;

		if ( is_null( $result ) || $result === false ) {
			$result = $getData();
			self::setCache( $key, $result, $cacheTime, $command );
		}

		return $result;
	}

	/**
	 * Purges cached object
	 * intended to use with function WikiaDataAccess::cache
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 */
	static function cachePurge( $key ) {
		F::app()->wg->Memc->delete( $key );
	}

	/**
	 *
	 * Helper to set cache along
	 * with Logging if getting was skipped
	 * but refresh is made
	 *
	 * @param $key String
	 * @param $result Mixed
	 * @param $cacheTime Integer
	 * @param $command Integer
	 * 
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */
	static private function setCache( $key, $result, $cacheTime, $command = self::USE_CACHE ) {
		if ( $command == self::USE_CACHE || $command == self::REFRESH_CACHE ) {
			F::app()->wg->Memc->set( $key, $result, $cacheTime );
		}

		if ( $command == self::REFRESH_CACHE ) {
			Wikia::log( __METHOD__, 'debug', "Cache refreshed for key:{$key}, if this is on production please contact the author of the code.", true );
		}
	}

	/**
	* returns cached data if possible
	* if cached data is older than $cacheTime but fresher than twice that time
	*  - first thread to request it will start getting data
	*  - other threads in the meantime will continue receiving old data
	* if there's no cached data fresher than double of $cacheTime
	*  - first thread to request it will start getting data
	*  - other threads will wait for the first thread to finish, afterwards they will receive
	*    the same data as the first thread
	* 
	* @author Piotr Bablok <pbablok@wikia-inc.com>
	* @author Jakub Olek <jolek@wikia-inc.com>
	*/
	static function cacheWithLock( $key, $cacheTime, $getData, $command = self::USE_CACHE ) {
		$app = F::app();

		if ( $command == self::SKIP_CACHE ) {
			Wikia::log( __METHOD__, 'debug', "Cache disabled for key:{$key}, if this is on production please contact the author of the code.", true);
		}

		$keyLock = $key . ':lock';
		$key .= '-withDate';

		$result = ($command == self::USE_CACHE) ? static::getDataAndVerify($app, $key) : null;

		if ( is_null( $result ) ) {

			list($gotLock, $wasLocked) = self::lock( $keyLock );

			if( $wasLocked && $gotLock ) {
				self::unlock( $keyLock );
				$gotLock = false;
				$result = ($command == self::USE_CACHE) ? static::getDataAndVerify($app, $key) : null;
			}

			if( is_null( $result ) ) {
				$result = array(
					'data' => $getData(),
					'time' => wfTimestamp( TS_UNIX )
				);
				self::setCache( $key, $result, $cacheTime * self::CACHE_TIME_FACTOR_FOR_LOCK, $command );
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
					// because we hold the lock other threads won't try to generate it in the same time
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

		return $result['data'];
	}

	/**
	 * Purges cached object
	 * Forces object regeneration even if another thread hold the lock
	 * intended to use with function WikiaDataAccess::cacheWithLock
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


	static private function lock( $key, $waitForLock = true ) {
		$app = F::app();
		$wasLocked = false;
		$timeout = $waitForLock ? self::LOCK_TIMEOUT : 1;
		$gotLock = false;
		for ( $i = 0; $i < $timeout && !($gotLock = $app->wg->Memc->add( $key, 1, self::LOCK_TIMEOUT )); $i++ ) {
			$wasLocked = true;
			sleep( 1 );
		}

		return array($gotLock, $wasLocked);
	}

	static private function unlock( $key ) {
		F::app()->wg->Memc->delete( $key );
	}

	/*
	 * Internal use by cacheWithLock code-path
	 */
	static private function getDataAndVerify( $app, $key ) {
		$result = $app->wg->Memc->get( $key );
		if( !is_array($result) || $result === false || !isset($result['data']) || !isset($result['time'])) {
			$result = null;
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