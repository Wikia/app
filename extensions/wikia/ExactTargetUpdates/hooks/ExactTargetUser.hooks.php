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
		/* Prepare params */
		$aUserData = [
			'user_id' => $iUserId,
			'user_name' => $sNewUsername
		];

		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'updateUserData', $aUserData );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task for updating user editcount to job queue
	 * @param WikiPage $article
	 * @param User $user
	 * @return bool
	 */
	public function onArticleSaveComplete( \WikiPage $article, \User $user ) {
		/* Prepare params */
		$aUserData = [
			'user_id' => $user->getId(),
			'user_editcount' => $user->getEditCount()
		];

		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'updateUserData', $aUserData );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task for removing user to job queue
	 * @param User $oUser
	 * @return bool
	 */
	public function onEditAccountClosed( \User $oUser ) {
		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getDeleteUserTask();
		$task->call( 'deleteUserData', $oUser->getId() );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 * @return bool
	 */
	public function onEditAccountEmailChanged( \User $oUser ) {
		$this->addTheUpdateCreateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds Task for updating user email
	 * @param User $user
	 * @return bool
	 */
	public function onEmailChangeConfirmed( \User $oUser ) {
		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'updateUserEmail', $oUser->getId(), $oUser->getEmail() );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 * @return bool
	 */
	public function onSignupConfirmEmailComplete( \User $oUser ) {
		$this->addTheUpdateCreateUserTask( $oUser );
		return true;
	}

	/**
	 * Adds a task for adding user groups
	 * @param User $user
	 * @param string $sGroup Group name to add
	 * @return bool
	 */
	public function onAfterUserAddGlobalGroup( \User $oUser, $sGroup ) {
		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'addUserGroup', $oUser->getId(), $sGroup );
		$task->queue();
		return true;
	}

	/**
	 * Adds a task for removing user groups
	 * @param User $user
	 * @param string $sGroup Group name to remove
	 * @return bool
	 */
	public function onAfterUserRemoveGlobalGroup( \User $oUser, $sGroup ) {
		/* Get and run the task */
		$oUserHelper = $this->getUserHelper();
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'removeUserGroup', $oUser->getId(), $sGroup );
		$task->queue();
		return true;
	}

	/**
	 * Adds a task for updating user properties
	 * @param User $user
	 * @return bool
	 */
	public function onUserSaveSettings( \User $user ) {
		/* Prepare params */
		$oUserHelper = $this->getUserHelper();
		$aUserData = $oUserHelper->prepareUserParams( $user );
		$aUserProperties = $oUserHelper->prepareUserPropertiesParams( $user );

		/* Get and run the task */
		$task = $oUserHelper->getUpdateUserTask();
		$task->call( 'updateUserPropertiesData', $aUserData, $aUserProperties );
		$task->queue();
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 */
	private function addTheUpdateCreateUserTask( \User $oUser ) {
		/* Prepare params */
		$oUserHelper = $this->getUserHelper();
		$aUserData = $oUserHelper->prepareUserParams( $oUser );
		$aUserProperties = $oUserHelper->prepareUserPropertiesParams( $oUser );

		/* Get and run the task */
		$task = $oUserHelper->getCreateUserTask();
		$task->call( 'updateCreateUserData', $aUserData, $aUserProperties );
		$task->queue();
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return  object ExactTargetUserHooksHelper
	 */
	private function getUserHelper() {
		return new ExactTargetUserHooksHelper();
	}

}
