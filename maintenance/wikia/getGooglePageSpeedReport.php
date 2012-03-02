<?php
/**
 * @addto maintenance
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 *
 * SERVER_ID=1 php getGooglePageSpeedReport.php --url=http://wikia.com/Wikia --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

function printHelp() {
		echo <<<HELP
Returns Google PageSpeed report

USAGE: php getGooglePageSpeedReport.php --url=http://foo.bar [--cacti] [--noexternals]

	--url
		Page to be checked

	--cacti
		Use Cacti compatible output format

	--noexternals
		Test pages without external resources fetched (i.e. noexternals=1 added to the URL)

HELP;
}

// show help and quit
if (!isset($options['url'])) {
	printHelp();
	die(1);
}

$service = new PageSpeedAPI();
$url = $options['url'];

// support --noexternals option
if (isset($options['noexternals'])) {
	$url .= (strpos($url, '?') !== false ? '&' : '?') . 'noexternals=1';
}

// use GooglePage speed API
$report = $service->getReportForURL($url);

if (empty($report)) {
	echo "API request failed!\n";
	die(1);
}

// format the output for Cacti
if (isset($options['cacti'])) {
	$output = "pageScore:{$report['score']}";

	// emit the rest of the values
	foreach($report['stats'] as $id => $value) {
		$output .= " {$id}:{$value}";
	}

	echo $output . "\n";
	die(0);
}

// print the report on the screen
$reportUrl = $report['url'];

echo <<<REPORT
-------------------------------------------------------------------------------
PageSpeed report for <$reportUrl>:
-------------------------------------------------------------------------------

REPORT;

// make the score green
echo "\nPageSpeed score is: \033[32m{$report['score']}\033[0m\n";

// print key/value details
echo "\nDetails:\n--------\n";

foreach($report['stats'] as $key => $value) {
	echo '* ' . sprintf('%-30s: %s', $key, number_format($value)) . "\n";
}

die(0);
