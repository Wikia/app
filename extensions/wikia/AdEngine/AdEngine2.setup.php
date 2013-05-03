<?php

$app = F::app();

$wgAutoloadClasses['AdServer'] =  __DIR__ . '/AdServer.php';
$wgAutoloadClasses['AdEngine2Controller'] =  __DIR__ . '/AdEngine2Controller.class.php';

$app->registerHook('WikiaSkinTopScripts', 'AdEngine2Controller', 'onWikiaSkinTopScripts');
$app->registerHook('WikiaSkinTopScripts', 'AdEngine2Controller', 'onWikiaSkinTopScriptsLegacy');
$app->registerHook('MakeGlobalVariablesScript', 'AdEngine2Controller', 'onMakeGlobalVariablesScript');
$app->registerHook('OasisSkinAssetGroupsBlocking', 'AdEngine2Controller', 'onOasisSkinAssetGroupsBlocking');
$app->registerHook('WikiaSkinTopModules', 'AdEngine2Controller', 'onWikiaSkinTopModules');
$app->registerHook('OasisSkinAssetGroups', 'AdEngine2Controller', 'onOasisSkinAssetGroups');
$app->registerHook('LinkerMakeExternalLink', 'AdEngine2Controller', 'onLinkerMakeExternalLink');
$app->registerHook('LinkEnd', 'AdEngine2Controller', 'onLinkEnd');

$app->registerExtensionMessageFile('AdEngine', __DIR__ . '/AdEngine.i18n.php');

$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage('AdEngine', array('adengine-*'));
};
