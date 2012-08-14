<?php
/**
 * WikiaHubs
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
		'name'		=> 'WikiaHubs',
		'author'	=> 'Andrzej "nAndy" Łukaszewski,Hyun Lim,Marcin Maciejewski,Saipetch Kongkatong,Sebastian Marzjan',
		'description'	=> 'WikiaHubs',
		'version'	=> 1.0
);

//classes
$app->registerClass('WikiaHubsSuggestController', $dir.'WikiaHubsSuggestController.class.php');
$app->registerClass('WikiaHubsPopularVideos', $dir . 'WikiaHubsHook.class.php');
$app->registerClass('WikiaHubsMobile', $dir . 'WikiaHubsHook.class.php');
$app->registerClass('WikiaHubsHelper', $dir . 'WikiaHubsHelper.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubs'] = $dir . 'WikiaHubs.i18n.php';

// hooks
$app->registerHook('ParserFirstCallInit', 'WikiaHubsPopularVideos', 'onParserFirstCallInit');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHubsMobile', 'onWikiaMobileAssetsPackages');
$app->registerHook('WikiaAssetsPackages', 'WikiaHubsHelper', 'onWikiaAssetsPackages');
$app->registerHook('OutputPageMakeCategoryLinks','WikiaHubsHelper','onOutputPageMakeCategoryLinks');
$app->registerHook('OutputPageBeforeHTML','WikiaHubsHelper','onOutputPageBeforeHTML');
