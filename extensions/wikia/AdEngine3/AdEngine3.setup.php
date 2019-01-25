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
$wgAutoloadClasses['AdEngine3ApiController'] = __DIR__ . '/AdEngine2ApiController.class.php';
$wgAutoloadClasses['AdEngine3Resource'] = __DIR__ . '/ResourceLoaders/AdEngine3Resource.class.php';
$wgAutoloadClasses['AdEngine3WikiData'] =  __DIR__ . '/AdEngine3WikiData.class.php';

// ResourceLoader
$wgAutoloadClasses['ResourceLoaderAdEngineBase'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineBase.php';
$wgAutoloadClasses['ResourceLoaderAdEngineBTCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineBTCode.php';
$wgAutoloadClasses['ResourceLoaderAdEngineHMDCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineHMDCode.php';
$wgAutoloadClasses['ResourceLoaderScript'] = __DIR__ . '/ResourceLoaders/ResourceLoaderScript.php';

// Hooks
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine3::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine3::onWikiaSkinTopScripts';
