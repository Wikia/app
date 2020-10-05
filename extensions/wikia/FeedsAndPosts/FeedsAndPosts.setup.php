<?php
/**
 * Feeds and Posts
 * Injects discussion feed into an article page
 */

$dir = dirname( __FILE__ ) . '/';

// Autoload
$wgAutoloadClasses['FeedsAndPostsHooks'] = $dir . 'FeedsAndPostsHooks.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\RecentChanges'] = $dir . 'RecentChanges.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\TopArticles'] = $dir . 'TopArticles.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\Thumbnails'] = $dir . 'Thumbnails.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\ThemeSettings'] = $dir . 'ThemeSettings.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\WikiVariables'] = $dir . 'WikiVariables.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\ArticleData'] = $dir . 'ArticleData.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\WikiDetails'] = $dir . 'WikiDetails.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\ArticleTags'] = $dir . 'ArticleTags.class.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\Discussion\DiscussionGateway'] = $dir . 'Discussion/DiscussionGateway.php';
$wgAutoloadClasses['Wikia\FeedsAndPosts\Discussion\UserInfoHelper'] = $dir . 'Discussion/UserInfoHelper.php';


// Controllers
$wgAutoloadClasses['FeedsAndPostsController'] = $dir . 'FeedsAndPostsController.class.php';
$wgAutoloadClasses['DiscussionPollController'] = $dir . 'Discussion/DiscussionPollController.php';
$wgAutoloadClasses['DiscussionVoteController'] = $dir . 'Discussion/DiscussionVoteController.php';

// Hooks
$wgHooks['BeforePageDisplay'][] = 'FeedsAndPostsHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'FeedsAndPostsHooks::onMakeGlobalVariablesScript';

// Add new API controller to API controllers list
$wgWikiaApiControllers['FeedsAndPostsController'] = $dir . 'FeedsAndPostsController.class.php';

$wgExtensionMessagesFiles['FeedsAndPosts'] = $dir . 'FeedsAndPosts.i18n.php';
