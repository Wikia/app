<?php

class ARecoveryModule {
	const disabledMessage = PHP_EOL . '<!-- Recovery disabled. -->' . PHP_EOL;

	/**
	 * Checks whether recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isDisabled() {
		global $wgUser, $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS;

		if( $wgUser instanceof User && $wgUser->isLoggedIn() ) {
			return true;
		}

		return $wgAdDriverEnableSourcePointRecovery === false && $wgAdDriverEnableSourcePointMMS === false;
	}
	
	public static function getSourcePointBootstrapCode() {
		if ( static::isDisabled() ) {
			return self::disabledMessage;
		}
		return F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}
	

	public static function isLockEnabled() {
		return !self::isDisabled();
	}
}
