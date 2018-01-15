<?php
/**
 * Update dataware.pages table with information about local wiki articles
 */

$GLOBALS['wgAutoloadClasses']['PagesEntry'] = __DIR__ . '/PagesEntry.php';
$GLOBALS['wgAutoloadClasses']['PagesHooks'] = __DIR__ . '/PagesHooks.php';
$GLOBALS['wgAutoloadClasses']['UpdatePagesTask'] = __DIR__ . '/UpdatePagesTask.php';

$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'PagesHooks::scheduleDeleteTask';
$GLOBALS['wgHooks']['NewRevisionFromEditComplete'][] = 'PagesHooks::scheduleUpdateTask';
$GLOBALS['wgHooks']['ArticleUndeleteComplete'][] = 'PagesHooks::scheduleUpdateTask';
