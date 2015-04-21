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
		global $wgPADConfig;

		if( !empty( $wgPADConfig ) ) {
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
		global $wgPADConfig;

		if( !empty( $wgPADConfig ) ) {
			$vars['wgPADConfig'] = $wgPADConfig;
		}

		return true;
	}

}
