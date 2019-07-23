<?php
$wgExtensionMessagesFiles['ArticleVideo'] = __DIR__ . '/ArticleVideo.i18n.php';
$wgAutoloadClasses['ArticleVideoContext'] = __DIR__ . '/ArticleVideoContext.class.php';
$wgAutoloadClasses['ArticleVideoHooks'] = __DIR__ . '/ArticleVideo.hooks.php';
$wgAutoloadClasses['ArticleVideoController'] = __DIR__ . '/ArticleVideoController.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleVideoHooks::onBeforePageDisplay';
$wgHooks['InstantGlobalsGetVariables'][] = 'ArticleVideoHooks::onInstantGlobalsGetVariables';
$wgHooks['GetPreferences'][] = '\ArticleVideoHooks::onGetPreferences';

$wgResourceModules['ext.ArticleVideo.jw'] = [
	'scripts' => [
		'skins/oasis/js/jwplayer/node_modules/jwplayer-fandom/dist/wikiajwplayer.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.autoplay.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.cookies.js',
		'extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.instant.js',
	],
];

$wgExtensionFunctions[] = function () {
	JSMessages::registerPackage( 'ArticleVideo', [
		'articlevideo-attribution-from',
	] );
};

JSMessages::enqueuePackage( 'ArticleVideo', JSMessages::EXTERNAL );
