<?php

/**
 * Forum
 *
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$wgExtensionCredits['specialpage'][] = array( '
	name' => 'Forum', 
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ) 
);

$dir = dirname( __FILE__ ) . '/';
$app = F::app( );

// classes
$app->registerClass( 'ForumSpecialController', $dir . 'ForumSpecialController.class.php' );
$app->registerClass( 'ForumHooksHelper', $dir . 'ForumHooksHelper.class.php' );
$app->registerClass( 'ForumController', $dir . 'ForumController.class.php' );
$app->registerClass( 'ForumNotificationPlugin', $dir . 'ForumNotificationPlugin.class.php' );
$app->registerClass( 'Forum', $dir . 'Forum.class.php' );
$app->registerClass( 'ForumBoard', $dir . 'ForumBoard.class.php' );
$app->registerClass( 'ForumHelper', $dir . 'ForumHelper.class.php' );
$app->registerClass( 'ForumExternalController', $dir . 'ForumExternalController.class.php' );

// i18n mapping
$app->registerExtensionMessageFile( 'Forum', $dir . 'Forum.i18n.php' );

// special pages
$app->registerSpecialPage( 'Forum', 'ForumSpecialController' );

// hooks
$app->registerHook( 'AfterWallWikiActivityFilter', 'ForumHooksHelper', 'onAfterWallWikiActivityFilter' );
$app->registerHook( 'WallContributionsLine', 'ForumHooksHelper', 'onWallContributionsLine' );
$app->registerHook( 'getUserPermissionsErrors', 'ForumHooksHelper', 'getUserPermissionsErrors' );
$app->registerHook( 'WallRecentchangesMessagePrefix', 'ForumHooksHelper', 'onWallRecentchangesMessagePrefix' );
$app->registerHook( 'WallThreadHeader', 'ForumHooksHelper', 'onWallThreadHeader' );

$app->registerHook( 'WallHistoryThreadHeader', 'ForumHooksHelper', 'onWallHistoryThreadHeader' );
$app->registerHook( 'WallHistoryHeader', 'ForumHooksHelper', 'onWallHistoryHeader' );

$app->registerHook( 'WallHeader', 'ForumHooksHelper', 'onWallHeader' );
$app->registerHook( 'WallNewMessage', 'ForumHooksHelper', 'onWallNewMessage' );
$app->registerHook( 'EditCommentsIndex', 'ForumHooksHelper', 'onEditCommentsIndex' );
$app->registerHook( 'ArticleInsertComplete', 'ForumHooksHelper', 'onArticleInsertComplete' );
$app->registerHook( 'WallBeforeRenderThread', 'ForumHooksHelper', 'onWallBeforeRenderThread' );
$app->registerHook( 'AfterBuildNewMessageAndPost', 'ForumHooksHelper', 'onAfterBuildNewMessageAndPost' );
$app->registerHook( 'WallMessageDeleted', 'ForumHooksHelper', 'onWallMessageDeleted' );

//notification hooks
$app->registerHook( 'NotificationGetNotificationMessage', 'ForumNotificationPlugin', 'onGetNotificationMessage' );
$app->registerHook( 'NotificationGetMailNotificationMessage', 'ForumNotificationPlugin', 'onGetMailNotificationMessage' );

//old forum archive
$app->registerHook( 'getUserPermissionsErrors', 'ForumHooksHelper', 'onGetUserPermissionsErrors' );
$app->registerHook( 'PageHeaderIndexAfterActionButtonPrepared', 'ForumHooksHelper', 'onPageHeaderIndexAfterActionButtonPrepared' );
$app->registerHook( 'ArticleViewHeader', 'ForumHooksHelper', 'onArticleViewHeader' );

include ($dir . '/Forum.namespace.setup.php');

// permissions
$wgAvailableRights[] = 'forum';
$wgAvailableRights[] = 'boardedit';
$wgAvailableRights[] = 'forumadmin';

$wgGroupPermissions['*']['forum'] = false;
$wgGroupPermissions['staff']['forum'] = true;
$wgGroupPermissions['sysop']['forum'] = true;
$wgGroupPermissions['bureaucrat']['forum'] = true;

$wgRevokePermissions['vstf']['forum'] = true;

$wgGroupPermissions['*']['boardedit'] = false;
$wgGroupPermissions['staff']['boardedit'] = true;

$wgGroupPermissions['*']['forumoldedit'] = false;
$wgGroupPermissions['staff']['forumoldedit'] = true;
$wgGroupPermissions['sysop']['forumoldedit'] = true;
$wgGroupPermissions['bureaucrat']['forumoldedit'] = true;

$wgGroupPermissions['*']['forumadmin'] = false;
$wgGroupPermissions['staff']['forumadmin'] = true;
$wgGroupPermissions['sysop']['forumadmin'] = true;
