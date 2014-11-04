<?php
namespace Wikia\ExactTarget;

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
		\Hooks::register( 'ArticleSaveComplete', $oUserHooks );
		\Hooks::register( 'EditAccountClosed', $oUserHooks );
		\Hooks::register( 'EditAccountEmailChanged', $oUserHooks );
		\Hooks::register( 'EmailChangeConfirmed', $oUserHooks );
		\Hooks::register( 'SignupConfirmEmailComplete', $oUserHooks );
		\Hooks::register( 'UserSaveSettings', $oUserHooks );
		\Hooks::register( 'UserRename::AfterAccountRename', [ $oUserHooks, 'onUserRenameAfterAccountRename' ] );
	}

	/**
	 * Register all hooks that are necessary to update wiki data in ExactTarget
	 */
	public function registerWikiHooks() {
		$oWikiHooks = $this->getWikiHooks();
		\Hooks::register( 'CreateWikiLocalJob-complete', [ $oWikiHooks, 'onCreateWikiLocalJobComplete' ] );
		\Hooks::register( 'WikiFactoryChangeCommitted', [ $oWikiHooks, 'onWikiFactoryChangeCommitted' ] );
		\Hooks::register( 'WikiFactoryVerticalSet', [ $oWikiHooks, 'onWikiFactoryVerticalSet' ] );
		\Hooks::register( 'CityCatMappingUpdated', [ $oWikiHooks, 'onCityCatMappingUpdated' ] );
		\Hooks::register( 'WikiFactoryWikiClosed', [ $oWikiHooks, 'onWikiFactoryWikiClosed' ] );
	}

	/**
	 * Returns new instance of ExactTargetUserHooks
	 * @return ExactTargetUserHooks
	 */
	public function getUserHooks() {
		return new ExactTargetUserHooks();
	}

	/**
	 * Returns new instance of ExactTargetWikiHooks
	 * @return ExactTargetWikiHooks
	 */
	public function getWikiHooks() {
		return new ExactTargetWikiHooks();
	}
}
