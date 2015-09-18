<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Google Form Tag Extension',
	'author' => [
		'X-Wing Team @Wikia',
	],
	'descriptionmsg' => 'google-form-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GoogleFormTag',
];

$wgAutoloadClasses['GoogleFormTagController'] = __DIR__ . '/GoogleFormTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'GoogleFormTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['GoogleFormTag'] = __DIR__ . '/GoogleFormTag.i18n.php';
