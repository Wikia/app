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
	'name'		=> 'WikiaHubs V2',
	'author'	=> 'Andrzej "nAndy" Łukaszewski,Marcin Maciejewski,Sebastian Marzjan',
	'description'	=> 'WikiaHubs V2',
	'version'	=> 1.0
);

//classes
$app->registerClass('SpecialWikiaHubsV2Controller', $dir . 'SpecialWikiaHubsV2Controller.class.php');
$app->registerSpecialPage('WikiaHubsV2', 'SpecialWikiaHubsV2Controller');

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubsV2'] = $dir . 'WikiaHubsV2.i18n.php';

// hooks
$app->registerHook('ParserFirstCallInit', 'WikiaHubsPopularVideos', 'onParserFirstCallInit');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHubsMobile', 'onWikiaMobileAssetsPackages');
$app->registerHook('OutputPageMakeCategoryLinks','WikiaHubsHelper','onOutputPageMakeCategoryLinks');
$app->registerHook('OutputPageBeforeHTML','WikiaHubsHelper','onOutputPageBeforeHTML');
