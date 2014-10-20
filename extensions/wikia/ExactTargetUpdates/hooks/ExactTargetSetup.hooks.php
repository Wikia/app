<?php

class ExactTargetSetupHooks {

	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public static function setupHooks() {
		$oExactTargetUserHooks = new self();
		/* Don't add task when on dev or internal */
		if ( $oExactTargetUserHooks->shouldUpdate() ) {
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

	/**
	 * Checks whether environment allows to do ExactTarget updates
	 * You can't update on DEV and INTERNAL environment,
	 * unless wgExactTargetDevelopmentMode is set to true.
	 */
	public function shouldUpdate() {
		global $wgWikiaEnvironment, $wgExactTargetDevelopmentMode;

		if ( ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) || $wgExactTargetDevelopmentMode === true ) {
			return true;
		}

		return false;
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
