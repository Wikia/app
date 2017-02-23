<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 * $wgAdDriverEnablePageFairRecovery === false; // disabled on wiki
	 * $wgAdDriverEnablePageFairRecovery === true; // enabled on wiki
	 * $wgAdDriverEnablePageFairRecovery === null; // will depend on $wgAdDriverPageFairRecoveryCountries
	 * @return bool
	 */
	public function isPageFairRecoveryDisabled() {
		global $wgUser, $wgAdDriverEnablePageFairRecovery;

		return $wgUser->isLoggedIn() || $wgAdDriverEnablePageFairRecovery === false;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * $wgAdDriverEnableSourcePointRecovery === false; // disabled on wiki
	 * $wgAdDriverEnableSourcePointRecovery === true; // enabled on wiki
	 * $wgAdDriverEnableSourcePointRecovery === null; // will depend on $wgAdDriverSourcePointRecoveryCountries
	 *
	 * @return bool
	 */
	public function isSourcePointRecoveryDisabled() {
		global $wgUser, $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS;

		return $wgUser->isLoggedIn() || (
			$wgAdDriverEnableSourcePointRecovery === false && $wgAdDriverEnableSourcePointMMS === false
		);
	}
}
