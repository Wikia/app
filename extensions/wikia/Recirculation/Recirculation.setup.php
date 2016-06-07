<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Recirculation',
	'author' => array( 'Paul Oslund' ),
	'descriptionmsg' => 'recirculation-desc',
	'version' => '0.2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recirculation',
];

// Autoload
$wgAutoloadClasses['ParselyDataService'] =  __DIR__ . '/services/ParselyDataService.class.php';
$wgAutoloadClasses['DiscussionsDataService'] =  __DIR__ . '/services/DiscussionsDataService.class.php';
$wgAutoloadClasses['CakeRelatedContentService'] =  __DIR__ . '/services/CakeRelatedContentService.php';
$wgAutoloadClasses['CuratedContentService'] =  __DIR__ . '/services/CuratedContentService.class.php';

$wgAutoloadClasses['RecirculationController'] =  __DIR__ . '/RecirculationController.class.php';
$wgAutoloadClasses['RecirculationApiController'] =  __DIR__ . '/RecirculationApiController.class.php';
$wgAutoloadClasses['RecirculationHooks'] =  __DIR__ . '/RecirculationHooks.class.php';

$wgAutoloadClasses['RecirculationContent'] =  __DIR__ . '/RecirculationContent.php';

// Hooks
$wgHooks['GetRailModuleList'][] = 'RecirculationHooks::onGetRailModuleList';
$wgHooks['OasisSkinAssetGroups'][] = 'RecirculationHooks::onOasisSkinAssetGroups';
$wgHooks['BeforePageDisplay'][] = 'RecirculationHooks::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['Recirculation'] = __DIR__ . '/Recirculation.i18n.php';

JSMessages::registerPackage('Recirculation', [
	'recirculation-*',
]);
