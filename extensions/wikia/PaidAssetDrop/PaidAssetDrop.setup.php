<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Paid Asset Drop (PAD)',
	'author' => 'Ad Engineering @Wikia',
	'descriptionmsg' => 'paidassetdrop-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PaidAssetDrop',
];

// Autoload
$wgAutoloadClasses['PaidAssetDropHooks'] =  __DIR__ . '/PaidAssetDropHooks.class.php';

// Hooks for PAD
$wgHooks['AfterInitialize'][] = 'PaidAssetDropHooks::onAfterInitialize';
$wgHooks['OasisSkinAssetGroups'][] = 'PaidAssetDropHooks::onOasisSkinAssetGroups';
$wgHooks['WikiaSkinTopScripts'][] = 'PaidAssetDropHooks::onWikiaSkinTopScripts';
$wgHooks['InstantGlobalsGetVariables'][] = 'PaidAssetDropHooks::onInstantGlobalsGetVariables';

// i18n
$wgExtensionMessagesFiles['PaidAssetDrop'] = __DIR__ . '/PaidAssetDrop.i18n.php';
