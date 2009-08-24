<?php

if( php_sapi_name() != 'cli' ) {
	print( 'Invalid entry' );
	die( 1 );
}

function update_flaggedrevs_querycache() {
	global $wgFlaggedRevsNamespaces;
	if( empty($wgFlaggedRevsNamespaces) ) {
		return;
	}
	print( "UnreviewedPages..." );
	$dbr = wfGetDB( DB_SLAVE );
	$dbw = wfGetDB( DB_MASTER );
	$querycache = $dbr->tableName( 'querycache' );
	/*
	 * Find pages that were never reviewed at all...
	 */
	$res = $dbr->select( array('page','flaggedpages'),
		array( 'page_namespace', 'page_title', 'page_id' ),
		array( 'page_namespace' => $wgFlaggedRevsNamespaces, 
			'page_is_redirect' => 0, // no redirects
			'fp_page_id IS NULL' ),
		__METHOD__,
		array( 'LIMIT' => 5000 ),
		array( 'flaggedpages' => array('LEFT JOIN','fp_page_id = page_id') )
	);
	if( $dbr->numRows( $res ) ) {
		$first = true;
		$insertSql = "INSERT INTO $querycache (qc_type,qc_namespace,qc_title,qc_value) VALUES ";
		while( $row = $dbr->fetchObject( $res ) ) {
			if( $first ) {
				$first = false;
			} else {
				$insertSql .= ',';
			}
			$insertSql .= '(' .
				$dbr->addQuotes( 'fr_unreviewedpages' ) . ',' .
				$dbr->addQuotes( $row->page_namespace ) . ',' .
				$dbr->addQuotes( $row->page_title ) . ',' .
				$dbr->addQuotes( $row->page_id ) . ')';
		}
	}
	$dbr->freeResult( $res );
	# Clear out any old cached data
	$dbw->delete( 'querycache', array( 'qc_type' => 'fr_unreviewedpages' ), __METHOD__ );
	wfWaitForSlaves( 5 );
	# Insert data
	if( !empty($insertSql) ) {
		$dbw->query( $insertSql, __METHOD__ );
	}
	# Update the querycache_info record for the page
	$dbw->delete( 'querycache_info', array( 'qci_type' => 'fr_unreviewedpages' ), __METHOD__ );
	$dbw->insert( 'querycache_info', array( 'qci_type' => 'fr_unreviewedpages', 
		'qci_timestamp' => $dbw->timestamp() ), __METHOD__ );

	/*
	 * Find pages that were never marked as "quality"...
	 */
	$res = $dbr->select( array('page','flaggedpages'),
		array( 'page_namespace', 'page_title', 'page_id' ),
		array( 'page_namespace' => $wgFlaggedRevsNamespaces, 
			'page_is_redirect' => 0, // no redirects
			'fp_page_id IS NULL OR fp_quality = 0' ),
		__METHOD__,
		array( 'LIMIT' => 5000 ),
		array( 'flaggedpages' => array('LEFT JOIN','fp_page_id = page_id') )
	);
	if( $dbr->numRows( $res ) ) {
		$first = true;
		$insertSql = "INSERT INTO $querycache (qc_type,qc_namespace,qc_title,qc_value) VALUES ";
		while( $row = $dbr->fetchObject( $res ) ) {
			if( $first ) {
				$first = false;
			} else {
				$insertSql .= ',';
			}
			$insertSql .= '(' .
				$dbr->addQuotes( 'fr_unreviewedpages_q' ) . ',' .
				$dbr->addQuotes( $row->page_namespace ) . ',' .
				$dbr->addQuotes( $row->page_title ) . ',' .
				$dbr->addQuotes( $row->page_id ) . ')';
		}
	}
	$dbr->freeResult( $res );
	# Clear out any old cached data
	$dbw->delete( 'querycache', array( 'qc_type' => 'fr_unreviewedpages_q' ), __METHOD__ );
	wfWaitForSlaves( 5 );
	# Insert data
	if( !empty($insertSql) ) {
		$dbw->query( $insertSql, __METHOD__ );
	}
	# Update the querycache_info record for the page
	$dbw->delete( 'querycache_info', array( 'qci_type' => 'fr_unreviewedpages_q' ), __METHOD__ );
	$dbw->insert( 'querycache_info', array( 'qci_type' => 'fr_unreviewedpages_q', 
		'qci_timestamp' => $dbw->timestamp() ), __METHOD__ );
	print( "done!\n" );
}
