<?php
$dir = realpath( dirname( __DIR__ ) );
include "{$dir}/commandLine.inc";

class MixHacks {

public function stage1() {
	global $wgMemc;
	$sKey = wfMemcKey( 'user', 'id', '737801' );
	var_dump( $wgMemc->delete( $sKey ) );
}

}

// the work...
$oObj = new MixHacks();
$oObj->stage1();
exit( 0 );
