<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan',
	'description-msg' => 'analyticsengine-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AnalyticsEngine',
);

//i18n
$wgExtensionMessagesFiles['AnalyticsEngine'] = __DIR__ . '/i18n/AnalyticsEngine.i18n.php';

// autoloaded classes
$wgAutoloadClasses['iAnalyticsProvider'] = __DIR__ . '/iAnalyticsProvider.php';
$wgAutoloadClasses['AnalyticsEngine'] = __DIR__ . '/AnalyticsEngine.php';
$wgAutoloadClasses['AnalyticsProviderQuantServe'] = __DIR__ . '/AnalyticsProviderQuantServe.php';
$wgAutoloadClasses['AnalyticsProviderComscore'] = __DIR__ . '/AnalyticsProviderComscore.php';
$wgAutoloadClasses['AnalyticsProviderExelate'] = __DIR__ . '/AnalyticsProviderExelate.php';
$wgAutoloadClasses['AnalyticsProviderA9'] = __DIR__ . '/AnalyticsProviderA9.php';
$wgAutoloadClasses['AnalyticsProviderDynamicYield'] = __DIR__ . '/AnalyticsProviderDynamicYield.php';
$wgAutoloadClasses['AnalyticsProviderGoogleFundingChoices'] = __DIR__ . '/AnalyticsProviderGoogleFundingChoices.php';
$wgAutoloadClasses['AnalyticsProviderGoogleUA'] = __DIR__ . '/AnalyticsProviderGoogleUA.php';
$wgAutoloadClasses['AnalyticsProviderKrux'] = __DIR__ . '/AnalyticsProviderKrux.php';
$wgAutoloadClasses['AnalyticsProviderNielsen'] = __DIR__ . '/AnalyticsProviderNielsen.php';
$wgAutoloadClasses['AnalyticsProviderPrebid'] = __DIR__ . '/AnalyticsProviderPrebid.php';
$wgAutoloadClasses['AnalyticsProviderNetzAthleten'] = __DIR__ . '/AnalyticsProviderNetzAthleten.php';

//hooks
//register hook to inject GA js library (MW 1.19)
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderGoogleFundingChoices::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderGoogleUA::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderNielsen::onWikiaSkinTopScripts';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AnalyticsProviderGoogleUA::onOasisSkinAssetGroupsBlocking';
$wgHooks['InstantGlobalsGetVariables'][] = 'AnalyticsProviderGoogleFundingChoices::onInstantGlobalsGetVariables';

//register hook for WikiaMobile skin to get the asset as part of the head js package in one request
$wgHooks['WikiaMobileAssetsPackages'][] = 'AnalyticsProviderGoogleUA::onWikiaMobileAssetsPackages';
