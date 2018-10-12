<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

$wgExtensionCredits['other'][] = [
	'name' => 'AutoLogin Extension',
	'author' => [
		'Platform Team @Wikia',
	],
	'descriptionmsg' => 'autologin-tag-desc',
	'version' => '1',
	'url' => '',
];

$wgAutoloadClasses['AutoLoginService'] = __DIR__ . '/AutoLoginService.class.php';
$kubernetesExternalUrlProvider = new KubernetesExternalUrlProvider();
AutoLoginService::setKubernetesExternalUrlProvider($kubernetesExternalUrlProvider);
$wgHooks['WikiaSkinTopScripts'][] = 'AutoLoginService::addCookieSyncerJsVariable';
