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

	/**
	 * If a user is a PowerUser, add the pageviews tracking module
	 * @see extensions/wikia/PowerUser/js/pageViewTracking.js
	 *
	 * @param \OutputPage $out
	 * @return bool
	 */
	public function onBeforePageDisplay( \OutputPage $out ) {
		global $wgUser;
		if ( $wgUser instanceof \User && $wgUser->isPowerUser() ) {
			\Wikia::addAssetsToOutput( 'poweruser' );
		}
		return true;
	}
}
