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
USAGE: php codelint.php [--help] [--mode] [--format] --file|--dir

	--help
		Show this help information

	--mode
		Set working mode (can be either "js" or "css")

	--file
		File to lint

	--dir
		Directory to lint (subdirectories will be included)

	--format[=text]
		Report format (either text, json or html)

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
$mode = isset($options['mode']) ? $options['mode'] : 'js';
$format = isset($options['format']) ? $options['format'] : 'text';
$file = isset($options['file']) ? $options['file'] : false;
$dir = isset($options['dir']) ? $options['dir'] : false;

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

echo $lint->formatReport($results, $format);

// this script is run by CruiseControl requiring return code to equal zero
die(0);