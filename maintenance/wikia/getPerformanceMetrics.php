<?php
/**
 * Displays various performance metrics from different sources:
 *
 *  - Google PageSpeed
 *  - DOM complexity report
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

USAGE: php getPerformanceMetrics.php --url=http://foo.bar [--cacti] [--noexternals] [--providers=PerformanceMetricsPhantom,PerformanceMetricsGooglePageSpeed] [--csv] [--ganglia=graph-s1]

	--url
		Page to be checked

	--mobile
		Force wikiamobile skin

	--noexternals
		Test pages without external resources fetched (i.e. noexternals=1 added to the URL)

	--providers
		Comma separated list of providers to get data from

	--logged-in
		Get metrics for logged-in version of the site

	--csv
		Return in CSV format

	--ganglia
		Send data to given Ganglia server using UDP protocol

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
	'loggedIn' => isset($options['logged-in'])
);

// use GooglePage speed API
$metrics = F::build('PerformanceMetrics');
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
if (isset($options['ganglia'])) {
	$host = $options['ganglia'];
	echo "\nSending data to {$host}...";

	// TODO: use OOP library
	include "{$IP}/lib/gmetric.php";
	$res =  gmetric_open($host, 8651, 'udp');

	if ($res === false) {
		echo " failed!\n";
		die(1);
	}

	foreach($report['metrics'] as $key => $value) {
		gmetric_send($res, $key, $value, is_numeric($value) ? 'uint32' : 'string', '', null, 0, 0);
	}

	gmetric_close($res);

	echo " done!\n";
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

die(0);