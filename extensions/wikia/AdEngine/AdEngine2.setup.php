<?php

$wgExtensionCredits['other'][] =
	array(
		'name' => 'Ad Engine',
		'author' => 'Wikia',
		'descriptionmsg' => 'adengine-desc',
		'version' => '2.0',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AdEngine',
	);

// Autoload
$wgAutoloadClasses['AdEngine2ContextService'] =  __DIR__ . '/AdEngine2ContextService.class.php';
$wgAutoloadClasses['AdEngine2Controller'] =  __DIR__ . '/AdEngine2Controller.class.php';
$wgAutoloadClasses['AdEngine2Hooks'] =  __DIR__ . '/AdEngine2Hooks.class.php';
$wgAutoloadClasses['AdEngine2PageTypeService'] = __DIR__ . '/AdEngine2PageTypeService.class.php';
$wgAutoloadClasses['AdEngine2Resource'] = __DIR__ . '/ResourceLoaders/AdEngine2Resource.class.php';
$wgAutoloadClasses['AdEngine2Service'] =  __DIR__ . '/AdEngine2Service.class.php';
$wgAutoloadClasses['AdTargeting'] =  __DIR__ . '/AdTargeting.class.php';
$wgAutoloadClasses['ResourceLoaderAdEngineBase'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineBase.php';
$wgAutoloadClasses['ResourceLoaderScript'] = __DIR__ . '/ResourceLoaders/ResourceLoaderScript.php';
$wgAutoloadClasses['AdEngine2ApiController'] = __DIR__ . '/AdEngine2ApiController.class.php';

// Hooks for AdEngine2
$wgHooks['AfterInitialize'][] = 'AdEngine2Hooks::onAfterInitialize';
$wgHooks['InstantGlobalsGetNewsAndStoriesVariables'][] = 'AdEngine2Hooks::onInstantGlobalsGetNewsAndStoriesVariables';
$wgHooks['InstantGlobalsGetVariables'][] = 'AdEngine2Hooks::onInstantGlobalsGetVariables';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2Hooks::onOasisSkinAssetGroups';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine2Hooks::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AdEngine2Hooks::onWikiaMobileAssetsPackages';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Hooks::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine2Hooks::onWikiaSkinTopModules';

// i18n
$wgExtensionMessagesFiles['AdEngine'] = __DIR__ . '/AdEngine.i18n.php';
$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage( 'AdEngine', [
		'adengine-*'
	] );
};

JSMessages::enqueuePackage('AdEngine', JSMessages::EXTERNAL);

AdEngine2Resource::register('wikia.ext.adengine.pf.detection', 'ResourceLoaderAdEnginePageFairDetectionModule');
AdEngine2Resource::register('wikia.ext.adengine.sp.detection', 'ResourceLoaderAdEngineSourcePointDetectionModule');

// Special page for importing ad test
if ( !empty( $wgDevelEnvironment ) && $wgDBname === 'adtest' ) {
	$wgAutoloadClasses['SpecialAdTestImport'] = __DIR__ . '/SpecialAdTestImport.class.php';
	$wgSpecialPages['AdTestImport'] = 'SpecialAdTestImport';
}
