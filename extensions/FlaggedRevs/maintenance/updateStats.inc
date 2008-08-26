<?php

if( php_sapi_name() != 'cli' ) {
	print( 'Invalid entry' );
	die( 1 );
}

function update_flaggedrevs_stats() {
	global $wgFlaggedRevsNamespaces, $wgFlaggedRevsStatsAge;
	// Set key to limit duplicate updates...
	$dbCache = wfGetCache( CACHE_DB );
	$keySQL = wfMemcKey( 'flaggedrevs', 'statsUpdating' );
	$dbCache->set( $keySQL, '1', $wgFlaggedRevsStatsAge );

	$dbr = wfGetDB( DB_SLAVE );
	list($page,$flaggedpages,$flaggedrevs_stats) = $dbr->tableNamesN('page','flaggedpages','flaggedrevs_stats');
	$ns = $dbr->makeList( $wgFlaggedRevsNamespaces );
	if( empty($ns) ) {
		return; // no SQL errors please :)
	}
	$ns_total = array();
	$ns_reviewed = array();
	$ns_synced = array();
	// Get page count for each namespace
	$ret = $dbr->query( 
		"SELECT page_namespace AS namespace, COUNT(*) AS total 
		FROM $page WHERE page_is_redirect = 0 AND page_namespace IN($ns) 
		GROUP BY page_namespace"
	);
	while( $row = $dbr->fetchObject( $ret ) ) {
		$ns_total[$row->namespace] = intval($row->total);
	}
	// Get reviewed page count for each namespace
	$ret = $dbr->query( 
		"SELECT page_namespace AS namespace, COUNT(*) AS reviewed 
		FROM $flaggedpages, $page WHERE fp_page_id = page_id 
		AND page_is_redirect = 0 AND page_namespace IN($ns) 
		GROUP BY page_namespace"
	);
	while( $row = $dbr->fetchObject( $ret ) ) {
		$ns_reviewed[$row->namespace] = intval($row->reviewed);
	}
	// Get synced page count for each namespace
	$ret = $dbr->query( 
		"SELECT page_namespace AS namespace, COUNT(*) AS synced 
		FROM $flaggedpages, $page WHERE fp_page_id = page_id 
		AND fp_reviewed = 1 AND page_is_redirect = 0 AND page_namespace IN($ns) 
		GROUP BY page_namespace"
	);
	while( $row = $dbr->fetchObject( $ret ) ) {
		$ns_synced[$row->namespace] = intval($row->synced);
	}
	$dbw = wfGetDB( DB_MASTER );
	$dbw->begin();
	// Create a small stats table if not present
	if( !$dbw->tableExists( 'flaggedrevs_stats' ) ) {
		createFlaggedRevsStatsTable( $dbw, $flaggedrevs_stats );
	}
	foreach( $wgFlaggedRevsNamespaces as $namespace ) {
		$dbw->replace( 'flaggedrevs_stats',
			array( 'namespace' ),
			array( 'namespace' => intval($namespace),
				'total'    => isset($ns_total[$namespace]) ? $ns_total[$namespace] : 0,
				'reviewed' => isset($ns_reviewed[$namespace]) ? $ns_reviewed[$namespace] : 0,
				'synced'   => isset($ns_synced[$namespace]) ? $ns_synced[$namespace] : 0 ),
			__METHOD__
		);
	}
	$dbw->commit();
	// Stats are not up to date!
	$key = wfMemcKey( 'flaggedrevs', 'statsUpdated' );
	$dbCache->set( $key, '1', $wgFlaggedRevsStatsAge );
	$dbCache->delete( $keySQL );
	print( "Done updating!\n" );
}

function createFlaggedRevsStatsTable( $dbw, $flaggedrevs_stats ) {
	$dbw->query( 
		"CREATE TABLE $flaggedrevs_stats (
			namespace  INTEGER NOT NULL DEFAULT 0,
			total      INTEGER NOT NULL DEFAULT 0,
			reviewed   INTEGER NOT NULL DEFAULT 0,
			synced     INTEGER NOT NULL DEFAULT 0,
			PRIMARY KEY (namespace)
		);"
	);
}
