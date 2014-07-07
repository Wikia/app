<?php

/**
 * Initial very basic framework for doing some benchmark tests, comparing
 * scripts in the inline script to equivalent raw PHP execution (eval'd)
 *
 * <brion@pobox.com> 2010-04-14
 */

if (php_sapi_name() != 'cli') {
    die("cli only");
}

require_once "../../../../maintenance/commandLine.inc";

require_once "../../InlineScripts.php"; // if ext not already enabled

$testcases = array(array(
'script' => <<<END_SCRIPT
"Hello, world!";
END_SCRIPT
,
'php' => <<<END_PHP
return "Hello, world!";
END_PHP
));

function runtest( $lang, $source ) {
	if ($lang == 'php') {
		return eval($source);
	} else {
		$scriptParser = new ISInterpreter();
		$parser = new Parser();
		$frame = null; //new Frame();
		return $scriptParser->evaluate( $source, $parser, $frame );
	}
}

$runs = 10;
foreach( $testcases as $testcase ) {
	foreach( $testcase as $lang => $code ) {
		$start = microtime( true );
		$result = runtest( $lang, $code );
		$delta1 = microtime( true ) - $start;
		for ($i = 1; $i < $runs; $i++) {
			runtest( $lang, $code );
		}
		$delta = (microtime( true ) - $start) / $runs;
		printf( "%s: %0.3f ms first, %0.3f ms avg of %d runs\n",
		        $lang, $delta1 * 1000.0, $delta * 1000.0, $runs );
		var_dump($result);
		print "\n";
	}
}
