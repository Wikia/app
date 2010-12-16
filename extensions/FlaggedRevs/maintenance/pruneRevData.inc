<?php

function prune_flaggedrevs( $start = null, $prune = false ) {
	if( $prune ) {
		echo "Pruning old flagged revision inclusion data...\n";
	} else {
		echo "Running dry-run of old flagged revision inclusion data pruning...\n";
	}
	
	$BATCH_SIZE = 500;
	
	$db = wfGetDB( DB_MASTER );
	
	if( $start === null ) {
		$start = $db->selectField( 'flaggedpages', 'MIN(fp_page_id)', false, __FUNCTION__ );
	}
	$end = $db->selectField( 'flaggedpages', 'MAX(fp_page_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ) {
		echo "...flaggedpages table seems to be empty.\n";
		return;
	}
	$end += $BATCH_SIZE - 1; # Do remaining chunk
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	
	$tDeleted = $fDeleted = 0; // tallies
	
	$newerRevs = 50;
	$cutoff = $db->timestamp( time() - 30*24*3600 );
	$cutoff = $db->timestamp( time() - 3600 );
	while( $blockEnd <= $end ) {
		echo "...doing fp_page_id from $blockStart to $blockEnd\n";
		$cond = "fp_page_id BETWEEN $blockStart AND $blockEnd";
		$res = $db->select( 'flaggedpages', 'fp_page_id', $cond, __FUNCTION__ );
		$batchCount = 0; // rows deleted without slave lag check
		// Go through a chunk of flagged pages...
		while( $row = $db->fetchObject($res) ) {
			// Get the newest X ($newerRevs) flagged revs for this page
			$sres = $db->select( 'flaggedrevs',
				'fr_rev_id',
				array( 'fr_page_id' => $row->fp_page_id ),
				__METHOD__,
				array( 'ORDER BY' => 'fr_rev_id DESC', 'LIMIT' => $newerRevs )
			);
			// See if there are older revs that can be pruned...
			if( $db->numRows( $sres ) == $newerRevs ) {
				// Get the oldest of the top X revisions
				$sres->seek( $newerRevs - 1 );
				$lrow = $db->fetchObject( $sres );
				$oldestId = (int)$lrow->fr_rev_id; // oldest revision Id
				// Get revs not in the top X that were not reviewed recently
				$db->freeResult( $sres );
				$sres = $db->select( 'flaggedrevs',
					'fr_rev_id',
					array(
						'fr_page_id' => $row->fp_page_id,
						'fr_rev_id < '.$oldestId, // not in the newest X
						'fr_timestamp < '.$db->addQuotes( $cutoff ) // not reviewed recently
					),
					__METHOD__,
					// Sanity check (start with the oldest)
					array( 'ORDER BY' => 'fr_rev_id ASC', 'LIMIT' => 5000 )
				);
				// Build an array of these rev Ids
				$revsClearIncludes = array();
				foreach( $sres as $srow ) {
					$revsClearIncludes[] = $srow->fr_rev_id;
				}
				$batchCount += count($revsClearIncludes); // # of revs to prune
				$db->freeResult( $sres );
				// Write run: clear the include data for these old revs
				if( $prune ) {
					$db->begin();
					$db->delete( 'flaggedtemplates',
						array('ft_rev_id' => $revsClearIncludes),
						__METHOD__
					);
					$tDeleted += $db->affectedRows();
					$db->delete( 'flaggedimages',
						array('fi_rev_id' => $revsClearIncludes),
						__METHOD__
					);
					$fDeleted += $db->affectedRows();
					$db->commit();
				// Dry run: say how many includes rows would have been cleared
				} else if( count($revsClearIncludes) ) {
					$tDeleted += $db->selectField( 'flaggedtemplates',
						'COUNT(*)',
						array('ft_rev_id' => $revsClearIncludes),
						__METHOD__
					);
					$fDeleted += $db->selectField( 'flaggedimages',
						'COUNT(*)',
						array('fi_rev_id' => $revsClearIncludes),
						__METHOD__
					);
				}
				// Check slave lag...
				if( $batchCount >= $BATCH_SIZE ) {
					$batchCount = 0;
					wfWaitForSlaves( 5 );
				}
			} else {
				$db->freeResult( $sres );
			}
		}
		$db->freeResult( $res );
		$blockStart += $BATCH_SIZE;
		$blockEnd += $BATCH_SIZE;
	}
	if( $prune ) {
		echo "...flagged revision inclusion prunning complete ...\n";
	} else {
		echo "...flagged revision inclusion prune test complete ...\n";
	}
	echo "Rows: \tflaggedtemplates:$tDeleted\t\tflaggedimages:$fDeleted\n";
}
