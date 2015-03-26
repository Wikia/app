<?php
/**
* SharedUserrights -- manage global rights stored in shared database
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Lucas 'TOR' Garczewski <tor@wikia.com>
* @author: Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
*
* @copyright Copyright (C) 2008 Lucas 'TOR' Garczewski, Wikia, Inc.
* @copyright Copyright (C) 2010 Maciej Błaszkowski (Marooned), Wikia, Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
* @todo: display global rights in Listusers
*
*/

class UserRights {

	private static $globalGroups = [];

	/**
	 * data provider
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 *
	 * @param User $user
	 * @return array list of global groups
	 */
	static function getGlobalGroups( User $user ) {
		if ( $user->isAnon() ) {
			return [];
		}

		$fname = __METHOD__;
		$userId = $user->getId();

		if ( !isset( self::$globalGroups[$userId] ) ) {
			$globalGroups = WikiaDataAccess::cache(
				self::getMemcKey( $user ),
				WikiaResponse::CACHE_LONG,
				function() use ( $userId, $fname ) {
					$dbr = self::getDB();

					return $dbr->selectFieldValues(
						'user_groups',
						'ug_group',
						[ 'ug_user' => $userId ],
						$fname
					);
				}
			);

			global $wgWikiaGlobalUserGroups;
			self::$globalGroups[$userId] = array_intersect( $globalGroups, $wgWikiaGlobalUserGroups );
		}

		return self::$globalGroups[$userId];
	}

	/**
	 * Get group data for the user object. Needed for removing global group rights.
	 *
	 * @author grunny
	 */
	public static function onUserLoadGroups( User $user ) {
		$userId = $user->getId();
		if ( !self::isCentralWiki() || $user->isAnon() ) {
			return true;
		} elseif ( !isset( self::$globalGroups[$userId] ) ) {
			// Load the global groups into the class variable
			self::getGlobalGroups( $user );
		}
		$user->mGroups = array_merge( $user->mGroups, array_diff( self::$globalGroups[$userId], $user->mGroups ) );
		return true;
	}

	/**
	 * @param User $user
	 * @param $group
	 * @return bool false, it's a hook
	 */
	static function addGlobalGroup( User $user, $group ) {
		global $wgWikiaGlobalUserGroups;

		if ( !in_array( $group, $wgWikiaGlobalUserGroups ) ) {
			return true;
		}

		$dbw = self::getDB( DB_MASTER );
		if ( $user->getId() ) {
			$dbw->insert( 'user_groups',
				[
					'ug_user'  => $user->getID(),
					'ug_group' => $group,
				 ],
				__METHOD__
			);
		}

		WikiaDataAccess::cachePurge( self::getMemcKey( $user ) );

		wfRunHooks( 'AfterUserAddGlobalGroup', [ $user, $group ] );

		// return false to prevent group from being added to local DB
		return false;
	}

	/**
	 * @param User $user
	 * @param $group
	 * @return bool true, it's a hook
	 * @throws DBUnexpectedError
	 */
	static function removeGlobalGroup( User $user, $group ) {
		global $wgWikiaGlobalUserGroups;

		if ( !in_array( $group, $wgWikiaGlobalUserGroups ) ) {
			return true;
		}

		$dbw = self::getDB( DB_MASTER );
		$dbw->delete( 'user_groups',
				[
					'ug_user'  => $user->getID(),
					'ug_group' => $group,
				],
			__METHOD__
		);
		// Remember that the user was in this group
		$dbw->insert( 'user_former_groups',
				[
					'ufg_user'  => $user->getID(),
					'ufg_group' => $group,
				],
				__METHOD__
		);

		WikiaDataAccess::cachePurge( self::getMemcKey( $user ) );

		wfRunHooks( 'AfterUserRemoveGlobalGroup', [ $user, $group ] );

		// return true to let the User class clean up any residual staff rights stored locally
		return true;
	}

	/**
	 * check if we are on central wiki (shared db)
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 */
	static function isCentralWiki() {
		global $wgWikiaIsCentralWiki;
		return (bool)$wgWikiaIsCentralWiki;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function userEffectiveGroups( User $user, Array &$groups ) {
		$groups = array_unique( array_merge( $groups, self::getGlobalGroups( $user ) ) );
		return $groups;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function showEditUserGroupsForm( User $user, Array &$groups ) {
		$groups = array_unique( array_merge( $groups, self::getGlobalGroups( $user ) ) );

		return true;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function groupCheckboxes( $group, &$disabled, &$irreversible ) {
		global $wgWikiaGlobalUserGroups;

		if ( !self::isCentralWiki() && in_array( $group, $wgWikiaGlobalUserGroups ) ) {
			$disabled = true;
		}
		return true;
	}

	/**
	 * Return memcache key used for storing shared groups for a given user
	 *
	 * @param User $user
	 * @return string memcache key
	 */
	static private function getMemcKey( User $user ) {
		return wfSharedMemcKey( __CLASS__, 'global-groups', $user->getId() );
	}

	/**
	 * @param int $db DB_SLAVE or DB_MASTER
	 * @return DatabaseBase
	 */
	static private function getDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}
}
