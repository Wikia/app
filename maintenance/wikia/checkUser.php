<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require( 'commandLine.inc' );

$id = $options['u'];
if ( empty( $id ) ) {
	echo "Invalid user ID \n"; exit;
}

$id = 3504341;
$key = wfSharedMemcKey( "user_touched", $id );
echo "touched: " . $wgMemc->get( $key ) . "\n";

$u = User::newFromId( $id );
$u->load();
echo print_r( $u, true );

exit;
