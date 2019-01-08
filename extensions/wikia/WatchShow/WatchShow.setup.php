<?php
/**
 * Watch Show
 * Inserts Watch This Show module in the right rail and in Mobile Wiki articles
 * @see IW-1470
 */

$dir = dirname( __FILE__ ) . '/';

// Autoload
$wgAutoloadClasses['WatchShowHooks'] = $dir . 'WatchShowHooks.class.php';

// Controllers
$wgAutoloadClasses['WatchShowService'] = $dir . 'WatchShowService.class.php';

// Hooks
$wgHooks['BeforePageDisplay'][] = 'WatchShowHooks::onBeforePageDisplay';
$wgHooks['MercuryWikiVariables'][] = 'WatchShowHooks::onMercuryWikiVariables';
