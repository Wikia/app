<?php

/**
 * Sitemap Page
 *
 * @author Saipetch Kongkatong
 */

$wgExtensionCredits['sitemappage'][] = [
	'name' => 'SitemapPage',
	'author' => ['Saipetch Kongkatong'],
	'descriptionmsg' => 'sitemap-page-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SitemapPage'
];

$dir = dirname( __FILE__ ) . '/';

// autoload
$wgAutoloadClasses['SitemapPageController'] =  $dir . 'SitemapPageController.class.php';
$wgAutoloadClasses['SitemapPageModel'] = $dir . 'SitemapPageModel.class.php';
$wgAutoloadClasses['SitemapPageArticle'] = $dir . 'SitemapPageArticle.class.php';
$wgAutoloadClasses['SitemapPageHooks'] = $dir . 'SitemapPageHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['SitemapPage'] = $dir . 'SitemapPage.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'SitemapPageHooks::onArticleFromTitle';
