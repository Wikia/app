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
define('FT_PHOTO_ADD_10', 20);
define('FT_MAINPAGE_EDIT', 30);
define('FT_MAINPAGE_ADDPHOTO', 40);
define('FT_CATEGORY_ADD3', 50);
define('FT_THEMEDESIGNER_VISIT', 60);
define('FT_LAYOUT_ADD_1', 70);
define('FT_WIKIALABS_VISIT', 80);
define('FT_TOTAL_EDIT_75', 90);
define('FT_PAGE_ADD_20', 100);
define('FT_PHOTO_ADD_20', 110);
define('FT_MAINPAGE_ADDSLIDER', 120);
define('FT_WORDMARK_EDIT', 130);
define('FT_CATEGORY_ADD_5', 140);
define('FT_COMMCORNER_EDIT', 150);
define('FT_TOTAL_EDIT_200', 160);
define('FT_LAYOUT_ADD_2', 170);
define('FT_FEATURETOGGLE_VISIT', 180);
define('FT_TOPNAV_VISIT', 190);
define('FT_USERADD_10', 200);
define('FT_PROFILE_EDIT_5', 210);
define('FT_ADMINPROFILE_EDIT', 220);
define('FT_FB_CONNECT', 230);
define('FT_COMMCORNER_MESSAGE', 240);
define('FT_TOTAL_EDIT_300', 250);
define('FT_FB_LIKES_5', 260);
define('FT_COMMCENTRAL_VISIT', 270);
define('FT_USERLIST_VISIT', 280);
