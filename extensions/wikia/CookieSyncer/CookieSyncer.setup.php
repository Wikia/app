<?php
$wgExtensionCredits['other'][] = [
	'name' => 'CookieSyncer Extension',
	'author' => [
		'Platform Team @Wikia',
	],
	'description' => 'Sync cookies between wikia.com and fandom.com',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CookieSyncer'
];
$wgAutoloadClasses['CookieSyncerService'] = __DIR__ . '/CookieSyncerService.class.php';
