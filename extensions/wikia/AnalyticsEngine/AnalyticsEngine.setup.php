<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan'
);

// autoloaded classes
$wgAutoloadClasses['iAnalyticsProvider'] = __DIR__ . '/iAnalyticsProvider.php';
$wgAutoloadClasses['AnalyticsEngine'] = __DIR__ . '/AnalyticsEngine.php';
$wgAutoloadClasses['AnalyticsProviderQuantServe'] = __DIR__ . '/AnalyticsProviderQuantServe.php';
$wgAutoloadClasses['AnalyticsProviderGA_Urchin'] = __DIR__ . '/AnalyticsProviderGA_Urchin.php';
$wgAutoloadClasses['AnalyticsProviderComscore'] = __DIR__ . '/AnalyticsProviderComscore.php';
$wgAutoloadClasses['AnalyticsProviderExelate'] = __DIR__ . '/AnalyticsProviderExelate.php';
$wgAutoloadClasses['AnalyticsProviderGAS'] = __DIR__ . '/AnalyticsProviderGAS.php';
$wgAutoloadClasses['AnalyticsProviderIVW'] = __DIR__ . '/AnalyticsProviderIVW.php';
$wgAutoloadClasses['AnalyticsProviderAmazonDirectTargetedBuy'] = __DIR__ . '/AnalyticsProviderAmazonDirectTargetedBuy.php';
$wgAutoloadClasses['AnalyticsProviderDynamicYield'] = __DIR__ . '/AnalyticsProviderDynamicYield.php';

//hooks
//register hook to inject gas js library (MW 1.19)
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderGAS::onWikiaSkinTopScripts';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AnalyticsProviderGAS::onOasisSkinAssetGroupsBlocking';

//register hook for WikiaMobile skin to get the asset as part of the head js package in one request
$wgHooks['WikiaMobileAssetsPackages'][] = 'AnalyticsProviderGAS::onWikiaMobileAssetsPackages';
