<?php

$wgExtensionCredits['parserTag'][] = [
	'name' => 'Twitter Tag',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TwitterTag',
	'author' => [
		'[http://community.wikia.com/wiki/User:TyA TyA]',
		'X-Wing Team @ Wikia',
	],
	'descriptionmsg' => 'twittertag-desc',
];

$wgAutoloadClasses['TwitterTagController'] = __DIR__ . '/TwitterTagController.class.php';

$wgExtensionMessagesFiles['TwitterTag'] = __DIR__ . '/TwitterTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'TwitterTagController::onParserFirstCallInit';

