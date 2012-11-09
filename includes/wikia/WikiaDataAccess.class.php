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
	 *
	 * @author Piotr Bablok <pbablok@wikia-inc.com>
	 */
	static function cache( $key, $cacheTime, $getData ) {
		$app = F::app();

		$result = $app->wg->Memc->get( $key );

		if( is_null($result) || $result === false ) {
			$result = call_user_func($getData);
			$app->wg->Memc->set( $key, $result, $cacheTime );
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
	* returns cached data if possible
	* if cached data is older than $cacheTime but fresher than twice that time
	*  - first thread to request it will start getting data
	*  - other threads in the meantime will continue receiving old data
	* if there's no cached data fresher than double of $cacheTime
	*  - first thread to request it will start getting data
	*  - other threads will wait for the first thread to finish, afterwards they will receive
	*    the same data as the first thread
	* @author Piotr Bablok <pbablok@wikia-inc.com>
	*/
	static function cacheWithLock( $key, $cacheTime, $getData ) {
		$app = F::app();

		$keyLock = $key . ':lock';
		$key .= '-withDate';

		$tryCache = function( $key ) use ( $app ) {
			$result = $app->wg->Memc->get( $key );
			if( !is_array($result) || $result === false || !isset($result['data']) || !isset($result['time'])) {
				$result = null;
			}
			return $result;
		};

		$result = $tryCache($key);

		if( is_null($result) ) {

			list($gotLock, $wasLocked) = self::lock( $keyLock );

			if( $wasLocked && $gotLock ) {
				self::unlock( $keyLock );
				$gotLock = false;
				$result = $tryCache($key);
			}

			if( is_null($result) ) {
				$result = array(
					'data' => $getData(),
					'time' => $app->wf->Timestamp( TS_UNIX )
				);
				$app->wg->Memc->set( $key, $result, $cacheTime * 2 );
			}

			if( $gotLock ) self::unlock( $keyLock );

		} else {
			$now = $app->wf->Timestamp( TS_UNIX );
			if( $result['time'] >= $now - $cacheTime ) {
				// still fresh enough
			} else {
				// we could use the data, but maybe we should regenerate
				list($gotLock, $wasLocked) = self::lock( $keyLock, false );

				if( !$wasLocked && $gotLock ) {
					// we are the first thread to find that data older than $cacheTime but fresher than $oldCacheTime
					// let's try to get new data
					// because we hold the lock other threads won't try to generate it in the same time
					$result = array(
						'data' => $getData(),
						'time' => $app->wf->Timestamp( TS_UNIX )
					);
					$app->wg->Memc->set( $key, $result, $cacheTime * 2 );
					self::unlock( $keyLock );
				} else {
					// what we already have in $result is good enough
					// and another thread is generating that data anyway for future requests
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
		$app = F::app();
		$app->wg->Memc->delete( $key );
	}

}

////////////////////////////////
//       EXAMPLE USAGE
////////////////////////////////
//
//$getData = function() {
//	$app = F::app();
//
//	$db = $app->wf->GetDB( DB_SLAVE );
//
//	$result = $db->select('page', '*', array('page_id'=> '(SELECT MIN(page_id) from page') );
//
//	$data = array();
//
//	while( $row = $db->fetchObject( $result ) ) {
//		$data[] = get_object_vars( $row );
//	}
//
//	return $data;
//};
//
//$key = 'MyModule:MyFunction-version:1-user:Abc';
//$cacheTime = 5; // seconds
//
//$myPreciousData = WikiaDataAccess::cache( $key, $cacheTime, $getData );