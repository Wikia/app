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
$wgAutoloadClasses['AdEngine3WikiData'] =  __DIR__ . '/AdEngine3WikiData.class.php';

// ResourceLoader
$wgAutoloadClasses['ResourceLoaderAdEngine3Base'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3Base.php';
$wgAutoloadClasses['ResourceLoaderAdEngine3BTCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3BTCode.php';
$wgAutoloadClasses['ResourceLoaderAdEngine3HMDCode'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngine3HMDCode.php';
$wgAutoloadClasses['ResourceLoaderScript'] = __DIR__ . '/ResourceLoaders/ResourceLoaderScript.php';

// Hooks
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine3::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine3::onWikiaSkinTopScripts';

// Mirrors logic
if ( !empty( $_SERVER['HTTP_FASTLY_FF'] ) && !empty($_SERVER[ 'X-Staging' ]) ) {
	if ( $_SERVER[ 'X-Staging' ] == 'externaltest' ) {
	// externaltest is a mirror to our production communities where AdOperations test ads campaigns
		include "$IP/../config/externaltest.php";
	}

	if ( $_SERVER[ 'X-Staging' ] == 'showcase' ) {
	// showcase is a mirror to our production communities where AdOperations target demo ads campaigns and Sales demonstate it to our clients
		include "$IP/../config/showcase.php";
	}
}
