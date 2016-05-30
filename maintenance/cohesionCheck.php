<?php

// php cohesionCheck.php 4

require_once( dirname( __FILE__ ) . '/commandLine.inc' );
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

$max_tries = (int) $argv[0] ? (int) $argv[0] : 3;

$langs = [ 'en', 'pl', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'pt', 'ru', 'zh-hans', 'zh-tw' ];

for ($i = 0; $i < $max_tries; ++$i) {
	$cmd = 'SERVER_ID=177 php maintenance/rebuildLocalisationCache.php --force --primary --cache-dir=/tmp/messagecache-new' . $i;
	shell_exec( $cmd );
	print 'cache ' . $i . ' done' . PHP_EOL;
}

$all_files = 0;
$match_files = 0;

foreach ( $langs as $languageCode ) {
	$md5_cache = '';

	for ( $i = 0; $i < $max_tries; ++$i ) {

		$md5 = md5_file ('/tmp/messagecache-new' . $i);
		if (!$md5_cache) {
			++$match_files;
			++$all_files;
			$md5_cache = $md5;
		}
		elseif ($md5_cache !== $md5) {
			++$all_files;
			print 'ERROR: ' . $languageCode . ' /tmp/messagecache-new0 do NOT MATCH with /tmp/messagecache-new' . $i . PHP_EOL;
		}
		else {
			++$match_files;
			++$all_files;
			print $languageCode . ' /tmp/messagecache-new0 do MATCH with /tmp/messagecache-new' . $i . PHP_EOL;
		}
	}
}

for ( $i = 0; $i < $max_tries; ++$i ) {
	$cmd = 'rm -fr /tmp/messagecache-new' . $i;
	shell_exec( $cmd );

	print $i . ' removed' . PHP_EOL;
}

print $match_files . '/' . $all_files . ' cache files matches' . PHP_EOL;
