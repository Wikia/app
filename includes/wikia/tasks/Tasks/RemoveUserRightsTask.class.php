<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/2/14
 * Time: 10:11 AM
 */

namespace Wikia\Tasks\Tasks;

/**
 * Task which removes user from all groups, which he belongs to - in all Wikias
 *
 * ADDED BY WIKIA
 *
 * @author yurii@wikia-inc.com
 */
class RemoveUserRightsTask extends BaseTask {

	public function removeRightsFromAllWikias( $userId ) {
		$dbw = wfGetDB( DB_MASTER );

		// Select database names of all active Wikias
		$res = $dbw->select( 'city_list',
			/*FROM*/ 'city_dbname',
			/*WHERE*/ [ 'city_public' => 1 ],
			__METHOD__
		);

		while ( $row = $dbw->fetchObject( $res ) ) {
			$wikiaDbName = $row[ 'city_dbname' ];

			$this->removeFromAllGroups( $userId, $wikiaDbName );
		}
	}

	/**
	 * @param $userId
	 * @param $wikiaDbName
	 */
	protected function removeFromAllGroups( $userId, $wikiaDbName ) {
		$dbw = wfGetDB( DB_MASTER, [ ], $wikiaDbName );

		$groups = $this->fetchUserGroups( $userId, $dbw );
		if( empty( $groups ) ) {
			return;
		}

		$this->removeUserFromAllGroups( $userId, $dbw );

		$this->rememberUserGroups( $userId, $groups, $dbw );
	}

	/**
	 * @param $userId
	 * @param $dbw
	 * @return array of groups, which user belongs to
	 */
	protected function fetchUserGroups( $userId, &$dbw ) {
		$groups = [ ];

		// Fetch user groups
		$res = $dbw->select( 'user_groups',
			/*FROM*/ 'ug_group',
			/*WHERE*/ [ 'ug_user' => $userId ],
			__METHOD__
		);

		while ( $row = $dbw->fetchObject( $res ) ) {
			$groups[ ] = $row[ 'ug_group' ];
		}

		return $groups;
	}

	/**
	 * Remove user from all groups, which he belongs to
	 * @param $userId
	 * @param $dbw
	 */
	protected function removeUserFromAllGroups( $userId, &$dbw ) {
		$dbw->delete(
			'user_groups',
			[ 'ug_user' => $userId ],
			__METHOD__
		);
	}

	/**
	 * Remember that the user was in these groups
	 * @param $userId
	 * @param $groups
	 * @param $dbw
	 */
	protected function rememberUserGroups( $userId, &$groups, &$dbw ) {
		// Prepare rows for batch insert
		$rowsToInsert = [ ];
		foreach ( $groups as $group ) {
			$rowsToInsert[ ] = [
				'ufg_user' => $userId,
				'ufg_group' => $group
			];
		}

		// Batch insert to database
		$dbw->insert(
			'user_former_groups',
			$rowsToInsert,
			__METHOD__,
			[ 'IGNORE' ]
		);
	}
}