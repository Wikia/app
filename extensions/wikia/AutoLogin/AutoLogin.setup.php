<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'AutLogin Extension',
	'author' => [
		'Platform Team @Wikia',
	],
	'descriptionmsg' => 'autologin-tag-desc',
	'version' => '1',
	'url' => '',
];

$wgAutoloadClasses['AutoLoginController'] = __DIR__ . '/AutoLoginController.class.php';
