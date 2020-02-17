<?php
class QualarooHooks {
	/**
	* Add Qualaroo assets on Oasis
	*
	* @param $assetsArray
	*
	* @return bool
	*/
	static public function onOasisSkinAssetGroups( array &$assetsArray ): bool {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$assetsArray[] = 'qualaroo_js';
		}

		return true;
	}

	static public function onWikiaAssetsPackages ( OutputPage $out, array &$jsPackages, array &$scssPackages ): bool {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$scssPackages[] = 'wikia/Qualaroo/css/Qualaroo.scss';
		}

		return true;
	}

	static public function onOasisSkinAssetGroupsBlocking( array &$jsAssetGroups ): bool {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsAssetGroups[] = 'qualaroo_blocking_js';
		}

		return true;
	}

	static public function onMakeGlobalVariablesScript( array &$vars, OutputPage $outputPage ): bool {
		global $wgNoExternals, $wgQualarooDevUrl, $wgDevelEnvironment, $wgQualarooUrl, $wgUser, $wgCityId;

		if ( empty( $wgNoExternals ) && $outputPage->getSkin()->getSkinName() == 'oasis' ) {
			$vars[ 'wgQualarooUrl' ] = ( $wgDevelEnvironment ) ? $wgQualarooDevUrl : $wgQualarooUrl;
			$vars[ 'isContributor' ] = $wgUser->getEditCount() > 0;
			$vars[ 'isCurrentWikiAdmin' ] = in_array( $wgUser->getId(), ( new WikiService() )->getWikiAdminIds() );
			$vars[ 'fullVerticalName' ] = ( new WikiFactoryHub() )->getWikiVertical( $wgCityId )[ 'short' ];
			$vars[ 'dartGnreValues' ] = AdTargeting::getRatingFromDartKeyValues( 'gnre' );
		}

		return true;
	}
}
