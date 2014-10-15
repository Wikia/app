<?php

class ExactTargetUserTasksAdderHooks extends ExactTargetUserTasksAdderBaseHooks {

	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public static function setupHooks() {
		$oExactTargetUserTasksAdderHooks = new self();

		\Hooks::register( 'AfterAccountRename', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'ArticleSaveComplete', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'EditAccountClosed', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'EditAccountEmailChanged', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'EmailChangeConfirmed', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'SignupConfirmEmailComplete', $oExactTargetUserTasksAdderHooks );
		\Hooks::register( 'UserSaveSettings', $oExactTargetUserTasksAdderHooks );
	}

	/**
	 * Adds Task for updating user name to job queue
	 * @param int $iUserId
	 * @param string $sOldUsername
	 * @param string $sNewUsername
	 * @return bool
	 */
	public function onAfterAccountRename( $iUserId, $sOldUsername, $sNewUsername ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aUserData = [
				'user_id' => $iUserId,
				'user_name' => $sNewUsername
			];
			$task = $this->getExactTargetUpdateUserTask();
			$task->call( 'updateUserData', $aUserData );
			$task->queue();
		}
		return true;
	}

	/**
	 * Adds Task for updating user editcount to job queue
	 * @param WikiPage $article
	 * @param User $user
	 * @return bool
	 */
	public function onArticleSaveComplete( WikiPage $article, User $user ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aUserData = [
				'user_id' => $user->getId(),
				'user_editcount' => $user->getEditCount()
			];
			$task = $this->getExactTargetUpdateUserTask();
			$task->call( 'updateUserData', $aUserData );
			$task->queue();
		}
		return true;
	}

	/**
	 * Adds Task for removing user to job queue
	 * @param User $oUser
	 * @return bool
	 */
	public function onEditAccountClosed( User $oUser ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$task = $this->getExactTargetRemoveUserTask();
			$task->call( 'removeUserData', $oUser->getId() );
			$task->queue();
		}
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 * @return bool
	 */
	public function onEditAccountEmailChanged( User $oUser ) {
		$this->addTheUpdateAddUserTask( $oUser );
		return true;
	}


	/**
	 * Adds Task for updating user email
	 * @param User $user
	 * @return bool
	 */
	public function onEmailChangeConfirmed( User $user ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$task = $this->getExactTargetUpdateUserTask();
			$task->call( 'updateUserEmail', $user->getId(), $user->getEmail() );
			$task->queue();
		}
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 * @return bool
	 */
	public function onSignupConfirmEmailComplete( User $oUser ) {
		$this->addTheUpdateAddUserTask( $oUser );
		return true;
	}

	/**
	 * Adds a task for updating user properties
	 * @param User $user
	 * @return bool
	 */
	public function onUserSaveSettings( User $user ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aUserData = $this->prepareUserParams( $user );
			$aUserProperties = $this->prepareUserPropertiesParams( $user );
			$task = $this->getExactTargetUpdateUserTask();
			$task->call( 'updateUserPropertiesData', $aUserData, $aUserProperties );
			$task->queue();
		}
		return true;
	}

	/**
	 * Adds Task to job queue that updates a user or adds a user if one doesn't exist
	 * @param User $oUser
	 */
	private function addTheUpdateAddUserTask( User $oUser ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ($wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL) {
			$aUserData = $this->prepareUserParams( $oUser );
			$aUserProperties = $this->prepareUserPropertiesParams( $oUser );
			$task = $this->getExactTargetAddUserTask();
			$task->call( 'updateAddUserData', $aUserData, $aUserProperties );
			$task->queue();
		}
	}
}
