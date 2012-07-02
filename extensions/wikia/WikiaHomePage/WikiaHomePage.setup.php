<?php
/**
 * WikiaHomePage
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
		'name'			=> 'WikiaHomePage',
		'author'		=> 'Andrzej "nAndy" Łukaszewski, Hyun Lim, Marcin Maciejewski, Saipetch Kongkatong, Sebastian Marzjan',
		'description'	=> 'WikiaHomePage',
		'version'		=> 1.0
);

//classes
$app->registerClass('WikiaHomePageController', $dir.'WikiaHomePageController.class.php');
$app->registerClass('WikiaHomePageSpecialController', $dir.'WikiaHomePageSpecialController.class.php');
$app->registerClass('WikiaHomePageHelper', $dir.'WikiaHomePageHelper.class.php');
$app->registerClass('CityVisualization', $dir.'CityVisualization.class.php');

//special page
$app->registerSpecialPage('WikiaHomePage', 'WikiaHomePageSpecialController');

//i18n mapping
$app->registerExtensionMessageFile('WikiaHomePage', $dir.'WikiaHomePage.i18n.php');
F::build('JSMessages')->registerPackage('WikiaHomePage', array('wikia-home-page-*'));

$app->registerHook('GetHTMLAfterBody', 'WikiaHomePageController', 'onGetHTMLAfterBody');
$app->registerHook('OutputPageBeforeHTML', 'WikiaHomePageController', 'onOutputPageBeforeHTML');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHomePageController', 'onWikiaMobileAssetsPackages');
$app->registerHook('ArticleCommentCheck', 'WikiaHomePageController', 'onArticleCommentCheck');
$app->registerHook('AfterGlobalHeader', 'WikiaHomePageController', 'onAfterGlobalHeader');

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['wikiahomepagestafftool'] = false;
$wgGroupPermissions['staff']['wikiahomepagestafftool'] = true;
$wgGroupPermissions['vstf']['wikiahomepagestafftool'] = false;
$wgGroupPermissions['helper']['wikiahomepagestafftool'] = false;
$wgGroupPermissions['sysop']['wikiahomepagestafftool'] = false;
