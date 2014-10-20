<?php

class ExactTargetSetupHooks {

	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public static function setupHooks() {
		$oExactTargetUserHooks = new self();
		$oExactTargetMainHelper = $oExactTargetUserHooks->getMainHelper();
		/* Don't add task when on dev or internal */
		if ( $oExactTargetMainHelper->shouldUpdate() ) {
			$oExactTargetUserHooks->registerUserHooks();
		}
	}
	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public function registerUserHooks() {
		$oUserHooks = $this->getUserHooks();
		\Hooks::register('AfterAccountRename', $oUserHooks);
		\Hooks::register('ArticleSaveComplete', $oUserHooks);
		\Hooks::register('EditAccountClosed', $oUserHooks);
		\Hooks::register('EditAccountEmailChanged', $oUserHooks);
		\Hooks::register('EmailChangeConfirmed', $oUserHooks);
		\Hooks::register('SignupConfirmEmailComplete', $oUserHooks);
		\Hooks::register('UserSaveSettings', $oUserHooks);
	}

	private function getMainHelper() {
		return new ExactTargetMainHelper();
	}

	/**
	 * Returns new instance of ExactTargetUserHooks
	 * @return ExactTargetUserHooks
	 */
	public function getUserHooks() {
		return new ExactTargetUserHooks();
	}
}
