<?php

/**
 * Generate a list of users with some number of edits before some date.
 *
 * Will eventually be replaced by something called makeList.php, with more features.
 */

$optionsWithArgs = array( 'before', 'edits' );
require( dirname(__FILE__).'/cli.inc' );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$fname = 'voterList.php';
$before = isset( $options['before'] ) ? wfTimestamp( TS_MW, strtotime( $options['before'] ) ) : false;
$minEdits = isset( $options['edits'] ) ? intval( $options['edits'] ) : false;

if ( !isset( $args[0] ) ) {
	echo "Usage: php voterList.php [--replace] [--before=<date>] [--edits=<date>] <name>\n";
	exit( 1 );
}
$listName = $args[0];
$startBatch = 0;
$batchSize = 100;

$listExists = $dbr->selectField( 'securepoll_lists', '1', 
	array( 'li_name' => $listName ), $fname );
if ( $listExists ) {
	if ( isset( $options['replace'] ) ) {
		echo "Deleting existing list...\n";
		$dbw->delete( 'securepoll_lists', array( 'li_name' => $listName ), $fname );
	} else {
		echo "Error: list exists. Use --replace to replace it.\n";
		exit( 1 );
	}
}

while ( true ) {
	$res = $dbr->select( 'user', 'user_id',
		array( 'user_id > ' . $dbr->addQuotes( $startBatch ) ),
		$fname,
		array( 'LIMIT' => $batchSize ) );

	if ( !$res->numRows() ) {
		break;
	}

	$insertBatch = array();
	foreach ( $res as $row ) {
		$startBatch = $userId = $row->user_id;
		$insertRow = array( 'li_name' => $listName, 'li_member' => $userId );
		if ( $minEdits === false ) {
			$insertBatch[] = $insertRow;
			continue;
		}

		# Count edits
		$conds = array( 'rev_user' => $userId );
		if ( $before !== false ) {
			$conds[] = 'rev_timestamp < ' . $dbr->addQuotes( $before );
		}
		$edits = $dbr->selectField( 'revision', 'COUNT(*)', $conds, $fname );
		if ( $edits >= $minEdits ) {
			$insertBatch[] = $insertRow;
		}
	}
	if ( $insertBatch ) {
		$dbw->insert( 'securepoll_lists', $insertBatch, $fname );
	}
}
