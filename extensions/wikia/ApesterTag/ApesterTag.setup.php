<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Apester Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'descriptionmsg' => 'apester-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ApesterTag',
];

$wgAutoloadClasses['ApesterTagController'] =  __DIR__ . '/ApesterTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'ApesterTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['ApesterTag'] = __DIR__ . '/ApesterTag.i18n.php';
