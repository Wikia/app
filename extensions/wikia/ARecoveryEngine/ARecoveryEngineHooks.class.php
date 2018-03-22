<?php

class ARecoveryEngineHooks {

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgARecoveryEngineCustomLog';
		$vars[] = 'wgAdDriverPageFairRecoveryCountries';
		$vars[] = 'wgAdDriverInstartLogicRecoveryCountries';

		return true;
	}
}
