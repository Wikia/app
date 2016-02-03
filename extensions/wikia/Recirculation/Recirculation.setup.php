<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Recirculation',
	'author' => array( 'Paul Oslund' ),
	'descriptionmsg' => 'recirculation-desc',
	'version' => '0.2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recirculation',
];

// Autoload
$wgAutoloadClasses['FandomDataService'] =  __DIR__ . '/services/FandomDataService.class.php';
$wgAutoloadClasses['DiscussionsDataService'] =  __DIR__ . '/services/DiscussionsDataService.class.php';

$wgAutoloadClasses['RecirculationController'] =  __DIR__ . '/RecirculationController.class.php';
$wgAutoloadClasses['RecirculationHooks'] =  __DIR__ . '/RecirculationHooks.class.php';

// Hooks
$wgHooks['GetRailModuleList'][] = 'RecirculationHooks::onGetRailModuleList';
$wgHooks['OasisSkinAssetGroups'][] = 'RecirculationHooks::onOasisSkinAssetGroups';
$wgHooks['BeforePageDisplay'][] = 'RecirculationHooks::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['Recirculation'] = __DIR__ . '/Recirculation.i18n.php';
