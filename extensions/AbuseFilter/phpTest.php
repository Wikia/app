<?php

/*
 * Runs tests against the PHP parser.
 */

require_once ( getenv('MW_INSTALL_PATH') !== false
	? getenv('MW_INSTALL_PATH')."/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

$tester = new AbuseFilterParser;

$test_path = dirname( __FILE__ )."/parser_native/tests";
$tests = glob( $test_path."/*.t" );

// die( print_r( $tester->intEval( '"foo" in "foobar" & "quux" contains "ux"' ), true ) );

$check = 0;
$pass = 0;

foreach( $tests as $test ) {
	if( in_string( 'whitespace.t', $test ) )
		continue;	// Skip it. Or add preset variables support to the parser

	$result = substr($test,0,-2).".r";

	$rule = trim(file_get_contents( $test ));
	$output = ($cont = trim(file_get_contents( $result ))) == 'MATCH';
	
	$testname = basename($test);
	
	print "Trying test $testname...\n";
	
	try {
		$check++;
		$actual = intval($tester->parse( $rule ));
		
		if ($actual == $output) {
			print "-PASSED.\n";
			$pass++;
		} else {
			print "-FAILED - expected output $output, actual output $actual.\n";
			print "-Expression: $rule\n";
		}
	} catch (AFPException $excep) {
		print "-FAILED - exception ".$excep->getMessage()." with input $rule\n";
	}
}

print "$pass tests passed out of $check\n";