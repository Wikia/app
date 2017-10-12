<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Playbuzz Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'descriptionmsg' => 'playbuzz-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PlaybuzzTag',
];

$wgAutoloadClasses['PlaybuzzTagController'] =  __DIR__ . '/PlaybuzzTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'PlaybuzzTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['PlaybuzzTag'] = __DIR__ . '/PlaybuzzTag.i18n.php';
