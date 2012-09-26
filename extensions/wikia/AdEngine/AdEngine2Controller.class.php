<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {
	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';

	/**
	 * Register ad-related vars on top
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public function onWikiaSkinTopScripts(&$vars) {
		wfProfileIn(__METHOD__);

		$wg = $this->app->wg;

		$vars['adslots2'] = array();
		$vars['wgLoadAdsInHead'] = $wg->LoadAdsInHead;

		// TODO remove? dev only?
		$vars['wgHighValueCountries2'] = $wg->HighValueCountries2;

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function onOasisSkinAssetGroups(&$jsAssets) {
		$coreGroupIndex = array_search(self::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex === false) {
			// Do nothing. oasis_shared_core_js must be present for ads to work
			return true;
		}

		if (F::app()->wg->LoadAdsInHead) {
			// Removing oasis_shared_core_js asset group
			array_splice($jsAssets, $coreGroupIndex, 1);
		} else {
			// Add ad asset to JavaScripts loaded on bottom (with regular JavaScripts)
			array_splice($jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE);
		}
		return true;
	}

	/**
	 * Modify assets appended to the top of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if (F::app()->wg->LoadAdsInHead) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = self::ASSET_GROUP_CORE;
			$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		}
		return true;
	}
}
