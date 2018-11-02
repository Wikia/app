<?php
/**
 * Feeds and Posts
 * Injects discussion feed into an article page
 */

// Autoload
$wgAutoloadClasses['FeedsAndPostsHooks'] =  __DIR__ . '/FeedsAndPostsHooks.class.php';

// Hooks
$wgHooks['BeforePageDisplay'][] = 'FeedsAndPostsHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'FeedsAndPostsHooks::onMakeGlobalVariablesScript';
