<?php
/**
 * Wall
 *
 * User Message Wall for MediaWiki
 *
 * @author Sean Colombo <sean@wikia-inc.com>, Christian Williams <christian@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'User Wall',
	'author' => array( 'Tomek Odrobny', 'Christian Williams', "Andrzej 'nAndy' Lukaszewski", 'Piotr Bablok' ),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wall-desc',
);

$dir = dirname(__FILE__);

include($dir . '/WallNamespaces.php');

$wgNamespacesWithSubpages[ NS_USER_WALL ] = true;

if(!empty($app->wg->EnableForumExt)) {
	$app->registerClass('Wall', $dir . '/Wall.class.php');
	$app->registerClass('WallThread', $dir . '/WallThread.class.php');
} else {
	$app->registerClass('Wall', $dir . '/backward_compatibility/Wall.class.php');
	$app->registerClass('WallThread', $dir . '/backward_compatibility/WallThread.class.php');	
}


$app->registerClass('WallMessage', $dir . '/WallMessage.class.php');
$app->registerClass('WallController', $dir . '/WallController.class.php');
$app->registerClass('WallExternalController', $dir . '/WallExternalController.class.php');
$app->registerClass('WallHistoryController', $dir . '/WallHistoryController.class.php');
$app->registerClass('WallHooksHelper', $dir . '/WallHooksHelper.class.php');
$app->registerClass('WallRailHelper', $dir . '/WallRailHelper.class.php');
$app->registerClass('WallRailController', $dir . '/WallRailController.class.php');
$app->registerClass('WallHelper', $dir . '/WallHelper.class.php');
$app->registerClass('WallHistory', $dir . '/WallHistory.class.php');
$app->registerClass('WallBaseController', $dir . '/WallBaseController.class.php');
$app->registerClass('VoteHelper', $dir . '/VoteHelper.class.php');
$app->registerClass('WallRelatedPages', $dir . '/WallRelatedPages.class.php');


// register task in task manager
if (function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask(dirname(__FILE__)."/WallCopyFollowsTask.class.php", "wallcopyfollows", "WallCopyFollowsTask");
}


include($dir . '/notification/WallNotifications.setup.php');


$app->registerExtensionMessageFile('Wall', $dir . '/Wall.i18n.php');

$app->registerHook('ArticleViewHeader', 'WallHooksHelper', 'onArticleViewHeader');
$app->registerHook('SkinTemplateTabs', 'WallHooksHelper', 'onSkinTemplateTabs');
$app->registerHook('AlternateEdit', 'WallHooksHelper', 'onAlternateEdit');
$app->registerHook('AfterEditPermissionErrors', 'WallHooksHelper', 'onAfterEditPermissionErrors');
$app->registerHook('BeforePageProtect', 'WallHooksHelper', 'onBeforePageProtect');
$app->registerHook('BeforePageUnprotect', 'WallHooksHelper', 'onBeforePageUnprotect');
$app->registerHook('BeforePageDelete', 'WallHooksHelper', 'onBeforePageDelete');
$app->registerHook('PersonalUrls', 'WallHooksHelper', 'onPersonalUrls');
$app->registerHook('UserPagesHeaderModuleAfterGetTabs', 'WallHooksHelper', 'onUserPagesHeaderModuleAfterGetTabs');
$app->registerHook('SkinSubPageSubtitleAfterTitle', 'WallHooksHelper', 'onSkinSubPageSubtitleAfterTitle');
$app->registerHook('SkinTemplateContentActions', 'WallHooksHelper', 'onSkinTemplateContentActions');
$app->registerHook('PageHeaderIndexAfterActionButtonPrepared', 'WallHooksHelper', 'onPageHeaderIndexAfterActionButtonPrepared');
$app->registerHook('BlockIpCompleteWatch', 'WallHooksHelper', 'onBlockIpCompleteWatch');
$app->registerHook('UserIsBlockedFrom', 'WallHooksHelper', 'onUserIsBlockedFrom');

//wall history in toolbar
$app->registerHook('BeforeToolbarMenu', 'WallHooksHelper', 'onBeforeToolbarMenu');
$app->registerHook('BeforePageHistory', 'WallHooksHelper', 'onBeforePageHistory');
$app->registerHook('GetHistoryDescription', 'WallHooksHelper', 'onGetHistoryDescription');

$app->registerHook('AllowNotifyOnPageChange', 'WallHooksHelper', 'onAllowNotifyOnPageChange');
$app->registerHook('GetPreferences', 'WallHooksHelper', 'onGetPreferences');

//recent changes adjusting
$app->registerHook('AC_RecentChange_Save', 'WallHooksHelper', 'onRecentChangeSave');
$app->registerHook('ChangesListInsertFlags', 'WallHooksHelper', 'onChangesListInsertFlags');
$app->registerHook('ChangesListInsertArticleLink', 'WallHooksHelper', 'onChangesListInsertArticleLink');
$app->registerHook('ChangesListInsertDiffHist', 'WallHooksHelper', 'onChangesListInsertDiffHist');
$app->registerHook('ChangesListInsertRollback', 'WallHooksHelper', 'onChangesListInsertRollback');
$app->registerHook('ChangesListInsertLogEntry', 'WallHooksHelper', 'onChangesListInsertLogEntry');
$app->registerHook('ChangesListInsertComment', 'WallHooksHelper', 'onChangesListInsertComment');
$app->registerHook('ArticleDoDeleteArticleBeforeLogEntry', 'WallHooksHelper', 'onArticleDoDeleteArticleBeforeLogEntry');
$app->registerHook('PageArchiveUndeleteBeforeLogEntry', 'WallHooksHelper', 'onPageArchiveUndeleteBeforeLogEntry');
$app->registerHook('OldChangesListRecentChangesLine', 'WallHooksHelper', 'onOldChangesListRecentChangesLine');
$app->registerHook('ChangesListMakeSecureName', 'WallHooksHelper', 'onChangesListMakeSecureName');
$app->registerHook('WikiaRecentChangesBlockHandlerChangeHeaderBlockGroup', 'WallHooksHelper', 'onWikiaRecentChangesBlockHandlerChangeHeaderBlockGroup');

$app->registerHook('ArticleDeleteComplete' , 'WallHooksHelper', 'onArticleDeleteComplete');

$app->registerHook('getUserPermissionsErrors', 'WallHooksHelper', 'onGetUserPermissionsErrors');
$app->registerHook('ComposeCommonBodyMail', 'WallHooksHelper', 'onComposeCommonBodyMail' );

//Special:Contributions adjusting
$app->registerHook('ContributionsLineEnding', 'WallHooksHelper', 'onContributionsLineEnding' );

//Special:Whatlinkshere adjustinb
$app->registerHook('SpecialWhatlinkshere::renderWhatLinksHereRow', 'WallHooksHelper', 'onRenderWhatLinksHereRow');
$app->registerHook('ContributionsToolLinks', 'WallHooksHelper', 'onContributionsToolLinks');

//watchlist
$app->registerHook('ArticleCommentBeforeWatchlistAdd', 'WallHooksHelper', 'onArticleCommentBeforeWatchlistAdd');
//$app->registerHook('WatchArticle', 'WallHooksHelper', 'onWatchArticle');
//$app->registerHook('UnwatchArticle', 'WallHooksHelper', 'onUnwatchArticle');

//diff page adjusting
$app->registerHook('DiffViewHeader', 'WallHooksHelper', 'onDiffViewHeader');
$app->registerHook('PageHeaderEditPage', 'WallHooksHelper', 'onPageHeaderEditPage');
$app->registerHook('DiffLoadText', 'WallHooksHelper', 'onDiffLoadText');

//right rail adjusting
$app->registerHook('GetRailModuleList', 'WallRailHelper', 'onGetRailModuleList');

//handmade links to message wall adjusting
$app->registerHook('LinkBegin', 'WallHooksHelper', 'onLinkBegin');
$app->registerHook('LinkerUserTalkLinkAfter', 'WallHooksHelper', 'onLinkerUserTalkLinkAfter');

//saving user talk archive redirects to user talk archive
$app->registerHook('ArticleSaveComplete', 'WallHooksHelper', 'onArticleSaveComplete');

//cancel API vote adding
$app->registerHook('ArticleBeforeVote', 'WallHooksHelper', 'onArticleBeforeVote');

// vote invalidation
$app->registerHook('BlockIpComplete', 'WallHooksHelper', 'onBlockIpComplete');
$app->registerHook('UnBlockIpComplete', 'WallHooksHelper', 'onBlockIpComplete');

$app->registerHook('CategoryViewer::beforeCategoryData', 'WallHooksHelper', 'onBeforeCategoryData');

$app->registerHook('GetRailModuleSpecialPageList', 'WallHooksHelper', 'onGetRailModuleSpecialPageList');
$app->registerHook('SpecialWikiActivityExecute', 'WallHooksHelper', 'onSpecialWikiActivityExecute');

$app->registerHook('WantedPages::getQueryInfo', 'WallHooksHelper', 'onWantedPagesGetQueryInfo');
$app->registerHook('ListredirectsPage::getQueryInfo', 'WallHooksHelper', 'onListredirectsPageGetQueryInfo');

$app->registerHook('AfterLanguageGetNamespaces', 'WallHooksHelper', 'onAfterLanguageGetNamespaces');

F::build('JSMessages')->registerPackage('Wall', array(
	'wall-notifications',
	'wall-notifications-reminder',
	'wall-notifications-wall-disabled',
	'oasis-follow',
	'wall-message-edited',
	'wikiafollowedpages-following',
	'wall-message-unfollow',
	'wall-button-to-submit-comment-no-topic',
	'wall-button-to-submit-comment',
	'wall-button-save-changes',
	'wall-button-cancel-changes',
	'wall-delete-confirm',
	'wall-delete-confirm-thread',
	'wall-delete-confirm-cancel',
	'wall-delete-confirm-ok',
	'wall-delete-title',
	'wall-delete-error-title',
	'wall-delete-error-content',
	'wall-button-to-cancel-preview',
	'wall-button-to-preview-comment',
	'wall-votes-modal-title',
	'wall-button-done-source',
	'wall-preview-modal-title',
	'wall-preview-modal-button-back',
	'wall-preview-modal-button-publish',
	'wall-action-*',
	'wall-message-source',
	'wall-confirm-monobook-*',
	'wall-preview-modal-title'
));

/**
 * extension related configuration
 */


define( 'WALL_EMAIL_NOEMAIL', -1);
define( 'WALL_EMAIL_EVERY', 1);
define( 'WALL_EMAIL_SINCEVISITED', 2);
define( 'WALL_EMAIL_REMINDER', 3);

$wgDefaultUserOptions['enotifwallthread'] = WALL_EMAIL_SINCEVISITED;
$wgDefaultUserOptions['wallshowsource'] = false;
$wgDefaultUserOptions['walldelete'] = false;

$userProfileNamespaces = array();
$userProfileNamespaces[] = NS_USER;
$userProfileNamespaces[] = NS_USER_TALK;
$userProfileNamespaces[] = NS_USER_WALL;
$app->getLocalRegistry()->set('UserProfileNamespaces', $userProfileNamespaces);

define( 'WH_EDIT', 0);
define( 'WH_NEW', 1);
define( 'WH_DELETE', 2);
define( 'WH_REMOVE', 4);
define( 'WH_RESTORE', 5);
define( 'WH_ARCHIVE', 6);
define( 'WH_REOPEN', 7);


//wall
$wgGroupPermissions['*']['walldelete'] = false;
$wgGroupPermissions['util']['walldelete'] = true;

$wgGroupPermissions['*']['walladmindelete'] = false;
$wgGroupPermissions['staff']['walladmindelete'] = false;
$wgGroupPermissions['vstf']['walladmindelete'] = true;
$wgGroupPermissions['helper']['walladmindelete'] = false;
$wgGroupPermissions['sysop']['walladmindelete'] = false;

$wgGroupPermissions['*']['wallarchive'] = false;
$wgGroupPermissions['staff']['wallarchive'] = true;
$wgGroupPermissions['vstf']['wallarchive'] = true;
$wgGroupPermissions['helper']['wallarchive'] = true;
$wgGroupPermissions['sysop']['wallarchive'] = true;

$wgGroupPermissions['*']['wallremove'] = false;
$wgGroupPermissions['user']['wallremove'] = true;

$wgGroupPermissions['*']['walledit'] = false;
$wgGroupPermissions['staff']['walledit'] = true;
$wgGroupPermissions['vstf']['walledit'] = true;
$wgGroupPermissions['helper']['walledit'] = true;
$wgGroupPermissions['sysop']['walledit'] = true;

$wgGroupPermissions['*']['editwallarchivedpages'] = false;
$wgGroupPermissions['sysop']['editwallarchivedpages'] = true;
$wgGroupPermissions['vstf']['editwallarchivedpages'] = true;
$wgGroupPermissions['staff']['editwallarchivedpages'] = true;
$wgGroupPermissions['helper']['editwallarchivedpages'] = true;

$wgGroupPermissions['*']['wallshowwikiaemblem'] = false;
$wgGroupPermissions['staff']['wallshowwikiaemblem'] = true;

$wgGroupPermissions['*']['notifyeveryone'] = false;
$wgGroupPermissions['sysop']['notifyeveryone'] = true;
$wgGroupPermissions['vstf']['notifyeveryone'] = true;
$wgGroupPermissions['staff']['notifyeveryone'] = true;
$wgGroupPermissions['helper']['notifyeveryone'] = true;

$wgGroupPermissions['*']['wallfastadmindelete'] = false;
$wgGroupPermissions['sysop']['wallfastadmindelete'] = false;
$wgGroupPermissions['vstf']['wallfastadmindelete'] = true;
$wgGroupPermissions['staff']['wallfastadmindelete'] = true;
