<?php
$wgExtensionCredits['other'][] = [
	'name' => 'CookieSyncer Extension',
	'author' => [
		'Platform Team @Wikia',
	],
	'description' => 'Sync cookies between wikia.com and fandom.com',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CookieSyncer'
];

$wgAutoloadClasses['CookieSyncerHooks'] = __DIR__ . '/CookieSyncerHooks.class.php';

$wgHooks['WikiaSkinTopScripts'][] = 'CookieSyncerHooks::addCookieSyncerJsVariable';
$wgHooks['BeforePageDisplay'][] = 'CookieSyncerHooks::onBeforePageDisplay';

$urlProvider = new \Wikia\Service\Gateway\KubernetesExternalUrlProvider();
$wgCookieSyncerApiUrl = $urlProvider->getUrl( 'cookie-syncer' ) . '/frame';
