<?php
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'FounderProgressBar',
	'author'         => 'Wikia',
	'descriptionmsg' => 'founderprogressbar-credits',
);

$dir = dirname(__FILE__).'/';
$app = F::app();

//Autoload
$app->registerClass('FounderProgressBarController', $dir . '/FounderProgressBarController.class.php');
$app->registerClass('FounderProgressBarHooks', $dir . '/FounderProgressBarHooks.class.php');

// I18N
$app->registerExtensionMessageFile('FounderProgressBar', $dir . '/FounderProgressBar.i18n.php');

// Hooks
$app->registerHook("ArticleSaveComplete", "FounderProgressBarHooks", "onArticleSaveComplete");
$app->registerHook("UploadComplete", "FounderProgressBarHooks", "onUploadComplete");
$app->registerHook("CreateWikiLocalJob-complete", "FounderProgressBarHooks", "onWikiCreation");

// Define founder event constants
define('FT_PAGE_ADD_10', 10);
define('FT_THEMEDESIGNER_VISIT', 20);
define('FT_MAINPAGE_EDIT', 30);
define('FT_PHOTO_ADD_10', 40);
define('FT_CATEGORY_ADD3', 50);
define('FT_COMMCENTRAL_VISIT', 60);
define('FT_WIKIACTIVITY_VISIT', 70);
define('FT_PROFILE_EDIT', 80);
define('FT_PHOTO_ADD_20', 90);
define('FT_TOTAL_EDIT_75', 100);
define('FT_PAGE_ADD_20', 110);
define('FT_CATEGORY_EDIT', 120);
define('FT_WIKIALABS_VISIT', 130);
define('FT_FB_CONNECT', 140);
define('FT_CATEGORY_ADD_5', 150);
define('FT_PAGELAYOUT_VISIT', 160);
define('FT_GALLERY_ADD', 170);
define('FT_TOPNAV_EDIT', 180);
define('FT_MAINPAGE_ADDSLIDER', 190);
define('FT_COMMCORNER_EDIT', 200);
define('FT_VIDEO_ADD', 210);
define('FT_USER_ADD_5', 220);
define('FT_RECENTCHANGES_VISIT', 230);
define('FT_WORDMARK_EDIT', 240);
define('FT_MOSTVISITED_VISIT', 250);
define('FT_TOPTENLIST_ADD', 260);
define('FT_BLOGPOST_ADD', 270);
define('FT_FB_LIKES_3', 280);
define('FT_UNCATEGORIZED_VISIT', 290);
define('FT_TOTAL_EDIT_300', 300);