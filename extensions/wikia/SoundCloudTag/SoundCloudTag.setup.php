<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'SoundCloud Tag Extension',
	'author' => [
		'X-Wing Team @Wikia',
		'TK-999'
	],
	'descriptionmsg' => 'soundcloud-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SoundCloudTag',
];

$wgAutoloadClasses['SoundCloudTagController'] =  __DIR__ . '/SoundCloudTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'SoundCloudTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['SoundCloudTag'] = __DIR__ . '/SoundCloudTag.i18n.php';
