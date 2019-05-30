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
$wgAutoloadClasses['AdEngine3ApiController'] = __DIR__ . '/AdEngine3ApiController.class.php';
$wgAutoloadClasses['AdEngine3Controller'] =  __DIR__ . '/AdEngine3Controller.class.php';
$wgAutoloadClasses['AdEngine3InstantGlobals'] =  __DIR__ . '/AdEngine3InstantGlobals.class.php';
$wgAutoloadClasses['AdEngine3PageTypeService'] = __DIR__ . '/AdEngine3PageTypeService.class.php';
$wgAutoloadClasses['AdEngine3Service'] =  __DIR__ . '/AdEngine3Service.class.php';
$wgAutoloadClasses['AdEngine3WikiData'] =  __DIR__ . '/AdEngine3WikiData.class.php';
$wgAutoloadClasses['AdTargeting'] =  __DIR__ . '/AdTargeting.class.php';

// ResourceLoader
$wgAutoloadClasses['ResourceLoaderAdEngine3Base'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3Base.php';
$wgAutoloadClasses['ResourceLoaderAdEngine3BTCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3BTCode.php';
$wgAutoloadClasses['ResourceLoaderAdEngine3HMDCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3HMDCode.php';
$wgAutoloadClasses['ResourceLoaderScript'] = __DIR__ . '/ResourceLoaders/ResourceLoaderScript.php';

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
