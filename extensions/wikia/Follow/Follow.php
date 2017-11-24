<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Watchlist improvements',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'follow-desc',
	'version' => '1.0.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Follow'
);

$dir = dirname(__FILE__) . '/';
/*Auto loader setup */
$wgAutoloadClasses['FollowHelper']  = $dir . 'FollowHelper.class.php';
$wgAutoloadClasses['FollowedPages']  = $dir . 'FollowedPagesSpecial.php';
$wgAutoloadClasses['FollowModel'] = $dir . 'FollowModel.class.php';
$wgAutoloadClasses['FollowEmailTask'] = $dir . 'FollowEmailTask.class.php';
$wgExtensionMessagesFiles['Follow'] = $dir . 'Follow.i18n.php';
$wgExtensionMessagesFiles['FollowAliases'] = $dir . 'Follow.alias.php';

/* Hooks setup */
if ( !empty($wgEnableWikiaFollowedPages) && $wgEnableWikiaFollowedPages ) {
	$wgHooks['AfterCategoriesUpdate'][] = 'FollowHelper::watchCategories';
	$wgHooks['BlogListingSave'][] = 'FollowHelper::blogListingBuildRelation';
	$wgHooks['ArticleSaveComplete'][] = "FollowHelper::watchBlogListing";
	$wgHooks['PersonalUrls'][] = 'FollowHelper::addPersonalUrl';
	$wgHooks['MakeGlobalVariablesScript'][] = 'FollowHelper::jsVars';
	$wgHooks['AddToUserProfile'][] = 'FollowHelper::renderUserProfile';
	$wgSpecialPages['Following'] = 'FollowedPages'; # Let MediaWiki know about your new special page.
	$wgSpecialPageGroups['Following'] = 'changes';
	$wgAjaxExportList[] = 'FollowHelper::showAll';
	$wgHooks['MailNotifyBuildKeys'][] = 'FollowHelper::mailNotifyBuildKeys';
}

$wgHooks['beforeBlogListingForm'][] = 'FollowHelper::categoryIndexer';

$wgHooks['WatchlistPreferencesBefore'][] = 'FollowHelper::renderFollowPrefs';
