<?php

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
		global $wgExternalSharedDB;
		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		( new \WikiaSQL() )
			->SELECT( 'city_dbname' )
			->FROM( 'city_list' )
			->WHERE( 'city_public' )->EQUAL_TO( 1 )
			->runLoop( $db,
				function ( &$dataCollector, $row ) use ( $userId ) {
					$wikiaDbName = $row[ 'city_dbname' ];
					$this->removeAndRememberUserGroups( $userId, $wikiaDbName );
				}
			);
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

		if ( !empty( $groups ) ) {

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

		$groups =
			( new \WikiaSQL() )
				->SELECT( 'ug_group' )
				->FROM( 'user_groups' )
				->WHERE( 'ug_user' )->EQUAL_TO( $userId )
				->runLoop( $db,
					function ( &$dataCollector, $row ) {
						$dataCollector[ ] = $row[ 'ug_group' ];
					}
				);

		return $groups;
	}

	/**
	 * Remove user from all groups, which he belongs to
	 *
	 * @param $userId
	 * @param $db
	 */
	protected function removeUserGroups( $userId, &$db ) {
		( new \WikiaSQL() )
			->DELETE( 'user_groups' )
			->WHERE( 'ug_user' )->EQUAL_TO( $userId )
			->run( $db );
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
		( new \WikiaSQL() )
			->INSERT( 'user_former_groups',
				$rowsToInsert
			);
	}

	/**
	 * Disabling execution via Special:Tasks
	 */
	public function getAdminExecuteableMethods() {
		return [ ];
	}
}
