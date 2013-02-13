<?php
/**
 * WikiaHubs services and classes used in Special:MarketingToolbox, Special:WikiaHubs and WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Damian Jóźwiak
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass('MarketingToolboxModel', $dir . 'models/MarketingToolboxModel.class.php');
$app->registerClass('MarketingToolboxTop10listModel', $dir . 'models/MarketingToolboxTop10listModel.class.php');
$app->registerClass('MarketingToolboxExploreModel', $dir . 'models/MarketingToolboxExploreModel.class.php');
$app->registerClass('MarketingToolboxPollsModel', $dir . 'models/MarketingToolboxPollsModel.class.php');
$app->registerClass('MarketingToolboxSliderModel', $dir . 'models/MarketingToolboxSliderModel.class.php');
$app->registerClass('MarketingToolboxFromthecommunityModel', $dir . 'models/MarketingToolboxFromthecommunityModel.class.php');
$app->registerClass('MarketingToolboxImageModel', $dir . 'models/MarketingToolboxImageModel.class.php');

$app->registerClass('MarketingToolboxModuleService', $dir . 'modules/MarketingToolboxModuleService.class.php');
$app->registerClass('MarketingToolboxModuleSliderService', $dir . 'modules/MarketingToolboxModuleSliderService.class.php');
$app->registerClass('MarketingToolboxModulePulseService', $dir . 'modules/MarketingToolboxModulePulseService.class.php');
$app->registerClass('MarketingToolboxModuleWikiaspicksService', $dir . 'modules/MarketingToolboxModuleWikiaspicksService.class.php');
$app->registerClass('MarketingToolboxModuleTop10listService', $dir . 'modules/MarketingToolboxModuleTop10listService.class.php');
$app->registerClass('MarketingToolboxModulePopularvideosService', $dir . 'modules/MarketingToolboxModulePopularvideosService.class.php');
$app->registerClass('MarketingToolboxModuleExploreService', $dir . 'modules/MarketingToolboxModuleExploreService.class.php');
$app->registerClass('MarketingToolboxModuleFeaturedvideoService', $dir . 'modules/MarketingToolboxModuleFeaturedvideoService.class.php');
$app->registerClass('MarketingToolboxModuleFromthecommunityService', $dir . 'modules/MarketingToolboxModuleFromthecommunityService.class.php');
$app->registerClass('MarketingToolboxModulePollsService', $dir . 'modules/MarketingToolboxModulePollsService.class.php');

include_once($dir . '../RelatedVideos/RelatedVideos.setup.php'); //TODO: remove after discussing it with Video Team