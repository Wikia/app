<?php

require( dirname( __FILE__ ) . '/../cli.inc' );
$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$fname = 'voterList-bv2009.php';
$listName = 'board-vote-2009-amended';

if ( !$wgCentralAuthDatabase ) {
	echo wfWikiID() . ": CentralAuth not active, skipping\n";
	exit( 0 );
}

$dbw->delete( 'securepoll_lists', array( 'li_name' => $listName ), $fname );

$userId = 0;
$numQualified = 0;
while ( true ) {
	$res = $dbr->select( 'user', array( 'user_id', 'user_name' ),
		array( 'user_id > ' . $dbr->addQuotes( $userId ) ),
		__METHOD__,
		array( 'LIMIT' => 1000, 'ORDER BY' => 'user_id' ) );
	if ( !$res->numRows() ) {
		break;
	}

	$users = array();
	foreach ( $res as $row ) {
		$users[$row->user_id] = $row->user_name;
		$userId = $row->user_id;
	}
	$qualifieds = spGetQualifiedUsers( $users );
	$insertBatch = array();
	foreach ( $qualifieds as $id => $name ) {
		$insertBatch[] = array(
			'li_name' => $listName,
			'li_member' => $id
		);
	}
	if ( $insertBatch ) {
		$dbw->insert( 'securepoll_lists', $insertBatch, $fname );
		$numQualified += count( $insertBatch );
	}
}
echo wfWikiID() . " qualified \t$numQualified\n";

function spGetQualifiedUsers( $users ) {
	global $wgCentralAuthDatabase, $wgLocalDatabases;
	$dbc = wfGetDB( DB_SLAVE, array(), $wgCentralAuthDatabase );
	$editCounts = array();

	# Check local attachment
	$res = $dbc->select( 'localuser', array( 'lu_name' ),
		array(
			'lu_wiki' => wfWikiID(),
			'lu_name' => array_values( $users )
		), __METHOD__ );

	$attached = array();
	foreach ( $res as $row ) {
		$attached[] = $row->lu_name;
		$editCounts[$row->lu_name] = array( 0, 0 );
	}
	$nonLocalUsers = array();

	$localEditCounts = spGetEditCounts( wfGetDB( DB_SLAVE ), $users );
	foreach ( $localEditCounts as $user => $counts ) {
		if ( $counts[0] == 0 ) {
			// No recent local edits, remove from consideration
			// This is just for efficiency, the user can vote somewhere else
			$nonLocalUsers[] = $user;
		}
		$editCounts[$user] = $counts;
	}
	$attached = array_diff( $attached, $nonLocalUsers );
	
	# Check all global accounts
	$localWiki = wfWikiID();
	if ( $attached ) {
		$res = $dbc->select( 'localuser', 
			array( 'lu_name', 'lu_wiki' ),
			array( 'lu_name' => $attached ),
			__METHOD__ );
		$foreignUsers = array();
		foreach ( $res as $row ) {
			if ( $row->lu_wiki != $localWiki ) {
				$foreignUsers[$row->lu_wiki][] = $row->lu_name;
			}
		}

		foreach ( $foreignUsers as $wiki => $wikiUsers ) {
			if ( !in_array( $wiki, $wgLocalDatabases ) ) {
				continue;
			}
			$lb = wfGetLB( $wiki );
			$db = $lb->getConnection( DB_SLAVE, array(), $wiki );
			$foreignEditCounts = spGetEditCounts( $db, $wikiUsers );
			$lb->reuseConnection( $db );
			foreach ( $foreignEditCounts as $name => $count ) {
				$editCounts[$name][0] += $count[0];
				$editCounts[$name][1] += $count[1];
			}
		}
	}

	$idsByUser = array_flip( $users );
	$qualifiedUsers = array();
	foreach ( $editCounts as $user => $count ) {
		if ( spIsQualified( $count[0], $count[1] ) ) {
			$id = $idsByUser[$user];
			$qualifiedUsers[$id] = $user;
		}
	}

	return $qualifiedUsers;
}

function spGetEditCounts( $db, $userNames ) {
	$res = $db->select(
		array( 'user', 'bv2009_edits' ), 
		array( 'user_name', 'bv_long_edits', 'bv_short_edits' ),
		array( 'bv_user=user_id', 'user_name' => $userNames ),
		__METHOD__ );
	$editCounts = array();
	foreach ( $res as $row ) {
		$editCounts[$row->user_name] = array( $row->bv_short_edits, $row->bv_long_edits );
	}
	foreach ( $userNames as $user ) {
		if ( !isset( $editCounts[$user] ) ) {
			$editCounts[$user] = array( 0, 0 );
		}
	}
	return $editCounts;
}

function spIsQualified( $short, $long ) {
	return $short >= 50 && $long >= 600;
}
