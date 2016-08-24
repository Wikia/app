<?php

class ARecoveryModule {
	const ASSET_GROUP_ARECOVERY_LOCK = 'arecovery_lock_scss';

	/**
	 * Checks whether recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isEnabled() {
		global $wgUser, $wgEnableUsingSourcePointProxyForCSS;

		if( $wgUser instanceof User && $wgUser->isLoggedIn() ) {
			return false;
		}

		return !empty( $wgEnableUsingSourcePointProxyForCSS );
	}
	
	public static function getSourcePointBootStrapCode() {
		if ( !static::isEnabled() ) {
			return '<!-- SourcePoint recovery disabled. -->';
		}
		$sourcePointScript = F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
		return $sourcePointScript;
	}
	

	public static function isLockEnabled() {
		$user = F::app()->wg->User;
		return self::isEnabled() && ( $user && !$user->isLoggedIn() );
	}
}
