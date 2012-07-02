<?php

class FlaggedRevsLog {
	/**
	 * $action is a valid review log action
	 * @return bool
	 */
	public static function isReviewAction( $action ) {
		return preg_match( '/^(approve2?(-i|-a|-ia)?|unapprove2?)$/', $action );
	}

	/**
	 * $action is a valid stability log action
	 * @return bool
	 */
	public static function isStabilityAction( $action ) {
		return preg_match( '/^(config|modify|reset)$/', $action );
	}

	/**
	 * $action is a valid review log deprecate action
	 * @return bool
	 */
	public static function isReviewDeapproval( $action ) {
		return ( $action == 'unapprove' || $action == 'unapprove2' );
	}

	/**
	 * Record a log entry on the review action
	 * @param Title $title
	 * @param array $dims
	 * @param array $oldDims
	 * @param string $comment
	 * @param int $revId, revision ID
	 * @param int $stableId, prior stable revision ID
	 * @param bool $approve, approved? (otherwise unapproved)
	 * @param bool $auto
	 */
	public static function updateReviewLog(
		Title $title, array $dims, array $oldDims,
		$comment, $revId, $stableId, $approve, $auto = false
	) {
		$log = new LogPage( 'review',
			false /* $rc */,
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
		# Param format is <rev id, old stable id, rev timestamp>
		$logid = $log->addEntry( $action, $title, $comment, array( $revId, $stableId, $ts ) );
		# Make log easily searchable by rev_id
		$log->addRelations( 'rev_id', array( $revId ), $logid );
	}

	/**
	 * Record a log entry on the stability config change action
	 * @param Title $title
	 * @param array $config
	 * @param array $oldConfig
	 * @param string $reason
	 * @param bool $auto
	 */
	public static function updateStabilityLog(
		Title $title, array $config, array $oldConfig, $reason
	) {
		$log = new LogPage( 'stable' );
		if ( FRPageConfig::configIsReset( $config ) ) {
			# We are going back to default settings
			$log->addEntry( 'reset', $title, $reason );
		} else {
			# We are changing to non-default settings
			$action = ( $oldConfig === FRPageConfig::getDefaultVisibilitySettings() )
				? 'config' // set a custom configuration
				: 'modify'; // modified an existing custom configuration
			$log->addEntry( $action, $title, $reason,
				FlaggedRevsLog::collapseParams( self::stabilityLogParams( $config ) ) );
		}
	}

	/**
	 * Get log params (associate array) from a stability config
	 * @param array $config
	 * @return array (associative)
	 */
	public static function stabilityLogParams( array $config ) {
		$params = $config;
		if ( !FlaggedRevs::useOnlyIfProtected() ) {
			$params['precedence'] = 1; // b/c hack for presenting log params...
		}
		return $params;
	}

	/**
	 * Collapse an associate array into a string
	 * @param array $pars
	 * @return string
	 */
	public static function collapseParams( array $pars ) {
		$res = array();
		foreach ( $pars as $param => $value ) {
			// Sanity check...
			if ( strpos( $param, '=' ) !== false || strpos( $value, '=' ) !== false ) {
				throw new MWException( "collapseParams() - cannot use equal sign" );
			} elseif ( strpos( $param, "\n" ) !== false || strpos( $value, "\n" ) !== false ) {
				throw new MWException( "collapseParams() - cannot use newline" );
			}
			$res[] = "{$param}={$value}";
		}
		return implode( "\n", $res );
	}

	/**
	 * Expand a list of log params into an associative array
	 * @params array $pars
	 * @return array (associative)
	 */
	public static function expandParams( array $pars ) {
		$res = array();
		$pars = array_filter( $pars, 'strlen' );
		foreach ( $pars as $paramAndValue ) {
			list( $param, $value ) = explode( '=', $paramAndValue, 2 );
			$res[$param] = $value;
		}
		return $res;
	}
}
