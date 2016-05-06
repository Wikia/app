<?php

class ARecoveryEngineHooks {
	const ASSET_GROUP_ARECOVERY_LOCK = 'arecovery_lock_scss';

	/**
	 * Register recovery related scripts on the top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		if ( !ARecoveryModule::isEnabled() ) {
			return true;
		}

		$scripts .= F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );

		return true;
	}

	public static function onBeforePageDisplay( &$outputPage, &$skin ) {
		if ( ARecoveryModule::isEnabled() ) {
			Wikia::addAssetsToOutput( self::ASSET_GROUP_ARECOVERY_LOCK );
		}

		return true;
	}
}
