<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'PollSnack Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'descriptionmsg' => 'pollsnack-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PollSnackTag',
];

$wgAutoloadClasses['PollSnackTagController'] =  __DIR__ . '/PollSnackTagController.class.php';
$wgAutoloadClasses['PollSnackTagValidator'] =  __DIR__ . '/PollSnackTagValidator.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'PollSnackTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['PollSnackTag'] = __DIR__ . '/PollSnackTag.i18n.php';
