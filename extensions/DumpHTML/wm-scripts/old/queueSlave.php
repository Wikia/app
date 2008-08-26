<?php

$queueHost = $argv[1];
$queuePort = $argv[2];
$baseDir = $argv[3];

$queueSock = fsockopen( $queueHost, $queuePort );
if ( !$queueSock ) {
	echo "Unable to connect to queue server\n";
	die( 1 );
}

chdir( "/home/wikipedia/common/php-1.5/maintenance" );
$waiting = false;
while ( 1 ) {
	if ( !fwrite( $queueSock, "deq\n" ) ) {
		echo "Unable to write to queue server\n";
		die( 1 );
	}
	$s = fgets( $queueSock );
	if ( $s === false ) {
		echo "Unable to read from queue server\n";
		die( 1 );
	}
	if ( preg_match( '!^data ([a-z_-]+) (\d+/\d+)!', $s, $m ) ) {
		$waiting = false;
		$wiki = $m[1];
		$slice = $m[2];
		echo "-------------------------------------------------------------------\n";
		echo "$wiki $slice\n";
		echo "-------------------------------------------------------------------\n";
		$checkpoint = "$baseDir/checkpoints/{$wiki}_" . str_replace( '/', '_', $slice );
		$lang = str_replace( 'wiki', '', $wiki );
		$dest = "$baseDir/$lang-new";
		
		passthru( "php -n dumpHTML.php $wiki --force-copy --image-snapshot --interlang -d $dest --slice $slice --checkpoint $checkpoint" );
	} else {
		# Wait for jobs
		if ( !$waiting ) {
			print "Waiting...\n";
			$waiting = true;
		}
		sleep( 5 );
	}
}

?>
