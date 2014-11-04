<?php

class ExactTargetUpdatesUserGroupsHooks {

	/**
	 * Runs a method that adds a task to job queue for adding user group
	 * Function executed on AfterUserAddGlobalGroup hook
	 * @param User $user
	 * @param string $sGroup
	 * @return bool
	 */
	public static function onAfterUserAddGlobalGroup( User $user, $sGroup ) {
		$thisInstance = new ExactTargetUpdatesUserGroupsHooks();
		$thisInstance->addTheUserAddGroupTask( $user, $sGroup, new ExactTargetUserGroupsTask() );
		return true;
	}

	/**
	 * Runs a method for adding a user group remove task to job queue
	 * Function executed on Aftergit stUserRemoveGlobalGroup hook
	 * @param User $user
	 * @param string $sGroup
	 * @return bool
	 */
	public static function onAfterUserRemoveGlobalGroup( User $user, $sGroup ) {
		$thisInstance = new ExactTargetUpdatesUserGroupsHooks();
		$thisInstance->addTheUserRemoveGroupTask( $user, $sGroup, new ExactTargetUserGroupsTask() );
		return true;
	}

	/**
	 * Adds Task to job queue that adds user group to ExactTarget
	 * @param User $oUser
	 * @param string $sGroup
	 * @param ExactTargetUserGroupsTask $task
	 */
	public function addTheUserAddGroupTask( User $oUser, $sGroup, ExactTargetUserGroupsTask $task ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ($wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL) {
			$task->call( 'addGroup', $oUser->getId(), $sGroup );
			$task->queue();
		}
	}

	/**
	 * Adds Task to job queue that removes user group from ExactTarget
	 * @param User $oUser
	 * @param string $sGroup
	 * @param ExactTargetUserGroupsTask $task
	 */
	public function addTheUserRemoveGroupTask( User $oUser, $sGroup, ExactTargetUserGroupsTask $task ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ($wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL) {
			$task->call( 'removeGroup', $oUser->getId(), $sGroup );
			$task->queue();
		}
	}

}
