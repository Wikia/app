<?php


function update_autopromote() {
	global $wgContentNamespaces, $wgFlaggedRevsAutopromote;
	$batchSize = 25;
	echo "Populating and updating flaggedrevs_promote table\n";

	$db = wfGetDB( DB_SLAVE );
	$start = $db->selectField( 'user', 'MIN(user_id)', false, __FUNCTION__ );
	$end = $db->selectField( 'user', 'MAX(user_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...user table seems to be empty.\n";
		return;
	}
	$count = 0;
	$changed = 0;
	for ( $blockStart = $start; $blockStart <= $end; $blockStart += $batchSize ) {
		$blockEnd = min( $end, $blockStart + $batchSize - 1 );
		echo "...doing user_id from $blockStart to $blockEnd\n";
		$cond = "user_id BETWEEN $blockStart AND $blockEnd\n";
		$res = $db->select( 'user', '*', $cond, __FUNCTION__ );
		# Go through and clean up missing items, as well as correct fr_quality...
		foreach( $res as $row ) {
			$user = User::newFromRow( $row );
			$p = FlaggedRevs::getUserParams( $user->getId() );
			$oldp = $p;
			# Get edit comments used
			$sres = $db->select( 'revision', '1',
				array( 'rev_user' => $user->getID(),
					'rev_comment != ""' ),
				__METHOD__,
				array( 'LIMIT' => max($wgFlaggedRevsAutopromote['editComments'],500) )
			);
			$p['editComments'] = $db->numRows( $sres );
			# Get content page edits
			$sres = $db->select( array('revision','page'), '1',
				array( 'rev_user' => $user->getID(),
					'page_id = rev_page',
					'page_namespace' => $wgContentNamespaces ),
				__METHOD__,
				array( 'LIMIT' => max($wgFlaggedRevsAutopromote['totalContentEdits'],500) )
			);
			$p['totalContentEdits'] = $db->numRows( $sres );
			# Get unique content pages edited
			$sres = $db->select( array('revision','page'), 'DISTINCT(rev_page)',
				array( 'rev_user' => $user->getID(),
					'page_id = rev_page', 
					'page_namespace' => $wgContentNamespaces ),
				__METHOD__,
				array( 'LIMIT' => max($wgFlaggedRevsAutopromote['uniqueContentPages'],50) )
			);
			$p['uniqueContentPages'] = $db->numRows( $sres );
			# Get reviewed edits
			$sres = $db->select( array('revision','flaggedrevs'), '1',
				array( 'rev_user' => $user->getID(),
					'fr_page_id = rev_page',
					'fr_rev_id = rev_id' ),
				__METHOD__,
				array( 'LIMIT' => max($wgFlaggedRevsAutopromote['totalReviewedEdits'],500) )
			);
			$p['reviewedEdits'] = $db->numRows( $sres );
		
			if( $oldp != $p ) {
				FlaggedRevs::saveUserParams( $user->getId(), $p );
				$changed++;
			}
		
			$count++;
		}
		wfWaitForSlaves( 5 );
	}
	echo "flaggedrevs_promote table update complete ... {$count} rows [{$changed} changed or added]\n";
}
