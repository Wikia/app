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
	private static $globalGroup;

	/**
	 * data provider
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function getGlobalGroups(User $user) {
		$userId = $user->getId();
		if ( $userId == 0 ) {
			return array();
		} elseif (!isset(self::$globalGroup[$userId])) {
			global $wgWikiaGlobalUserGroups, $wgExternalSharedDB;

			$globalGroups = array();

			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

			$res = $dbr->select(
				'user_groups',
				'ug_group',
				array('ug_user' => $userId),
				__METHOD__
			);

			while ($row = $dbr->fetchObject($res)) {
				$globalGroups[] = $row->ug_group;
			}
			$dbr->freeResult($res);
			self::$globalGroup[$userId] = array_intersect($globalGroups, $wgWikiaGlobalUserGroups);
		}
		return self::$globalGroup[$userId];
	}

	/**
	 * Get group data for the user object. Needed for removing global group rights.
	 *
	 * @author grunny
	 */
	public static function onUserLoadGroups( User $user ) {
		$userId = $user->getId();
		if ( !self::isCentralWiki() || $userId == 0 ) {
			return true;
		} elseif ( !isset( self::$globalGroup[$userId] ) ) {
			// Load the global groups into the class variable
			self::getGlobalGroups( $user );
		}
		$user->mGroups = array_merge( $user->mGroups, array_diff( self::$globalGroup[$userId], $user->mGroups ) );
		return true;
	}

	static function addGlobalGroup( $user, $group ) {
		global $wgExternalSharedDB, $wgWikiaGlobalUserGroups;

		if ( !in_array( $group, $wgWikiaGlobalUserGroups ) ) {
			return true;
		}

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		if( $user->getId() ) {
			$dbw->insert( 'user_groups',
					array(
						'ug_user'  => $user->getID(),
						'ug_group' => $group,
					     ),
					__METHOD__,
					array( 'IGNORE' ) );
		}

		wfRunHooks( 'AfterUserAddGlobalGroup', array( $user, $group ) );

		// return false to prevent group from being added to local DB
		return false;
	}

	static function removeGlobalGroup( $user, $group ) {
		global $wgExternalSharedDB, $wgWikiaGlobalUserGroups;

		if ( !in_array( $group, $wgWikiaGlobalUserGroups ) ) {
			return true;
		}

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->delete( 'user_groups',
				array(
					'ug_user'  => $user->getID(),
					'ug_group' => $group,
				     ), __METHOD__ );
		// Remember that the user was in this group
		$dbw->insert( 'user_former_groups',
				array(
					'ufg_user'  => $user->getID(),
					'ufg_group' => $group,
				     ),
				__METHOD__,
				array( 'IGNORE' ) );

		wfRunHooks( 'AfterUserRemoveGlobalGroup', array( $user, $group ) );

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
	static function userEffectiveGroups(&$user, &$groups) {
		$groups = array_unique(array_merge($groups, self::getGlobalGroups($user)));
		return $groups;
	}


	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function showEditUserGroupsForm(&$user, &$groups) {
		$groups = array_unique(array_merge($groups, self::getGlobalGroups($user)));

		return true;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function groupCheckboxes($group, &$disabled, &$irreversible) {
		global $wgWikiaGlobalUserGroups;

		if (!self::isCentralWiki() && in_array($group, $wgWikiaGlobalUserGroups)) {
			$disabled = true;
		}
		return true;
	}
}
