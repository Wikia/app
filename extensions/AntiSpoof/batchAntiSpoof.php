<?php

// Go through all usernames and calculate and record spoof thingies

$base = dirname( dirname( dirname( __FILE__ ) ) );
require $base . '/maintenance/commandLine.inc';

// fixme
$dbr = new Database( $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname );
$dbr->bufferResults( false );

$batchSize = 1000;

$result = $dbr->select( 'user', 'user_name', '1', 'batchAntiSpoof.php' );
$n = 0;
while( $row = $dbr->fetchObject( $result ) ) {
	if( $n++ % $batchSize == 0 ) {
		echo "$wgDBname $n\n";
	}

	$items[] = new SpoofUser( $row->user_name );

	if( $n % $batchSize == 0 ) {
		SpoofUser::batchRecord( $items );
		$items = array();
	}
}
SpoofUser::batchRecord( $items );
echo "$wgDBname $n done.\n";
$dbr->freeResult( $result );
