<?php

/**
 * Like makeSimpleList.php except with edits limited to the main namespace
 */

$optionsWithArgs = array( 'before', 'edits' );
require( dirname(__FILE__).'/../cli.inc' );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$fname = 'voterList.php';
$before = isset( $options['before'] ) ? $dbr->timestamp( strtotime( $options['before'] ) ) : false;
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
		$conds[] = 'page_id=rev_page';
		$conds['page_namespace'] = 0;
		$edits = $dbr->selectField( array( 'page', 'revision' ), 'COUNT(*)', $conds, $fname );
		if ( $edits >= $minEdits ) {
			$insertBatch[] = $insertRow;
		}
	}
	if ( $insertBatch ) {
		$dbw->insert( 'securepoll_lists', $insertBatch, $fname );
	}
}
