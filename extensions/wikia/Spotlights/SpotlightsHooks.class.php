<?php

class SpotlightsHooks {
	const ASSET_GROUP_SPOTLIGHTS = 'spotlights_js';

	/**
	 * Register spotlights related var on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts(&$vars, &$scripts)
	{
		global $wgEnableOpenXSPC;

		if ($wgEnableOpenXSPC) {
			$vars['wgEnableOpenXSPC'] = $wgEnableOpenXSPC;
		}

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		$jsAssets[] = self::ASSET_GROUP_SPOTLIGHTS;

		return true;
	}
}
