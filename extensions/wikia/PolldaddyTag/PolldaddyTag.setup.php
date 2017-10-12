<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Polldaddy Tag Extension',
	'author' => [
		'X-Wing Team @Wikia'
	],
	'descriptionmsg' => 'polldaddy-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PolldaddyTag',
];

$wgAutoloadClasses['PolldaddyTagController'] = __DIR__ . '/PolldaddyTagController.class.php';
$wgAutoloadClasses['PolldaddyTagValidator'] = __DIR__ . '/PolldaddyTagValidator.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'PolldaddyTagController::onParserFirstCallInit';
$wgHooks['WikiaMobileAssetsPackages'][] = 'PolldaddyTagController::onWikiaMobileAssetsPackages';

// i18n
$wgExtensionMessagesFiles['PolldaddyTag'] = __DIR__ . '/PolldaddyTag.i18n.php';
