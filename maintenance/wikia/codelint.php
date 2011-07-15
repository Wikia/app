<?php
/**
 * @addto maintenance
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

function printHelp() {
		echo <<<HELP
Performs lint check on given file / directory
USAGE: php codelint.php --file|--dir [--help] [--mode] [--format] [--output]

	--help
		Show this help information

	--file
		File to lint

	--dir
		Directory to lint (subdirectories will be included)

	--mode
		Set working mode (can be either "js" or "css")

	--format[=text]
		Report format (either text, json or html)

	--output
		Name of the file to write report to

HELP;
}

if (!CodeLint::isNodeJsInstalled()) {
	die('You need to have nodejs installed in order to use this tool!');
}

$nodeJsVersion = CodeLint::getNodeJsVersion();

//echo "Using nodejs {$nodeJsVersion}\n\n";

// show help and quit
if (isset($options['help'])) {
	printHelp();
	die(1);
}

// parse command line options
$file = isset($options['file']) ? $options['file'] : false;
$dir = isset($options['dir']) ? $options['dir'] : false;
$mode = isset($options['mode']) ? $options['mode'] : 'js';
$format = isset($options['format']) ? $options['format'] : 'text';
$output = isset($options['output']) ? $options['output'] : false;


switch($mode) {
	case 'js':
		$lint = new JsLint();
		$pattern = '*.js';
		break;

	default:
		echo "Unsupported mode provided\n\n";
		printHelp();
		die(1);
		break;
}

if (!empty($file)) {
	$results = array($lint->checkFile($file));
}
else if (!empty($dir)) {
	$results = $lint->checkDirectory($dir);
}
else {
	echo "Please provide either file name or directory to lint\n\n";
	printHelp();
	die(1);
}

//var_dump($results);

// generate report
$report = $lint->formatReport($results, $format);

// save it to file
if (!empty($output)) {
	file_put_contents($output, $report);
	echo "Report saved to {$output}...\n\n";
}
else {
	echo $report;
}

// this script is run by CruiseControl requiring return code to equal zero
die(0);