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
		global $wgNoExternals, $wgOut;

		if ( empty( $wgNoExternals ) && $wgOut->getSkin()->getSkinName() == 'oasis' ) {
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

	static public function onMakeGlobalVariablesScript( &$vars, $outputPage ) {
		global $wgNoExternals, $wgQualarooDevUrl, $wgDevelEnvironment, $wgQualarooUrl, $wgUser, $wgCityId;

		if ( empty( $wgNoExternals ) && $outputPage->getSkin()->skinname == 'oasis' ) {
			$vars[ 'wgQualarooUrl' ] = ( $wgDevelEnvironment ) ? $wgQualarooDevUrl : $wgQualarooUrl;
			$vars[ 'isContributor' ] = $wgUser->getEditCount() > 0;
			$vars[ 'isCurrentWikiAdmin' ] = in_array( $wgUser->getId(), ( new WikiService() )->getWikiAdminIds() );
			$vars[ 'fullVerticalName' ] = ( new WikiFactoryHub() )->getWikiVertical( $wgCityId )[ 'short' ];
			$vars[ 'dartGnreValues' ] = AdTargeting::getRatingFromDartKeyValues( 'gnre' );
		}

		return true;
	}
}
