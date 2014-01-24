<?php

class UserProfilePageHelper {

	const GLOBAL_HIDDEN_WIKIS_ID = 0;
	const GLOBAL_HIDDEN_WIKIS_TYPE = 1;

	/**
	 * @brief Get user object from given title
	 *
	 * @desc getUserFromTitle() is sometimes called in hooks therefore I added returnUser flag and when
	 * it is set to true getUserFromTitle() will assign $this->user variable with a user object
	 *
	 * @return User
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


	public static function lockAndSetData( $memCSync, $getDataCallback, $lockFailCallback ) {
		// Try to update the data $count times before giving up
		$count = 5;
		while ( $count-- ) {
			if( $memCSync->lock() ) {
				$data = $getDataCallback();
				$success = false;
				// Make sure we have data
				if ( isset( $data ) ) {
					// See if we can set it successfully
					if ( $memCSync->set( $data ) ) {
						$success = true;
					}
				} else {
					// If there's no data don't bother doing anything
					$success = true;
				}
				$memCSync->unlock();
				if ( $success ) {
					break;
				}
			} else {
				usleep( rand( 1, $count * 1000 ) );
			}
		}
		// If count is -1 it means we left the above loop failing to update
		if ( $count == -1 ) {
			$lockFailCallback();
		}
	}

	private static function rebuildData( $memCSync, $city_id, $is_hidden ) {
		$changed = false;
		$hiddenWikis = $memCSync->get();
		if ( empty( $hiddenWikis ) && !is_array( $hiddenWikis ) ) {
			$hiddenWikis = self::getHiddenWikisFromDB();
		}
		if ( $is_hidden ) {
			if ( !in_array( $city_id, $hiddenWikis ) ) {
				$hiddenWikis[] = $city_id;
				$changed = true;
			}
		} else {
			if ( ( $index = array_search($city_id, $hiddenWikis ) ) !== false ) {
				unset( $hiddenWikis[$index] );
				$changed = true;
			}
		}
		if ( $changed ) {
			self::saveHiddenWikisDB( $hiddenWikis );
		}
		return $hiddenWikis;
	}

	private static function getHiddenWikiKey() {
		return  wfSharedMemcKey( __CLASS__, __METHOD__);
	}

	private static function getCache() {
		global $wgMemc;
		return new MemcacheSync( $wgMemc, self::getHiddenWikiKey() );
	}

	private static function getDb( $master = FALSE ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalDatawareDB );
	}

	private static function getHiddenWikisFromDB() {
		$value = self::getDb( false )->selectField(
			'global_registry',
			'item_value',
			array(
				'item_id' => self::GLOBAL_HIDDEN_WIKIS_ID,
				'item_type' => self::GLOBAL_HIDDEN_WIKIS_TYPE,
			),
			__METHOD__
		);
		$hiddenWikis = unserialize( $value );
		return is_array( $hiddenWikis ) ? $hiddenWikis : array();
	}

	public static function saveHiddenWikisDB( $hiddenWikis ) {
		self::getDb( true )->replace(
			'global_registry',
			array( 'item_id', 'item_type' ),
			array(
				'item_id' => self::GLOBAL_HIDDEN_WIKIS_ID,
				'item_type' => self::GLOBAL_HIDDEN_WIKIS_TYPE,
				'item_value' => serialize( $hiddenWikis )
			),
			__METHOD__
		);
	}

	public static function getHiddenWikiIds() {
		wfProfileIn(__METHOD__);
		$memCSync = self::getCache();

		$list = $memCSync->get();

		if ( empty( $list ) && !is_array( $list ) ) {
			self::lockAndSetData( $memCSync,
				function () use ( $memCSync, &$list ) {
					$list = self::getHiddenWikisFromDB();
					return $list;
				},
				function () {
					return array();
				}
			);
		}
		wfProfileOut(__METHOD__);
		return $list;
	}

	public static function updateHiddenWikis( $city_id, $is_hidden ) {
		wfProfileIn(__METHOD__);
		$memCSync = self::getCache();
		self::lockAndSetData( $memCSync,
			function() use ( $memCSync, $city_id, $is_hidden ) {
				return self::rebuildData( $memCSync, $city_id, $is_hidden );
			},
			function() use ( $memCSync) {
				// Delete the cache if we were unable to update to force a rebuild
				$memCSync->delete();
			}
		);
		wfProfileOut(__METHOD__);
	}

}
