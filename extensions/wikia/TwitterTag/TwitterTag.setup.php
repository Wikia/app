<?php

$wgExtensionCredits['parserTag'][] = [
	'name' => 'Twitter Tag',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TwitterTag',
	'author' => [
		'[http://community.wikia.com/wiki/User:TyA TyA]',
		'[http://community.wikia.com/wiki/User:Sactage sactage]',
		'X-Wing Team @ Wikia',
	],
	'descriptionmsg' => 'twitter-tag-desc',
];

$wgAutoloadClasses['TwitterTagController'] = __DIR__ . '/TwitterTagController.class.php';

$wgExtensionMessagesFiles['TwitterTag'] = __DIR__ . '/TwitterTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'TwitterTagController::onParserFirstCallInit';

$wgResourceModules['ext.TwitterTag'] = [
	'scripts' => 'scripts/twitter.min.js',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/TwitterTag'
];

