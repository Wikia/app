<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public function isPageFairRecoveryEnabled() {
		global $wgUser;

		return $wgUser->isAnon() &&
			!$this->hasSourcePointEnabledWgVars() &&
			$this->hasPageFairEnabledWgVars();
	}

	protected function hasPageFairEnabledWgVars() {
		global $wgAdDriverEnablePageFairRecovery;

		return $wgAdDriverEnablePageFairRecovery;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public function isSourcePointRecoveryEnabled() {
		global $wgUser;

		return $wgUser->isAnon() &&
			!$this->hasPageFairEnabledWgVars() &&
			$this->hasSourcePointEnabledWgVars();
	}

	protected function hasSourcePointEnabledWgVars() {
		global $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS;

		return $wgAdDriverEnableSourcePointRecovery && $wgAdDriverEnableSourcePointMMS;
	}
}
