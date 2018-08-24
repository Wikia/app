<?php
$wgExtensionCredits['other'][] = [
	'name' => 'CookieSyncer Extension',
	'author' => [
		'Platform Team @Wikia',
	],
	'descriptionmsg' => 'cookiesyncer-tag-desc',
	'version' => '1',
	'url' => '',
];
$wgAutoloadClasses['CookieSyncerService'] = __DIR__ . '/CookieSyncerService.class.php';
