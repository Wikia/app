<?php
namespace Wikia\ExactTarget;

class ExactTargetUserHooks {

	/**
	 * Adds Task for updating user name to job queue
	 * @param int $iUserId
	 * @param string $sOldUsername
	 * @param string $sNewUsername
	 * @return bool
	 */
	public function onUserRenameAfterAccountRename( $iUserId, $sOldUsername, $sNewUsername ) {
		$oUser = \User::newFromId( $iUserId );
		$oUser->setName( $sNewUsername ); // Reset new username just in case it's not propagated yet
		$this->queueUpdateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds Task for removing user to job queue
	 * @param \User $oUser
	 * @return bool
	 */
	public function onEditAccountClosed( \User $oUser ) {
		/* Get and run the task */
		$task = new ExactTargetUserTask();
		$task->call( 'deleteUserData', $oUser->getId() );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param \User $oUser
	 * @return bool
	 */
	public function onEditAccountEmailChanged( \User $oUser ) {
		$this->queueUpdateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds Task for updating user due to email authentication field change
	 * @param \User $user
	 * @return bool
	 */
	public function onInvalidateEmailComplete( \User $user ) {
		/* Prepare params */
		$userHelper = $this->getUserHelper();
		$userData = $userHelper->prepareUserParams( $user );

		/* Get and run the task */
		$task = new ExactTargetUserTask();
		$task->call( 'updateUser', $userData );
		$task->queue();
		return true;
	}


	/**
	 * Adds Task for updating user email
	 * @param \User $user
	 * @return bool
	 */
	public function onConfirmEmailComplete( \User $oUser ) {
		$this->queueUpdateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param \User $oUser
	 * @return bool
	 */
	public function onCreateNewUserComplete( \User $oUser ) {
		$this->queueUpdateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds a task for adding user groups
	 * @param \User $user
	 * @param string $sGroup Group name to add
	 * @return bool
	 */
	public function onAfterUserAddGlobalGroup( \User $oUser, $sGroup ) {
		/* Get and run the task */
		$task = new ExactTargetUserTask();
		$task->call( 'addUserGroup', $oUser->getId(), $sGroup );
		$task->queue();
		return true;
	}

	/**
	 * Adds a task for removing user groups
	 * @param \User $user
	 * @param string $sGroup Group name to remove
	 * @return bool
	 */
	public function onAfterUserRemoveGlobalGroup( \User $oUser, $sGroup ) {
		/* Get and run the task */
		$task = new ExactTargetUserTask();
		$task->call( 'removeUserGroup', $oUser->getId(), $sGroup );
		$task->queue();
		return true;
	}

	/**
	 * Adds a task for updating user properties
	 * @param \User $user
	 * @return bool
	 */
	public function onUserSaveSettings( \User $user ) {
		/* Prepare params */
		$oUserHelper = $this->getUserHelper();
		$aUserProperties = $oUserHelper->prepareUserPropertiesParams( $user );

		/* Get and run the task */
		$task = new ExactTargetUserTask();
		$task->call( 'updateUserProperties', $user->getId(), $aUserProperties );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param \User $oUser
	 */
	private function queueUpdateUserTask( \User $oUser ) {
		/* Prepare params */
		$oUserHelper = $this->getUserHelper();
		$aUserData = $oUserHelper->prepareUserParams( $oUser );
		$aUserProperties = $oUserHelper->prepareUserPropertiesParams( $oUser );

		/* Get and run updates tasks separately */
		$taskUser = new ExactTargetUserTask();
		$taskUser->call( 'updateUser', $aUserData );
		$taskUser->queue();
		$taskUserProperties = new ExactTargetUserTask();
		$taskUserProperties->call( 'updateUserProperties', $oUser->getId(), $aUserProperties );
		$taskUserProperties->queue();
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	private function getUserHelper() {
		return new ExactTargetUserHooksHelper();
	}

}
