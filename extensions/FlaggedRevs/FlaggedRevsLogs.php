<?php

class FlaggedRevsLogs {
	/**
	* @returns bool
	* $action is a valid review log action
	*/
	public static function isReviewAction( $action ) {
		return preg_match( '/^(approve2?(-i|-a|-ia)?|unapprove2?)$/', $action );
	}

	/**
	* @returns bool
	* $action is a valid review log deprecate action
	*/
	public static function isReviewDeapproval( $action ) {
		return ( $action == 'unapprove' || $action == 'unapprove2' );
	}

	/**
	* @param Title $title
	* @param string $timestamp
	* @returns string
	* Create history links for log line entry
	*/
	public static function stabilityLogLinks( $title, $timestamp ) {
		global $wgUser;
		# Add history link showing edits right before the config change
		$links = ' (';
		$links .= $wgUser->getSkin()->link(
			$title,
			wfMsgHtml( 'hist' ),
			array(),
			array( 'action' => 'history', 'offset' => $timestamp )
		);
		$links .= ')';
		return $links;
	}
	
	/**
	* Create revision, diff, and history links for log line entry
	*/
	public static function reviewLogLinks( $action, $title, $params ) {
		global $wgUser, $wgLang;
		$links = '';
		# Show link to page with oldid=x as well as the diff to the former stable rev.
		# Param format is <rev id, last stable id, rev timestamp>.
		if ( isset( $params[0] ) ) {
			$revId = (int)$params[0]; // the revision reviewed
			$oldStable = isset( $params[1] ) ? (int)$params[1] : 0;
			# Show diff to changes since the prior stable version
			if ( $oldStable && $revId > $oldStable ) {
				$msg = self::isReviewDeapproval( $action )
					? 'review-logentry-diff2' // unreviewed
					: 'review-logentry-diff'; // reviewed
				$links .= '(';
				$links .= $wgUser->getSkin()->makeKnownLinkObj(
					$title,
					wfMsgHtml( $msg ),
					"oldid={$oldStable}&diff={$revId}"
				);
				$links .= ')';
			}
			# Show a diff link to this revision
			$ts = empty( $params[2] )
				? Revision::getTimestampFromId( $title, $revId )
				: $params[2];
			$time = $wgLang->timeanddate( $ts );
			$links .= ' (';
			$links .= $wgUser->getSkin()->makeKnownLinkObj(
				$title,
				wfMsgHtml( 'review-logentry-id', $revId, $time ),
				"oldid={$revId}&diff=prev&diffonly=0"
			);
			$links .= ')';
		}
		return $links;
	}

	/**
	 * Record a log entry on the action
	 * @param Title $title
	 * @param array $dims
	 * @param array $oldDims
	 * @param string $comment
	 * @param int $revId, revision ID
	 * @param int $stableId, prior stable revision ID
	 * @param bool $approve, approved? (otherwise unapproved)
	 * @param bool $auto
	 */
	public static function updateLog( $title, $dims, $oldDims, $comment,
		$revId, $stableId, $approve, $auto = false )
	{
		global $wgFlaggedRevsLogInRC;
		$log = new LogPage( 'review',
			$auto ? false : $wgFlaggedRevsLogInRC, // RC logging
			$auto ? "skipUDP" : "UDP" // UDP logging
		);
		# Tag rating list (e.g. accuracy=x, depth=y, style=z)
		$ratings = array();
		# Skip rating list if flagging is just an 0/1 feature...
		if ( !FlaggedRevs::binaryFlagging() ) {
			foreach ( $dims as $quality => $level ) {
				$ratings[] = wfMsgForContent( "revreview-$quality" ) .
					wfMsgForContent( 'colon-separator' ) .
					wfMsgForContent( "revreview-$quality-$level" );
			}
		}
		$isAuto = ( $auto && !FlaggedRevs::isQuality( $dims ) ); // Paranoid check
		// Approved revisions
		if ( $approve ) {
			if ( $isAuto ) {
				$comment = wfMsgForContent( 'revreview-auto' ); // override this
			}
			# Make comma-separated list of ratings
			$rating = !empty( $ratings )
				? '[' . implode( ', ', $ratings ) . ']'
				: '';
			# Append comment with ratings
			if ( $rating != '' ) {
				$comment .= $comment ? " $rating" : $rating;
			}
			# Sort into the proper action (useful for filtering)
			$action = ( FlaggedRevs::isQuality( $dims ) || FlaggedRevs::isQuality( $oldDims ) ) ?
				'approve2' : 'approve';
			if ( !$stableId ) { // first time
				$action .= $isAuto ? "-ia" : "-i";
			} elseif ( $isAuto ) { // automatic
				$action .= "-a";
			}
		// De-approved revisions
		} else {
			$action = FlaggedRevs::isQuality( $oldDims ) ?
				'unapprove2' : 'unapprove';
		}
		$ts = Revision::getTimestampFromId( $title, $revId );
		# Param format is <rev id,old stable id, rev timestamp>
		$log->addEntry( $action, $title, $comment, array( $revId, $stableId, $ts ) );
	}
}
