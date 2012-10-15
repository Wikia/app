<?php

/**
 * have made at least 600 edits before 01 June 2009 across Wikimedia wikis (edits on several wikis can be combined if your accounts are unified into a global account); and
 * have made at least 50 edits between 01 January and 01 July 2009.
 */

require( dirname(__FILE__) . '/../cli.inc' );
$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );


$maxUser = $dbr->selectField( 'user', 'MAX(user_id)', false );
$beforeTime = '20090601000000';
$betweenTime = array( '20090101000000', '20090701000000' );
$fname = 'populatebv2009EditCount';

for ( $userId = 1; $userId <= $maxUser; $userId++ ) {
	$exists = $dbr->selectField( 'user', '1', array( 'user_id' => $userId ) );
	if ( !$exists ) {
		continue;
	}

	$longEdits = $dbr->selectField( 'revision', 'COUNT(*)', 
		array( 
			'rev_user' => $userId,
			'rev_timestamp < ' . $dbr->addQuotes( $beforeTime )
		), $fname );

	$shortEdits = $dbr->selectField( 'revision', 'COUNT(*)',
		array(
			'rev_user' => $userId,
			'rev_timestamp BETWEEN ' . $dbr->addQuotes( $betweenTime[0] ) . 
				' AND ' . $dbr->addQuotes( $betweenTime[1] ) 
		),
		$fname 
	);

	if ( $longEdits !== 0 || $shortEdits !== 0 ) {
		$dbw->insert( 'bv2009_edits', 
			array(
				'bv_user' => $userId,
				'bv_long_edits' => $longEdits,
				'bv_short_edits' => $shortEdits
			),
			$fname
		);
		$numUsers++;
	}
}

echo wfWikiID() . ": $numUsers users added\n";

