<?php

class ARecoveryEngineHooks {

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgARecoveryEngineCustomLog';
		$vars[] = 'wgAdDriverSourcePointRecoveryCountries';
		$vars[] = 'wgAdDriverPageFairRecoveryCountries';

		return true;
	}
}
