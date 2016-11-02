<?php

class ARecoveryModule {

	/**
	 * Checks whether recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isDisabled() {
		global $wgUser, $wgAdDriverEnableSourcePointRecovery;

		if( $wgUser instanceof User && $wgUser->isLoggedIn() ) {
			return false;
		}

		return $wgAdDriverEnableSourcePointRecovery === false;
	}
	
	public static function getSourcePointBootstrapCode() {
		if ( static::isDisabled() ) {
			return PHP_EOL . '<!-- Recovery disabled. -->' . PHP_EOL;
		}
		return F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}
	

	public static function isLockEnabled() {
		$user = F::app()->wg->User;
		return !self::isDisabled() && ( $user && !$user->isLoggedIn() );
	}
}
