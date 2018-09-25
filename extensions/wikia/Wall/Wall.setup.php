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

$wgExtensionCredits['specialpage'][] = [
	'name' => 'User Wall',
	'author' => [ 'Tomek Odrobny', 'Christian Williams', "Andrzej 'nAndy' Lukaszewski", 'Piotr Bablok' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Wall',
	'descriptionmsg' => 'wall-desc',
];

$dir = dirname( __FILE__ );

include_once( $dir . '/WallNamespaces.php' );

$GLOBALS['wgNamespacesWithSubpages'][ NS_USER_WALL ] = true;

$GLOBALS['wgAutoloadClasses']['CommentsIndex'] = __DIR__ . '/index/CommentsIndex.class.php';
$GLOBALS['wgAutoloadClasses']['CommentsIndexEntry'] = __DIR__ . '/index/CommentsIndexEntry.class.php';
$GLOBALS['wgAutoloadClasses']['CommentsIndexHooks'] = __DIR__ . '/index/CommentsIndexHooks.class.php';
$GLOBALS['wgAutoloadClasses']['CommentsIndexEntryNotFoundException'] = __DIR__ . '/index/CommentsIndexEntryNotFoundException.php';

$GLOBALS['wgAutoloadClasses']['Wall'] =  $dir . '/Wall.class.php';
$GLOBALS['wgAutoloadClasses']['WallThread'] =  $dir . '/WallThread.class.php';

$GLOBALS['wgAutoloadClasses']['WallMessage'] =  $dir . '/WallMessage.class.php';
$GLOBALS['wgAutoloadClasses']['WallController'] =  $dir . '/WallController.class.php';
$GLOBALS['wgAutoloadClasses']['WallExternalController'] =  $dir . '/WallExternalController.class.php';
$GLOBALS['wgAutoloadClasses']['WallHistoryController'] =  $dir . '/WallHistoryController.class.php';
$GLOBALS['wgAutoloadClasses']['WallHooksHelper'] =  $dir . '/WallHooksHelper.class.php';
$GLOBALS['wgAutoloadClasses']['WallRailHelper'] =  $dir . '/WallRailHelper.class.php';
$GLOBALS['wgAutoloadClasses']['WallHelper'] =  $dir . '/WallHelper.class.php';
$GLOBALS['wgAutoloadClasses']['WallHistory'] =  $dir . '/WallHistory.class.php';
$GLOBALS['wgAutoloadClasses']['WallBaseController'] =  $dir . '/WallBaseController.class.php';
$GLOBALS['wgAutoloadClasses']['VoteHelper'] =  $dir . '/VoteHelper.class.php';
$GLOBALS['wgAutoloadClasses']['WallRelatedPages'] =  $dir . '/WallRelatedPages.class.php';

$GLOBALS['wgAutoloadClasses']['WallTabsRenderer'] = __DIR__ . '/WallTabsRenderer.php';

$GLOBALS['wgAutoloadClasses']['WallBuilder'] = __DIR__ . '/builders/WallBuilder.class.php';
$GLOBALS['wgAutoloadClasses']['WallMessageBuilder'] = __DIR__ . '/builders/WallMessageBuilder.class.php';
$GLOBALS['wgAutoloadClasses']['WallEditBuilder'] = __DIR__ . '/builders/WallEditBuilder.class.php';

$GLOBALS['wgAutoloadClasses']['InappropriateContentException'] = __DIR__ . '/exceptions/InappropriateContentException.class.php';
$GLOBALS['wgAutoloadClasses']['WallBuilderException'] = __DIR__ . '/exceptions/WallBuilderException.class.php';
$GLOBALS['wgAutoloadClasses']['WallBuilderGenericException'] = __DIR__ . '/exceptions/WallBuilderGenericException.class.php';

$GLOBALS['wgExtensionMessagesFiles']['Wall'] = $dir . '/Wall.i18n.php';

$GLOBALS['wgHooks']['ArticleViewHeader'][] = 'WallHooksHelper::onArticleViewHeader';
$GLOBALS['wgHooks']['SkinTemplateTabs'][] = 'WallHooksHelper::onSkinTemplateTabs';
$GLOBALS['wgHooks']['AlternateEdit'][] = 'WallHooksHelper::onAlternateEdit';
$GLOBALS['wgHooks']['AfterEditPermissionErrors'][] = 'WallHooksHelper::onAfterEditPermissionErrors';
$GLOBALS['wgHooks']['BeforePageProtect'][] = 'WallHooksHelper::onBeforePageProtect';
$GLOBALS['wgHooks']['BeforePageUnprotect'][] = 'WallHooksHelper::onBeforePageUnprotect';
$GLOBALS['wgHooks']['BeforePageDelete'][] = 'WallHooksHelper::onBeforePageDelete';
$GLOBALS['wgHooks']['PersonalUrls'][] = 'WallHooksHelper::onPersonalUrls';
$GLOBALS['wgHooks']['UserPagesHeaderModuleAfterGetTabs'][] = 'WallHooksHelper::onUserPagesHeaderModuleAfterGetTabs';
$GLOBALS['wgHooks']['SkinSubPageSubtitleAfterTitle'][] = 'WallHooksHelper::onSkinSubPageSubtitleAfterTitle';
$GLOBALS['wgHooks']['SkinTemplateContentActions'][] = 'WallHooksHelper::onSkinTemplateContentActions';
$GLOBALS['wgHooks']['BlockIpCompleteWatch'][] = 'WallHooksHelper::onBlockIpCompleteWatch';
$GLOBALS['wgHooks']['UserIsBlockedFrom'][] = 'WallHooksHelper::onUserIsBlockedFrom';

$GLOBALS['wgHooks']['ArticleRobotPolicy'][] = 'WallHooksHelper::onArticleRobotPolicy';

// wall history in toolbar
$GLOBALS['wgHooks']['BeforeToolbarMenu'][] = 'WallHooksHelper::onBeforeToolbarMenu';
$GLOBALS['wgHooks']['BeforePageHistory'][] = 'WallHooksHelper::onBeforePageHistory';
$GLOBALS['wgHooks']['GetHistoryDescription'][] = 'WallHooksHelper::onGetHistoryDescription';

$GLOBALS['wgHooks']['AllowNotifyOnPageChange'][] = 'WallHooksHelper::onAllowNotifyOnPageChange';
$GLOBALS['wgHooks']['GetPreferences'][] = 'WallHooksHelper::onGetPreferences';

// recent changes adjusting
$GLOBALS['wgHooks']['ChangesListInsertFlags'][] = 'WallHooksHelper::onChangesListInsertFlags';
$GLOBALS['wgHooks']['ChangesListInsertArticleLink'][] = 'WallHooksHelper::onChangesListInsertArticleLink';
$GLOBALS['wgHooks']['ChangesListInsertDiffHist'][] = 'WallHooksHelper::onChangesListInsertDiffHist';
$GLOBALS['wgHooks']['ChangesListInsertRollback'][] = 'WallHooksHelper::onChangesListInsertRollback';
$GLOBALS['wgHooks']['ChangesListInsertLogEntry'][] = 'WallHooksHelper::onChangesListInsertLogEntry';
$GLOBALS['wgHooks']['ChangesListInsertComment'][] = 'WallHooksHelper::onChangesListInsertComment';

$GLOBALS['wgHooks']['ArticleDoDeleteArticleBeforeLogEntry'][] = 'WallHooksHelper::onArticleDoDeleteArticleBeforeLogEntry';
$GLOBALS['wgHooks']['PageArchiveUndeleteBeforeLogEntry'][] = 'WallHooksHelper::onPageArchiveUndeleteBeforeLogEntry';
$GLOBALS['wgHooks']['OldChangesListRecentChangesLine'][] = 'WallHooksHelper::onOldChangesListRecentChangesLine';
$GLOBALS['wgHooks']['ChangesListMakeSecureName'][] = 'WallHooksHelper::onChangesListMakeSecureName';
$GLOBALS['wgHooks']['WikiaRecentChangesBlockHandlerChangeHeaderBlockGroup'][] = 'WallHooksHelper::onWikiaRecentChangesBlockHandlerChangeHeaderBlockGroup';
$GLOBALS['wgHooks']['ChangesListItemGroupRegular'][] = 'WallHooksHelper::onChangesListItemGroupRegular';

$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'WallHooksHelper::onArticleDeleteComplete';
$GLOBALS['wgHooks']['FilePageImageUsageSingleLink'][] = 'WallHooksHelper::onFilePageImageUsageSingleLink';

$GLOBALS['wgHooks']['getUserPermissionsErrors'][] = 'WallHooksHelper::onGetUserPermissionsErrors';

// Special:Contributions adjusting
$GLOBALS['wgHooks']['ContributionsLineEnding'][] = 'WallHooksHelper::onContributionsLineEnding';

// Special:Whatlinkshere adjustinb
$GLOBALS['wgHooks']['SpecialWhatlinkshere::renderWhatLinksHereRow'][] = 'WallHooksHelper::onRenderWhatLinksHereRow';
$GLOBALS['wgHooks']['ContributionsToolLinks'][] = 'WallHooksHelper::onContributionsToolLinks';

$GLOBALS['wgHooks']['UnwatchArticle'][] = 'WallHooksHelper::onUnwatchArticle';

// diff page adjusting
$GLOBALS['wgHooks']['DiffViewHeader'][] = 'WallHooksHelper::onDiffViewHeader';

// right rail adjusting
$GLOBALS['wgHooks']['GetRailModuleList'][] = 'WallRailHelper::onGetRailModuleList';

// handmade links to message wall adjusting
$GLOBALS['wgHooks']['LinkBegin'][] = 'WallHooksHelper::onLinkBegin';
$GLOBALS['wgHooks']['LinkerUserTalkLinkAfter'][] = 'WallHooksHelper::onLinkerUserTalkLinkAfter';

// saving user talk archive redirects to user talk archive
$GLOBALS['wgHooks']['ArticleSaveComplete'][] = 'WallHooksHelper::onArticleSaveComplete';

// cancel API vote adding
$GLOBALS['wgHooks']['ArticleBeforeVote'][] = 'WallHooksHelper::onArticleBeforeVote';

// vote invalidation
$GLOBALS['wgHooks']['BlockIpComplete'][] = 'WallHooksHelper::onBlockIpComplete';
$GLOBALS['wgHooks']['UnBlockIpComplete'][] = 'WallHooksHelper::onBlockIpComplete';

$GLOBALS['wgHooks']['CategoryViewer::beforeCategoryData'][] = 'WallHooksHelper::onBeforeCategoryData';
$GLOBALS['wgHooks']['CategoryPage3::beforeCategoryData'][] = 'WallHooksHelper::onBeforeCategoryData';

$GLOBALS['wgHooks']['GetRailModuleSpecialPageList'][] = 'WallHooksHelper::onGetRailModuleSpecialPageList';
$GLOBALS['wgHooks']['SpecialWikiActivityExecute'][] = 'WallHooksHelper::onSpecialWikiActivityExecute';

$GLOBALS['wgHooks']['WantedPages::getQueryInfo'][] = 'WallHooksHelper::onWantedPagesGetQueryInfo';
$GLOBALS['wgHooks']['ListredirectsPage::getQueryInfo'][] = 'WallHooksHelper::onListredirectsPageGetQueryInfo';

$GLOBALS['wgHooks']['BeforeInitialize'][] = 'WallHooksHelper::onBeforeInitialize';
// lazy loaded by the previous hook

$GLOBALS['wgHooks']['WikiFeatures::afterToggleFeature'][] = 'WallHooksHelper::onAfterToggleFeature';
$GLOBALS['wgHooks']['AdvancedBoxSearchableNamespaces'][] = 'WallHooksHelper::onAdvancedBoxSearchableNamespaces';

$GLOBALS['wgHooks']['HAWelcomeGetPrefixText'][] = 'WallHooksHelper::onHAWelcomeGetPrefixText';

// Hook for code that wants a beautified title and URL given the not very readable Wall/Forum title
$GLOBALS['wgHooks']['FormatForumLinks'][] = 'WallHooksHelper::onFormatForumLinks';

// Fix URLs when purging after adding a thread/post
$GLOBALS['wgHooks']['TitleGetSquidURLs'][] = 'WallHooksHelper::onTitleGetSquidURLs';

// Fix User_talk links for profile page diff on wall enabled wikis
// VOLDEV-66

$GLOBALS['wgHooks']['GetTalkPage'][] = 'WallHooksHelper::onGetTalkPage';

// SUS-260: Prevent moving pages within, into or out of Wall namespaces
$GLOBALS['wgHooks']['MWNamespace:isMovable'][] = 'WallHooksHelper::onNamespaceIsMovable';

// handle MediaWiki delete flow and comments_index updates
$GLOBALS['wgHooks']['ArticleDoDeleteArticleBeforeLogEntry'][] = 'CommentsIndexHooks::onArticleDoDeleteArticleBeforeLogEntry';
$GLOBALS['wgHooks']['ArticleUndelete'][] = 'CommentsIndexHooks::onArticleUndelete';

$GLOBALS['wgHooks']['AfterPageHeaderPageSubtitle'][] = 'WallHooksHelper::onAfterPageHeaderPageSubtitle';

JSMessages::registerPackage( 'Wall', [
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
	'wall-posting-message-failed-title',
	'wall-posting-message-failed-body',
	'wall-posting-message-failed-filter-title',
	'wall-posting-message-failed-filter-body',
	'preview',
	'savearticle',
	'back',
] );

/**
 * extension related configuration
 */


define( 'WALL_EMAIL_NOEMAIL', -1 );
define( 'WALL_EMAIL_EVERY', 1 );
define( 'WALL_EMAIL_SINCEVISITED', 2 );
define( 'WALL_EMAIL_REMINDER', 3 );

$GLOBALS['wgDefaultUserOptions']['enotifwallthread'] = WALL_EMAIL_SINCEVISITED;
$GLOBALS['wgDefaultUserOptions']['wallshowsource'] = false;
$GLOBALS['wgDefaultUserOptions']['walldelete'] = false;

$GLOBALS['wgUserProfileNamespaces'] = [
	NS_USER, NS_USER_TALK, NS_USER_WALL
];

define( 'WH_EDIT', 0 );
define( 'WH_NEW', 1 );
define( 'WH_DELETE', 2 );
define( 'WH_REMOVE', 4 );
define( 'WH_RESTORE', 5 );
define( 'WH_ARCHIVE', 6 );
define( 'WH_REOPEN', 7 );
