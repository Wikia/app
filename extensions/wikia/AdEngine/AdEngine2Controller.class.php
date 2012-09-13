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

		$vars['adslots2'] = array();

		// TODO remove? dev only?
		global $wgHighValueCountries2;
		if ($wgHighValueCountries2) {
			$vars['wgHighValueCountries2'] = $wgHighValueCountries2;
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add ad asset to JavaScripts loaded on bottom (with regular JavaScripts)
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function addNonBlockingAssetGroup(&$jsAssets) {
		$coreGroupIndex = array_search(self::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex !== false) {
			// Adding self::ASSET_GROUP_ADENGINE group after self::ASSET_GROUP_CORE
			array_splice($jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE);
		} else {
			// Do nothing. oasis_shared_core_js must be present for ads to work
		}
		return true;
	}

	/**
	 * Add ad assets and oasis_shared_core_js to JavaScripts at the top
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function addBlockingAssetGroup(&$jsAssets) {
		$jsAssets[] = self::ASSET_GROUP_CORE;
		$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		return true;
	}

	/**
	 * Remove oasis_shared_core_js asset (because we added it to the scripts in HEAD)
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function removeCoreAssetGroup(&$jsAssets) {
		$coreGroupIndex = array_search(self::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex !== false) {
			// Removing oasis_shared_core_js asset group
			array_splice($jsAssets, $coreGroupIndex, 1);
		} else {
			// Do nothing. oasis_shared_core_js must be present for ads to work
		}
		return true;
	}
}
