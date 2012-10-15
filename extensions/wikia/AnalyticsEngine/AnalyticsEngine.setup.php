<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan'
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['iAnalyticsProvider'] = "$dir/iAnalyticsProvider.php";
$wgAutoloadClasses['AnalyticsEngine'] = "$dir/AnalyticsEngine.php";
$wgAutoloadClasses['AnalyticsProviderQuantServe'] = "$dir/AnalyticsProviderQuantServe.php";
$wgAutoloadClasses['AnalyticsProviderGA_Urchin'] = "$dir/AnalyticsProviderGA_Urchin.php";
$wgAutoloadClasses['AnalyticsProviderComscore'] = "$dir/AnalyticsProviderComscore.php";
$wgAutoloadClasses['AnalyticsProviderExelate'] = "$dir/AnalyticsProviderExelate.php";
$wgAutoloadClasses['AnalyticsProviderGAS'] = "$dir/AnalyticsProviderGAS.php";
$wgAutoloadClasses['AnalyticsProviderIVW'] = "$dir/AnalyticsProviderIVW.php";

//hooks
//register hook to inject gas js library (MW 1.19)
$wgHooks['WikiaSkinTopScripts'][] = 'AnalyticsProviderGAS::onWikiaSkinTopScripts';

//register hook for WikiaMobile skin to get the asset as part of the head js package in one request
$wgHooks['WikiaMobileAssetsPackages'][] = 'AnalyticsProviderGAS::onWikiaMobileAssetsPackages';