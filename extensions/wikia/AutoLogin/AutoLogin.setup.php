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
$wgAutoloadClasses['AutoLoginHooks'] = __DIR__ . '/AutoLoginHooks.class.php';
$kubernetesExternalUrlProvider = new KubernetesExternalUrlProvider();
AutoLoginService::setKubernetesExternalUrlProvider( $kubernetesExternalUrlProvider );
AutoLoginHooks::setKubernetesExternalUrlProvider( $kubernetesExternalUrlProvider );
$wgHooks['WikiaSkinTopScripts'][] = 'AutoLoginHooks::onWikiaSkinTopScripts';
