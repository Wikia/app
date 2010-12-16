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
	list($page,$flaggedpages) = $dbr->tableNamesN('page','flaggedpages');
	$ns = $dbr->makeList( $wgFlaggedRevsNamespaces );
	if( empty($ns) ) return; // no SQL errors please :)

	print( "ValidationStatistics..." );

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
	// Getting mean pending edit time
	$now = time(); // current time in UNIX TS
	$avePET = (int)$dbr->selectField( array('flaggedpages','page'),
		"AVG( $now - UNIX_TIMESTAMP(fp_pending_since) )",
		array( 'fp_pending_since IS NOT NULL', 
			'fp_page_id = page_id',
			'page_namespace' => $wgFlaggedRevsNamespaces // Sanity check the NS
		),
		__METHOD__,
		array( 'USE INDEX' => array('flaggedpages' => 'fp_pending_since') )
	);
	// Get the mean edit review time
	$size = 10000; // Sample size
	$seconds = $aveRT = $medianRT = 0;
	# Only go so far back...otherwise we will get garbage values due to 
	# the fact that FlaggedRevs wasn't enabled until after a while.
	$installed = $dbr->selectField( 'logging', 'MIN(log_timestamp)',
		array('log_type' => 'review') );
	if( !$installed ) $installed = $dbr->timestamp(); // now
	# Skip the most recent recent revs as they are likely to just 
	# be WHERE condition misses. This also gives us more data to use.
	# Lastly, we want to avoid bias that would make the time too low
	# since new revisions could not have "took a long time to sight".
	$worstLagTS = $dbr->timestamp(); // now
	$last = '0';
	while( true ) { // should almost always be ~1 pass
		# Get the page with the worst pending lag...
		$row = $dbr->selectRow( array('flaggedpages','flaggedrevs','page'),
			array( 'fp_page_id', 'fp_stable', 'fp_pending_since', 'fr_timestamp' ),
			array( 
				'fp_pending_since > '.$dbr->addQuotes($installed), // needs actual display lag
				'fr_page_id = fp_page_id AND fr_rev_id = fp_stable',
				'fp_pending_since > '.$dbr->addQuotes($last), // skip failed rows
				'page_id = fp_page_id', // get page title
				'page_namespace' => $wgFlaggedRevsNamespaces // sanity check NS
			),
			__METHOD__,
			array( 'ORDER BY' => 'fp_pending_since ASC',
				'USE INDEX' => array('flaggedpages' => 'fp_pending_since') )
		);
		if( !$row ) break;
		# Find the newest revision at the time the page was reviewed,
		# this is the one that *should* have been reviewed.
		$idealRev = (int)$dbr->selectField( 'revision', 'rev_id', 
			array( 'rev_page' => $row->fp_page_id, 
				'rev_timestamp < '.$dbr->addQuotes($row->fr_timestamp) ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp DESC', 'LIMIT' => 1 )
		);
		# Fudge factor to prevent deliberate reviewing of non-current revisions
		# from squeezing the range. Shouldn't effect anything otherwise.
		if( $row->fp_stable >= $idealRev ) {
			$worstLagTS = $row->fp_pending_since;
			break;
		} else {
			$last = $row->fp_pending_since; // next iteration
		}
	}
	# Add a day for good measure to avoid bias
	$maxTS = $dbr->timestamp( wfTimestamp(TS_UNIX,$worstLagTS) - 86400 );
	$encMaxTS = $dbr->addQuotes( $maxTS );
	# Use a one week time range
	$minTS = $dbr->timestamp( wfTimestamp(TS_UNIX,$worstLagTS) - 7*86400 );
	$encMinTS = $dbr->addQuotes( $minTS );
	# Approximate the number rows to scan
	$rows = $dbr->estimateRowCount( 'revision', '1',
		'rev_user=0 AND rev_timestamp BETWEEN '.$encMinTS.' AND '.$encMaxTS
	);
	# If the range doesn't have many rows (like on small wikis), use 14 days
	if( $rows < 500 ) {
		$minTS = $dbr->timestamp( wfTimestamp(TS_UNIX,$worstLagTS) - 14*86400 );
		# Approximate rows to scan
		$rows = $dbr->estimateRowCount( 'revision', '1',
			'rev_user=0 AND rev_timestamp BETWEEN '.$encMinTS.' AND '.$encMaxTS
		);
		# If the range doesn't have many rows (like on really small wikis), use 30 days
		if( $rows <= 500 ) {
			$minTS = $dbr->timestamp( wfTimestamp(TS_UNIX,$worstLagTS) - 30*86400 );
			# Approximate rows to scan
			$rows = $dbr->estimateRowCount( 'revision', '1',
				'rev_user=0 AND rev_timestamp BETWEEN '.$encMinTS.' AND '.$encMaxTS
			);
			# If the range doesn't have many rows (like on really tiny wikis), use 90 days
			if( $rows <= 500 ) {
				$minTS = $dbr->timestamp( wfTimestamp(TS_UNIX,$worstLagTS) - 90*86400 );
			}
		}
	}
	# Sanity check the starting timestamp
	$minTS = max($minTS,$installed);
	# Get timestamp boundaries
	$timeCondition = 'rev_timestamp BETWEEN '.$encMinTS.' AND '.$encMaxTS;
	# Modulus (to spread out over range)
	$mod = intval($rows/$size);
	$mod = max($mod,1); # $mod >= 1
	# For edits that started off pending, how long do they take to get reviewed?
	# Get the *first* reviewed rev *after* each RC item and get the average difference.
	# Only do this for revisions to pages that *were* already logged as reviewed.
	$sql = $dbr->selectSQLText( array('revision','page','logging','flaggedrevs'),
		array(
			'UNIX_TIMESTAMP(rev_timestamp) AS rt', // edit time
			'UNIX_TIMESTAMP(MIN(fr_timestamp)) AS ft', // revision flagging time
			'MIN(log_timestamp)' // page flagging time
		),
		array(
			$timeCondition, // in time range
			'rev_user = 0', // IP edits (should start off unreviewed)
			"(rev_id % $mod) = 0", // Better spread
		),
		__METHOD__,
		array(
			'GROUP BY'  => 'rev_id', // stats are for each edit and ID is unique
			'ORDER BY'  => 'rev_id ASC', // slight bias avoidance, if any
			'LIMIT'     => $size, // sample size
			'USE INDEX' => array('page' => 'PRIMARY','flaggedrevs' => 'PRIMARY',
								'logging' => 'page_time')
		),
		array( // Assumes title unchanged (reasonable). Double-check NS though.
			'page' => array('INNER JOIN', array('page_id = rev_page',
				'page_namespace' => $wgFlaggedRevsNamespaces)),
			// Check that this page was stable at the time...
			// Assumes that reviewed pages stay reviewed (reasonable).
			'logging' => array('INNER JOIN','log_namespace = page_namespace
				AND log_title = page_title AND log_type = "review"
				AND log_timestamp < rev_timestamp'),
			// Check *if* it was later reviewed
			'flaggedrevs' => array('LEFT JOIN', 'fr_page_id = page_id
				AND fr_rev_id >= rev_id AND fr_timestamp > rev_timestamp'),
		)
	);
	# Actually run the query...
	$res = $dbr->doQuery( $sql, __METHOD__ );
	$data = array(); // percentiles
	if( $count = $dbr->numRows($res) ) {
		$censored = 0;
		$times = array();
		# Get the sum of elapsed times
		while( $row = $dbr->fetchObject($res) ) {
			# Reviewed: just subtract the times
			if( $row->ft ) {
				$time = $row->ft - $row->rt;
				$seconds += $time;
				$times[] = $time;
			# Not reviewed: censored data
			} else {
				$seconds += ($now - $row->rt);
				$censored++;
			}
			#echo( "\nedit:".$row->rt . "\treviewed:" . $row->ft );
		}
		$aveRT = $seconds/($count - $censored); // sample mean
		sort($times); // order smallest -> largest
		// Sample median
		$rank = round( count($times)/2 + .5 ) - 1;
		$medianRT = $times[$rank];
		// Make percentile tabulation data
		$percentile = 35; // start at 35th
		while( $percentile < 100 ) {
			$rank = round( $percentile*count($times)/100 + .5 ) - 1;
			$data[$percentile] = $times[$rank];
			$percentile += 10;
		}
	}
	// Save/cache percentiles
	$key = wfMemcKey( 'flaggedrevs', 'reviewPercentiles' );
	$dbCache = wfGetCache( CACHE_DB );
	$dbCache->set( $key, $data, 30*24*3600 );
	// Save the data
	$dbw = wfGetDB( DB_MASTER );
	$dbw->begin();
	// Create small stats tables if not present
	$flaggedrevs_stats = $dbr->tableName('flaggedrevs_stats');
	$flaggedrevs_stats2 = $dbr->tableName('flaggedrevs_stats2');
	if( !$dbw->tableExists( 'flaggedrevs_stats' ) ) {
		createFlaggedRevsStatsTable( $dbw, $flaggedrevs_stats );
	}
	if( !$dbw->tableExists( 'flaggedrevs_stats2' ) ) {
		createFlaggedRevsStatsTable2( $dbw, $flaggedrevs_stats2 );
	}
	// Per-namespace stats...
	foreach( $wgFlaggedRevsNamespaces as $namespace ) {
		$dbw->replace( 'flaggedrevs_stats',
			array( 'namespace' ),
			array( 'namespace' => intval($namespace),
				'total'    => isset($ns_total[$namespace]) ? $ns_total[$namespace] : 0,
				'reviewed' => isset($ns_reviewed[$namespace]) ? $ns_reviewed[$namespace] : 0,
				'synced'   => isset($ns_synced[$namespace]) ? $ns_synced[$namespace] : 0
			),
			__METHOD__
		);
	}
	// Overall stats...
	$dbw->replace( 'flaggedrevs_stats2',
		array( 'stat_id' ),
		array( 'stat_id' => 1,
			'ave_review_time' => $aveRT,
			'med_review_time' => $medianRT,
			'ave_pending_time' => $avePET
		),
		__METHOD__
	);
	// Update timestamp
	$dbw->replace( 'querycache_info', array('qci_type'),
		array('qci_type' => 'validationstats', 'qci_timestamp' => $dbw->timestamp()),
		__METHOD__
	);
	$dbw->commit();
	// Stats are now up to date!
	$key = wfMemcKey( 'flaggedrevs', 'statsUpdated' );
	$dbCache->set( $key, '1', $wgFlaggedRevsStatsAge );
	$dbCache->delete( $keySQL );
	print( "done updating!\n" );
}

// Per-Namespace stats
function createFlaggedRevsStatsTable( $dbw, $flaggedrevs_stats ) {
	$dbw->query( 
		"CREATE TABLE $flaggedrevs_stats (
			namespace  INTEGER UNSIGNED NOT NULL DEFAULT 0 PRIMARY KEY,
			total      INTEGER UNSIGNED NOT NULL DEFAULT 0,
			reviewed   INTEGER UNSIGNED NOT NULL DEFAULT 0,
			synced     INTEGER UNSIGNED NOT NULL DEFAULT 0
		);"
	);
}

// General stats
function createFlaggedRevsStatsTable2( $dbw, $flaggedrevs_stats2 ) {
	$dbw->query( 
		"CREATE TABLE $flaggedrevs_stats2 (
			stat_id          INTEGER UNSIGNED NOT NULL DEFAULT 1 PRIMARY KEY,
			ave_review_time  INTEGER UNSIGNED NOT NULL DEFAULT 0,
			med_review_time  INTEGER UNSIGNED NOT NULL DEFAULT 0,
			ave_pending_time INTEGER UNSIGNED NOT NULL DEFAULT 0
		);"
	);
}
