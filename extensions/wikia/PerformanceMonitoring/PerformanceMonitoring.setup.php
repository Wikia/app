<?php
/**
 * Real User Monitoring
 */

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'PerformanceMonitoring',
	'author' => 'Fandom, Inc.',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PerformanceMonitoring',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['PerformanceMonitoringHooks'] =  $dir . 'PerformanceMonitoringHooks.class.php';

$wgHooks['MercuryWikiVariables'][] = 'PerformanceMonitoringHooks::onMercuryWikiVariables';

