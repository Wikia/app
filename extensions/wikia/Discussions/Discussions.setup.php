<?php

/**
 * Discussions
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

// load classes
$wgAutoloadClasses['SpecialDiscussionsController'] = __DIR__ . '/controllers/SpecialDiscussionsController.class.php';
$wgAutoloadClasses['EnableDiscussionsController'] = __DIR__ . '/controllers/EnableDiscussionsController.class.php';
$wgAutoloadClasses['DiscussionsVarToggler'] = __DIR__ . '/DiscussionsVarToggler.class.php';
$wgAutoloadClasses['DiscussionsVarTogglerException'] = __DIR__ . '/DiscussionsVarToggler.class.php';
$wgAutoloadClasses['ThreadCreator'] = __DIR__ . '/api/ThreadCreator.class.php';
$wgAutoloadClasses['DiscussionsActivator'] = __DIR__ . '/api/DiscussionsActivator.class.php';
$wgAutoloadClasses['DiscussionsActivity'] = __DIR__ . '/api/DiscussionsActivity.class.php';
$wgAutoloadClasses['LegacyRedirect'] = __DIR__ . '/api/LegacyRedirect.class.php';
$wgAutoloadClasses['StaffWelcomePoster'] = __DIR__ . '/maintenance/StaffWelcomePoster.class.php';
$wgAutoloadClasses['DiscussionsHooksHelper'] = __DIR__ . '/DiscussionsHooksHelper.php';

// register special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

//// This will cause /wiki/Special:Forum to redirect to Discussions when Discussions
//// is enabled and Forums are disabled.
//if ( !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ) {
//	$wgAutoloadClasses['SpecialForumRedirectController'] = __DIR__ . '/controllers/SpecialForumRedirectController.class.php';
//	$wgHooks['ArticleViewHeader'][] = 'SpecialForumRedirectController::onArticleViewHeader';
//	$wgHooks['BeforePageHistory'][] = 'SpecialForumRedirectController::onBeforePageHistory';
//	$wgHooks['LinkBegin'][] = 'DiscussionsHooksHelper::onLinkBegin';
//	$wgSpecialPages['Forum'] = 'SpecialForumRedirectController';
//
//	// IRIS-5184: Exclude outgoing links in Forum content from Special:WhatLinksHere and Special:WantedPages
//	$wgHooks['SpecialWhatLinksHere::beforeQuery'][] = 'DiscussionsHooksHelper::onSpecialWhatLinksHereBeforeQuery';
//	$wgHooks['WantedPages::getExcludedSourceNamespaces'][] = 'DiscussionsHooksHelper::onWantedPagesGetExcludedSourceNamespaces';
//
//	// Make sure we recognize the Forum namespaces so we can redirect them if requested
//	$wgExtensionNamespacesFiles['Discussions'] = __DIR__ . '/../Forum/Forum.namespaces.php';
//	wfLoadExtensionNamespaces( 'Forum', [
//		NS_WIKIA_FORUM_BOARD,
//		NS_WIKIA_FORUM_BOARD_THREAD,
//		NS_WIKIA_FORUM_TOPIC_BOARD
//		]
//	);
//	$app->registerNamespaceController(
//		NS_WIKIA_FORUM_BOARD,
//		'SpecialForumRedirectController',
//		'redirectBoardToCategory'
//	);
//}

// message files
$wgExtensionMessagesFiles['SpecialDiscussions'] = __DIR__ . '/i18n/SpecialDiscussions.i18n.php';
$wgExtensionMessagesFiles['StaffWelcomePost'] = __DIR__ . '/i18n/StaffWelcomePost.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['soap']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = true;
$wgGroupPermissions['staff']['specialdiscussions'] = true;
$wgGroupPermissions['wiki-manager']['specialdiscussions'] = true;

$wgHooks['WikiaSkinTopScripts'][] = 'DiscussionsHooksHelper::addDiscussionJsVariable';
$wgHooks['BeforePageDisplay'][] = 'DiscussionsHooksHelper::onBeforePageDisplay';

$wgResourceModules['ext.wikia.Disucssions.migration'] = [
	'messages' => [
		'before-forum-to-discussions-migration-message',
		'in-progress-forum-to-discussions-migration-message',
		'after-forum-to-discussions-migration-message',
	],
	'scripts' => [
		'scripts/forumMigration.js',
	],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Discussions',
];

$urlProvider = new \Wikia\Service\Gateway\KubernetesExternalUrlProvider();
$wgDiscussionsApiUrl = $urlProvider->getUrl( 'discussion' );
