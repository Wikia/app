<?php

class ARecoveryModule {
	const ASSET_GROUP_ARECOVERY_LOCK = 'arecovery_lock_scss';

	/**
	 * Checks whether recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isEnabled() {
		global $wgEnableUsingSourcePointProxyForCSS;

		return !empty( $wgEnableUsingSourcePointProxyForCSS );
	}

	public static function isLockEnabled() {
		$user = F::app()->wg->User;
		return self::isEnabled() && ( $user && !$user->isLoggedIn() );
	}

	public static function isUntouchableAdsEnabled() {
		//TODO: Add wgVar
		return true;
	}
}
