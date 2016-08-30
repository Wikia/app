<?php
/**
 * FandomHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 * @author Damian Jóźwiak
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name'				=> 'FandomHomePage',
	'author'			=> array(
		'Andrzej "nAndy" Łukaszewski', 
		'Hyun Lim', 
		'Marcin Maciejewski', 
		'Saipetch Kongkatong', 
		'Sebastian Marzjan', 
		'Damian Jóźwiak'
	),
	'descriptionmsg'	=> 'wikiahome-desc',
	'version'			=> 1.0,
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FandomHomePage'
);

$wgAutoloadClasses['FandomHomePageController'] = $dir.'FandomHomePageController.class.php';
$wgAutoloadClasses['WikiaHubsApiController'] = $dir . '../WikiaHubsServices/api/WikiaHubsApiController.class.php';

//i18n mapping
$wgExtensionMessagesFiles['FandomHomePage'] = $dir.'FandomHomePage.i18n.php';
JSMessages::registerPackage('FandomHomePage', array('wikia-home-page-*'));

// services
$wgAutoloadClasses['RedirectService'] = 'includes/wikia/services/RedirectService.class.php';

// hooks
$wgHooks['GetHTMLAfterBody'][] = 'FandomHomePageController::onGetHTMLAfterBody';
$wgHooks['OutputPageBeforeHTML'][] = 'FandomHomePageController::onOutputPageBeforeHTML';
$wgHooks['WikiaMobileAssetsPackages'][] = 'FandomHomePageController::onWikiaMobileAssetsPackages';
$wgHooks['ArticleCommentCheck'][] = 'FandomHomePageController::onArticleCommentCheck';
$wgHooks['AfterGlobalHeader'][] = 'FandomHomePageController::onAfterGlobalHeader';
$wgHooks['BeforePageDisplay'][] = 'FandomHomePageController::onBeforePageDisplay';
$wgHooks['AfterOasisSettingsInitialized'][] = 'FandomHomePageController::onAfterOasisSettingsInitialized';
$wgHooks['ArticleFromTitle'][] = 'FandomHomePageController::onArticleFromTitle';
