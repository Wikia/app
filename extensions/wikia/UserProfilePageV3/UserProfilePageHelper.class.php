<?php

class UserProfilePageHelper {

	const GLOBAL_RESTRICTED_WIKIS_ID = 0;
	const GLOBAL_RESTRICTED_WIKIS_TYPE = 1;
	const GLOBAL_RESTRICTED_WIKIS_CACHE_TIME = 0;

	const GLOBAL_REGISTRY_TABLE = 'global_registry';

	/**
	 * @brief Get user object from given title
	 *
	 * @desc getUserFromTitle() is sometimes called in hooks therefore I added returnUser flag and when
	 * it is set to true getUserFromTitle() will assign $this->user variable with a user object
	 *
	 * @param null|String|Title $title
	 *
	 * @return User|null
	 *
	 * @author ADi
	 * @author nAndy
	 */
	static public function getUserFromTitle($title = null) {
		global $UPPNamespaces;

		wfProfileIn(__METHOD__);
		$wg = F::app()->wg;
		if( is_null($title) ) {
			$title = $wg->Title;
		}

		$user = null;
		if ($title instanceof Title && in_array($title->getNamespace(), $UPPNamespaces)) {
			// get "owner" of this user / user talk / blog page
			$parts = explode('/', $title->getText());
		} else {
			if ($title instanceof Title && $title->getNamespace() == NS_SPECIAL && ($title->isSpecial('Following') || $title->isSpecial('Contributions'))) {
				$target = $wg->Request->getVal('target');

				if (!empty($target)) {
					// Special:Contributions?target=FooBar (RT #68323)
					$parts = array($target);
				} else {
					// get user this special page referrs to
					$titleVal = $wg->Request->getVal('title', false);
					$parts = explode('/', $titleVal);

					// remove special page name
					array_shift($parts);
				}

				if ($title->isSpecial('Following') && !isset($parts[0])) {
					//following pages are rendered only for profile owners
					$user = $wg->User;
					wfProfileOut(__METHOD__);
					return $user;
				}
			}
		}


		if (!empty($parts[0])) {
			$userName = str_replace('_', ' ', $parts[0]);
			$user = User::newFromName($userName);
		}

		if (!($user instanceof User) && !empty($userName)) {
			//it should work only for title=User:AAA.BBB.CCC.DDD where AAA.BBB.CCC.DDD is an IP address
			//in previous user profile pages when IP was passed it returned false which leads to load
			//"default" oasis data to Masthead; here it couldn't be done because of new User Identity Box
			$user = new User();
			$user->mName = $userName;
			$user->mFrom = 'name';
		}

		if (!($user instanceof User) && empty($userName)) {
			//this is in case Blog:Recent_posts or Special:Contribution will be called
			//then in title there is no username and "default" user instance is $wgUser
			$user = $wg->User;
		}

		wfProfileOut(__METHOD__);
		return $user;
	}

	/**
	 * Generate Restricted Wikis Memcache key
	 *
	 * @return string
	 */
	private static function getRestrictedWikisKey() {
		return  wfSharedMemcKey( __CLASS__, __METHOD__);
	}

	/**
	 * Get database handler to Dataware
	 *
	 * @param bool $master - Master or slave DB
	 * @return DatabaseBase|TotallyFakeDatabase - Database hadler
	 */
	private static function getDb( $master = FALSE ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalDatawareDB );
	}

	/**
	 * Load restricted wiki ids from DB
	 *
	 * @return array - Array with restricted wiki ids
	 */
	private static function getRestrictedWikisFromDB() {
		wfProfileIn( __METHOD__ );
		$db = self::getDb( false );
		if ( !$db->tableExists( self::GLOBAL_REGISTRY_TABLE, __METHOD__ ) ) {
			Wikia::log( __METHOD__, sprintf('Table %s does not exist on Dataware DB', self::GLOBAL_REGISTRY_TABLE ));
			wfProfileOut( __METHOD__ );
			return array();
		}
		$value = $db->selectField(
			self::GLOBAL_REGISTRY_TABLE,
			'item_value',
			array(
				'item_id' => self::GLOBAL_RESTRICTED_WIKIS_ID,
				'item_type' => self::GLOBAL_RESTRICTED_WIKIS_TYPE,
			),
			__METHOD__
		);
		$restrictedWikis = unserialize( $value );
		wfProfileOut(__METHOD__);
		return is_array( $restrictedWikis ) ? $restrictedWikis : array();
	}

	/**
	 * Save restricted wiki ids to DB
	 * @param $restrictedWikis array - array with restricted wiki ids
	 */
	public static function saveRestrictedWikisDB( $restrictedWikis ) {
		if ( wfReadOnly() ) {
			return;
		}
		$db = self::getDb( true );
		if ( !$db->tableExists( self::GLOBAL_REGISTRY_TABLE, __METHOD__ ) ) {
			Wikia::log( __METHOD__, sprintf('Table %s does not exist on Dataware DB', self::GLOBAL_REGISTRY_TABLE ));
			return;
		}
		$db->replace(
			self::GLOBAL_REGISTRY_TABLE,
			array( 'item_id', 'item_type' ),
			array(
				'item_id' => self::GLOBAL_RESTRICTED_WIKIS_ID,
				'item_type' => self::GLOBAL_RESTRICTED_WIKIS_TYPE,
				'item_value' => serialize( $restrictedWikis )
			),
			__METHOD__
		);
		$db->commit();
	}

	/**
	 * Get restricted wiki ids
	 *
	 * @return array Array with restricted wiki ids
	 */
	public static function getRestrictedWikisIds() {
		return WikiaDataAccess::cache( self::getRestrictedWikisKey(), self::GLOBAL_RESTRICTED_WIKIS_CACHE_TIME,
			function () {
				return self::getRestrictedWikisFromDB();
			}
		);
	}

	/**
	 * Update Restricted wiki list if necessary
	 *
	 * @param $city_id integer Wiki id in wikicities
	 * @param $is_restricted bool True if wiki is restricted
	 */
	public static function updateRestrictedWikis( $city_id, $is_restricted ) {
		$changed = false;
		$restrictedWikis = self::getRestrictedWikisIds();
		if ( $is_restricted ) {
			if ( !in_array( $city_id, $restrictedWikis ) ) {
				$restrictedWikis[] = $city_id;
				$changed = true;
			}
		} else {
			if ( ( $index = array_search($city_id, $restrictedWikis ) ) !== false ) {
				unset( $restrictedWikis[$index] );
				$changed = true;
			}
		}
		if ( $changed ) {
			self::saveRestrictedWikisDB( $restrictedWikis );
			WikiaDataAccess::cachePurge( self::getRestrictedWikisKey() );
		}
	}

}
