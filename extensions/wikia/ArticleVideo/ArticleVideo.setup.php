<?php
$wgExtensionMessagesFiles['ArticleVideo'] = __DIR__ . '/ArticleVideo.i18n.php';
$wgAutoloadClasses['ArticleVideoHooks'] = __DIR__ . '/ArticleVideo.hooks.php';
$wgAutoloadClasses['ArticleVideoController'] = __DIR__ . '/ArticleVideoController.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleVideoHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'ArticleVideoHooks::onMakeGlobalVariablesScript';

$wgResourceModules['ext.ArticleVideo'] = [
	'messages' => [
		'articlevideo-watch',
	],
];