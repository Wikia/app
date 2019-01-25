<?php
spl_autoload_register( function( $class ) {
	$prefix = 'FandomCreator\\';
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$file = __DIR__ . '/' . str_replace( '\\', '/', substr( $class, $len ) ) . '.php';
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

// These hooks are active on every wiki
$wgHooks['GetWikisUnderDomain'][] = 'FandomCreator\Hooks::onGetWikisUnderDomain';
$wgHooks['GenerateRobotsRules'][] = 'FandomCreator\Hooks::onGenerateRobotsRules';

if ( !empty( $wgFandomCreatorCommunityId ) ) {
	// Part of the setup that is active on fandom creator communities
	$wgAutoloadClasses['FandomCreator\Api\CommunitySetupController'] = __DIR__ . '/Api/CommunitySetupController.php';

	$wgHooks['NavigationApigetDataAfterExecute'][] = function( WikiaDispatchableObject $dispatchable ) {
		global $wgMaxLevelOneNavElements, $wgFandomCreatorCommunityId, $wgMaxLevelTwoNavElements, $wgMaxLevelThreeNavElements;

		FandomCreator\Hooks::onNavigationApiGetData(
			$dispatchable,
			$wgFandomCreatorCommunityId,
			[$wgMaxLevelOneNavElements, $wgMaxLevelTwoNavElements, $wgMaxLevelThreeNavElements]
		);

		return true;
	};

	$wgHooks['DesignSystemCommunityHeaderModelGetData'][] = 'FandomCreator\Hooks::onDesignSystemCommunityHeaderModelGetData';

	$wgHooks['DesignSystemApigetAllElementsAfterExecute'][] = function( WikiaDispatchableObject $dispatchable ) {
		$params = $dispatchable->getRequest()->getParams();
		$product = $params[DesignSystemApiController::PARAM_PRODUCT];

		if ( $product === 'wikis' ) {
			$cityId = $params[DesignSystemApiController::PARAM_ID];
			$fandomCreatorCommunityId = WikiFactory::getVarValueByName( "wgFandomCreatorCommunityId", $cityId, false, "" );
			FandomCreator\Hooks::onDesignSystemApiGetAllElements( $dispatchable, $fandomCreatorCommunityId );
		}

		return true;
	};

	$wgHooks['MercuryApigetWikiVariablesAfterExecute'][] = function( WikiaDispatchableObject $dispatchable ) {
		global $wgFandomCreatorCommunityId;

		FandomCreator\Hooks::onMercuryApiGetWikiVariables( $dispatchable, $wgFandomCreatorCommunityId );

		return true;
	};
}
