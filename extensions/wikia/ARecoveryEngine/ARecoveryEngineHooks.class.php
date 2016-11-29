<?php

class ARecoveryEngineHooks {

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgARecoveryEngineCustomLog';
		$vars[] = 'wgAdDriverSourcePointRecoveryCountries';
		return true;
	}
}
