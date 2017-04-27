<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isPageFairRecoveryEnabled() {
		global $wgUser, $wgAdDriverEnablePageFairRecovery;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] ) && $wgAdDriverEnablePageFairRecovery === true;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isSourcePointRecoveryEnabled() {
		global $wgUser, $wgAdDriverEnableSourcePointRecovery;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] ) && $wgAdDriverEnableSourcePointRecovery;
	}

	/**
	 * Checks whether SourcePoint MMS is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public static function isSourcePointMessagingEnabled() {
		global $wgUser, $wgAdDriverEnableSourcePointMMS;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] ) && $wgAdDriverEnableSourcePointMMS;
	}

	/**
	 * Checks whether should load SourcePoint bootstrap
	 *
	 * @return bool
	 */
	public static function shouldLoadSourcePointBootstrap() {
		return self::isSourcePointRecoveryEnabled() || self::isSourcePointMessagingEnabled();
	}
}
