<?php

class ARecoveryEngineHooks {
	
	public static function onBeforePageDisplay( &$outputPage, &$skin ) {
		if ( ARecoveryModule::isLockEnabled() ) {
			Wikia::addAssetsToOutput( ARecoveryModule::ASSET_GROUP_ARECOVERY_LOCK );
		}
		return true;
	}

	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgARecoveryEngineCustomLog';
		return true;
	}
}
