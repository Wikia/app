<?php
/**
 * Update dataware.pages table with information about local wiki articles
 */

$GLOBALS['wgAutoloadClasses']['PagesHooks'] = __DIR__ . '/PagesHooks.php';
$GLOBALS['wgAutoloadClasses']['UpdatePagesTask'] = __DIR__ . '/UpdatePagesTask.php';

$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'PagesHooks::onArticleDeleteComplete';
$GLOBALS['wgHooks']['TitleMoveComplete'][] = 'PagesHooks::onTitleMoveComplete';
$GLOBALS['wgHooks']['NewRevisionFromEditComplete'][] = 'PagesHooks::onNewRevisionFromEditComplete';
$GLOBALS['wgHooks']['ArticleUndeleteComplete'][] = 'PagesHooks::onArticleUndeleteComplete';
