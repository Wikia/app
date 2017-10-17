<?php
$wgExtensionMessagesFiles['ArticleVideo'] = __DIR__ . '/ArticleVideo.i18n.php';
$wgAutoloadClasses['ArticleVideoContext'] = __DIR__ . '/ArticleVideoContext.class.php';
$wgAutoloadClasses['ArticleVideoHooks'] = __DIR__ . '/ArticleVideo.hooks.php';
$wgAutoloadClasses['ArticleVideoController'] = __DIR__ . '/ArticleVideoController.class.php';
$wgAutoloadClasses['OoyalaBacklotApiService'] = __DIR__ . '/OoyalaBacklotApiService.class.php';
$wgAutoloadClasses['OoyalaConfigController'] = __DIR__ . '/OoyalaConfigController.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleVideoHooks::onBeforePageDisplay';
$wgHooks['InstantGlobalsGetVariables'][] = 'ArticleVideoHooks::onInstantGlobalsGetVariables';

$wgResourceModules['ext.ArticleVideo'] = [
	'messages' => [
		'articlevideo-watch',
	],
];

$wgResourceModules['ext.ArticleVideo.jw'] = [
	'scripts' => [
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.ads.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.instance.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.icons.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.autoplay.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.instant.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.tracking.js',
	],
];
