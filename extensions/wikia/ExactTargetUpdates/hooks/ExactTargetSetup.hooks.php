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
		\Hooks::register( 'ArticleSaveComplete', [ $oUserHooks, 'onArticleSaveComplete' ] );
		\Hooks::register( 'EditAccountClosed', [ $oUserHooks, 'onEditAccountClosed' ] );
		\Hooks::register( 'EditAccountEmailChanged', [ $oUserHooks, 'onEditAccountEmailChanged' ] );
		\Hooks::register( 'EmailChangeConfirmed', [ $oUserHooks, 'onEmailChangeConfirmed' ] );
		\Hooks::register( 'SignupConfirmEmailComplete', [ $oUserHooks, 'onSignupConfirmEmailComplete' ] );
		\Hooks::register( 'AfterUserAddGlobalGroup', [ $oUserHooks, 'onAfterUserAddGlobalGroup' ] );
		\Hooks::register( 'AfterUserRemoveGlobalGroup', [ $oUserHooks, 'onAfterUserRemoveGlobalGroup' ] );
		\Hooks::register( 'UserSaveSettings', [ $oUserHooks, 'onUserSaveSettings' ] );
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
