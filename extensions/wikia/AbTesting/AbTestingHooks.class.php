<?php

/**
 * AbTestingHooks contains all hook handlers used in AbTesting
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class AbTestingHooks {

	public static function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		array_unshift( $jsBodyPackages, 'abtesting' );
		return true;
	}
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		array_unshift( $jsAssetGroups, 'abtesting' );
		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		$app = F::app();
		$wg = $app->wg;
		if ( $app->checkSkin( 'wikiamobile', $skin ) ) {
			//Add this mock as wikia.ext.abtesting relies on it and on WikiaMobile there is no mw object
			//This will need some treatment if we add more abtesting to WikiaMobile
			$scripts .= '<script>var mw = {loader: {state: function(){}}}</script>';
		}

		if ( $app->checkSkin( ['oasis', 'wikiamobile'], $skin ) ) {
			$scripts .= ResourceLoader::makeCustomLink( $wg->out, array( 'wikia.ext.abtesting' ), 'scripts' ) . "\n";
		}

		return true;
	}

	static public function onWikiaSkinTopShortTTLModules( Array &$modules, $skin) {
		$app = F::app();

		if ( $app->checkSkin( ['oasis', 'wikiamobile', 'venus'], $skin ) ) {
			$modules[] = 'wikia.ext.abtesting';
		}

		return true;
	}
}