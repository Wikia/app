<?php

/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		if ( static::shouldLoadOptimizely() ) {
			$jsAssetGroups[] = 'optimizely_blocking_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		global $wgOptimizelyLoadFromOurCDN, $wgWikiaEnvironment;

		if ( static::shouldLoadOptimizely() ) {
			// On devboxes and sandboxes Optimizely script should be laoded from original CDN for the ease of testing
			// the experiments, by mitigating the need to run the fetchOptimizelyScript.php (or waiting for it to be run
			// by cron for sandbox).
			if (
				$wgOptimizelyLoadFromOurCDN &&
				!in_array( $wgWikiaEnvironment, [ WIKIA_ENV_DEV, WIKIA_ENV_SANDBOX ] )
			) {
				$scripts .= static::loadFromOurCDN();
			} else {
				$scripts .= static::loadOriginal();
			}
		}

		return true;
	}

	public static function shouldLoadOptimizely() {
		global $wgNoExternals;

		return empty( $wgNoExternals );
	}

	protected static function loadFromOurCDN() {
		$scriptDomain = WikiFactory::getLocalEnvURL(
			WikiFactory::getVarValueByName( 'wgServer', Wikia::COMMUNITY_WIKI_ID )
		);
		// do not async - we need it for UA tracking
		return '<script src="' . $scriptDomain . '/wikia.php?controller=Optimizely&method=getCode"></script>';
	}

	protected static function loadOriginal() {
		global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;
		// do not async - we need it for UA tracking
		return '<script src="' . ( $wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl ) . '"></script>';
	}
}
