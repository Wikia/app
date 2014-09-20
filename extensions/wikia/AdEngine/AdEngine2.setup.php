<?php

// Autoload
$wgAutoloadClasses['AdEngine2Controller'] =  __DIR__ . '/AdEngine2Controller.class.php';
$wgAutoloadClasses['AdEngine2ExitstitialHooks'] =  __DIR__ . '/AdEngine2ExitstitialHooks.class.php';
$wgAutoloadClasses['AdEngine2Hooks'] =  __DIR__ . '/AdEngine2Hooks.class.php';
$wgAutoloadClasses['AdEngine2Service'] =  __DIR__ . '/AdEngine2Service.class.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSevenOneMediaModule'] = __DIR__ . '/ResourceLoaderAdEngineSevenOneMediaModule.php';
$wgAutoloadClasses['AdProviderEbayController'] = __DIR__ . '/AdProviderEbayController.class.php';

// Hooks for AdEngine2
$wgHooks['AfterInitialize'][] = 'AdEngine2Hooks::onAfterInitialize';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Hooks::onWikiaSkinTopScripts';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine2Hooks::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine2Hooks::onWikiaSkinTopModules';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AdEngine2Hooks::onWikiaMobileAssetsPackages';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2Hooks::onOasisSkinAssetGroups';
$wgHooks['InstantGlobalsGetVariables'][] = 'AdEngine2Hooks::onInstantGlobalsGetVariables';

// Hooks for Exitstitial ads
$wgHooks['LinkerMakeExternalLink'][] = 'AdEngine2ExitstitialHooks::onLinkerMakeExternalLink';
$wgHooks['LinkEnd'][] = 'AdEngine2ExitstitialHooks::onLinkEnd';

// i18n
$wgExtensionMessagesFiles['AdEngine'] = __DIR__ . '/AdEngine.i18n.php';
$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage('AdEngine', array('adengine-*'));
};

// Register Resource Loader module for SevenOne Media files
$wgResourceModules['wikia.ext.adengine.sevenonemedia'] = array(
	'class' => 'ResourceLoaderAdEngineSevenOneMediaModule',
);
