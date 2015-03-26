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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Wall',
	'descriptionmsg' => 'wall-desc',
);

$dir = dirname(__FILE__);

include($dir . '/WallNamespaces.php');

$wgNamespacesWithSubpages[ NS_USER_WALL ] = true;

$wgAutoloadClasses['Wall'] =  $dir . '/Wall.class.php';
$wgAutoloadClasses['Walls'] =  $dir . '/Walls.class.php';
$wgAutoloadClasses['WallThread'] =  $dir . '/WallThread.class.php';

$wgAutoloadClasses['WallMessage'] =  $dir . '/WallMessage.class.php';
$wgAutoloadClasses['WallController'] =  $dir . '/WallController.class.php';
$wgAutoloadClasses['WallExternalController'] =  $dir . '/WallExternalController.class.php';
$wgAutoloadClasses['WallHistoryController'] =  $dir . '/WallHistoryController.class.php';
$wgAutoloadClasses['WallHooksHelper'] =  $dir . '/WallHooksHelper.class.php';
$wgAutoloadClasses['WallRailHelper'] =  $dir . '/WallRailHelper.class.php';
$wgAutoloadClasses['WallRailController'] =  $dir . '/WallRailController.class.php';
$wgAutoloadClasses['WallHelper'] =  $dir . '/WallHelper.class.php';
$wgAutoloadClasses['WallHistory'] =  $dir . '/WallHistory.class.php';
$wgAutoloadClasses['WallBaseController'] =  $dir . '/WallBaseController.class.php';
$wgAutoloadClasses['VoteHelper'] =  $dir . '/VoteHelper.class.php';
$wgAutoloadClasses['WallRelatedPages'] =  $dir . '/WallRelatedPages.class.php';

$wgExtensionMessagesFiles['Wall'] = $dir . '/Wall.i18n.php';

$wgHooks['AccountNavigationModuleAfterDropdownItems'][] = 'WallHooksHelper::onAccountNavigationModuleAfterDropdownItems';
$wgHooks['ArticleViewHeader'][] = 'WallHooksHelper::onArticleViewHeader';
$wgHooks['SkinTemplateTabs'][] = 'WallHooksHelper::onSkinTemplateTabs';
$wgHooks['AlternateEdit'][] = 'WallHooksHelper::onAlternateEdit';
$wgHooks['AfterEditPermissionErrors'][] = 'WallHooksHelper::onAfterEditPermissionErrors';
$wgHooks['BeforePageProtect'][] = 'WallHooksHelper::onBeforePageProtect';
$wgHooks['BeforePageUnprotect'][] = 'WallHooksHelper::onBeforePageUnprotect';
$wgHooks['BeforePageDelete'][] = 'WallHooksHelper::onBeforePageDelete';
$wgHooks['PersonalUrls'][] = 'WallHooksHelper::onPersonalUrls';
$wgHooks['UserPagesHeaderModuleAfterGetTabs'][] = 'WallHooksHelper::onUserPagesHeaderModuleAfterGetTabs';
$wgHooks['SkinSubPageSubtitleAfterTitle'][] = 'WallHooksHelper::onSkinSubPageSubtitleAfterTitle';
$wgHooks['SkinTemplateContentActions'][] = 'WallHooksHelper::onSkinTemplateContentActions';
$wgHooks['PageHeaderIndexAfterActionButtonPrepared'][] = 'WallHooksHelper::onPageHeaderIndexAfterActionButtonPrepared';
$wgHooks['BlockIpCompleteWatch'][] = 'WallHooksHelper::onBlockIpCompleteWatch';
$wgHooks['UserIsBlockedFrom'][] = 'WallHooksHelper::onUserIsBlockedFrom';

$wgHooks['ArticleRobotPolicy'][] = 'WallHooksHelper::onArticleRobotPolicy';

//wall history in toolbar
$wgHooks['BeforeToolbarMenu'][] = 'WallHooksHelper::onBeforeToolbarMenu';
$wgHooks['BeforePageHistory'][] = 'WallHooksHelper::onBeforePageHistory';
$wgHooks['GetHistoryDescription'][] = 'WallHooksHelper::onGetHistoryDescription';

$wgHooks['AllowNotifyOnPageChange'][] = 'WallHooksHelper::onAllowNotifyOnPageChange';
$wgHooks['GetPreferences'][] = 'WallHooksHelper::onGetPreferences';

//recent changes adjusting

$wgHooks['AC_RecentChange_Save'][] = 'WallHooksHelper::onRecentChangeSave';
$wgHooks['ChangesListInsertFlags'][] = 'WallHooksHelper::onChangesListInsertFlags';
$wgHooks['ChangesListInsertArticleLink'][] = 'WallHooksHelper::onChangesListInsertArticleLink';
$wgHooks['ChangesListInsertDiffHist'][] = 'WallHooksHelper::onChangesListInsertDiffHist';
$wgHooks['ChangesListInsertRollback'][] = 'WallHooksHelper::onChangesListInsertRollback';
$wgHooks['ChangesListInsertLogEntry'][] = 'WallHooksHelper::onChangesListInsertLogEntry';
$wgHooks['ChangesListInsertComment'][] = 'WallHooksHelper::onChangesListInsertComment';

$wgHooks['ArticleDoDeleteArticleBeforeLogEntry'][] = 'WallHooksHelper::onArticleDoDeleteArticleBeforeLogEntry';
$wgHooks['PageArchiveUndeleteBeforeLogEntry'][] = 'WallHooksHelper::onPageArchiveUndeleteBeforeLogEntry';
$wgHooks['OldChangesListRecentChangesLine'][] = 'WallHooksHelper::onOldChangesListRecentChangesLine';
$wgHooks['ChangesListMakeSecureName'][] = 'WallHooksHelper::onChangesListMakeSecureName';
$wgHooks['WikiaRecentChangesBlockHandlerChangeHeaderBlockGroup'][] = 'WallHooksHelper::onWikiaRecentChangesBlockHandlerChangeHeaderBlockGroup';
$wgHooks['ChangesListItemGroupRegular'][] = 'WallHooksHelper::onChangesListItemGroupRegular';

$wgHooks['ArticleDeleteComplete'][] = 'WallHooksHelper::onArticleDeleteComplete';
$wgHooks['FilePageImageUsageSingleLink'][] = 'WallHooksHelper::onFilePageImageUsageSingleLink';

$wgHooks['getUserPermissionsErrors'][] = 'WallHooksHelper::onGetUserPermissionsErrors';

//Special:Contributions adjusting
$wgHooks['ContributionsLineEnding'][] = 'WallHooksHelper::onContributionsLineEnding';

//Special:Whatlinkshere adjustinb
$wgHooks['SpecialWhatlinkshere::renderWhatLinksHereRow'][] = 'WallHooksHelper::onRenderWhatLinksHereRow';
$wgHooks['ContributionsToolLinks'][] = 'WallHooksHelper::onContributionsToolLinks';

//watchlist
$wgHooks['ArticleCommentBeforeWatchlistAdd'][] = 'WallHooksHelper::onArticleCommentBeforeWatchlistAdd';
//$wgHooks['WatchArticle'][] = 'WallHooksHelper::onWatchArticle';
//$wgHooks['UnwatchArticle'][] = 'WallHooksHelper::onUnwatchArticle';

//diff page adjusting
$wgHooks['DiffViewHeader'][] = 'WallHooksHelper::onDiffViewHeader';
$wgHooks['PageHeaderEditPage'][] = 'WallHooksHelper::onPageHeaderEditPage';
$wgHooks['DiffLoadText'][] = 'WallHooksHelper::onDiffLoadText';

//right rail adjusting
$wgHooks['GetRailModuleList'][] = 'WallRailHelper::onGetRailModuleList';

//handmade links to message wall adjusting
$wgHooks['LinkBegin'][] = 'WallHooksHelper::onLinkBegin';
$wgHooks['LinkerUserTalkLinkAfter'][] = 'WallHooksHelper::onLinkerUserTalkLinkAfter';

//saving user talk archive redirects to user talk archive
$wgHooks['ArticleSaveComplete'][] = 'WallHooksHelper::onArticleSaveComplete';

//cancel API vote adding
$wgHooks['ArticleBeforeVote'][] = 'WallHooksHelper::onArticleBeforeVote';

// vote invalidation
$wgHooks['BlockIpComplete'][] = 'WallHooksHelper::onBlockIpComplete';
$wgHooks['UnBlockIpComplete'][] = 'WallHooksHelper::onBlockIpComplete';

$wgHooks['CategoryViewer::beforeCategoryData'][] = 'WallHooksHelper::onBeforeCategoryData';

$wgHooks['GetRailModuleSpecialPageList'][] = 'WallHooksHelper::onGetRailModuleSpecialPageList';
$wgHooks['SpecialWikiActivityExecute'][] = 'WallHooksHelper::onSpecialWikiActivityExecute';

$wgHooks['WantedPages::getQueryInfo'][] = 'WallHooksHelper::onWantedPagesGetQueryInfo';
$wgHooks['ListredirectsPage::getQueryInfo'][] = 'WallHooksHelper::onListredirectsPageGetQueryInfo';

$wgHooks['BeforeInitialize'][] = 'WallHooksHelper::onBeforeInitialize';
// lazy loaded by the previous hook

$wgHooks['WikiFeatures::afterToggleFeature'][] = 'WallHooksHelper::onAfterToggleFeature';
$wgHooks['AdvancedBoxSearchableNamespaces'][] = 'WallHooksHelper::onAdvancedBoxSearchableNamespaces';

$wgHooks['HAWelcomeGetPrefixText'][] = 'WallHooksHelper::onHAWelcomeGetPrefixText';

// Monobook toolbar links
$wgHooks['SkinTemplateToolboxEnd'][] = 'WallHooksHelper::onBuildMonobookToolbox';

// Hook for code that wants a beautified title and URL given the not very readable Wall/Forum title
$wgHooks['FormatForumLinks'][] = 'WallHooksHelper::onFormatForumLinks';

// Fix URLs when purging after adding a thread/post
$wgHooks['TitleGetSquidURLs'][] = 'WallHooksHelper::onTitleGetSquidURLs';
$wgHooks['ArticleCommentGetSquidURLs'][] = 'WallHooksHelper::onArticleCommentGetSquidURLs';

// Fix User_talk links for profile page diff on wall enabled wikis
// VOLDEV-66
$wgHooks['GetTalkPage'][] = 'WallHooksHelper::onGetTalkPage';

JSMessages::registerPackage('Wall', array(
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
	'wall-action-*',
	'wall-message-source',
	'wall-confirm-monobook-*',
	'preview',
	'savearticle',
	'back',
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

$wgUserProfileNamespaces = array(
	NS_USER, NS_USER_TALK, NS_USER_WALL
);

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
$wgGroupPermissions['staff']['walladmindelete'] = true;
$wgGroupPermissions['vstf']['walladmindelete'] = true;
$wgGroupPermissions['helper']['walladmindelete'] = true;
$wgGroupPermissions['sysop']['walladmindelete'] = true;

$wgGroupPermissions['*']['wallarchive'] = false;
$wgGroupPermissions['staff']['wallarchive'] = true;
$wgGroupPermissions['vstf']['wallarchive'] = true;
$wgGroupPermissions['helper']['wallarchive'] = true;
$wgGroupPermissions['sysop']['wallarchive'] = true;
$wgGroupPermissions['threadmoderator']['wallarchive'] = true;

$wgGroupPermissions['*']['wallremove'] = false;
$wgGroupPermissions['staff']['wallremove'] = true;
$wgGroupPermissions['vstf']['wallremove'] = true;
$wgGroupPermissions['helper']['wallremove'] = true;
$wgGroupPermissions['sysop']['wallremove'] = true;
$wgGroupPermissions['threadmoderator']['wallremove'] = true;

$wgGroupPermissions['*']['walledit'] = false;
$wgGroupPermissions['staff']['walledit'] = true;
$wgGroupPermissions['vstf']['walledit'] = true;
$wgGroupPermissions['helper']['walledit'] = true;
$wgGroupPermissions['sysop']['walledit'] = true;
$wgGroupPermissions['threadmoderator']['walledit'] = true;

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
$wgGroupPermissions['threadmoderator']['notifyeveryone'] = true;

$wgGroupPermissions['*']['wallfastadmindelete'] = false;
$wgGroupPermissions['sysop']['wallfastadmindelete'] = false;
$wgGroupPermissions['vstf']['wallfastadmindelete'] = true;
$wgGroupPermissions['staff']['wallfastadmindelete'] = true;

$wgGroupPermissions['*']['wallmessagemove'] = false;
$wgGroupPermissions['threadmoderator']['wallmessagemove'] = true;
$wgGroupPermissions['sysop']['wallmessagemove'] = true;
$wgGroupPermissions['vstf']['wallmessagemove'] = true;
$wgGroupPermissions['helper']['wallmessagemove'] = true;
$wgGroupPermissions['staff']['wallmessagemove'] = true;

$wgAddGroups['bureaucrat'][] = 'threadmoderator';
$wgRemoveGroups['bureaucrat'][] = 'threadmoderator';
$wgAddGroups['sysop'][] = 'threadmoderator';
$wgRemoveGroups['sysop'][] = 'threadmoderator';
