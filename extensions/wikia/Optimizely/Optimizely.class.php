<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsAssetGroups[] = 'optimizely_blocking_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		global $wgOptimizelyLoadFromOurCDN, $wgNoExternals, $wgWikiaEnvironment;

		if ( !$wgNoExternals ) {
			// load optimizely_blocking_js on wikiamobile
			if ( F::app()->checkSkin( ['wikiamobile'], $skin ) ) {
				foreach ( AssetsManager::getInstance()->getURL( [ 'optimizely_blocking_js' ] ) as $script ) {
					$scripts .= '<script src="' . $script . '"></script>';
				}
			}

			// On devboxes and sandboxes Optimizely script should be laoded from original CDN for the ease of testing
			// the experiments, by mitigating the need to run the fetchOptimizelyScript.php (or waiting for it to be run
			// by cron for sandbox).
			if ( $wgOptimizelyLoadFromOurCDN &&
				!in_array( $wgWikiaEnvironment, [ WIKIA_ENV_DEV, WIKIA_ENV_SANDBOX ] )
			) {
				$scripts .= static::loadFromOurCDN();
			} else {
				$scripts .= static::loadOriginal();
			}
		}

		return true;
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
		return '<script src="' . ($wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl) . '"></script>';
	}
}
