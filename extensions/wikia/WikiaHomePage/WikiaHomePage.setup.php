<?php
/**
 * WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
	'name'			=> 'WikiaHomePage',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Hyun Lim, Marcin Maciejewski, Saipetch Kongkatong, Sebastian Marzjan',
	'description'	=> 'WikiaHomePage',
	'version'		=> 1.0
);

// helper hierarchy
//classes
$app->registerClass('WikiaHomePageController', $dir.'WikiaHomePageController.class.php');

//i18n mapping
$app->registerExtensionMessageFile('WikiaHomePage', $dir.'WikiaHomePage.i18n.php');
F::build('JSMessages')->registerPackage('WikiaHomePage', array('wikia-home-page-*'));

// hooks
$app->registerHook('GetHTMLAfterBody', 'WikiaHomePageController', 'onGetHTMLAfterBody');
$app->registerHook('OutputPageBeforeHTML', 'WikiaHomePageController', 'onOutputPageBeforeHTML');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHomePageController', 'onWikiaMobileAssetsPackages');
$app->registerHook('ArticleCommentCheck', 'WikiaHomePageController', 'onArticleCommentCheck');
$app->registerHook('AfterGlobalHeader', 'WikiaHomePageController', 'onAfterGlobalHeader');