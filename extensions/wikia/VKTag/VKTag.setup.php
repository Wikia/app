<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'VK Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'descriptionmsg' => 'vk-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/VKTag',
];

$wgAutoloadClasses['VKTagController'] =  __DIR__ . '/VKTagController.class.php';
$wgAutoloadClasses['VKTagValidator'] =  __DIR__ . '/VKTagValidator.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'VKTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['VKTag'] = __DIR__ . '/VKTag.i18n.php';

$wgResourceModules['ext.wikia.VKTag'] = [
	'skinScripts' => [
		'oasis' => [
			'js/VKTag.js'
		]
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/VKTag'
];
