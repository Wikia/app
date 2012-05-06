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
$wgHooks[ 'ArticleSaveComplete' ][] = 'FounderProgressBarHooks::onArticleSaveComplete';
$wgHooks[ 'UploadComplete' ][] = 'FounderProgressBarHooks::onUploadComplete';
$wgHooks[ 'UploadWordmarkComplete' ][] = 'FounderProgressBarHooks::onUploadWordmarkComplete';
$wgHooks[ 'AddNewAccount' ][] = 'FounderProgressBarHooks::onAddNewAccount';

// On wiki creation or WikiFactory enable add db columns
$wgHooks['CreateWikiLocalJob-complete'][] = "FounderProgressBarHooks::onWikiCreation";

// Define founder event constants
// FIXME: Right now you must edit FounderProgressBarHooks::initRecords() and WikiFactoryHooks::FounderProgressBar if you add new tasks
define('FT_PAGE_ADD_10', 10);
define('FT_THEMEDESIGNER_VISIT', 20);
define('FT_MAINPAGE_EDIT', 30);
define('FT_PHOTO_ADD_10', 40);
define('FT_CATEGORY_ADD_3', 50);
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
// Bonus tasks start at ID 500 just to keep them separate if we add more "base" tasks
define('FT_BONUS_PHOTO_ADD_10', 510);
define('FT_BONUS_PAGE_ADD_5', 520);
define('FT_BONUS_EDIT_50', 540);
define('FT_COMPLETION', 1000);    // special internal flag for "all tasks complete"
