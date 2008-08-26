<?php

define( 'UNORM_NONE', 1 );
define( 'UNORM_NFD',  2 );
define( 'UNORM_NFKD', 3 );
define( 'UNORM_NFC',  4 );
define( 'UNORM_DEFAULT', UNORM_NFC );
define( 'UNORM_NFKC', 5 );
define( 'UNORM_FCD',  6 );

dl("php_utfnormal.so");

$tests = array(
	"Hello world" => "Hello world",
	"こんにちは、世界" => "こんにちは、世界",
	"a\xcc\x80" => "à",
	"e\xcc\x81" => "é",
	
	"\xc0" => NULL, # Head byte at end is known to fail
	"\xc0\x20" => "\xef\xbf\xbd\x20", # If followed, replacement char is ok
);

$failed = false;
foreach( $tests as $input => $expect ) {
	$output = utf8_normalize( $input, UNORM_NFC );
	print "\"$input\" -> \"$output\"";
	if( $output === $expect ) {
		print " - ok\n";
	} else {
		print " - FAILED\n";
		$failed = true;
	}
}

if( $failed ) {
	print "Can't even pass quick checks; something is wrong.\n";
	exit( -1 );
} else {
	print "Quick checks ok; try the more thorough test suite in includes/normal\n";
	exit( 0 );
}

