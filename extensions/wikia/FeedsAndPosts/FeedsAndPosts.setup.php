<?php
/**
 * Feeds and Posts
 * Injects discussion feed into an article page
 */

$dir = dirname( __FILE__ ) . '/';

// Autoload
$wgAutoloadClasses['FeedsAndPostsHooks'] = $dir . 'FeedsAndPostsHooks.class.php';

// Controllers
$wgAutoloadClasses['FeedsAndPostsController'] = $dir . 'FeedsAndPostsController.class.php';

// Hooks
$wgHooks['BeforePageDisplay'][] = 'FeedsAndPostsHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'FeedsAndPostsHooks::onMakeGlobalVariablesScript';

// Add new API controller to API controllers list
$wgWikiaApiControllers['FeedsAndPostsController'] = $dir . 'FeedsAndPostsController.class.php';

$wgAutoloadClasses['Wikia\FeedsAndPosts\JustUpdatedAPIProxy'] =
	$dir . 'JustUpdatedAPIProxy.class.php';
