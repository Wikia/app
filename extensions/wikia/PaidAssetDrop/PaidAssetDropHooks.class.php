<?php
class PaidAssetDropHooks {

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		global $wgPaidAssetDropConfig;

		if( !empty( $wgPaidAssetDropConfig ) ) {
			$jsAssets[] = 'paid_asset_drop_desktop_js';
		}

		return true;
	}

	/**
	 * Register PAD var on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgPaidAssetDropConfig;

		if( !empty( $wgPaidAssetDropConfig ) ) {
			$vars['wgPaidAssetDropConfig'] = $wgPaidAssetDropConfig;
		}

		return true;
	}

}
