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
USAGE: php codelint.php [--help] [--mode] --file|--dir

	--help
		Show this help information

	--mode
		Set working mode (can be either "js" or "css")

	--file
		File to lint

	--dir
		Directory to lint (subdirectories will be included)


HELP;
}

$codeLint = F::build('CodeLint');

if (!$codeLint->isNodeJsInstalled()) {
	die('You need to have nodejs installed in order to use this tool!');
}

$nodeJsVersion = $codeLint->getNodeJsVersion();

echo "Using nodejs {$nodeJsVersion}\n\n";

// show help and quit
if (isset($options['help'])) {
	printHelp();
	die(1);
}

// parse command line options
$mode = isset($options['mode']) ? $options['mode'] : 'js';
$file = isset($options['file']) ? $options['file'] : false;
$dir = isset($options['dir']) ? $options['dir'] : false;

switch($mode) {
	case 'js':
		$lint = new JsLint();
		break;

	default:
		echo "Unsupported mode provided\n\n";
		printHelp();
		die(1);
		break;
}

$lint->checkFile($file);

// this script is run by CruiseControl requiring return code to equal zero
die(0);
