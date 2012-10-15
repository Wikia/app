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
$app = F::build('App');

// generic classes
$app->registerClass('PerformanceMetrics', $dir . '/PerformanceMetrics.class.php');
$app->registerClass('PerformanceMetricsProvider', $dir . '/PerformanceMetricsProvider.class.php');

// providers
$app->registerClass('PerformanceMetricsGooglePageSpeed', $dir . '/providers/PerformanceMetricsGooglePageSpeed.class.php');
$app->registerClass('PerformanceMetricsPhantom', $dir . '/providers/PerformanceMetricsPhantom.class.php');

// list of all available providers
$wgPerformanceMetricsProviders = array(
	'PerformanceMetricsGooglePageSpeed',
	'PerformanceMetricsPhantom'
);
