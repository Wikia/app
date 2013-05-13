<?php

/**
 * Forum
 *
 * @author Hyun Lim, Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Forum',
	'author' => array( 'Hyun Lim', 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ),
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
$app->registerClass( 'RelatedForumDiscussionController', $dir . 'RelatedForumDiscussionController.class.php' );

// i18n mapping
$app->registerExtensionMessageFile( 'Forum', $dir . 'Forum.i18n.php' );
$app->registerExtensionMessageFile( 'ForumAliases', $dir . 'Forum.alias.php');

// special pages
$app->registerSpecialPage( 'Forum', 'ForumSpecialController' );

// hooks
$app->registerHook( 'AfterWallWikiActivityFilter', 'ForumHooksHelper', 'onAfterWallWikiActivityFilter' );
$app->registerHook( 'WallContributionsLine', 'ForumHooksHelper', 'onWallContributionsLine' );
$app->registerHook( 'getUserPermissionsErrors', 'ForumHooksHelper', 'getUserPermissionsErrors' );
$app->registerHook( 'WallRecentchangesMessagePrefix', 'ForumHooksHelper', 'onWallRecentchangesMessagePrefix' );
$app->registerHook( 'WallThreadHeader', 'ForumHooksHelper', 'onWallThreadHeader' );
$app->registerHook( 'WallMessageGetWallOwnerName', 'ForumHooksHelper', 'onWallMessageGetWallOwnerName' );

$app->registerHook( 'WallHistoryThreadHeader', 'ForumHooksHelper', 'onWallHistoryThreadHeader' );
$app->registerHook( 'WallHistoryHeader', 'ForumHooksHelper', 'onWallHistoryHeader' );

$app->registerHook( 'WallHeader', 'ForumHooksHelper', 'onWallHeader' );
$app->registerHook( 'WallNewMessage', 'ForumHooksHelper', 'onWallNewMessage' );
$app->registerHook( 'EditCommentsIndex', 'ForumHooksHelper', 'onEditCommentsIndex' );
$app->registerHook( 'ArticleInsertComplete', 'ForumHooksHelper', 'onArticleInsertComplete' );
$app->registerHook( 'WallBeforeRenderThread', 'ForumHooksHelper', 'onWallBeforeRenderThread' );
$app->registerHook( 'AfterBuildNewMessageAndPost', 'ForumHooksHelper', 'onAfterBuildNewMessageAndPost' );
$app->registerHook( 'WallMessageDeleted', 'ForumHooksHelper', 'onWallMessageDeleted' );
$app->registerHook( 'ContributionsLineEnding', 'ForumHooksHelper', 'onContributionsLineEnding' );
$app->registerHook( 'OasisAddPageDeletedConfirmationMessage', 'ForumHooksHelper', 'onOasisAddPageDeletedConfirmationMessage' );
$app->registerHook( 'FilePageImageUsageSingleLink', 'ForumHooksHelper', 'onFilePageImageUsageSingleLink' );

//notification hooks
$app->registerHook( 'NotificationGetNotificationMessage', 'ForumNotificationPlugin', 'onGetNotificationMessage' );
$app->registerHook( 'NotificationGetMailNotificationMessage', 'ForumNotificationPlugin', 'onGetMailNotificationMessage' );

//old forum archive
$app->registerHook( 'getUserPermissionsErrors', 'ForumHooksHelper', 'onGetUserPermissionsErrors' );
$app->registerHook( 'PageHeaderIndexAfterActionButtonPrepared', 'ForumHooksHelper', 'onPageHeaderIndexAfterActionButtonPrepared' );
$app->registerHook( 'ArticleViewHeader', 'ForumHooksHelper', 'onArticleViewHeader' );

// forum discussion on article
//It need to be first one !!!
array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'ForumHooksHelper::onOutputPageBeforeHTML' );

$app->registerHook( 'WallAction', 'ForumHooksHelper', 'onWallAction');
$app->registerHook( 'WallBeforeStoreRelatedTopicsInDB', 'ForumHooksHelper', 'onWallStoreRelatedTopicsInDB');
$app->registerHook( 'WallAfterStoreRelatedTopicsInDB', 'ForumHooksHelper', 'onWallStoreRelatedTopicsInDB');

$app->registerHook( 'ArticleFromTitle', 'ForumHooksHelper', 'onArticleFromTitle' );

// For activity module tag
$app->registerHook( 'ParserFirstCallInit', 'ForumHooksHelper', 'onParserFirstCallInit' );

// Hook for topic red links
$app->registerHook( 'LinkBegin', 'ForumHooksHelper', 'onLinkBegin' );

// Fix URLs of thread pages when purging them.
$app->registerHook( 'TitleGetSquidURLs', 'ForumHooksHelper', 'onTitleGetSquidURLs' );

include ($dir . '/Forum.namespace.setup.php');

//add this namespace to list of wall namespaces
$app->registerNamespaceControler( NS_WIKIA_FORUM_BOARD, 'ForumController', 'board', true );
$app->registerNamespaceControler( NS_WIKIA_FORUM_TOPIC_BOARD, 'ForumController', 'board', true );

// permissions
$wgAvailableRights[] = 'forum';
$wgAvailableRights[] = 'boardedit';
$wgAvailableRights[] = 'forumadmin';

$wgGroupPermissions['*']['forum'] = false;
$wgGroupPermissions['staff']['forum'] = true;
$wgGroupPermissions['sysop']['forum'] = true;
$wgGroupPermissions['bureaucrat']['forum'] = true;
$wgGroupPermissions['helper']['forum'] = true;

$wgRevokePermissions['vstf']['forum'] = true;

$wgGroupPermissions['*']['boardedit'] = false;
$wgGroupPermissions['staff']['boardedit'] = true;

$wgGroupPermissions['*']['forumoldedit'] = false;
$wgGroupPermissions['staff']['forumoldedit'] = true;
$wgGroupPermissions['helper']['forumoldedit'] = true;
$wgGroupPermissions['sysop']['forumoldedit'] = true;
$wgGroupPermissions['bureaucrat']['forumoldedit'] = true;
$wgGroupPermissions['helper']['forumoldedit'] = true;

$wgGroupPermissions['*']['forumadmin'] = false;
$wgGroupPermissions['staff']['forumadmin'] = true;
$wgGroupPermissions['helper']['forumadmin'] = true;
$wgGroupPermissions['sysop']['forumadmin'] = true;
$wgGroupPermissions['helper']['forumadmin'] = true;


F::build('JSMessages')->registerPackage('Forum', array(
	'back',
	'forum-specialpage-policies-edit',
	'forum-specialpage-policies'
));

