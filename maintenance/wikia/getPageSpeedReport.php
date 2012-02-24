<?php

/**
 * @addto maintenance
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

function printHelp() {
		echo <<<HELP
Returns Google PageSpeed report

USAGE: php codelint.php --url=http://foo.bar --score-only

	--url
		Page to be checked

HELP;
}

// show help and quit
if (!isset($options['url'])) {
	printHelp();
	die(1);
}

$service = new PageSpeedAPI();
$url = $options['url'];

// use GooglePage speed API
$report = $service->getReportForURL($url);

if (empty($report)) {
	echo "API request failed!\n";
	die(1);
}

// print the report
$reportUrl = $report['url'];

echo <<<REPORT
-------------------------------------------------------------------------------
PageSpeed report for <$reportUrl>:
-------------------------------------------------------------------------------

REPORT;

echo "\nPageSpeed score is: \033[32m{$report['score']}\033[0m\n";

// print key/value details
echo "\nDetails:\n--------\n";

foreach($report['stats'] as $key => $value) {
	echo '* ' . sprintf('%-30s: %s', $key, number_format($value)) . "\n";
}

die(0);
