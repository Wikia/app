<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Weibo Tag Extension',
	'author' => 'X-Wing @Wikia',
	'descriptionmsg' => 'weibo-tag-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WeiboTag',
];

// Autoload
$wgAutoloadClasses['WeiboTagController'] =  __DIR__ . '/WeiboTagController.class.php';
$wgAutoloadClasses['WeiboTagValidator'] =  __DIR__ . '/WeiboTagValidator.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'WeiboTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['WeiboTag'] = __DIR__ . '/WeiboTag.i18n.php';
