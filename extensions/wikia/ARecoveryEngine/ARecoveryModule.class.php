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

		$skin = RequestContext::getMain()->getSkin();
		$skinName = $skin->getSkinName();

		return !empty( $wgEnableUsingSourcePointProxyForCSS ) && $skinName === 'oasis';
	}

	public static function isLockEnabled() {
		$user = F::app()->wg->User;
		return self::isEnabled() && ( $user && !$user->isLoggedIn() );
	}
}
