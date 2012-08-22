<?php
/**
 * WikiaHubs V2
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaHubs V2',
	'author' => 'Andrzej "nAndy" Łukaszewski,Marcin Maciejewski,Sebastian Marzjan',
	'description' => 'WikiaHubs V2',
	'version' => 1.0
);

// constroller classes
$app->registerClass('SpecialWikiaHubsV2Controller', $dir . 'SpecialWikiaHubsV2Controller.class.php');
$app->registerClass('WikiaHubsV2SuggestController', $dir . 'WikiaHubsV2SuggestController.class.php');

// hook classes

$app->registerClass('WikiaHubsV2Mobile', $dir . 'hooks/WikiaHubsV2MobileHooks.php');
$app->registerClass('WikiaHubsV2Hooks', $dir . 'hooks/WikiaHubsV2Hooks.php');

// model classes
$app->registerClass('WikiaHubsV2Article', $dir . 'models/WikiaHubsV2Article.class.php');
$app->registerClass('WikiaHubsV2Model', $dir . 'models/WikiaHubsV2Model.class.php');

$app->registerClass('WikiaHubsV2Module', $dir . 'models/modules/WikiaHubsV2Module.class.php');
$app->registerClass('WikiaHubsV2PulseModule', $dir . 'models/modules/WikiaHubsV2PulseModule.class.php');
$app->registerClass('WikiaHubsV2SliderModule', $dir . 'models/modules/WikiaHubsV2SliderModule.class.php');

$app->registerClass('MysqlWikiaHubsV2ModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2ModuleDataProvider.class.php');
$app->registerClass('MysqlWikiaHubsV2PulseModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2PulseModuleDataProvider.class.php');
$app->registerClass('MysqlWikiaHubsV2SliderModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2SliderModuleDataProvider.class.php');

$app->registerClass('StaticWikiaHubsV2ModuleDataProvider', $dir . 'models/dataproviders/static/StaticWikiaHubsV2ModuleDataProvider.class.php');
$app->registerClass('StaticWikiaHubsV2PulseModuleDataProvider', $dir . 'models/dataproviders/static/StaticWikiaHubsV2PulseModuleDataProvider.class.php');
$app->registerClass('StaticWikiaHubsV2SliderModuleDataProvider', $dir . 'models/dataproviders/static/StaticWikiaHubsV2SliderModuleDataProvider.class.php');

$app->registerClass('WikiaHubsV2ModuleDataProvider', $dir . 'models/dataproviders/WikiaHubsV2ModuleDataProvider.class.php');
$app->registerClass('MysqlWikiaHubsV2Connector', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2Connector.class.php');
$app->registerClass('MysqlWikiaHubsV2ModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2ModuleDataProvider.class.php');
$app->registerClass('MysqlWikiaHubsV2PulseModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2PulseModuleDataProvider.class.php');
$app->registerClass('MysqlWikiaHubsV2SliderModuleDataProvider', $dir . 'models/dataproviders/mysql/MysqlWikiaHubsV2SliderModuleDataProvider.class.php');

// pages
$app->registerSpecialPage('WikiaHubsV2', 'SpecialWikiaHubsV2Controller');

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubsV2'] = $dir . 'WikiaHubsV2.i18n.php';

// hooks
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHubsV2Mobile', 'onWikiaMobileAssetsPackages');
$app->registerHook('ArticleFromTitle', 'WikiaHubsV2Hooks', 'onArticleFromTitle');
