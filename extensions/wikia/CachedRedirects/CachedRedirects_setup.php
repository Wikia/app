<?php

$wgExtensionCredits['other'][] = array(
	'name'				=> 'cached redirects',
	'version'			=> '0.1',
	'descriptionmsg'	=> 'cachedredirects-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CachedRedirects',
);

$dir = dirname(__FILE__) . '/';


//classes
$wgAutoloadClasses['CachedRedirects'] =  $dir . 'CachedRedirects.class.php';

//hooks
$wgHooks['UndeleteComplete'][] = 'CachedRedirects::onUndeleteComplete';
$wgHooks['ArticleDeleteComplete'][] = 'CachedRedirects::onArticleDeleteComplete';
$wgHooks['ArticleSaveComplete'][] = 'CachedRedirects::onArticleSaveComplete';
$wgHooks['ArticleGetFileLinks'][] = 'CachedRedirects::onGetFileLinks';

