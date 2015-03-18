<?php
/**
 * Hook PowerUser management actions to given events
 *
 * @package PowerUser
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\PowerUser;

class PowerUserHooks {

	public static function setupHooks() {
		$oPowerUserHooks = new self();
		\Hooks::register( 'NewRevisionFromEditComplete', [ $oPowerUserHooks, 'onNewRevisionFromEditComplete' ] );
		\Hooks::register( 'UserAddGroup', [ $oPowerUserHooks, 'onUserAddGroup' ] );
		\Hooks::register( 'WikiaSkinTopScripts', [ $oPowerUserHooks, 'onWikiaSkinTopScripts' ] );
		\Hooks::register( 'UserLoginComplete', [ $oPowerUserHooks, 'onUserLoginComplete' ] );
		\Hooks::register( 'UserLogoutComplete', [ $oPowerUserHooks, 'onUserLogoutComplete' ] );
		\Hooks::register( 'BeforePageDisplay', [ $oPowerUserHooks, 'onBeforePageDisplay' ] );
	}

	/**
	 * Related to PowerUser lifetime type. It is triggered
	 * on every edit and checks if a user has enough edits
	 * to become a PowerUser (see PowerUser.class.php).
	 *
	 * @param $oArticle
	 * @param $oRevision
	 * @param $iBaseRevId
	 * @param \User $oUser
	 * @return bool
	 */
	public function onNewRevisionFromEditComplete( $oArticle, $oRevision, $iBaseRevId, \User $oUser ) {
		$oUserStatsService = new \UserStatsService( $oUser->getId() );

		if ( !$oUser->isSpecificPowerUser( PowerUser::TYPE_LIFETIME ) &&
			$oUserStatsService->getEditCountGlobal() > PowerUser::MIN_LIFETIME_EDITS
		) {
			$oPowerUser = new PowerUser( $oUser );
			$oPowerUser->addPowerUserProperty( PowerUser::TYPE_LIFETIME );
		}

		return true;
	}

	/**
	 * Gives a user a PowerUser property of an admin type.
	 *
	 * @param \User $oUser
	 * @param string $sGroup One of the groups from PowerUser.class.php
	 * @return bool
	 */
	public function onUserAddGroup( \User $oUser, $sGroup ) {
		if ( !$oUser->isSpecificPowerUser( PowerUser::TYPE_ADMIN ) &&
			in_array( $sGroup, PowerUser::$aPowerUserAdminGroups )
		) {
			$oPowerUser = new PowerUser( $oUser );
			$oPowerUser->addPowerUserProperty( PowerUser::TYPE_ADMIN );
		}

		return true;
	}

	/**
	 * Sets a JS variable if a user is a specific PU
	 *
	 * @param array $vars
	 * @param $scripts
	 * @return bool
	 */
	public function onWikiaSkinTopScripts( Array &$vars, &$scripts ) {
		global $wgUser;

		foreach ( PowerUser::$aPowerUserJSVariables as $sProperty => $sVarName ) {
			if ( $wgUser->isSpecificPowerUser( $sProperty ) ) {
				$vars[ $sVarName ] = true;
			}
		}

		return true;
	}

	public function onUserLoginComplete( \User $oUser, &$injected_html ) {
		wfDebug( 'PowerUserLog: ' . 'Login complete' . "\n" );
		if ( $oUser->isPowerUser() ) {
			$oPowerUser = new PowerUser( $oUser );
			wfDebug( 'PowerUserLog: ' . 'Cookie to be set' . "\n" );
			$oPowerUser->pageViewsSetCookie();
		}
		return true;
	}

	public function onUserLogoutComplete( \User $oUser, &$injected_html, $sOldName ) {
		wfDebug( 'PowerUserLog: ' . 'Logout complete' . "\n" );
		$oPowerUser = new PowerUser( $oUser );
		if ( $oUser->isPowerUser() && $oPowerUser->pageViewsIsSetCookie() ) {
			wfDebug( 'PowerUserLog: ' . 'Cookie to be cleared' . "\n" );
			$oPowerUser->pageViewsClearCookie();
		}
		return true;
	}

	public function onBeforePageDisplay( \OutputPage $out ) {
		global $wgUser;
		wfDebug( 'PowerUserLog: ' . 'BeforePageDisplay' . "\n" );
		if ( $wgUser instanceof \User ) {
			wfDebug( 'PowerUserLog: ' . 'Is user' . "\n" );
			$oPowerUser = new PowerUser( $wgUser );
			if ( $oPowerUser->pageViewsIsSetCookie() ) {
				wfDebug( 'PowerUserLog: ' . 'Add asset' . "\n" );
				\Wikia::addAssetsToOutput('poweruser_pageviews');
			}
		}
		return true;
	}
}
