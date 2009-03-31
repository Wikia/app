<?php

function autoreview_current( $user, $db ) {
	global $wgFlaggedRevsNamespaces;
	echo "Auto-reviewing all current page versions...\n";
	if( !$user->getID() ) {
		echo( "Invalid user specified!" );
		exit(0);
	}
	echo "Reviewer username: ".$user->getName()."\n";
	$BATCH_SIZE = 50;
	$start = $db->selectField( 'page', 'MIN(page_id)', false, __FUNCTION__ );
	$end = $db->selectField( 'page', 'MAX(page_id)', false, __FUNCTION__ );
	if( is_null( $start ) || is_null( $end ) ){
		echo "...page table seems to be empty.\n";
		return;
	}
	# Do remaining chunk
	$end += $BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + $BATCH_SIZE - 1;
	$count = 0;
	$changed = 0;
	while( $blockEnd <= $end ) {
		echo "...doing page_id from $blockStart to $blockEnd\n";
		$cond = "page_id BETWEEN $blockStart AND $blockEnd";
		$res = $db->select( 'page', array('page_id','page_latest','page_namespace','page_title'), 
			array( $cond, 'page_namespace' => $wgFlaggedRevsNamespaces ),
			__FUNCTION__ );
		# Go through and autoreview the current version of every page...
		foreach( $res as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$rev = Revision::newFromId( $row->page_latest );
			# Is it already reviewed?
			$frev = FlaggedRevision::newFromTitle( $title, $row->page_latest, FR_FOR_UPDATE );
			# Should exist, but to be safe...
			if( !$frev && $rev && FlaggedRevs::isPageReviewable($title) ) {
				$text = $rev->getText();
				# Assume basic flagging level
				$flags = array();
				foreach( FlaggedRevs::getDimensions() as $tag => $minQL ) {
					$flags[$tag] = 1;
				}
				$article = new Article( $title );
				FlaggedRevs::autoReviewEdit( $article, $user, $text, $rev, $flags, true );
				$changed++;
				# Purge squid for this page only
				$article->getTitle()->purgeSquid();
			}
			$count++;
		}
		$db->freeResult( $res );
		$blockStart += $BATCH_SIZE - 1;
		$blockEnd += $BATCH_SIZE - 1;
		wfWaitForSlaves( 5 );
	}
	echo "Auto-reviewing of all pages complete ... {$count} rows [{$changed} changed]\n";
}

