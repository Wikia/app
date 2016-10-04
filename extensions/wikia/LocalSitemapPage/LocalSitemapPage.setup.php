<?php

// autoload
$wgAutoloadClasses['LocalSitemapPageArticle'] = __DIR__ . '/LocalSitemapPageArticle.class.php';
$wgAutoloadClasses['LocalSitemapPageHelper'] = __DIR__ . '/LocalSitemapPageHelper.class.php';
$wgAutoloadClasses['LocalSitemapPageHooks'] = __DIR__ . '/LocalSitemapPageHooks.class.php';
$wgAutoloadClasses['LocalSitemapSpecialPage'] = __DIR__ . '/LocalSitemapSpecialPage.class.php';

// i18n mapping
$wgExtensionMessagesFiles['LocalSitemapPage'] = __DIR__ . '/LocalSitemapPage.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'LocalSitemapPageHooks::onArticleFromTitle';
$wgHooks['PageHeaderPageTypePrepared'][] = 'LocalSitemapPageHooks::onPageHeaderPageTypePrepared';
