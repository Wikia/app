<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/2/14
 * Time: 10:11 AM
 */

namespace Wikia\Tasks\Tasks;

/**
 * Task which removes all user's rights from all Wikias
 *
 * ADDED BY WIKIA
 *
 * @author yurii@wikia-inc.com
 */
class RemoveUserRightsTask extends BaseTask {

	public function removeRightsFromAllWikias( $userId ) {
		$db = wfGetDB( DB_MASTER );

		// Select database names of all active Wikias
		$cursor = $db->select( 'city_list',
			/*FROM*/ 'city_dbname',
			/*WHERE*/ [ 'city_public' => 1 ],
			__METHOD__
		);

		while ( $row = $db->fetchObject( $cursor ) ) {
			$wikiaDbName = $row[ 'city_dbname' ];

			$this->removeAndRememberUserGroups( $userId, $wikiaDbName );
		}
	}

	/**
	 * In fact - each group represent some rights of user.
	 * So, by removing user groups - we remove user rights.
	 * Also, we remember user groups, because this information can be needed by some logic of application.
	 *
	 * @param $userId
	 * @param $wikiaDbName
	 */
	protected function removeAndRememberUserGroups( $userId, $wikiaDbName ) {
		$db = wfGetDB( DB_MASTER, [ ], $wikiaDbName );

		$groups = $this->fetchUserGroups( $userId, $db );

		if( !empty( $groups ) ) {

			$this->removeUserGroups( $userId, $db );

			$this->rememberUserGroups( $userId, $groups, $db );
		}
	}

	/**
	 * Find all groups, which user belongs to
	 *
	 * @param $userId
	 * @param $db
	 * @return array of groups, which user belongs to
	 */
	protected function fetchUserGroups( $userId, &$db ) {
		$groups = [ ];

		// Fetch user groups
		$cursor = $db->select( 'user_groups',
			/*FROM*/ 'ug_group',
			/*WHERE*/ [ 'ug_user' => $userId ],
			__METHOD__
		);

		while ( $row = $db->fetchObject( $cursor ) ) {
			$groups[ ] = $row[ 'ug_group' ];
		}

		return $groups;
	}

	/**
	 * Remove user from all groups, which he belongs to
	 *
	 * @param $userId
	 * @param $db
	 */
	protected function removeUserGroups( $userId, &$db ) {
		$db->delete(
			'user_groups',
			[ 'ug_user' => $userId ],
			__METHOD__
		);
	}

	/**
	 * Remember that the user was in these groups
	 * (this information can be needed by some logic of application)
	 *
	 * @param $userId
	 * @param $groups
	 * @param $db
	 */
	protected function rememberUserGroups( $userId, &$groups, &$db ) {
		// Prepare rows for batch insert
		$rowsToInsert = [ ];
		foreach ( $groups as $group ) {
			$rowsToInsert[ ] = [
				'ufg_user' => $userId,
				'ufg_group' => $group
			];
		}

		// Batch insert to database
		$db->insert(
			'user_former_groups',
			$rowsToInsert,
			__METHOD__,
			[ 'IGNORE' ]
		);
	}
}