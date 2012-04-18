<?php
/**
 * Runs js unit tests using phantomJS
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 *
 * php run-js-test.php --test=path/to/test.js
 */

function printHelp() {
		echo <<<HELP
Runs a javascript unit test

USAGE: php run-js-test.php -t/path/to/test.js

	-t
		test file to run
HELP;
}

$options = getopt( 't:' );

if ( empty( $options['t'] ) ) {
	printHelp();
}

$dir = dirname(__FILE__);
$test = escapeshellcmd( $options['t'] );
$cmd = "phantomjs {$dir}/../extensions/wikia/JSTestRunner/js/phantom.js {$test}";

exec($cmd, $output, $retVal);

// decode the last line
var_dump( array( 'ret' => $retVal, 'output' => $output ) );