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

		$wgGlobalEnableSourcePoint = WikiFactory::getVarValueByName( 'wgGlobalEnableSourcePoint', Wikia::COMMUNITY_WIKI_ID );

		return !empty( $wgEnableUsingSourcePointProxyForCSS ) || !empty( $wgGlobalEnableSourcePoint );
	}

	public static function isLockEnabled() {
		$user = F::app()->wg->User;
		return self::isEnabled() && ( $user && !$user->isLoggedIn() );
	}
}
