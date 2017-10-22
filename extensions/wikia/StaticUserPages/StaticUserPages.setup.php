<?php

/**
 * This extension is used to render user pages for bot accounts using content stored in i18n messages.
 *
 * @see SUS-1587
 */

$wgAutoloadClasses['StaticUserPagesHooks'] = __DIR__ . '/StaticUserPagesHooks.class.php';
$wgAutoloadClasses['StaticUserPagesArticle'] = __DIR__ . '/StaticUserPagesArticle.class.php';

$wgHooks['ArticleFromTitle'][] =  'StaticUserPagesHooks::onArticleFromTitle';
