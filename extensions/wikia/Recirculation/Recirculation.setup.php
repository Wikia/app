<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Recirculation',
	'author' => array( 'Paul Oslund' ),
	'descriptionmsg' => 'recirculation-desc',
	'version' => '0.2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recirculation',
];

$dir = __DIR__;

// Autoload
$wgAutoloadClasses['FandomDataService'] =  $dir . '/services/FandomDataService.class.php';
$wgAutoloadClasses['DiscussionsDataService'] =  $dir . '/services/DiscussionsDataService.class.php';

$wgAutoloadClasses['RecirculationController'] =  $dir . '/RecirculationController.class.php';
$wgAutoloadClasses['RecirculationHooks'] =  $dir . '/RecirculationHooks.class.php';

// Hooks
$wgHooks['GetRailModuleList'][] = 'RecirculationHooks::onGetRailModuleList';
$wgHooks['OasisSkinAssetGroups'][] = 'RecirculationHooks::onOasisSkinAssetGroups';
$wgHooks['BeforePageDisplay'][] = 'RecirculationHooks::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['Recirculation'] = $dir . '/Recirculation.i18n.php';
