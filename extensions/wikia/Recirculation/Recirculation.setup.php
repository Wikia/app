<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Recirculation',
	'author' => array('Paul Oslund'),
	'descriptionmsg' => 'recirculation-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recirculation',
];

// Autoload
$wgAutoloadClasses['RecirculationHooks'] =  __DIR__ . '/RecirculationHooks.class.php';
$wgHooks['GetRailModuleList'][] = 'RecirculationHooks::onGetRailModuleList';
$wgHooks['OasisSkinAssetGroups'][] = 'RecirculationHooks::onOasisSkinAssetGroups';

// i18n
$wgExtensionMessagesFiles['Recirculation'] = __DIR__ . '/Recirculation.i18n.php';
