<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Watchlist improvements',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'follow-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
/*Auto loader setup */
$wgAutoloadClasses['FollowHelper']  = $dir . 'FollowHelper.class.php';
$wgAutoloadClasses['FollowedPages']  = $dir . 'FollowedPagesSpecial.php';
$wgAutoloadClasses['FollowModel'] = $dir . 'FollowModel.class.php';
$wgExtensionMessagesFiles['Follow'] = $dir . 'Follow.i18n.php';
$wgExtensionAliasesFiles['Follow'] = $dir . 'Follow.alias.php';

/* Hooks setup */
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
	$wgHooks['MailNotifyBuildKeys'][] = 'FollowHelper::mailNotifyBuildKeys';
}

$wgHooks['beforeBlogListingForm'][] = 'FollowHelper::categoryIndexer';

$wgHooks['UserToggles'][] = 'FollowHelper::addExtraToggles';
$wgHooks['beforeRenderPrefsWatchlist'][] = 'FollowHelper::renderFollowPrefs';

$wgHooks['UserRename::Local'][] = "FollowUserRenameLocal";

function FollowUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'blog_listing_relation',
		'userid_column' => null,
		'username_column' => 'blr_relation',
		'conds' => array(
			'blr_type' => 'user',
		)
	);
	return true;
}