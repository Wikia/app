<?php

class ARecoveryModule {
	const DISABLED_MESSAGE = PHP_EOL . '<!-- Recovery disabled. -->' . PHP_EOL;

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

	public function getSourcePointBootstrapCode() {
		return $this->isSourcePointRecoveryEnabled() ? $this->getBootstrapCode() : static::DISABLED_MESSAGE;
	}

	private function getBootstrapCode() {
		return F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}
}
