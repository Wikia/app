<?php

/**
 * Marketing Toolbox
 *
 * @author Damian Jóźwiak
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Marketing Toolbox',
	'description' => 'Internal tool to configure marketing features',
	'authors' => array(
		'Damian Jóźwiak',
		'Andrzej "nAndy" Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan',
	),
	'version' => 1.0
);

//classes
$app->registerController('MarketingToolboxController', $dir.'MarketingToolboxController.class.php');

$app->registerClass('MarketingToolboxModel', $dir.'models/MarketingToolboxModel.class.php');
$app->registerClass('MarketingToolboxUserPropertiesHandler', $dir.'models/MarketingToolboxUserPropertiesHandler.class.php');
$app->registerClass('MarketingToolboxTop10listModel', $dir.'models/MarketingToolboxTop10listModel.class.php');

$app->registerClass('MarketingToolboxModuleService', $dir.'modules/MarketingToolboxModuleService.class.php');
$app->registerClass('MarketingToolboxModuleSliderService', $dir.'modules/MarketingToolboxModuleSliderService.class.php');
$app->registerClass('MarketingToolboxModulePulseService', $dir.'modules/MarketingToolboxModulePulseService.class.php');
$app->registerClass('MarketingToolboxModuleWikiaspicksService', $dir.'modules/MarketingToolboxModuleWikiaspicksService.class.php');
$app->registerClass('MarketingToolboxModuleTop10listService', $dir.'modules/MarketingToolboxModuleTop10listService.class.php');
$app->registerClass('MarketingToolboxModulePopularvideosService', $dir.'modules/MarketingToolboxModulePopularvideosService.class.php');
$app->registerClass('MarketingToolboxModuleExploreService', $dir.'modules/MarketingToolboxModuleExploreService.class.php');
$app->registerClass('MarketingToolboxModuleFeaturedvideoService', $dir.'modules/MarketingToolboxModuleFeaturedvideoService.class.php');
$app->registerClass('MarketingToolboxModuleFromthecommunityService', $dir.'modules/MarketingToolboxModuleFromthecommunityService.class.php');
$app->registerClass('MarketingToolboxModulePollsService', $dir.'modules/MarketingToolboxModulePollsService.class.php');

WikiaUserPropertiesController::registerHandler('MarketingToolboxUserPropertiesHandler');

// hooks
$app->registerClass('MarketingToolboxHooks', $dir.'hooks/MarketingToolboxHooks.class.php');
$app->registerHook('MakeGlobalVariablesScript', 'MarketingToolboxHooks', 'onMakeGlobalVariablesScript');

//special page
$app->registerSpecialPage('MarketingToolbox', 'MarketingToolboxController', 'wikia');

//message files
$app->registerExtensionMessageFile('MarketingToolbox', $dir.'MarketingToolbox.i18n.php');
F::build('JSMessages')->registerPackage('MarketingToolbox', array('marketing-toolbox-*'));

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['marketingtoolbox'] = false;
$wgGroupPermissions['staff']['marketingtoolbox'] = true;
$wgGroupPermissions['vstf']['marketingtoolbox'] = false;
$wgGroupPermissions['helper']['marketingtoolbox'] = false;
$wgGroupPermissions['sysop']['marketingtoolbox'] = false;
