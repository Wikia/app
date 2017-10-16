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
		if ( !$oUser->isSpecificPowerUser( PowerUser::TYPE_LIFETIME ) &&
			$oUser->getEditCount() > PowerUser::MIN_LIFETIME_EDITS
		) {
			$oPowerUser = new PowerUser( $oUser );
			$oPowerUser->addPowerUserProperty( PowerUser::TYPE_LIFETIME );
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
}
