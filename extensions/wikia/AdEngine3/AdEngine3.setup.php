<?php
$wgExtensionCredits['other'][] = [
	'name' => 'AdEngine',
	'author' => 'Wikia',
	'description' => 'AdEngine',
	'version' => '3.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AdEngine3',
];

// Autoload
$wgAutoloadClasses['AdEngine3'] =  __DIR__ . '/AdEngine3.class.php';
$wgAutoloadClasses['AdEngine3Controller'] =  __DIR__ . '/AdEngine3Controller.class.php';
$wgAutoloadClasses['AdEngine3DeciderService'] = __DIR__ . '/AdEngine3DeciderService.class.php';
$wgAutoloadClasses['AdEngine3InstantGlobals'] =  __DIR__ . '/AdEngine3InstantGlobals.class.php';
$wgAutoloadClasses['AdEngine3PageTypeService'] = __DIR__ . '/AdEngine3PageTypeService.class.php';
$wgAutoloadClasses['AdEngine3Service'] =  __DIR__ . '/AdEngine3Service.class.php';
$wgAutoloadClasses['AdEngine3WikiData'] =  __DIR__ . '/AdEngine3WikiData.class.php';
$wgAutoloadClasses['AdTargeting'] =  __DIR__ . '/AdTargeting.class.php';

// Hooks
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine3::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopModules'][] = 'AdEngine3::onWikiaSkinTopModules';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine3::onWikiaSkinTopScripts';
$wgHooks['AfterInitialize'][] = 'AdEngine3::onAfterInitialize';

// Instant Globals
$wgHooks['InstantGlobalsGetNewsAndStoriesVariables'][] = 'AdEngine3InstantGlobals::onInstantGlobalsGetNewsAndStoriesVariables';
$wgHooks['InstantGlobalsGetFandomCreatorVariables'][] = 'AdEngine3InstantGlobals::onInstantGlobalsGetFandomCreatorVariables';
$wgHooks['InstantGlobalsGetVariables'][] = 'AdEngine3InstantGlobals::onInstantGlobalsGetVariables';

// I18n
$wgExtensionMessagesFiles['AdEngine3'] = __DIR__ . '/AdEngine3.i18n.php';
$wgExtensionFunctions[] = function() {
	JSMessages::registerPackage( 'AdEngine3', [
		'adengine-*'
	] );
};
JSMessages::enqueuePackage('AdEngine3', JSMessages::EXTERNAL);
