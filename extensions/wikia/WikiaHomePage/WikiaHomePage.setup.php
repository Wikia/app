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

// i18n mapping
$wgExtensionMessagesFiles['WikiaHomePage'] = $dir . 'WikiaHomePage.i18n.php';

$app->registerHook('GetHTMLAfterBody', 'WikiaHomePageController', 'onGetHTMLAfterBody');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHomePageController', 'onWikiaMobileAssetsPackages');
