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
$wgAutoloadClasses['ForumHelper'] =  $dir . 'ForumHelper.class.php' ;
$wgAutoloadClasses['ForumExternalController'] =  $dir . 'ForumExternalController.class.php' ;
$wgAutoloadClasses['RelatedForumDiscussionController'] =  $dir . 'RelatedForumDiscussionController.class.php' ;

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
$wgHooks['ArticleInsertComplete'][] = 'ForumHooksHelper::onArticleInsertComplete';
$wgHooks['WallBeforeRenderThread'][] = 'ForumHooksHelper::onWallBeforeRenderThread';
$wgHooks['AfterBuildNewMessageAndPost'][] = 'ForumHooksHelper::onAfterBuildNewMessageAndPost';
$wgHooks['WallMessageDeleted'][] = 'ForumHooksHelper::onWallMessageDeleted';
$wgHooks['ContributionsLineEnding'][] = 'ForumHooksHelper::onContributionsLineEnding';
$wgHooks['OasisAddPageDeletedConfirmationMessage'][] = 'ForumHooksHelper::onOasisAddPageDeletedConfirmationMessage';
$wgHooks['FilePageImageUsageSingleLink'][] = 'ForumHooksHelper::onFilePageImageUsageSingleLink';

// notification hooks
$wgHooks['NotificationGetNotificationMessage'][] = 'ForumNotificationPlugin::onGetNotificationMessage';

// old forum archive
$wgHooks['getUserPermissionsErrors'][] = 'ForumHooksHelper::onGetUserPermissionsErrors';
$wgHooks['PageHeaderIndexAfterActionButtonPrepared'][] = 'ForumHooksHelper::onPageHeaderIndexAfterActionButtonPrepared';
$wgHooks['ArticleViewHeader'][] = 'ForumHooksHelper::onArticleViewHeader';

// make sure that when an article is deleted, if it has a comments_index,
// that record is properly marked as deleted. this needs to happen within
// the transaction in  WikiPage::doDeleteArticleReal which is why it's being hooked
// here and not in ArticleDeleteComplete
$wgHooks['ArticleDoDeleteArticleBeforeLogEntry'][] = 'ForumHooksHelper::onArticleDoDeleteArticleBeforeLogEntry';


// forum discussion on article
// It need to be first one !!!
array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'ForumHooksHelper::onOutputPageBeforeHTML' );

$wgHooks['WallAction'][] = 'ForumHooksHelper::onWallAction';
$wgHooks['WallBeforeStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';
$wgHooks['WallAfterStoreRelatedTopicsInDB'][] = 'ForumHooksHelper::onWallStoreRelatedTopicsInDB';

$wgHooks['ArticleFromTitle'][] = 'ForumHooksHelper::onArticleFromTitle';
$wgHooks['ArticleRobotPolicy'][] = 'ForumHooksHelper::onArticleRobotPolicy';

// For activity module tag
$wgHooks['ParserFirstCallInit'][] = 'ForumHooksHelper::onParserFirstCallInit';

// Hook for topic red links
$wgHooks['LinkBegin'][] = 'ForumHooksHelper::onLinkBegin';

// Fix URLs of thread pages when purging them.
$wgHooks['TitleGetSquidURLs'][] = 'ForumHooksHelper::onTitleGetSquidURLs';
$wgHooks['ArticleCommentGetSquidURLs'][] = 'ForumHooksHelper::onArticleCommentGetSquidURLs';

include ( $dir . '/Forum.namespace.setup.php' );

// add this namespace to list of wall namespaces
$app->registerNamespaceControler( NS_WIKIA_FORUM_BOARD, 'ForumController', 'board', true );
$app->registerNamespaceControler( NS_WIKIA_FORUM_TOPIC_BOARD, 'ForumController', 'board', true );

JSMessages::registerPackage( 'Forum', [
	'back',
	'forum-specialpage-policies-edit',
	'forum-specialpage-policies'
] );
