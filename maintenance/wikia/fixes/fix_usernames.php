<?php

include( '../../commandLine.inc' );

$dbr = wfGetDB( DB_MASTER );

$dbg = wfGetDB( DB_SLAVE, array(), 'muppet' );

$res = $dbr->query( 'SELECT DISTINCT rev_user, rev_user_text from revision where rev_user != 0 order by rev_user' );

$fixed = array();

while ( $row = $dbr->fetchObject( $res ) ) {
	if ( in_array( $row->rev_user, $fixed ) ) {
		continue;
	}

	wfWaitForSlaves( 5 );

	$name = $dbg->selectField( 'wikicities.user', 'user_name', array( 'user_id' => $row->rev_user ) );

	if ( $name != $row->rev_user_text && !in_array( $row->rev_user, $fixed ) ) {
		echo "Renaming ID {$row->rev_user} to " . $name . "\n";

		$dbr->update( 'revision', array( 'rev_user_text' => $name ), array( 'rev_user' => $row->rev_user ) );
		$fixed[] = $row->rev_user;
	}
}
