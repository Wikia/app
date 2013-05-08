<?php
class UserService extends Service {

	const CACHE_EXPIRATION = 86400;//1 day

	private static $userCache;
	private static $userMapping;

	private static function getUsersFromCache( &$ids ) {
		$result = array();
		//set prefix, so we take correct cached data
		global $wgCachePrefix;
		$tmpCachePrefix = $wgCachePrefix;
		$wgCachePrefix = 'GlobalUserCache';

		if ( !empty( $ids[ 'user_id' ] ) ) {
			foreach ( $ids[ 'user_id'] as $key => $id ) {
				if ( isset( static::$userCache[ $id ] ) ) {
					$result[ $id ] = static::$userCache[ $id ];
					unset( $ids[ 'user_id' ][ $key ] );
				} else {
					//if not cached locally, try memc
					$cacheIdKey = F::app()->wf->memcKey( $id );
					if ( ( $value = F::app()->wg->memc->get( $cacheIdKey ) ) !== false ) {
						//cache locally
						static::cacheLocalUser( $value );
						$result[ $value->getId() ] = $value;
						unset( $ids[ 'user_id' ][ $key ] );
					}
				}
			}
		}
		if ( !empty( $ids[ 'user_name' ] ) ) {
			foreach ( $ids[ 'user_name'] as $key => $name ) {
				if ( isset( static::$userMapping[ $name ] ) ) {
					$id = static::$userMapping[ $name ];
					$result[ $id ] = static::$userCache[ $id ];
					unset( $ids[ 'user_name' ][ $key ] );
				} else {
					//if not cached locally, try memc
					$cacheNameKey = F::app()->wf->memcKey( $name );
					if ( ( $value = F::app()->wg->memc->get( $cacheNameKey ) ) !== false ) {
						$cacheIdKey = F::app()->wf->memcKey( $value );
						$userValue = F::app()->wg->memc->get( $cacheIdKey );
						if ( $userValue !== false ) {
							//cache locally
							static::cacheLocalUser( $userValue );
							$result[ $userValue->getId() ] = $userValue;
							unset( $ids[ 'user_name' ][ $key ] );
						}
					}
				}
			}
		}
		//set global cache prefix back to previous value
		$wgCachePrefix = $tmpCachePrefix;

		if ( empty( $ids[ 'user_id' ] ) ) {
			unset ( $ids[ 'user_id' ] );
		}
		if ( empty( $ids[ 'user_name' ] ) ) {
			unset ( $ids[ 'user_name' ] );
		}

		return $result;
	}

	/**
	 * @param $user User
	 */
	private static function cacheUser( $user ) {
		global $wgCachePrefix;
		$tmpCachePrefix = $wgCachePrefix;
		$wgCachePrefix = 'GlobalUserCache';
		$cacheIdKey = F::app()->wf->memcKey( $user->getId() );
		$cacheNameKey = F::app()->wf->memcKey( $user->getName() );
		$wgCachePrefix = $tmpCachePrefix;
		F::app()->wg->memc->set( $cacheIdKey, $user, static::CACHE_EXPIRATION );
		F::app()->wg->memc->set( $cacheNameKey, $user->getId(), static::CACHE_EXPIRATION );

		static::cacheLocalUser( $user );
	}

	private static function cacheLocalUser( $user ) {
		static::$userMapping[ $user->getName() ] = $user->getId();
		static::$userCache[ $user->getId() ] = $user;
	}
	
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

		if ( !isset( $ids[ 'user_id' ] ) && !isset( $ids[ 'user_name' ] ) ) {
			$conds = array();
			//make it array, so we can filter it using array_filter
			if ( !is_array( $ids ) ) {
				$ids = array( $ids );
			}
			foreach ( $ids as $id ) {
				if ( is_numeric( $id ) ) {
					$numeric[] = $id;
				} else {
					$text[] = $id;
				}
			}
			if ( !empty( $numeric ) ) {
				$conds[ 'user_id' ] = $numeric;
			}
			if ( !empty( $text ) ) {
				$conds[ 'user_name' ] = $text;
			}
		} else {
			$conds = $ids;
		}

		//check for cached data
		$result = static::getUsersFromCache( $conds );
		if ( !empty( $conds ) ) {
			//init db connection
			$dbr = wfGetDB( DB_SLAVE );
			$where = $dbr->makeList( $conds, LIST_OR );
			$s = $dbr->selectSQLText( 'user', '*', $where, __METHOD__ );
			$s = $dbr->query( $s, __METHOD__ );

			while ( ( $row = $s->fetchObject() ) !== false ) {
				$user = User::newFromRow( $row );
				$result[ $row->user_id ] = $user;
				static::cacheUser( $user );
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
}