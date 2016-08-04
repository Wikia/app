<?php

// autoload
$wgAutoloadClasses['LocalSitemapPageArticle'] = __DIR__ . '/LocalSitemapPageArticle.class.php';
$wgAutoloadClasses['LocalSitemapPageHooks'] = __DIR__ . '/LocalSitemapPageHooks.class.php';
$wgAutoloadClasses['LocalSitemapSpecialPage'] = __DIR__ . '/LocalSitemapSpecialPage.class.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'LocalSitemapPageHooks::onArticleFromTitle';
$wgHooks['PageHeaderPageTypePrepared'][] = 'LocalSitemapPageHooks::onPageHeaderPageTypePrepared';
