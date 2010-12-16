<?php

function update_flaggedrevs( $start = null ) {
	echo "Populating and correcting flaggedrevs columns\n";
	
	$BATCH_SIZE = 500;
	
	$db = wfGetDB( DB_MASTER );
	
	if( $start === null ) {
		$start = $db->selectField( 'revision', 'MIN(rev_id)', false, __FUNCTION__ );
	}
	$end = $db->selectField( 'revision', 'MAX(rev_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...revision table seems to be empty.\n";
		return;
	}
	# Do remaining chunk
	$end += $BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	$count = 0;
	$changed = 0;
	while( $blockEnd <= $end ) {
		echo "...doing fr_rev_id from $blockStart to $blockEnd\n";
		$cond = "rev_id BETWEEN $blockStart AND $blockEnd 
			AND fr_page_id = rev_page AND fr_rev_id = rev_id AND page_id = rev_page";
		$res = $db->select( array('revision','flaggedrevs','page'),
			array('fr_rev_id','fr_tags','fr_quality','page_namespace','page_title',
				'fr_img_name','fr_img_timestamp','fr_img_sha1','rev_page'), 
			$cond, __FUNCTION__ );
		# Go through and clean up missing items, as well as correct fr_quality...
		foreach( $res as $row ) {
			$tags = FlaggedRevision::expandRevisionTags( $row->fr_tags );
			# Quality rating levels may have changed due to config tweaks...
			if( FlaggedRevs::isPristine( $tags ) ) {
				$quality = 2;
			} else {
				$quality = FlaggedRevs::isQuality( $tags ) ? 1 : 0;
			}
			$time = $sha1 = $file = null;
			# Check for file version to see if it's stored the old way...
			if( !$row->fr_img_name && $row->page_namespace == NS_IMAGE ) {
				$irow = $db->selectRow( 'flaggedimages',
					array( 'fi_img_timestamp', 'fi_img_sha1' ),
					array( 'fi_rev_id' => $row->fr_rev_id,
						'fi_name' => $row->page_title ),
					__METHOD__ );
				$time = $irow ? $irow->fi_img_timestamp : null;
				$sha1 = $irow ? $irow->fi_img_sha1 : null;
				$file = $irow ? $row->page_title : null;
				# Fill in from current if broken
				if( !$irow ) {
					$crow = $db->selectRow( 'image',
						array( 'img_timestamp', 'img_sha1' ),
						array( 'img_name' => $row->page_title ),
						__METHOD__ );
					$time = $crow ? $crow->img_timestamp : null;
					$sha1 = $crow ? $crow->img_sha1 : null;
					$file = $crow ? $row->page_title : null;
				}
			# Leave it alone if already set
			} elseif( $row->fr_img_name && $row->page_namespace == NS_IMAGE ) {
				$time = $row->fr_img_timestamp;
				$sha1 = $row->fr_img_sha1;
				$file = $row->fr_img_name;
			}
			if( $file &&
				($file != $row->fr_img_name
				|| $time != $row->fr_img_timestamp
				|| $sha1 != $row->fr_img_sha1) )
			{
				$changed++;
			} else if ( $quality != $row->fr_quality ) {
				$changed++;
			}
			# Update the row...
			$db->begin();
			$db->update( 'flaggedrevs',
				array( 'fr_quality' => $quality,
					'fr_img_name' => $file,
					'fr_img_sha1' => $sha1,
					'fr_img_timestamp' => $time ),
				array( 'fr_rev_id' => $row->fr_rev_id, 'fr_page_id' => $row->rev_page ),
				__FUNCTION__ );
			$db->commit();
			$count++;
		}
		$db->freeResult( $res );
		$blockStart += $BATCH_SIZE;
		$blockEnd += $BATCH_SIZE;
		wfWaitForSlaves( 5 );
	}
	echo "fr_quality and fr_img_* columns update complete ... {$count} rows [{$changed} changed]\n";
}

function update_flaggedpages( $start = null ) {
	echo "Populating and correcting flaggedpages/flaggedpage_config columns\n";
	
	$BATCH_SIZE = 300;
	
	$db = wfGetDB( DB_MASTER );
	
	$start = $start ? $start : $db->selectField( 'page', 'MIN(page_id)', false, __FUNCTION__ );
	$end = $db->selectField( 'page', 'MAX(page_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...flaggedpages table seems to be empty.\n";
		return;
	}
	# Do remaining chunk
	$end += $BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	$count = $deleted = $fixed = 0;
	while( $blockEnd <= $end ) {
		echo "...doing page_id from $blockStart to $blockEnd\n";
		$cond = "page_id BETWEEN $blockStart AND $blockEnd";
		$res = $db->select( 'page', array('page_id','page_namespace','page_title','page_latest'),
			$cond, __FUNCTION__ );
		# Go through and update the de-normalized references...
		$db->begin();
		foreach( $res as $row ) {
			$title = Title::newFromRow( $row );
			$article = new Article( $title );
			# Replaces new fields into flaggedpages
			$frev = FlaggedRevision::newFromStable( $title, FR_FOR_UPDATE );
			# Update fp_stable, fp_quality, and fp_reviewed
			if( $frev ) {
				FlaggedRevs::updateStableVersion( $article, $frev->getRevision(), $row->page_latest );
			# Somethings broke? Delete the row...
			} else {
				FlaggedRevs::clearTrackingRows( $row->page_id );
				if( $db->affectedRows() > 0 ) $deleted++;
			}
			# Get the latest revision
			$revRow = $db->selectRow( 'revision', '*', array('rev_page' => $row->page_id), __FUNCTION__,
				array('ORDER BY' => 'rev_timestamp DESC') );
			# Correct page_latest if needed (import/files made plenty of bad rows)
			if( $revRow ) {
				$revision = new Revision( $revRow );
				if( $article->updateIfNewerOn( $db, $revision ) )
					$fixed++;
			}
			$count++;
		}
		$db->freeResult( $res );
		# Remove manual config settings that simply restate the site defaults
		$db->delete( 'flaggedpage_config',
			array( "fpc_page_id BETWEEN $blockStart AND $blockEnd",
				'fpc_select'   	=> FlaggedRevs::getPrecedence(),
				'fpc_override' 	=> intval( FlaggedRevs::isStableShownByDefault() ),
				'fpc_level' 	=> ''
			),
			__FUNCTION__
		);
		$deleted = $deleted + $db->affectedRows();
		$db->commit();
		$blockStart += $BATCH_SIZE;
		$blockEnd += $BATCH_SIZE;
		wfWaitForSlaves( 5 );
	}
	echo "flaggedpage columns update complete ... {$count} rows [{$fixed} fixed] [{$deleted} deleted]\n";
}

function update_flaggedtemplates( $start = null ) {
	echo "Removing unreferenced flaggedtemplates columns\n";
	
	$BATCH_SIZE = 500;
	
	$db = wfGetDB( DB_MASTER );
	
	if( $start === null ) {
		$start = $db->selectField( 'flaggedtemplates', 'MIN(ft_rev_id)', false, __FUNCTION__ );
	}
	$end = $db->selectField( 'flaggedtemplates', 'MAX(ft_rev_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...flaggedtemplates table seems to be empty.\n";
		return;
	}
	# Do remaining chunk
	$end += $BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	$count = 0;
	$deleted = 0;
	while( $blockEnd <= $end ) {
		echo "...doing ft_rev_id from $blockStart to $blockEnd\n";
		$cond = "ft_rev_id BETWEEN $blockStart AND $blockEnd";
		$res = $db->select( 'flaggedtemplates', array('ft_rev_id'), $cond, __FUNCTION__ );
		# Go through and update the de-normalized references...
		foreach( $res as $row ) {
			$revision = Revision::newFromId( $row->ft_rev_id );
			# Replaces new fields into flaggedpages
			$frev = $revision
				? FlaggedRevision::newFromTitle( $revision->getTitle(), $row->ft_rev_id )
				: null;
			# Somethings broke? Delete the row...
			if( !$frev ) {
				$db->begin();
				$db->delete( 'flaggedtemplates', 
					array( 'ft_rev_id' => $row->ft_rev_id ),
					__FUNCTION__ );
				if( $db->affectedRows() > 0 )
					$deleted++;
				$db->commit();
			}
			$count++;
		}
		$db->freeResult( $res );
		$blockStart += $BATCH_SIZE;
		$blockEnd += $BATCH_SIZE;
		wfWaitForSlaves( 5 );
	}
	echo "flaggedtemplates columns update complete ... {$count} rows [{$deleted} deleted]\n";
}

function update_flaggedimages( $start = null ) {
	echo "Removing unreferenced flaggedimages columns\n";
	
	$BATCH_SIZE = 500;
	
	$db = wfGetDB( DB_MASTER );
	
	if( $start === null ) {
		$start = $db->selectField( 'flaggedimages', 'MIN(fi_rev_id)', false, __FUNCTION__ );
	}
	$end = $db->selectField( 'flaggedimages', 'MAX(fi_rev_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...flaggedimages table seems to be empty.\n";
		return;
	}
	# Do remaining chunk
	$end += $BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	$count = 0;
	$deleted = 0;
	while( $blockEnd <= $end ) {
		echo "...doing fi_rev_id from $blockStart to $blockEnd\n";
		$cond = "fi_rev_id BETWEEN $blockStart AND $blockEnd";
		$res = $db->select( 'flaggedimages', array('fi_rev_id'), $cond, __FUNCTION__ );
		# Go through and update the de-normalized references...
		foreach( $res as $row ) {
			$revision = Revision::newFromId( $row->fi_rev_id );
			# Replaces new fields into flaggedpages
			$frev = $revision
				? FlaggedRevision::newFromTitle( $revision->getTitle(), $row->fi_rev_id )
				: null;
			# Somethings broke? Delete the row...
			if( !$frev ) {
				$db->begin();
				$db->delete( 'flaggedimages', 
					array( 'fi_rev_id' => $row->fi_rev_id ),
					__FUNCTION__ );
				if( $db->affectedRows() > 0 )
					$deleted++;
				$db->commit();
			}
			$count++;
		}
		$db->freeResult( $res );
		$blockStart += $BATCH_SIZE;
		$blockEnd += $BATCH_SIZE;
		wfWaitForSlaves( 5 );
	}
	echo "flaggedtemplates columns update complete ... {$count} rows [{$deleted} deleted]\n";
}
