<?php
$dir = realpath( dirname( __DIR__ ) );
include "{$dir}/commandLine.inc";

class MixHacks {

public function stage1( $iId ) {
	global $wgMemc;
	$sKey = wfMemcKey( 'user', 'id', $iId );
	var_dump( $wgMemc->delete( $sKey ) );
}

}

// the work...

if ( !isset( $options['user'] ) ) {
	exit( 1 );
}

$oObj = new MixHacks();
$oObj->stage1( $options['user'] );
exit( 0 );
