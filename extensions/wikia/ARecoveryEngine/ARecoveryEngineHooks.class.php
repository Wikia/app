<?php

class ARecoveryEngineHooks {
	/**
	 * Register recovery related scripts on the top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDevelEnvironment;

		if ( ARecoveryModule::isEnabled() ) {
			$spStatusURL = 'http://community.wikia.com/api/v1/ARecoveryEngine/SPStatus';
			if ( !empty( $wgDevelEnvironment ) ) {
				$spStatusURL = '/api/v1/ARecoveryEngine/SPStatus';
			}
			$scripts .= '<script src="' . $spStatusURL . '"></script>';
			$scripts .= F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
		}

		return true;
	}

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
