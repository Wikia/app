<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

define( 'METRICS_REPORTING_VERSION', 0.1 );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MetricsReporting',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MetricsReporting',
	'author' => 'Sam Reed',
	'version' => METRICS_REPORTING_VERSION,
	'description' => 'Api for Wikimedia Metrics Reporting output',
);

$wgMetricAPIModules = array();

$wgMetricsDBserver         = '';
$wgMetricsDBname           = '';
$wgMetricsDBuser           = '';
$wgMetricsDBpassword       = '';
$wgMetricsDBtype           = 'mysql';
$wgMetricsDBprefix         = '';

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['ApiAnalytics'] = $dir . 'ApiAnalytics.php';
$wgAPIModules['analytics'] = 'ApiAnalytics';

$wgAutoloadClasses['ApiAnalyticsBase'] = $dir . 'ApiAnalyticsBase.php';

$metricsDir = $dir . 'metrics/';

$wgAutoloadClasses['GenericMetricBase'] = $metricsDir . 'GenericMetricBase.php';

$wgAutoloadClasses['ComScoreReachPercentageMetric'] = $metricsDir . 'ComScoreReachPercentageMetric.php';
$wgMetricAPIModules['comscorereachpercentage'] = 'ComScoreReachPercentageMetric';

$wgAutoloadClasses['ComScoreUniqueVisitorMetric'] = $metricsDir . 'ComScoreUniqueVisitorMetric.php';
$wgMetricAPIModules['comscoreuniquevisitors'] = 'ComScoreUniqueVisitorMetric';

$wgAutoloadClasses['DumpActiveEditors100Metric'] = $metricsDir . 'DumpActiveEditors100Metric.php';
$wgMetricAPIModules['dumpactiveeditors100'] = 'DumpActiveEditors100Metric';

$wgAutoloadClasses['DumpActiveEditors5Metric'] = $metricsDir . 'DumpActiveEditors5Metric.php';
$wgMetricAPIModules['dumpactiveeditors5'] = 'DumpActiveEditors5Metric';

$wgAutoloadClasses['DumpArticleCountMetric'] = $metricsDir . 'DumpArticleCountMetric.php';
$wgMetricAPIModules['dumparticlecount'] = 'DumpArticleCountMetric';

$wgAutoloadClasses['DumpBinaryCountMetric'] = $metricsDir . 'DumpBinaryCountMetric.php';
$wgMetricAPIModules['dumpbinarycount'] = 'DumpBinaryCountMetric';

$wgAutoloadClasses['DumpEditsMetric'] = $metricsDir . 'DumpEditsMetric.php';
$wgMetricAPIModules['dumpedits'] = 'DumpEditsMetric';

$wgAutoloadClasses['DumpNewRegisteredEditorsMetric'] = $metricsDir . 'DumpNewRegisteredEditorsMetric.php';
$wgMetricAPIModules['dumpnewregisterededitors'] = 'DumpNewRegisteredEditorsMetric';

$wgAutoloadClasses['EstimateOfflineMetric'] = $metricsDir . 'EstimateOfflineMetric.php';
$wgMetricAPIModules['estimateoffline'] = 'EstimateOfflineMetric';

$wgAutoloadClasses['SquidPageViewsMetric'] = $metricsDir . 'SquidPageViewsMetric.php';
$wgMetricAPIModules['squidpageviews'] = 'SquidPageViewsMetric';

$wgAutoloadClasses['EditorsByGeographyMetric'] = $metricsDir . 'EditorsByGeographyMetric.php';
$wgMetricAPIModules['editorsbygeography'] = 'EditorsByGeographyMetric';
