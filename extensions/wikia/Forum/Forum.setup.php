<?php

/**
 * Forum
 *
 * @author Hyun Lim, Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Forum',
	'author' => [ 'Hyun Lim', 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Forum',
	'descriptionmsg' => 'forum-desc'
];

$dir = __DIR__ . '/';

// classes
$wgAutoloadClasses['ForumSpecialController'] =  $dir . 'ForumSpecialController.class.php' ;
$wgAutoloadClasses['ForumHooksHelper'] =  $dir . 'ForumHooksHelper.class.php' ;
$wgAutoloadClasses['ForumController'] =  $dir . 'ForumController.class.php' ;
$wgAutoloadClasses['ForumNotificationPlugin'] =  $dir . 'ForumNotificationPlugin.class.php' ;
$wgAutoloadClasses['Forum'] =  $dir . 'Forum.class.php' ;
$wgAutoloadClasses['ForumBoard'] =  $dir . 'ForumBoard.class.php' ;
$wgAutoloadClasses['ForumBoardInfo'] =  $dir . 'ForumBoardInfo.class.php' ;
$wgAutoloadClasses['ForumPostInfo'] =  $dir . 'ForumPostInfo.class.php' ;
$wgAutoloadClasses['ForumHelper'] =  $dir . 'ForumHelper.class.php' ;
$wgAutoloadClasses['ForumExternalController'] =  $dir . 'ForumExternalController.class.php' ;
$wgAutoloadClasses['RelatedForumDiscussionController'] =  $dir . 'RelatedForumDiscussionController.class.php' ;
$wgAutoloadClasses['ThreadWatchlistDeleteUpdate'] = $dir . 'ThreadWatchlistDeleteUpdate.php';

// i18n mapping
$wgExtensionMessagesFiles['Forum'] = $dir . 'Forum.i18n.php' ;
$wgExtensionMessagesFiles['ForumAliases'] = $dir . 'Forum.alias.php';

// special pages
$wgSpecialPages['Forum'] =  'ForumSpecialController';

// hooks
$wgHooks['AfterWallWikiActivityFilter'][] = 'ForumHooksHelper::onAfterWallWikiActivityFilter';
$wgHooks['WallContributionsLine'][] = 'ForumHooksHelper::onWallContributionsLine';
$wgHooks['getUserPermissionsErrors'][] = 'ForumHooksHelper::getUserPermissionsErrors';
$wgHooks['WallRecentchangesMessagePrefix'][] = 'ForumHooksHelper::onWallRecentchangesMessagePrefix';
$wgHooks['WallThreadHeader'][] = 'ForumHooksHelper::onWallThreadHeader';
$wgHooks['WallMessageGetWallOwnerName'][] = 'ForumHooksHelper::onWallMessageGetWallOwnerName';

$wgHooks['WallHistoryThreadHeader'][] = 'ForumHooksHelper::onWallHistoryThreadHeader';
$wgHooks['WallHistoryHeader'][] = 'ForumHooksHelper::onWallHistoryHeader';

$wgHooks['WallHeader'][] = 'ForumHooksHelper::onWallHeader';
$wgHooks['WallNewMessage'][] = 'ForumHooksHelper::onWallNewMessage';
$wgHooks['WallBeforeRenderThread'][] = 'ForumHooksHelper::onWallBeforeRenderThread';
$wgHooks['AfterBuildNewMessageAndPost'][] = 'ForumHooksHelper::onAfterBuildNewMessageAndPost';
$wgHooks['WallMessageDeleted'][] = 'ForumHooksHelper::onWallMessageDeleted';
$wgHooks['ContributionsLineEnding'][] = 'ForumHooksHelper::onContributionsLineEnding';
$wgHooks['OasisAddPageDeletedConfirmationMessage'][] = 'ForumHooksHelper::onOasisAddPageDeletedConfirmationMessage';
$wgHooks['FilePageImageUsageSingleLink'][] = 'ForumHooksHelper::onFilePageImageUsageSingleLink';
$wgHooks['AfterPageHeaderPageSubtitle'][] = 'ForumHooksHelper::onAfterPageHeaderPageSubtitle';
$wgHooks['PageHeaderActionButtonShouldDisplay'][] = 'ForumHooksHelper::onPageHeaderActionButtonShouldDisplay';

// notification hooks
$wgHooks['NotificationGetNotificationMessage'][] = 'ForumNotificationPlugin::onGetNotificationMessage';

// forum discussion on article
// It need to be first one !!!
array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'ForumHooksHelper::onOutputPageBeforeHTML' );

$wgHooks['WallAction'][] = 'ForumHooksHelper::onWallAction';
$wgHooks['WallBeforeStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';
$wgHooks['WallAfterStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';

$wgHooks['ArticleFromTitle'][] = 'ForumHooksHelper::onArticleFromTitle';

// For activity module tag
$wgHooks['ParserFirstCallInit'][] = 'ForumHooksHelper::onParserFirstCallInit';

// Hook for topic red links
$wgHooks['LinkBegin'][] = 'ForumHooksHelper::onLinkBegin';

// Fix URLs of thread pages when purging them.
$wgHooks['TitleGetSquidURLs'][] = 'ForumHooksHelper::onTitleGetSquidURLs';
$wgHooks['ArticleCommentGetSquidURLs'][] = 'ForumHooksHelper::onArticleCommentGetSquidURLs';

// SUS-1196: Invalidate "Forum Activity" rail module when deleting a thread via Nuke / Quick Tools
$wgHooks['ArticleDeleteComplete'][] = 'ForumHooksHelper::onArticleDeleteComplete';

// SUS-260: Prevent moving pages within, into or out of Forum namespaces
$wgHooks['MWNamespace:isMovable'][] = 'ForumHooksHelper::onNamespaceIsMovable';

$wgHooks['AfterPageHeaderButtons'][] = 'ForumHooksHelper::onAfterPageHeaderButtons';

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
