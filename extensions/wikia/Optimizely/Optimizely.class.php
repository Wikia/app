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
		global $wgOptimizelyLoadFromOurCDN;

		// load optimizely_blocking_js on wikiamobile
		if ( F::app()->checkSkin( ['wikiamobile'], $skin ) ) {
			foreach ( AssetsManager::getInstance()->getURL( [ 'optimizely_blocking_js' ] ) as $script ) {
				$scripts .= '<script src="' . $script . '"></script>';
			}
		}

		if ( $wgOptimizelyLoadFromOurCDN ) {
			$scripts .= static::loadFromOurCDN();
		} else {
			$scripts .= static::loadOriginal();
		}

		return true;
	}

	protected static function loadFromOurCDN() {
		$scriptDomain = WikiFactory::getLocalEnvURL( WikiFactory::getVarValueByName( 'wgServer', 177 ) );
		return '<script src="' . $scriptDomain . '/wikia.php?controller=Optimizely&method=getCode"></script>';
	}

	protected static function loadOriginal() {
		global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;
		return '<script src="' . ($wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl) . '" async></script>';
	}
}
