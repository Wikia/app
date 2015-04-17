<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Ad Engine',
	'author' => 'Wikia',
	'descriptionmsg' => 'paidassetdrop-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PaidAssetDrop',
];

// Autoload
$wgAutoloadClasses['PaidAssetDropHooks'] =  __DIR__ . '/PaidAssetDropHooks.class.php';

// Hooks for AdEngine2
$wgHooks['OasisSkinAssetGroups'][] = 'PaidAssetDropHooks::onOasisSkinAssetGroups';

// i18n
$wgExtensionMessagesFiles['PaidAssetDrop'] = __DIR__ . '/PaidAssetDrop.i18n.php';
