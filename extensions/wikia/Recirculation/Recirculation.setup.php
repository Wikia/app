<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Recirculation',
	'author' => array( 'Paul Oslund' ),
	'descriptionmsg' => 'recirculation-desc',
	'version' => '0.2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recirculation',
];

// Autoload
$wgAutoloadClasses['DiscussionsDataService'] =  __DIR__ . '/services/DiscussionsDataService.class.php';
$wgAutoloadClasses['PopularPagesService'] = __DIR__. '/services/PopularPagesService.php';
$wgAutoloadClasses['FandomArticleService'] = __DIR__. '/services/FandomArticleService.php';
$wgAutoloadClasses['CachedFandomArticleService'] = __DIR__. '/services/CachedFandomArticleService.php';
$wgAutoloadClasses['ParselyService'] = __DIR__. '/services/ParselyService.php';

$wgAutoloadClasses['RecirculationController'] =  __DIR__ . '/RecirculationController.class.php';
$wgAutoloadClasses['RecirculationApiController'] =  __DIR__ . '/RecirculationApiController.class.php';
$wgAutoloadClasses['RecirculationHooks'] =  __DIR__ . '/RecirculationHooks.class.php';
$wgAutoloadClasses['RailContentService'] = __DIR__ . '/RailContentService.php';

$wgAutoloadClasses['RecirculationContent'] =  __DIR__ . '/RecirculationContent.php';
$wgAutoloadClasses['WikiRecommendations'] =  __DIR__ . '/WikiRecommendations.class.php';

// Hooks
$wgHooks['OasisSkinAssetGroups'][] = 'RecirculationHooks::onOasisSkinAssetGroups';
$wgHooks['BeforePageDisplay'][] = 'RecirculationHooks::onBeforePageDisplay';
$wgHooks['GetRailModuleList'][] = '\RecirculationHooks::onGetRailModuleList';

// i18n
$wgExtensionMessagesFiles['Recirculation'] = __DIR__ . '/Recirculation.i18n.php';

JSMessages::registerPackage('Recirculation', [
	'recirculation-*',
]);
