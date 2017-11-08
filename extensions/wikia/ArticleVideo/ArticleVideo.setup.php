<?php
$wgExtensionMessagesFiles['ArticleVideo'] = __DIR__ . '/ArticleVideo.i18n.php';
$wgAutoloadClasses['ArticleVideoContext'] = __DIR__ . '/ArticleVideoContext.class.php';
$wgAutoloadClasses['ArticleVideoHooks'] = __DIR__ . '/ArticleVideo.hooks.php';
$wgAutoloadClasses['ArticleVideoController'] = __DIR__ . '/ArticleVideoController.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleVideoHooks::onBeforePageDisplay';
$wgHooks['InstantGlobalsGetVariables'][] = 'ArticleVideoHooks::onInstantGlobalsGetVariables';

$wgResourceModules['ext.ArticleVideo'] = [
	'messages' => [
		'articlevideo-watch',
	],
];

$wgResourceModules['ext.ArticleVideo.jw'] = [
	'scripts' => [
		'extensions/wikia/ArticleVideo/node_modules/jwplayer-fandom/dist/wikiajwplayer.js',
		'extensions/wikia/AdEngine/js/video/player/jwplayer/jwplayerTracker.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.ads.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.ads-tracking.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.autoplay.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.instant.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.moat-plugin.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.moat-tracking.js',
	],
];
