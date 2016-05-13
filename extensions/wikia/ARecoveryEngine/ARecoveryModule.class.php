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
		$user = F::app()->wg->User;

		return !empty( $wgEnableUsingSourcePointProxyForCSS ) && !$user->isLoggedIn();
	}
}
