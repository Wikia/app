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

	static public function onWikiaAssetsPackages ( &$wgOut, &$jsPackages, &$scssPackages ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) && $wgOut->getSkin()->getSkinName() == 'oasis' ) {
			$scssPackages[] = 'extensions/wikia/Qualaroo/css/Qualaroo.scss';
		}

		return true;
	}
}
