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
		/* Don't add task when on dev or internal */
		if ( $this->shouldUpdate() ) {
			$oUserHooks = $this->getUserHooks();
			\Hooks::register('AfterAccountRename', $oUserHooks);
			\Hooks::register('ArticleSaveComplete', $oUserHooks);
			\Hooks::register('EditAccountClosed', $oUserHooks);
			\Hooks::register('EditAccountEmailChanged', $oUserHooks);
			\Hooks::register('EmailChangeConfirmed', $oUserHooks);
			\Hooks::register('SignupConfirmEmailComplete', $oUserHooks);
			\Hooks::register('UserSaveSettings', $oUserHooks);
		}
	}

	/**
	 * Register all hooks that are necessary to update wiki data in ExactTarget
	 */
	public function registerWikiHooks() {
		/* Don't add task when on dev or internal */
		if ( $this->shouldUpdate() ) {
			$oWikiHooks = $this->getWikiHooks();
			\Hooks::register( 'CreateWikiLocalJob-complete', [ $oWikiHooks, 'onCreateWikiLocalJobComplete' ] );
			\Hooks::register( 'WikiFactoryChangeCommitted', $oWikiHooks );
			\Hooks::register( 'WikiFactoryVerticalSet', $oWikiHooks );
			\Hooks::register( 'CityCatMappingUpdated', $oWikiHooks );
		}
	}

	/**
	 * Checks whether environment allows to do ExactTarget updates
	 * You can't update on DEV and INTERNAL environment,
	 * unless wgExactTargetDevelopmentMode is set to true.
	 */
	private function shouldUpdate() {
		global $wgWikiaEnvironment, $wgExactTargetDevelopmentMode;

		if ( ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) || $wgExactTargetDevelopmentMode === true ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns new instance of ExactTargetUserHooks
	 * @return ExactTargetUserHooks
	 */
	public function getUserHooks() {
		return new ExactTargetUserHooks();
	}

	public function getWikiHooks() {
		return new ExactTargetWikiHooks();
	}
}
