<?php
/*
 * Featured Feed extension by Max Semenik.
 * License: WTFPL 2.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point' );
}


$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FeaturedFeeds',
	'author' => array( 'Max Semenik' ),
	'url' => '//mediawiki.org/wiki/Extension:FeaturedFeeds',
	'descriptionmsg' => 'ffeed-desc',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ApiFeaturedFeeds'] = "$dir/ApiFeaturedFeeds.php";
$wgAutoloadClasses['FeaturedFeeds'] = "$dir/FeaturedFeeds.body.php";
$wgAutoloadClasses['FeaturedFeedChannel'] = "$dir/FeaturedFeeds.body.php";
$wgAutoloadClasses['FeaturedFeedItem'] = "$dir/FeaturedFeeds.body.php";
$wgAutoloadClasses['SpecialFeedItem'] = "$dir/SpecialFeedItem.php";

$wgExtensionMessagesFiles['FeaturedFeeds'] =  "$dir/FeaturedFeeds.i18n.php";
$wgExtensionMessagesFiles['FeaturedFeedsAliases'] =  "$dir/FeaturedFeeds.alias.php";

$wgSpecialPages['FeedItem'] = 'SpecialFeedItem';

$wgAPIModules['featuredfeed'] = 'ApiFeaturedFeeds';

$wgHooks['ArticleSaveComplete'][] = 'FeaturedFeeds::articleSaveComplete';
$wgHooks['BeforePageDisplay'][] = 'FeaturedFeeds::beforePageDisplay';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'FeaturedFeeds::skinTemplateOutputPageBeforeExec';

/**
 * Configuration settings
 */

$wgFeaturedFeedsDefaults = array(
	'limit' => 10,
	'inUserLanguage' => false,
);

$wgFeaturedFeeds = array();

/**
 * Whether links to feeds should appear in sidebar
 */
$wgDisplayFeedsInSidebar = true;
