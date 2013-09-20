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
	public function getUsers( $ids ) {
		wfProfileIn( __METHOD__ );

		$where = $this->parseIds( $ids );
		//check for cached data
		//by id first
		$result = $this->getUsersFromCacheById( $where[ 'user_id' ] );
		//then check for names
		$result = array_merge( $result, $this->getUsersFromCacheByName( $where[ 'user_name' ] ) );
		//get user by id
		$result = array_merge( $result, $this->getUsersObjects( $where ) );

		wfProfileOut( __METHOD__ );
		return array_unique( $result );
	}

	/** Helper methods for getUsers */

	/**
	 * Methods builds User object depending on Ids and Names in ids array
	 * @param $ids array list of user ids and names to look for
	 * @return array with User objects
	 */
	private function getUsersObjects( $ids ) {
		wfProfileIn( __METHOD__ );
		$result = array();

		if( isset( $ids[ 'user_id' ] ) ) {
			foreach( $ids[ 'user_id' ] as $id ) {
				$user = User::newFromId( $id );
				//skip default user
				if ( $user->getTouched() != 0 ) {
					$result[] = $user;
					$this->cacheUser( $user );
				}
			}
		}
		if( isset( $ids[ 'user_name' ] ) ) {
			foreach( $ids[ 'user_name' ] as $name ) {
				$user = User::newFromName( $name );
				//skip default user
				if ( $user->getTouched() != 0 ) {
					$result[] = $user;
					$this->cacheUser( $user );
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return array_unique( $result );
	}


	/**
	 * The method parse ids so they can be used in sql query and cache
	 * @param $ids array|string ids and names to parse
	 * @return array
	 */
	private function parseIds( $ids ) {

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
	private function getUsersFromCacheById( &$ids ) {
		//extract getting from mem cache
		$result = array();
		if ( is_array( $ids ) ) {
			foreach ( $ids as $id ) {
				if ( ( $value = $this->getUserFromLocalCacheById( $id ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} elseif ( ( $value = $this->getUserFromMemCacheById( $id ) ) !== false ) {
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
	private function getUsersFromCacheByName( &$names ) {
		//extract getting from mem cache
		$result = array();
		if ( is_array( $names ) ) {
			foreach ( $names as $name ) {
				if ( ( $value = $this->getUserFromLocalCacheByName( $name ) ) !== false ) {
					$result[ $value->getId() ] = $value;
				} elseif ( ( $value = $this->getUserFromMemCacheByName( $name ) ) !== false ) {
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


	private function getUserFromMemCacheById( $id ) {
		$cacheIdKey = wfSharedMemcKey( "UserCache:".$id );
		if ( ( $value = F::app()->wg->memc->get( $cacheIdKey ) ) !== false ) {
			//cache locally
			$this->cacheLocalUser( $value );
			return $value;
		}
		return false;
	}

	private function getUserFromMemCacheByName( $name ) {
		$cacheNameKey = wfSharedMemcKey( "UserCache:".$name );
		if ( ( $value = F::app()->wg->memc->get( $cacheNameKey ) ) !== false ) {
			if ( ( $value = $this->getUserFromMemCacheById( $value ) ) !== false ) {
				return $value;
			}
		}
		return false;
	}

	private function getUserFromLocalCacheById( $id ) {
		if ( isset( static::$userCache[ $id ] ) ) {
			return static::$userCache[ $id ];
		}
		return false;
	}

	private function getUserFromLocalCacheByName( $name ) {
		if ( isset( static::$userCacheMapping[ $name ] ) ) {
			return $this->getUserFromLocalCacheById( static::$userCacheMapping[ $name ] );
		}
		return false;
	}

	/**
	 * @param $user User
	 */
	private function cacheUser( $user ) {
		$cacheIdKey = wfSharedMemcKey( "UserCache:".$user->getId() );
		$cacheNameKey = wfSharedMemcKey( "UserCache:".$user->getName() );
		F::app()->wg->memc->set( $cacheIdKey, $user, static::CACHE_EXPIRATION );
		F::app()->wg->memc->set( $cacheNameKey, $user->getId(), static::CACHE_EXPIRATION );

		$this->cacheLocalUser( $user );
	}

	/**
	 * @param $user User
	 */
	private function cacheLocalUser( $user ) {
		static::$userCacheMapping[ $user->getName() ] = $user->getId();
		static::$userCache[ $user->getId() ] = $user;
	}
}