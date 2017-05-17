<?php

class ARecoveryEngineHooks {

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgARecoveryEngineCustomLog';
		$vars[] = 'wgAdDriverSourcePointRecoveryCountries';
		$vars[] = 'wgAdDriverPageFairRecoveryCountries';
		$vars[] = 'wgAdDriverPageFairConditionalAdRendering';
		$vars[] = 'wgAdDriverPageFairConditionalIframeRendering';

		return true;
	}
}
