<?php
/**
 * Runs tests against the PHP parser.
 */

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

$tester = new AbuseFilterParser;

wfLoadExtensionMessages( 'AbuseFilter' );

$test_path = dirname( __FILE__ ) . "/tests";
$tests = glob( $test_path . "/*.t" );

$check = 0;
$pass = 0;

foreach ( $tests as $test ) {
	$result = substr( $test, 0, - 2 ) . ".r";

	$rule = trim( file_get_contents( $test ) );
	$output = ( $cont = trim( file_get_contents( $result ) ) ) == 'MATCH';

	$testname = basename( $test );

	print "Trying test $testname...\n";

	try {
		$check++;
		$actual = intval( $tester->parse( $rule ) );

		if ( $actual == $output ) {
			print "-PASSED.\n";
			$pass++;
		} else {
			print "-FAILED - expected output $output, actual output $actual.\n";
			print "-Expression: $rule\n";

			// export
			$vars = var_export( $tester->mTokens, true );
			file_put_contents( $test . '.parsed', $vars );
		}
	} catch ( AFPException $excep ) {
		print "-FAILED - exception " . $excep->getMessage() . " with input $rule\n";

		// export
		$vars = var_export( $tester->mTokens, true );
		file_put_contents( $test . '.parsed', $vars );
	}
}

print "$pass tests passed out of $check\n";
