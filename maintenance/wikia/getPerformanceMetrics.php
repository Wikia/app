<?php
/**
 * Displays various performance metrics from different sources:
 *
 *  - Google PageSpeed
 *  - phantomjs
 *
 * @addto maintenance
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 *
 * SERVER_ID=1 php getPerformanceMetrics.php --url=http://wikia.com/Wikia --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

require $IP . '/extensions/wikia/PerformanceMetrics/PerformanceMetrics.setup.php';

function printHelp() {
		echo <<<HELP
Returns performance metrics for a given page

USAGE: php getPerformanceMetrics.php --url=http://foo.bar [--cacti] [--noexternals] [--providers=PerformanceMetricsPhantom,PerformanceMetricsGooglePageSpeed] [--csv] [--ganglia --ganglia-group=Mobile performance] [----abtest-group=1] [--verbose]

	--url
		Page to be checked

	--mobile
		Force wikiamobile skin

	--noexternals
		Test pages without external resources fetched (i.e. noexternals=1 added to the URL)

	--logged-in
		Get metrics for logged-in version of the site

	--providers
		Comma separated list of providers to get data from

	--csv
		Return in CSV format

	--ganglia
		Send data to Ganglia server using UDP protocol

	--ganglia-group
		Name of Ganglia graph group to report metrics to

	--abtest-group
		ID of A/B testing group

	--verbose
		Be noisy :)
HELP;
}

// show help and quit
if (!isset($options['url'])) {
	printHelp();
	die(1);
}

$url = $options['url'];
$params = array(
	// support --noexternals option
	'noexternals' => isset($options['noexternals']),

	// support --mobile option
	'mobile' => isset($options['mobile']),

	// support --providers option
	'providers' => isset($options['providers']) ? explode(',', $options['providers']) : array(),

	// support --logged-in option
	'loggedIn' => isset($options['logged-in']),

	// support --abtest-group option
	'abGroup' => isset($options['abtest-group']) ? $options['abtest-group'] : false
);

$beVerbose = isset($options['verbose']);

// use GooglePage speed API
$metrics = new PerformanceMetrics();
$report = $metrics->getReport($url, $params);

if (empty($report)) {
	echo "Get metrics request failed!\n";
	die(1);
}

// format the output as CSV
if (isset($options['csv'])) {
	$output = implode(',', $report['metrics']);

	echo $output . "\n";
	die(0);
}

// send data to Ganglia using gmetric library (BugId:29371)
if (isset($options['ganglia']) && isset($options['ganglia-group'])) {
	$host = $wgGangliaHost;
	$port = $wgGangliaPort;
	$group = $options['ganglia-group'];

	if ($beVerbose) echo "Sending data to {$host}:{$port} ('{$group}' group)...";

	$gmetric = new GMetricClient();

	$gmetric->setHostnameSpoof('10.8.32.34', 'spoofed-performance-metrics');
	$gmetric->setPrefix(strtolower(str_replace(' ', '-', $group)));
	$gmetric->setGroup($group);

	foreach($report['metrics'] as $name => $value) {
		$gmetric->addMetric($name, is_numeric($value) ? GMetricClient::GANGLIA_VALUE_UNSIGNED_INT : GMetricClient::GANGLIA_VALUE_STRING, $value);
	}

	$gmetric->send($host, $port);

	if ($beVerbose) echo " done!\n";
	die(0);
}

// print the report on the screen
$reportUrl = $report['url'];

echo <<<REPORT
-------------------------------------------------------------------------------
Perfomance metrics for <$reportUrl>:
-------------------------------------------------------------------------------

REPORT;

// make the score green
if (isset($report['metrics']['pageSpeed'])) {
	echo "\nPageSpeed score is: \033[32m{$report['metrics']['pageSpeed']}\033[0m\n";
}

// print key/value details
echo "\nDetails:\n--------\n";

foreach($report['metrics'] as $key => $value) {
	echo '* ' . sprintf('%-30s: %s', $key, is_numeric($value) ? number_format($value) : $value)  . "\n";
}

// print out notices when in verbose mode
if ($beVerbose && !empty($report['notices'])) {
	echo "\nNotices:\n--------\n";

	foreach($report['notices'] as $notice) {
		echo "# {$notice}\n";
	}
}

die(0);
