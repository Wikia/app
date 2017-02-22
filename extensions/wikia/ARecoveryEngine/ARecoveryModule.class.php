<?php

class ARecoveryModule {
	/**
	 * Checks whether PageFair recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public function isPageFairRecoveryDisabled() {
		global $wgUser;

		return $wgUser->isLoggedIn() ||
			( $this->hasSourcePointDisabledWgVars() && !$this->hasPageFairDisabledWgVars() );
	}

	protected function hasPageFairDisabledWgVars() {
		global $wgAdDriverEnablePageFairRecovery;

		return $wgAdDriverEnablePageFairRecovery === false;
	}

	/**
	 * Checks whether SourcePoint recovery is enabled (on current wiki)
	 *
	 * @return bool
	 */
	public function isSourcePointRecoveryDisabled() {
		global $wgUser;

		return $wgUser->isLoggedIn() ||
			( $this->hasPageFairDisabledWgVars() && !$this->hasSourcePointDisabledWgVars() );
	}

	protected function hasSourcePointDisabledWgVars() {
		global $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS;

		return $wgAdDriverEnableSourcePointRecovery === false && $wgAdDriverEnableSourcePointMMS === false;
	}
}
