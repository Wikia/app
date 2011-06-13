<?php

// Go through all usernames and calculate and record spoof thingies

$base = dirname( dirname( dirname( __FILE__ ) ) );

require $base . '/maintenance/commandLine.inc';

include( '/usr/wikia/source/trunk/extensions/AntiSpoof/AntiSpoof.php' );

$dbw = wfGetDB( DB_MASTER );

$dbw->bufferResults( false );

$batchSize = 10;

$result = $dbw->select( 'user', 'user_name', null, 'batchAntiSpoof.php' );
$n = 0;
while( $row = $dbw->fetchObject( $result ) ) {
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
$dbw->freeResult( $result );

