<?php

/**
 * Forum
 *
 * @author Hyun Lim, Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$GLOBALS['wgExtensionCredits']['specialpage'][] = [
	'name' => 'Forum',
	'author' => [ 'Hyun Lim', 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Forum',
	'descriptionmsg' => 'forum-desc'
];

$dir = __DIR__ . '/';

// classes
$GLOBALS['wgAutoloadClasses']['ForumSpecialController'] =  $dir . 'ForumSpecialController.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumHooksHelper'] =  $dir . 'ForumHooksHelper.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumController'] =  $dir . 'ForumController.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumNotificationPlugin'] =  $dir . 'ForumNotificationPlugin.class.php' ;
$GLOBALS['wgAutoloadClasses']['Forum'] =  $dir . 'Forum.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumBoard'] =  $dir . 'ForumBoard.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumBoardInfo'] =  $dir . 'ForumBoardInfo.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumPostInfo'] =  $dir . 'ForumPostInfo.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumHelper'] =  $dir . 'ForumHelper.class.php' ;
$GLOBALS['wgAutoloadClasses']['ForumExternalController'] =  $dir . 'ForumExternalController.class.php' ;
$GLOBALS['wgAutoloadClasses']['RelatedForumDiscussionController'] =  $dir . 'RelatedForumDiscussionController.class.php' ;
$GLOBALS['wgAutoloadClasses']['ThreadWatchlistDeleteUpdate'] = $dir . 'ThreadWatchlistDeleteUpdate.php';

$GLOBALS['wgAutoloadClasses']['ForumActivityService'] = __DIR__ . '/ForumActivityService.php';
$GLOBALS['wgAutoloadClasses']['CachedForumActivityService'] = __DIR__ . '/CachedForumActivityService.php';
$GLOBALS['wgAutoloadClasses']['DatabaseForumActivityService'] = __DIR__ . '/DatabaseForumActivityService.php';

// i18n mapping
$GLOBALS['wgExtensionMessagesFiles']['Forum'] = $dir . 'Forum.i18n.php' ;
$GLOBALS['wgExtensionMessagesFiles']['ForumAliases'] = $dir . 'Forum.alias.php';

// special pages
$GLOBALS['wgSpecialPages']['Forum'] =  'ForumSpecialController';

// hooks
$GLOBALS['wgHooks']['AfterWallWikiActivityFilter'][] = 'ForumHooksHelper::onAfterWallWikiActivityFilter';
$GLOBALS['wgHooks']['WallContributionsLine'][] = 'ForumHooksHelper::onWallContributionsLine';
$GLOBALS['wgHooks']['getUserPermissionsErrors'][] = 'ForumHooksHelper::getUserPermissionsErrors';
$GLOBALS['wgHooks']['WallRecentchangesMessagePrefix'][] = 'ForumHooksHelper::onWallRecentchangesMessagePrefix';
$GLOBALS['wgHooks']['WallThreadHeader'][] = 'ForumHooksHelper::onWallThreadHeader';
$GLOBALS['wgHooks']['WallMessageGetWallOwnerName'][] = 'ForumHooksHelper::onWallMessageGetWallOwnerName';

$GLOBALS['wgHooks']['WallHistoryThreadHeader'][] = 'ForumHooksHelper::onWallHistoryThreadHeader';
$GLOBALS['wgHooks']['WallHistoryHeader'][] = 'ForumHooksHelper::onWallHistoryHeader';

$GLOBALS['wgHooks']['WallHeader'][] = 'ForumHooksHelper::onWallHeader';
$GLOBALS['wgHooks']['WallNewMessage'][] = 'ForumHooksHelper::onWallNewMessage';
$GLOBALS['wgHooks']['WallBeforeRenderThread'][] = 'ForumHooksHelper::onWallBeforeRenderThread';
$GLOBALS['wgHooks']['AfterBuildNewMessageAndPost'][] = 'ForumHooksHelper::onAfterBuildNewMessageAndPost';
$GLOBALS['wgHooks']['WallMessageDeleted'][] = 'ForumHooksHelper::onWallMessageDeleted';
$GLOBALS['wgHooks']['ContributionsLineEnding'][] = 'ForumHooksHelper::onContributionsLineEnding';
$GLOBALS['wgHooks']['OasisAddPageDeletedConfirmationMessage'][] = 'ForumHooksHelper::onOasisAddPageDeletedConfirmationMessage';
$GLOBALS['wgHooks']['FilePageImageUsageSingleLink'][] = 'ForumHooksHelper::onFilePageImageUsageSingleLink';
$GLOBALS['wgHooks']['AfterPageHeaderPageSubtitle'][] = 'ForumHooksHelper::onAfterPageHeaderPageSubtitle';
$GLOBALS['wgHooks']['PageHeaderActionButtonShouldDisplay'][] = 'ForumHooksHelper::onPageHeaderActionButtonShouldDisplay';

// notification hooks
$GLOBALS['wgHooks']['NotificationGetNotificationMessage'][] = 'ForumNotificationPlugin::onGetNotificationMessage';

// forum discussion on article
// It need to be first one !!!
array_splice( $GLOBALS['wgHooks']['OutputPageBeforeHTML'], 0, 0, 'ForumHooksHelper::onOutputPageBeforeHTML' );

$GLOBALS['wgHooks']['WallAction'][] = 'ForumHooksHelper::onWallAction';
$GLOBALS['wgHooks']['WallBeforeStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';
$GLOBALS['wgHooks']['WallAfterStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';

$GLOBALS['wgHooks']['ArticleFromTitle'][] = 'ForumHooksHelper::onArticleFromTitle';

// For activity module tag
$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'ForumHooksHelper::onParserFirstCallInit';

// Hook for topic red links
$GLOBALS['wgHooks']['LinkBegin'][] = 'ForumHooksHelper::onLinkBegin';

// Fix URLs of thread pages when purging them.
$GLOBALS['wgHooks']['TitleGetSquidURLs'][] = 'ForumHooksHelper::onTitleGetSquidURLs';
$GLOBALS['wgHooks']['ArticleCommentGetSquidURLs'][] = 'ForumHooksHelper::onArticleCommentGetSquidURLs';

// SUS-1196: Invalidate "Forum Activity" rail module when deleting a thread via Nuke / Quick Tools
$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'ForumHooksHelper::onArticleDeleteComplete';

// SUS-260: Prevent moving pages within, into or out of Forum namespaces
$GLOBALS['wgHooks']['MWNamespace:isMovable'][] = 'ForumHooksHelper::onNamespaceIsMovable';

$GLOBALS['wgHooks']['AfterPageHeaderButtons'][] = 'ForumHooksHelper::onAfterPageHeaderButtons';

include ( $dir . '/Forum.namespace.setup.php' );

// add this namespace to list of wall namespaces
$app->registerNamespaceController( NS_WIKIA_FORUM_BOARD, 'ForumController', 'board', true );
$app->registerNamespaceController( NS_WIKIA_FORUM_TOPIC_BOARD, 'ForumController', 'board',
	true );

JSMessages::registerPackage( 'Forum', [
	'back',
	'forum-specialpage-policies-edit',
	'forum-specialpage-policies'
] );
