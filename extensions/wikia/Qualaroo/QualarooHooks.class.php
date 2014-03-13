<?php
class QualarooHooks {
	/**
	* Add Qualaroo assets on Oasis
	*
	* @param $assetsArray
	*
	* @return bool
	*/
	static public function onOasisSkinAssetGroups( &$assetsArray ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$assetsArray[] = 'qualaroo_js';
		}

		return true;
	}
}
