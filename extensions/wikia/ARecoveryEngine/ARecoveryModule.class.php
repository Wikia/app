<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isPageFairRecoveryEnabled() {
		global $wgAdDriverEnablePageFairRecovery;

		return static::isRecoverablePage() && $wgAdDriverEnablePageFairRecovery === true;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isSourcePointRecoveryEnabled() {
		global $wgAdDriverEnableSourcePointRecovery;

		return static::isRecoverablePage() && $wgAdDriverEnableSourcePointRecovery;
	}

	/**
	 * Checks whether InstartLogic recovery is enabled
	 *
	 * @return bool
	 */
	public static function isInstartLogicRecoveryEnabled() {
		global $wgAdDriverEnableInstartLogicRecovery;

		return static::isRecoverablePage() && $wgAdDriverEnableInstartLogicRecovery;
	}

	/**
	 * Checks whether SourcePoint MMS is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isSourcePointMessagingEnabled() {
		global $wgAdDriverEnableSourcePointMMS, $wgAdDriverEnableSourcePointRecovery;

		return static::isRecoverablePage() && $wgAdDriverEnableSourcePointMMS && !$wgAdDriverEnableSourcePointRecovery;
	}

	/**
	 * Checks whether should load SourcePoint bootstrap
	 *
	 * @return bool
	 */
	public static function shouldLoadSourcePointBootstrap() {
		return self::isSourcePointRecoveryEnabled() || self::isSourcePointMessagingEnabled();
	}

	public static function isRecoverablePage() {
		global $wgUser;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] );
	}
}
