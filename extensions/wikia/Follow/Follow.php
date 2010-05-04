<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Watchlist improvements',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'improvements of watchlist',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
/*Auto loader setup */
$wgAutoloadClasses['FollowHelper']  = $dir . 'FollowHelper.class.php';
$wgAutoloadClasses['FollowedPages']  = $dir . 'FollowedPagesSpecial.php';
$wgAutoloadClasses['FollowModel'] = $dir . 'FollowModel.class.php';
$wgExtensionMessagesFiles['Follow'] = $dir . 'Follow.i18n.php';
/*Hoks setup */
if ( !empty($wgEnableWikiaFollowedPages) && $wgEnableWikiaFollowedPages ) {
	$wgHooks['RecentChangeNotify'][] = 'FollowHelper::watchersList';
	$wgHooks['AfterCategoriesUpdate'][] = 'FollowHelper::watchCategories';
	$wgHooks['BlogListingSave'][] = 'FollowHelper::blogListingBuildRelation';
	$wgHooks['ArticleSaveComplete'][] = "FollowHelper::watchBlogListing";
	$wgHooks['CustomUserData'][] = 'FollowHelper::addToUserMenu';
	$wgHooks['MakeGlobalVariablesScript'][] = 'FollowHelper::jsVars';
	$wgHooks['AddToUserProfile'][] = 'FollowHelper::renderUserProfile';
	$wgSpecialPages['Following'] = 'FollowedPages'; # Let MediaWiki know about your new special page.
	$wgSpecialPageGroups['Following'] = 'changes';
	$wgAjaxExportList[] = 'FollowHelper::showAll';	
}

$wgHooks['UserToggles'][] = 'FollowHelper::addExtraToggles';
$wgHooks['beforeRenderPrefsWatchlist'][] = 'FollowHelper::renderFollowPrefs';


 


