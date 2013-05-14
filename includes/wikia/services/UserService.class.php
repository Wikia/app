<?php
class UserService extends Service {

	const CACHE_EXPIRATION = 86400;//1 day

	private static $userCache;
	private static $userCacheMapping;

	public static function getNameFromUrl($url) {
		$out = false;
		
		$userUrlParted = explode(':', $url, 3);
		if( isset($userUrlParted[2]) ) {
			$user = User::newFromName( urldecode($userUrlParted[2]) );
			if( $user instanceof User ) {
				$out = $user->getName();
			}
		}

		return $out;
	}

	/**
	 * Method for acquiring the list of users from database as User class objects.
	 *
	 * @param $ids array|string list of ids or names for users, should be specified as
	 * array( 'user_id' => array(ids)|id [, 'user_name' => array(names)|name ]) or array( ids and names )
	 * @return mixed array list of User class objects
	 */
	public static function getUsers( $ids ) {
		wfProfileIn( __METHOD__ );

		$where = static::parseIds( $ids );
		//check for cached data
		//by id first
		$result = static::getUsersFromCacheById( $where[ 'user_id' ] );
		//then check for names
		$result = array_merge( $result, static::getUsersFromCacheByName( $where[ 'user_name' ] ) );
		//unset empty statements
		if ( empty( $where[ 'user_id' ] ) ) { unset( $where[ 'user_id' ] );	}
		if ( empty( $where[ 'user_name' ] ) ) { unset( $where[ 'user_name' ] );	}

		if ( !empty( $where ) ) {
			//init db connection
			$result = array_merge( $result, static::queryDbForUsers( $where ) );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/** Helper methods for getUsers */

	/**
	 * Gets the users fro given where conditions
	 * @param $where array filled with where condition for quering db
	 * @return array
	 */
	private static function queryDbForUsers( $where ) {
		global $wgExternalSharedDB;
		$result = array();
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$conds = $dbr->makeList( $where, LIST_OR );
		$s = $dbr->selectSQLText( 'user', '*', $conds, __METHOD__ );
		$s = $dbr->query( $s, __METHOD__ );

		while ( ( $row = $s->fetchObject() ) !== false ) {
			$user = User::newFromRow( $row );
			$result[ $row->user_id ] = $user;
			static::cacheUser( $user );
		}
		return $result;
	}


	/**
	 * The method parse ids so they can be used in sql query and cache
	 * @param $ids array|string ids and names to parse
	 * @return array
	 */
	private static function parseIds( $ids ) {

		if ( !isset( $ids[ 'user_id' ] ) && !isset( $ids[ 'user_name' ] ) ) {
			$conds = array();
			//make it array, so we can filter it using array_filter
			if ( !is_array( $ids ) ) {
				$ids = array( $ids );
			}
			foreach ( $ids as $id ) {
				if ( is_numeric( $id ) ) {
					$numeric[] = $id;
				} elseif( !empty( $id ) ) {
					$text[] = $id;
				}
			}
			if ( !empty( $numeric ) ) {
				$conds[ 'user_id' ] = $numeric;
			}
			if ( !empty( $text ) ) {
				$conds[ 'user_name' ] = $text;
			}
			return $conds;
		}
		return $ids;
	}

	/**
	 * Gets the users objects from local cache, and in case of miss from memcache. Method changes the ids list,
	 * ids found in cache are removed from array.
	 * @param $ids array list of user ids to check in cache
	 * @return array User objects list
	 */
	private static function getUsersFromCacheById( &$ids ) {
		//extract getting from mem cache
		$result = array();
		if ( is_array( $ids ) ) {
			foreach ( $ids as $id ) {
				if ( ( $value = static::getUserFromLocalCacheById( $id ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} elseif ( ( $value = static::getUserFromMemCacheById( $id ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} else {
					$idsToQuery[] = $id;
				}
			}

			//set the list of ids that werent found in cache
			if ( !empty( $idsToQuery ) ) {
				$ids = $idsToQuery;
			} else {
				$ids = null;
			}
		}

		return $result;
	}

	/**
	 * Looks in cache for User object by user name, local cache is firstly check then memcache. Method changes the names list,
	 * names found in cache are removed from array.
	 * @param $names array list of user names to check in cache
	 * @return array list of founded User objects
	 */
	private static function getUsersFromCacheByName( &$names ) {
		//extract getting from mem cache
		$result = array();
		if ( is_array( $names ) ) {
			foreach ( $names as $name ) {
				if ( ( $value = static::getUserFromLocalCacheByName( $name ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} elseif ( ( $value = static::getUserFromMemCacheByName( $name ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} else {
					$namesToQuery[] = $name;
				}
			}

			//set the list of names that werent found in cache
			if ( !empty( $namesToQuery ) ) {
				$names = $namesToQuery;
			} else {
				$names = null;
			}
		}

		return $result;
	}


	private static function getUserFromMemCacheById( $id ) {
		$cacheIdKey = F::app()->wf->sharedMemcKey( "UserCache:".$id );
		if ( ( $value = F::app()->wg->memc->get( $cacheIdKey ) ) !== false ) {
			//cache locally
			static::cacheLocalUser( $value );
			return $value;
		}
		return false;
	}

	private static function getUserFromMemCacheByName( $name ) {
		$cacheNameKey = F::app()->wf->sharedMemcKey( "UserCache:".$name );
		if ( ( $value = F::app()->wg->memc->get( $cacheNameKey ) ) !== false ) {
			if ( ( $value = static::getUserFromMemCacheById( $value ) ) !== false ) {
				return $value;
			}
		}
		return false;
	}

	private static function getUserFromLocalCacheById( $id ) {
		if ( isset( static::$userCache[ $id ] ) ) {
			return static::$userCache[ $id ];
		}
		return false;
	}

	private static function getUserFromLocalCacheByName( $name ) {
		if ( isset( static::$userCacheMapping[ $name ] ) ) {
			return static::getUserFromLocalCacheById( static::$userCacheMapping[ $name ] );
		}
		return false;
	}

	/**
	 * @param $user User
	 */
	private static function cacheUser( $user ) {
		$cacheIdKey = F::app()->wf->sharedMemcKey( "UserCache:".$user->getId() );
		$cacheNameKey = F::app()->wf->sharedMemcKey( "UserCache:".$user->getName() );
		F::app()->wg->memc->set( $cacheIdKey, $user, static::CACHE_EXPIRATION );
		F::app()->wg->memc->set( $cacheNameKey, $user->getId(), static::CACHE_EXPIRATION );

		static::cacheLocalUser( $user );
	}

	/**
	 * @param $user User
	 */
	private static function cacheLocalUser( $user ) {
		static::$userCacheMapping[ $user->getName() ] = $user->getId();
		static::$userCache[ $user->getId() ] = $user;
	}
}