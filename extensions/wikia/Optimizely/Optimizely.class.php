<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {

	/**
	 * Which environments are considered a developemnt/testing environments for Optimizely experiments?
	 * Optimizely Wikia Dev project script should be served also on sandboxes, to prevent poluting Wikia Prod project
	 * script with experiments that are still under developement.
	 */
	const OPTIMIZELY_DEV_ENVIRONMENTS = [ WIKIA_ENV_DEV, WIKIA_ENV_SANDBOX ];

	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsAssetGroups[] = 'optimizely_blocking_js';
		}

		return true;
	}

	/**
	 * Load Optimizely AssetsManager "blocking" group (i.e. in head section) on Venus
	 *
	 * @param array $jsHeadGroups
	 * @param array $jsBodyGroups
	 * @param array $cssGroups
	 * @return bool true
	 */
	static public function onVenusAssetsPackages( Array &$jsHeadGroups, Array &$jsBodyGroups, Array &$cssGroups ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsHeadGroups[] = 'optimizely_blocking_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		global $wgOptimizelyLoadFromOurCDN, $wgNoExternals;

		if ( !$wgNoExternals ) {
			// load optimizely_blocking_js on wikiamobile
			if ( F::app()->checkSkin( ['wikiamobile'], $skin ) ) {
				foreach ( AssetsManager::getInstance()->getURL( [ 'optimizely_blocking_js' ] ) as $script ) {
					$scripts .= '<script src="' . $script . '"></script>';
				}
			}

			// On dev envs Optimizely script should be laoded from original CDN for the ease of testing the experiments.
			if ( $wgOptimizelyLoadFromOurCDN && !static::isOptimizelyDevEnv() ) {
				$scripts .= static::loadFromOurCDN();
			} else {
				$scripts .= static::loadOriginal();
			}
		}

		return true;
	}

	public static function getOptimizelyUrl() {
		global $wgOptimizelyUrl, $wgOptimizelyDevUrl;

		return static::isOptimizelyDevEnv() ? $wgOptimizelyDevUrl : $wgOptimizelyUrl;
	}

	/**
	 * Is current environment considered a developemnt/testing environment for Optimizely experiments?
	 *
	 * @return bool
	 */
	protected static function isOptimizelyDevEnv() {
		global $wgWikiaEnvironment;

		return in_array( $wgWikiaEnvironment, static::OPTIMIZELY_DEV_ENVIRONMENTS );
	}

	protected static function loadFromOurCDN() {
		$scriptDomain = WikiFactory::getLocalEnvURL(
			WikiFactory::getVarValueByName( 'wgServer', Wikia::COMMUNITY_WIKI_ID )
		);
		// do not async - we need it for UA tracking
		return '<script src="' . $scriptDomain . '/wikia.php?controller=Optimizely&method=getCode"></script>';
	}

	protected static function loadOriginal() {
		// do not async - we need it for UA tracking
		return '<script src="' . static::getOptimizelyUrl() . '"></script>';
	}
}
