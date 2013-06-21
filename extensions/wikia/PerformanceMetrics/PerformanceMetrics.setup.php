<?php

/**
 * Set of tools generating site performance metrics with a common interface
 *
 * Use /maintenance/wikia/getPerformanceMetrics.php script to generate a report
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

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
