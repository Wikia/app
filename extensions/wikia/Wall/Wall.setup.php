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
	'author' => array( 'Tomek Odrobny', 'Christian Williams', 'Andrzej Łukaszewski', 'Piotr Bablok' ),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wall-desc',
);

$dir = dirname(__FILE__);

define( "NS_USER_WALL", 1200 );
define( "NS_USER_WALL_MESSAGE", 1201 );

$wgExtraNamespaces[ NS_USER_WALL ] = "Message_Wall";
$wgNamespacesWithSubpages[ NS_USER_WALL ] = true;

$app->registerClass('WallController', $dir . '/WallController.class.php');
$app->registerClass('WallExternalController', $dir . '/WallExternalController.class.php');
$app->registerClass('WallHelper', $dir . '/WallHelper.class.php');
$app->registerClass('WallHooksHelper', $dir . '/WallHooksHelper.class.php');
$app->registerClass('WallNotifications', $dir . '/WallNotifications.class.php');
$app->registerClass('WallNotificationEntity', $dir . '/WallNotificationEntity.class.php');
$app->registerClass('WallNotificationsModule', $dir . '/WallNotificationsModule.class.php');
$app->registerClass('WallNotificationsExternalController', $dir . '/WallNotificationsExternalController.class.php');
$app->registerClass('WallMessage', $dir . '/WallMessage.class.php');
$app->registerClass('WallRailHelper', $dir . '/WallRailHelper.class.php');

$app->registerExtensionMessageFile('Wall', $dir . '/Wall.i18n.php');

$app->registerHook('ArticleViewHeader', 'WallHooksHelper', 'onArticleViewHeader');
$app->registerHook('SkinTemplateTabs', 'WallHooksHelper', 'onSkinTemplateTabs');
$app->registerHook('AlternateEdit', 'WallHooksHelper', 'onAlternateEdit');
$app->registerHook('AfterEditPermissionErrors', 'WallHooksHelper', 'onAfterEditPermissionErrors');
$app->registerHook('BeforePageHistory', 'WallHooksHelper', 'onBeforePageHistory');
$app->registerHook('BeforePageProtect', 'WallHooksHelper', 'onBeforePageProtect');
$app->registerHook('BeforePageUnprotect', 'WallHooksHelper', 'onBeforePageUnprotect');
$app->registerHook('BeforePageDelete', 'WallHooksHelper', 'onBeforePageDelete');
$app->registerHook('PersonalUrls', 'WallHooksHelper', 'onPersonalUrls');
$app->registerHook('UserPagesHeaderModuleAfterGetTabs', 'WallHooksHelper', 'onUserPagesHeaderModuleAfterGetTabs');
$app->registerHook('SkinSubPageSubtitleAfterTitle', 'WallHooksHelper', 'onSkinSubPageSubtitleAfterTitle');
$app->registerHook('PageHeaderIndexAfterActionButtonPrepared', 'WallHooksHelper', 'onPageHeaderIndexAfterActionButtonPrepared');

$app->registerHook('AC_RecentChange_Save', 'WallHooksHelper', 'onRecentChangeSave');

$app->registerHook('ArticleCommentBeforeWatchlistAdd', 'WallHooksHelper', 'onArticleCommentBeforeWatchlistAdd');

$app->registerHook('MakeGlobalVariablesScript', 'JSMessages', 'onMakeGlobalVariablesScript');
$app->registerHook('SkinAfterBottomScripts', 'JSMessages', 'onSkinAfterBottomScripts');
$app->registerHook('MessageCacheReplace', 'JSMessagesHelper', 'onMessageCacheReplace');

$app->registerHook('GetRailModuleList', 'WallRailHelper', 'onGetRailModuleList');

F::build('JSMessages')->registerPackage('Wall', array(
	'wall-notifications',
	'wall-message-follow',
	'wall-message-following',
	'wall-message-unfollow',
	'wall-button-to-submit-comment-no-topic',
	'wall-button-to-submit-comment',
	'wall-button-save-changes',
	'wall-button-cancel-changes',
	'wall-delete-confirm',
	'wall-delete-confirm-thread',
	'wall-delete-confirm-cancel',
	'wall-delete-confirm-ok',
	'wall-delete-title'
));

/**
 * extension related configuration
 */

$wgDefaultUserOptions['enotifwallthread'] = true;
$wgDefaultUserOptions['enotifmywall'] = true;
 
$userProfileNamespaces = array();
$userProfileNamespaces[] = NS_USER;
$userProfileNamespaces[] = NS_USER_TALK;
$userProfileNamespaces[] = NS_USER_WALL;
$app->getLocalRegistry()->set('UserProfileNamespaces', $userProfileNamespaces);