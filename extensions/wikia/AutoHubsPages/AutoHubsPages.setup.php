<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AutoHubsPages',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'auto hubs page for wikia.com',
	'descriptionmsg' => 'myextension-desc',
	'version' => '1.0.0',
);

$wgHubsPages = array(   
	'handheld_games' => 'handheld',
	'pc_games' => 'pc',
	'xbox_360_games' => 'xbox360',
	'ps3_games' => 'ps3',
	'mobile_games' => 'mobile',
	'movie' => 'movie',
	'tv' => 'tv',
	'entertainment' => 'entertainment',
	'music' => 'music',                                          
	'animation' => 'anime',
	'anime' => 'anime',
	'music' => 'music',
	'sci-fi' => 'sci_fi',
	'horror' => 'horror',
	'gaming' => 'gaming',
	'lifestyle' => 'lifestyle', 
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['AutoHubsPagesHelper']  = $dir . 'AutoHubsPagesHelper.class.php';
$wgAutoloadClasses['AutoHubsPagesData']  = $dir . 'AutoHubsPagesData.class.php';
$wgAutoloadClasses['AutoHubsPagesArticle']  = $dir . 'AutoHubsPagesArticle.class.php';

$wgExtensionMessagesFiles['AutoHubsPages'] = $dir . 'AutoHubsPages.i18n.php';

$wgHooks[ "ArticleFromTitle" ][] = "AutoHubsPagesArticle::ArticleFromTitle";
$wgHooks['CorporateBeforeRedirect'][] = 'AutoHubsPagesHelper::beforeRedirect';
$wgHooks['CorporateBeforeMsgCacheClear'][] = 'AutoHubsPagesHelper::beforeMsgCacheClear';
$wgAjaxExportList[] = 'AutoHubsPagesHelper::setHubsFeedsVariable';
$wgAjaxExportList[] = 'AutoHubsPagesHelper::hideFeed';
