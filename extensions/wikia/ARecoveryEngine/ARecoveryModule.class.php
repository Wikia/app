<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 *
	 * $wgAdDriverEnablePageFairRecovery === false; // disabled on wiki
	 * $wgAdDriverEnablePageFairRecovery === true; // enabled on wiki
	 *
	 * @return bool
	 */
	public function isPageFairRecoveryEnabled() {
		global $wgUser, $wgAdDriverEnablePageFairRecovery;

		return $wgUser->isAnon() && F::app()->checkSkin( [ 'oasis' ] ) && $wgAdDriverEnablePageFairRecovery === true;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * $wgAdDriverEnableSourcePointRecovery === false; // disabled on wiki
	 * $wgAdDriverEnableSourcePointRecovery === true; // enabled on wiki
	 *
	 * @return bool
	 */
	public function isSourcePointRecoveryEnabled() {
		global $wgUser, $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS;

		return $wgUser->isAnon() && (
			$wgAdDriverEnableSourcePointRecovery === true || $wgAdDriverEnableSourcePointMMS === true
		);
	}
}
