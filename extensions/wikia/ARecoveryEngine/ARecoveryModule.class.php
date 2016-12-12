<?php

class ARecoveryModule {
	const DISABLED_MESSAGE = PHP_EOL . '<!-- Recovery disabled. -->' . PHP_EOL;

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
		return static::isDisabled() ? self::DISABLED_MESSAGE : self::getBootstrapCode();
	}

	public static function isLockEnabled() {
		return !self::isDisabled();
	}

	private static function getBootstrapCode() {
		return F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}
}
