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
		global $wgPaidAssetDrop;

		if( !empty( $wgPaidAssetDrop ) ) {
			$jsAssets[] = 'paid_asset_drop_js';
		}

		return true;
	}

}
