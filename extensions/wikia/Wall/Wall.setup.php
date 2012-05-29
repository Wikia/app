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
	'author' => array( 'Tomek Odrobny', 'Christian Williams', 'Andrzej ≈Åukaszewski', 'Piotr Bablok' ),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wall-desc',
);

$dir = dirname(__FILE__);

include($dir . '/WallNamespaces.php');

$wgNamespacesWithSubpages[ NS_USER_WALL ] = true;

$app->registerClass('Wall', $dir . '/Wall.class.php');
$app->registerClass('WallThread', $dir . '/WallThread.class.php');
$app->registerClass('WallMessage', $dir . '/WallMessage.class.php');
$app->registerClass('WallController', $dir . '/WallController.class.php');
$app->registerClass('WallExternalController', $dir . '/WallExternalController.class.php');
$app->registerClass('WallHistoryController', $dir . '/WallHistoryController.class.php');
$app->registerClass('WallHooksHelper', $dir . '/WallHooksHelper.class.php');
$app->registerClass('WallRailHelper', $dir . '/WallRailHelper.class.php');
$app->registerClass('WallRailController', $dir . '/WallRailController.class.php');
$app->registerClass('WallHelper', $dir . '/WallHelper.class.php');
$app->registerClass('WallHistory', $dir . '/WallHistory.class.php');

// register task in task manager
if (function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask(dirname(__FILE__)."/WallCopyFollowsTask.class.php", "wallcopyfollows", "WallCopyFollowsTask");
}


include($dir . '/WallNotifications.setup.php');


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
$app->registerHook('MakeGlobalVariablesScript', 'WallHooksHelper', 'onMakeGlobalVariablesScript');

//wall history in toolbar
$app->registerHook('BeforeToolbarMenu', 'WallHooksHelper', 'onBeforeToolbarMenu');
$app->registerHook('BeforePageHistory', 'WallHooksHelper', 'onBeforePageHistory');

$app->registerHook('AllowNotifyOnPageChange', 'WallHooksHelper', 'onAllowNotifyOnPageChange');
$app->registerHook('GetPreferences', 'WallHooksHelper', 'onGetPreferences');

//recent changes adjusting
$app->registerHook('AC_RecentChange_Save', 'WallHooksHelper', 'onRecentChangeSave');
$app->registerHook('ChangesListInsertFlags', 'WallHooksHelper', 'onChangesListInsertFlags');
$app->registerHook('ChangesListInsertArticleLink', 'WallHooksHelper', 'onChangesListInsertArticleLink');
$app->registerHook('ChangesListInsertDiffHist', 'WallHooksHelper', 'onChangesListInsertDiffHist');
$app->registerHook('ChangesListInsertRollback', 'WallHooksHelper', 'onChangesListInsertRollback');
$app->registerHook('ChangesListInsertAction', 'WallHooksHelper', 'onChangesListInsertAction');
$app->registerHook('ChangesListInsertComment', 'WallHooksHelper', 'onChangesListInsertComment');
$app->registerHook('ArticleDoDeleteArticleBeforeLogEntry', 'WallHooksHelper', 'onArticleDoDeleteArticleBeforeLogEntry');
$app->registerHook('PageArchiveUndeleteBeforeLogEntry', 'WallHooksHelper', 'onPageArchiveUndeleteBeforeLogEntry');
$app->registerHook('XmlNamespaceSelectorAfterGetFormattedNamespaces', 'WallHooksHelper', 'onXmlNamespaceSelectorAfterGetFormattedNamespaces');
$app->registerHook('ChangesListHeaderBlockGroup', 'WallHooksHelper', 'onChangesListHeaderBlockGroup');
$app->registerHook('OldChangesListRecentChangesLine', 'WallHooksHelper', 'onOldChangesListRecentChangesLine');
$app->registerHook('ChangesListMakeSecureName', 'WallHooksHelper', 'onChangesListMakeSecureName');

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

//right rail adjusting
$app->registerHook('GetRailModuleList', 'WallRailHelper', 'onGetRailModuleList');

//handmade links to message wall adjusting
$app->registerHook('LinkBegin', 'WallHooksHelper', 'onLinkBegin');

//saving user talk archive redirects to user talk archive
$app->registerHook('ArticleSaveComplete', 'WallHooksHelper', 'onArticleSaveComplete');

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
	'wall-button-done-source',
	'wall-action-*',
	'wall-message-source',
	'wall-confirm-monobook-*'
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
