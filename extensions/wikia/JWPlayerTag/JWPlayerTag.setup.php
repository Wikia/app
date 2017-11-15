<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'JWPlayer Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/JWPlayerTag',
];

$wgAutoloadClasses['JWPlayerTagController'] =  __DIR__ . '/JWPlayerTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'JWPlayerTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['JWPlayerTag'] = __DIR__ . '/JWPlayerTag.i18n.php';
