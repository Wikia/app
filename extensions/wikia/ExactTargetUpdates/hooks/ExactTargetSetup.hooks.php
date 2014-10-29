<?php

class ExactTargetSetupHooks {

	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public static function setupHooks() {
		$oExactTargetUserHooks = new self();
		$oExactTargetUserHooks->registerUserHooks();
		$oExactTargetUserHooks->registerWikiHooks();
	}

	/**
	 * Register all hooks that are necessary to update user data in ExactTarget
	 */
	public function registerUserHooks() {
		$oUserHooks = $this->getUserHooks();
		\Hooks::register( 'AfterAccountRename', $oUserHooks );
		\Hooks::register( 'ArticleSaveComplete', $oUserHooks );
		\Hooks::register( 'EditAccountClosed', $oUserHooks );
		\Hooks::register( 'EditAccountEmailChanged', $oUserHooks );
		\Hooks::register( 'EmailChangeConfirmed', $oUserHooks );
		\Hooks::register( 'SignupConfirmEmailComplete', $oUserHooks );
		\Hooks::register( 'UserSaveSettings', $oUserHooks );
	}

	/**
	 * Register all hooks that are necessary to update wiki data in ExactTarget
	 */
	public function registerWikiHooks() {

	}

	/**
	 * Returns new instance of ExactTargetUserHooks
	 * @return ExactTargetUserHooks
	 */
	public function getUserHooks() {
		return new ExactTargetUserHooks();
	}
}
