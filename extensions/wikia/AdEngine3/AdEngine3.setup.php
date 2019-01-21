<?php

$wgExtensionCredits['other'][] = [
	'name' => 'AdEngine',
	'author' => 'Wikia',
	'description' => 'AdEngine',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AdEngine3',
];

$wgAutoloadClasses['AdEngine3'] =  __DIR__ . '/AdEngine3.class.php';
$wgAutoloadClasses['AdEngine3WikiData'] =  __DIR__ . '/AdEngine3WikiData.class.php';

$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AdEngine3::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaSkinTopScripts'][] = 'AdEngine3::onWikiaSkinTopScripts';
