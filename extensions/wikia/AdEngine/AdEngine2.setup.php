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
$wgAutoloadClasses['AdEngine2ExitstitialHooks'] =  __DIR__ . '/AdEngine2ExitstitialHooks.class.php';
$wgAutoloadClasses['AdEngine2Hooks'] =  __DIR__ . '/AdEngine2Hooks.class.php';
$wgAutoloadClasses['AdEngine2PageTypeService'] = __DIR__ . '/AdEngine2PageTypeService.class.php';
$wgAutoloadClasses['AdEngine2Service'] =  __DIR__ . '/AdEngine2Service.class.php';
$wgAutoloadClasses['AdTargeting'] =  __DIR__ . '/AdTargeting.class.php';
$wgAutoloadClasses['ResourceLoaderAdEngineBase'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineBase.php';
$wgAutoloadClasses['ResourceLoaderScript'] = __DIR__ . '/ResourceLoaders/ResourceLoaderScript.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSevenOneMediaModule'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSevenOneMediaModule.php';

// Hooks for Exitstitial ads
$wgHooks['LinkerMakeExternalLink'][] = 'AdEngine2ExitstitialHooks::onLinkerMakeExternalLink';
$wgHooks['LinkEnd'][] = 'AdEngine2ExitstitialHooks::onLinkEnd';
$wgHooks['MakeGlobalVariablesScript'][] = 'AdEngine2ExitstitialHooks::onMakeGlobalVariablesScript';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2ExitstitialHooks::onOasisSkinAssetGroups';

// Hooks for AdEngine2
$wgHooks['AfterInitialize'][] = 'AdEngine2Hooks::onAfterInitialize';
$wgHooks['InstantGlobalsGetVariables'][] = 'AdEngine2Hooks::onInstantGlobalsGetVariables';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2Hooks::onOasisSkinAssetGroups';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine2Hooks::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AdEngine2Hooks::onWikiaMobileAssetsPackages';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Hooks::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine2Hooks::onWikiaSkinTopModules';
$wgHooks['SkinAfterContent'][] = 'AdEngine2Hooks::onSkinAfterContent';

// i18n
$wgExtensionMessagesFiles['AdEngine'] = __DIR__ . '/AdEngine.i18n.php';
$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage( 'AdEngine', [
		'adengine-*'
	] );
};

JSMessages::enqueuePackage('AdEngine', JSMessages::EXTERNAL);

$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage( 'AdEngineRecoveryMessage', [
		'adengine-recovery-message-*'
	] );
};

// Register Resource Loader module for SevenOne Media files
$wgResourceModules['wikia.ext.adengine.sevenonemedia'] = array(
	'class' => 'ResourceLoaderAdEngineSevenOneMediaModule',
);

$wgResourceModules['wikia.ext.adengine.sp.detection'] = array(
	'class' => 'ResourceLoaderAdEngineSourcePointDetectionModule',
);

// Special page for importing ad test
if ( !empty( $wgDevelEnvironment ) && $wgDBname === 'adtest' ) {
	$wgAutoloadClasses['SpecialAdTestImport'] = __DIR__ . '/SpecialAdTestImport.class.php';
	$wgSpecialPages['AdTestImport'] = 'SpecialAdTestImport';
}
