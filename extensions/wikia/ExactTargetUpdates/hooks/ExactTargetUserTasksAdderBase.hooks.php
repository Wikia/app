<?php

class ExactTargetUserTasksAdderBaseHooks {

	/**
	 * Returns new instance of ExactTargetAddUserTask
	 * @return ExactTargetAddUserTask
	 */
	public function getExactTargetAddUserTask() {
		return new ExactTargetAddUserTask();
	}

	/**
	 * Returns new instance of ExactTargetUpdateUserTask
	 * @return ExactTargetUpdateUserTask
	 */
	public function getExactTargetUpdateUserTask() {
		return new ExactTargetUpdateUserTask();
	}

	/**
	 * Returns new instance of ExactTargetRemoveUserTask
	 * @return ExactTargetRemoveUserTask
	 */
	public function getExactTargetRemoveUserTask() {
		return new ExactTargetRemoveUserTask();
	}

	/**
	 * Prepares array of user fields needed to be passed by API
	 * @param User $oUser
	 * @return array
	 */
	public function prepareUserParams( User $oUser ) {
		$aUserParams = [
			'user_id' => $oUser->getId(),
			'user_name' => $oUser->getName(),
			'user_real_name' => $oUser->getRealName(),
			'user_email' => $oUser->getEmail(),
			'user_email_authenticated' => $oUser->getEmailAuthenticationTimestamp(),
			'user_registration' => $oUser->getRegistration(),
			'user_editcount' => $oUser->getEditCount(),
			'user_touched' => $oUser->getTouched()
		];
		return $aUserParams;
	}

	/**
	 * Prepares array of user properties fields needed to be passed by API
	 * @param User $oUser
	 * @return array
	 */
	public function prepareUserPropertiesParams( User $oUser ) {
		$aUserPropertiesParams = [
			'marketingallowed' => $oUser->getOption( 'marketingallowed' ),
			'unsubscribed' => $oUser->getOption( 'unsubscribed' ),
			'language' => $oUser->getOption( 'language' )
		];
		return $aUserPropertiesParams;
	}
}
