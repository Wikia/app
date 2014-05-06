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
			$scssPackages[] = 'wikia/Qualaroo/css/Qualaroo.scss';
		}

		return true;
	}

	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		global $wgNoExternals, $wgOut;

		if ( empty( $wgNoExternals ) && $wgOut->getSkin()->getSkinName() == 'oasis' ) {
			$jsAssetGroups[] = 'qualaroo_blocking_js';
		}

		return true;
	}

	static public function onMakeGlobalVariablesScript ( &$vars, $outputPage ) {
		global $wgNoExternals, $wgQualarooDevUrl, $wgDevelEnvironment, $wgQualarooUrl;

		if ( empty( $wgNoExternals ) && $outputPage->getSkin()->skinname == 'oasis' ) {
			$vars['wgQualarooUrl'] = ($wgDevelEnvironment) ? $wgQualarooDevUrl : $wgQualarooUrl;
		}

		return true;
	}
}
