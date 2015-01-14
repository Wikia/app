<?php

/**
 * Set of tools generating site performance metrics with a common interface
 *
 * Use /maintenance/wikia/getPerformanceMetrics.php script to generate a report
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'PerformanceMetrics',
	'author' => 'Maciej Brencz (Macbre) <macbre at wikia-inc.com>',
	'descriptionmsg' => 'performance-metrics-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PerformanceMetrics',
);

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

//i18n
$wgExtensionMessagesFiles['PerformanceMetrics'] = $dir . '/PerformanceMetrics.i18n.php';

// generic classes
$wgAutoloadClasses['PerformanceMetrics'] =  $dir . '/PerformanceMetrics.class.php';
$wgAutoloadClasses['PerformanceMetricsProvider'] =  $dir . '/PerformanceMetricsProvider.class.php';

// providers
$wgAutoloadClasses['PerformanceMetricsGooglePageSpeed'] =  $dir . '/providers/PerformanceMetricsGooglePageSpeed.class.php';
$wgAutoloadClasses['PerformanceMetricsPhantom'] =  $dir . '/providers/PerformanceMetricsPhantom.class.php';

// list of all available providers
$wgPerformanceMetricsProviders = array(
	'PerformanceMetricsGooglePageSpeed',
	'PerformanceMetricsPhantom'
);
