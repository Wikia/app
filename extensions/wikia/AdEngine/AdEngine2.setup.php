<?php

$wgAutoloadClasses['AdServer'] =  __DIR__ . '/AdServer.php';
$wgAutoloadClasses['AdEngine2Controller'] =  __DIR__ . '/AdEngine2Controller.class.php';

$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Controller::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine2Controller::onWikiaSkinTopScriptsLegacy';
$wgHooks['MakeGlobalVariablesScript'][] = 'AdEngine2Controller::onMakeGlobalVariablesScript';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine2Controller::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine2Controller::onWikiaSkinTopModules';
$wgHooks['OasisSkinAssetGroups'][] = 'AdEngine2Controller::onOasisSkinAssetGroups';
$wgHooks['LinkerMakeExternalLink'][] = 'AdEngine2Controller::onLinkerMakeExternalLink';
$wgHooks['LinkEnd'][] = 'AdEngine2Controller::onLinkEnd';

$wgExtensionMessagesFiles['AdEngine'] = __DIR__ . '/AdEngine.i18n.php';

$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage('AdEngine', array('adengine-*'));
};
