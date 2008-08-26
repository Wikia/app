<?php

# Quickie memory leak checker.
# 2004-11-14 -- brion@pobox.com

if( php_sapi_name() != 'cli' ) {
	die( "Run me from the command line please.\n" );
}

echo 
"Memory leak test!

Watch PHP's memory usage in top; a leak in the extension will not
generally be reported by memory_get_usage() below since it's not using
PHP's emalloc().

If resident size in top climbs constantly, you've got a leak. If it
stays steady, the leak is fixed.

";

dl( 'php_wikidiff.so' );

function randomString( $length, $nullOk = false, $ascii = false ) {
	$out = '';
	for( $i = 0; $i < $length; $i++ )
		$out .= chr( mt_rand( $nullOk ? 0 : 1, $ascii ? 127 : 255 ) );
	return $out;
}

$size = 100000;
$maxruns = 1000;
$membase = memory_get_usage();
for( $i = 0; $i <= $maxruns; $i++ ) {
	$x = memory_get_usage() - $membase;
	printf( "%5d: up %d bytes\n", $i, $x );
	
	$a = randomString( $size );
	$b = randomString( $size );
	$c = wikidiff_do_diff( $a, $b, 1 );
	
	$a = '';
	$b = '';
	$c = '';
}

echo "(" . (memory_get_usage() - $membase) . " used)\n";

