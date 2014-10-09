<?php

class ExactTargetUpdatesUserGroupsHooks {

	/**
	 * Runs a method for adding addUserGroup task to job queue
	 * Function executed on UserAddGroup hook
	 * @param User $user
	 * @return bool
	 */
	public static function onUserAddGroup( User $user, $sGroup ) {
		$thisInstance = new ExactTargetUpdatesUserGroupsHooks();
		$thisInstance->addTheAddUserGroupTask( $user, $sGroup, new ExactTargetUserGroupsTask() );
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 * @param string $sGroup
	 * @param ExactTargetUserGroupsTask $task
	 */
	public function addTheAddUserGroupTask( User $oUser, $sGroup, ExactTargetUserGroupsTask $task ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ($wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL) {
			$task->call( 'addUserGroup', $oUser->getId(), $sGroup );
			$task->queue();
		}
	}

}
