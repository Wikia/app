<?php

$wgAutoloadClasses['AdServer'] =  __DIR__ . '/AdServer.php';
$wgAutoloadClasses['AdEngine2Controller'] =  __DIR__ . '/AdEngine2Controller.class.php';
$wgAutoloadClasses['AdEngine2Hooks'] =  __DIR__ . '/AdEngine2Hooks.class.php';
$wgAutoloadClasses['AdEngine2Service'] =  __DIR__ . '/AdEngine2Service.class.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSevenOneMediaModule'] = __DIR__ . '/ResourceLoaderAdEngineSevenOneMediaModule.php';

$wgHooks['AfterInitialize'][] = 'AdEngine2Hooks::onAfterInitialize';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Hooks::onWikiaSkinTopScripts';
$wgHooks['MakeGlobalVariablesScript'][] = 'AdEngine2Hooks::onMakeGlobalVariablesScript';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine2Hooks::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine2Hooks::onWikiaSkinTopModules';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2Hooks::onOasisSkinAssetGroups';
$wgHooks['LinkerMakeExternalLink'][] = 'AdEngine2Hooks::onLinkerMakeExternalLink';
$wgHooks['LinkEnd'][] = 'AdEngine2Hooks::onLinkEnd';

$wgExtensionMessagesFiles['AdEngine'] = __DIR__ . '/AdEngine.i18n.php';

$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage('AdEngine', array('adengine-*'));
};

// Register Resource Loader module for SevenOne Media files
$wgResourceModules['wikia.ext.adengine.sevenonemedia'] = array(
	'class' => 'ResourceLoaderAdEngineSevenOneMediaModule',
);
