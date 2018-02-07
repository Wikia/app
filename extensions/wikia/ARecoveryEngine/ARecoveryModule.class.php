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
	 * Checks whether InstartLogic recovery is enabled
	 *
	 * @return bool
	 */
	public static function isInstartLogicRecoveryEnabled() {
		global $wgAdDriverEnableInstartLogicRecovery;

		return static::isRecoverablePage() && $wgAdDriverEnableInstartLogicRecovery;
	}

	public static function isRecoverablePage() {
		global $wgUser;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] );
	}
}
