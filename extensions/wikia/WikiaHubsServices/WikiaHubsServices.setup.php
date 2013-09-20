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

$wgAutoloadClasses['MarketingToolboxModel'] =  $dir . 'models/MarketingToolboxModel.class.php';
$wgAutoloadClasses['MarketingToolboxExploreModel'] =  $dir . 'models/MarketingToolboxExploreModel.class.php';
$wgAutoloadClasses['MarketingToolboxFeaturedvideoModel'] =  $dir . 'models/MarketingToolboxFeaturedvideoModel.class.php';
$wgAutoloadClasses['MarketingToolboxPollsModel'] =  $dir . 'models/MarketingToolboxPollsModel.class.php';
$wgAutoloadClasses['MarketingToolboxPopularvideosModel'] =  $dir . 'models/MarketingToolboxPopularvideosModel.class.php';
$wgAutoloadClasses['MarketingToolboxSliderModel'] =  $dir . 'models/MarketingToolboxSliderModel.class.php';
$wgAutoloadClasses['MarketingToolboxFromthecommunityModel'] =  $dir . 'models/MarketingToolboxFromthecommunityModel.class.php';
$wgAutoloadClasses['MarketingToolboxImageModel'] =  $dir . 'models/MarketingToolboxImageModel.class.php';
$wgAutoloadClasses['MarketingToolboxWAMModel'] =  $dir . 'models/MarketingToolboxWAMModel.class.php';

$wgAutoloadClasses['MarketingToolboxModuleService'] =  $dir . 'modules/MarketingToolboxModuleService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleEditableService'] =  $dir . 'modules/MarketingToolboxModuleEditableService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleNonEditableService'] =  $dir . 'modules/MarketingToolboxModuleNonEditableService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleSliderService'] =  $dir . 'modules/MarketingToolboxModuleSliderService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleWikiaspicksService'] =  $dir . 'modules/MarketingToolboxModuleWikiaspicksService.class.php';
$wgAutoloadClasses['MarketingToolboxModulePopularvideosService'] =  $dir . 'modules/MarketingToolboxModulePopularvideosService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleExploreService'] =  $dir . 'modules/MarketingToolboxModuleExploreService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleFeaturedvideoService'] =  $dir . 'modules/MarketingToolboxModuleFeaturedvideoService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleFromthecommunityService'] =  $dir . 'modules/MarketingToolboxModuleFromthecommunityService.class.php';
$wgAutoloadClasses['MarketingToolboxModulePollsService'] =  $dir . 'modules/MarketingToolboxModulePollsService.class.php';
$wgAutoloadClasses['MarketingToolboxModuleWAMService'] =  $dir . 'modules/MarketingToolboxModuleWAMService.class.php';

$wgAutoloadClasses['WikiaHubsServicesHelper'] =  $dir . 'WikiaHubsServicesHelper.class.php';
