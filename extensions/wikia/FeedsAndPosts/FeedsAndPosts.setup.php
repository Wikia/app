<?php
/**
 * Feeds and Posts
 * Injects discussion feed into an article page
 */

// Autoload
$wgAutoloadClasses['FeedsAndPostsHooks'] =  __DIR__ . '/FeedsAndPostsHooks.class.php';

// Hooks
$wgHooks['OasisSkinAssetGroups'][] = 'FeedsAndPostsHooks::onOasisSkinAssetGroups';

$wgResourceModules['ext.wikia.feedsAndPosts'] = [
	'scripts' => 'js/feedsAndPosts.js',
];
