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
$wgAutoloadClasses['AnalyticsProviderGA_Urchin'] = __DIR__ . '/AnalyticsProviderGA_Urchin.php';
$wgAutoloadClasses['AnalyticsProviderComscore'] = __DIR__ . '/AnalyticsProviderComscore.php';
$wgAutoloadClasses['AnalyticsProviderExelate'] = __DIR__ . '/AnalyticsProviderExelate.php';
$wgAutoloadClasses['AnalyticsProviderGAS'] = __DIR__ . '/AnalyticsProviderGAS.php';
$wgAutoloadClasses['AnalyticsProviderAmazonMatch'] = __DIR__ . '/AnalyticsProviderAmazonMatch.php';
$wgAutoloadClasses['AnalyticsProviderDynamicYield'] = __DIR__ . '/AnalyticsProviderDynamicYield.php';
$wgAutoloadClasses['AnalyticsProviderIVW2'] = __DIR__ . '/AnalyticsProviderIVW2.php';
$wgAutoloadClasses['AnalyticsProviderBlueKai'] = __DIR__ . '/AnalyticsProviderBlueKai.php';
$wgAutoloadClasses['AnalyticsProviderDatonics'] = __DIR__ . '/AnalyticsProviderDatonics.php';
$wgAutoloadClasses['AnalyticsProviderClarityRay'] = __DIR__ . '/AnalyticsProviderClarityRay.php';
$wgAutoloadClasses['AnalyticsProviderPageFair'] = __DIR__ . '/AnalyticsProviderPageFair.php';
$wgAutoloadClasses['AnalyticsProviderRubiconRTP'] = __DIR__ . '/AnalyticsProviderRubiconRTP.php';

//hooks
//register hook to inject gas js library (MW 1.19)
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderGAS::onWikiaSkinTopScripts';
$wgHooks['SkinAfterBottomScripts'][] = 'AnalyticsProviderClarityRay::onSkinAfterBottomScripts';
$wgHooks['SkinAfterBottomScripts'][] = 'AnalyticsProviderPageFair::onSkinAfterBottomScripts';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AnalyticsProviderGAS::onOasisSkinAssetGroupsBlocking';
$wgHooks['MakeGlobalVariablesScript'][] = 'AnalyticsProviderGAS::onMakeGlobalVariablesScript';
$wgHooks['InstantGlobalsGetVariables'][] = 'AnalyticsProviderIVW2::onInstantGlobalsGetVariables';

//register hook for WikiaMobile skin to get the asset as part of the head js package in one request
$wgHooks['WikiaMobileAssetsPackages'][] = 'AnalyticsProviderGAS::onWikiaMobileAssetsPackages';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AnalyticsProviderBlueKai::onWikiaMobileAssetsPackages';

// register hooks for Venus
$wgHooks['VenusAssetsPackages'][] = 'AnalyticsProviderGAS::onVenusAssetsPackages';
