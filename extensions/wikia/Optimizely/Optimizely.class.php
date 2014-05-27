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
		global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl, $wgNoExternals;

		if ( !$wgNoExternals ) {
			// load optimizely_blocking_js on wikiamobile
			if ( F::app()->checkSkin( ['wikiamobile'], $skin ) ) {
				foreach ( AssetsManager::getInstance()->getURL( [ 'optimizely_blocking_js' ] ) as $script ) {
					$scripts .= '<script src="' . $script . '"></script>';
				}
			}

			$scripts .= '<script src="' . ($wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl) . '" async></script>';
		}

		return true;
	}
}
