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
	private static $globalGroup, $sharedDBname;

	/**
	 * data provider
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function getGlobalGroups($user) {
		if (!isset(self::$globalGroup[$user->mId])) {
			global $wgWikiaGlobalUserGroups;
			$globalGroups = array();

			$dbr = wfGetDB(DB_SLAVE, array(), self::getSharedDBname());

			$res = $dbr->select(
				'user_groups',
				'ug_group',
				array('ug_user' => $user->mId),
				__METHOD__
			);

			while ($row = $dbr->fetchObject($res)) {
				$globalGroups[] = $row->ug_group;
			}
			$dbr->freeResult($res);
			self::$globalGroup[$user->mId] = array_intersect($globalGroups, $wgWikiaGlobalUserGroups);
		}
		return self::$globalGroup[$user->mId];
	}

	/**
	 * get shared db name respecting current cluster
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function getSharedDBname() {
		if (!isset(self::$sharedDBname)) {
			global $wgExternalSharedDB, $wgWikiaCentralAuthDatabase;
			self::$sharedDBname = $wgWikiaCentralAuthDatabase ? $wgWikiaCentralAuthDatabase : $wgExternalSharedDB;
		}
		return self::$sharedDBname;
	}

	/**
	 * check if we are on central wiki (shared db)
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function isCentralWiki() {
		global $wgDBname;
		return self::getSharedDBname() == $wgDBname;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function userEffectiveGroups(&$user, &$groups) {
		if (!self::isCentralWiki()) {
			$groups = array_unique(array_merge($groups, self::getGlobalGroups($user)));
		}
		return $groups;
	}


	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	function showEditUserGroupsForm(&$user, &$groups) {
		//if not on central, block changing global rights
		if (!self::isCentralWiki()) {
			$groups = array_unique(array_merge($groups, self::getGlobalGroups($user)));
		}
		return true;
	}

	/**
	 * hook handler
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	function groupCheckboxes($group, &$disabled, &$irreversible) {
		global $wgWikiaGlobalUserGroups;

		if (!self::isCentralWiki() && in_array($group, $wgWikiaGlobalUserGroups)) {
			$disabled = true;
		}
		return true;
	}
}
