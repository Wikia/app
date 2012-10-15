<?php

class FlaggedRevsLogView {
	/** 
	 * Add setting change description to log line
	 * @return string
	 */
	public static function stabilityLogText(
		$type, $action, $title = null, $skin = null, $params = array()
	) {
		if ( !$title ) {
			return ''; // sanity check
		}
		if ( $skin ) {
			$titleLink = $skin->link( $title, $title->getPrefixedText() );
			$text = wfMsgHtml( "stable-logentry-{$action}", $titleLink );
		} else { // for content (e.g. IRC...)
			$text = wfMsgExt( "stable-logentry-{$action}",
				array( 'parsemag', 'escape', 'replaceafter', 'content' ),
				$title->getPrefixedText() );
		}
		$pars = FlaggedRevsLog::expandParams( $params ); // list -> assoc array
		$details = self::stabilitySettings( $pars, !$skin ); // list of setting values
		$text .= " $details";
		return $text;
	}

	/**
	 * Add history page link to log line
	*
	 * @param Title $title
	 * @param string $timestamp
	 * @param array $params
	 * @return string
	 */
	public static function stabilityLogLinks( $title, $timestamp, $params ) {
		global $wgUser;
		# Add history link showing edits right before the config change
		$hist = $wgUser->getSkin()->link(
			$title,
			wfMsgHtml( 'hist' ),
			array(),
			array( 'action' => 'history', 'offset' => $timestamp )
		);
		$hist = wfMsgHtml( 'parentheses', $hist );
		return $hist;
	}

	/**
	 * Make a list of stability settings for display
	*
	 * @param array $pars assoc array
	 * @param bool $forContent
	 * @return string
	 */
	public static function stabilitySettings( array $pars, $forContent ) {
		global $wgLang, $wgContLang;
		$set = array();
		$settings = '';
		$wfMsg = $forContent ? 'wfMsgForContent' : 'wfMsg';
		$langObj = $forContent ? $wgContLang : $wgLang;
		// Protection-based configs (precedence never changed)...
		if ( !isset( $pars['precedence'] ) ) {
			if ( isset( $pars['autoreview'] ) && strlen( $pars['autoreview'] ) ) {
				$set[] = $wfMsg( 'stable-log-restriction', $pars['autoreview'] );
			}
		// General case...
		} else {
			// Default version shown on page view
			if ( isset( $pars['override'] ) ) {
				$set[] = $wfMsg( 'stabilization-def-short' ) .
					$wfMsg( 'colon-separator' ) .
					$wfMsg( 'stabilization-def-short-' . $pars['override'] );
			}
			// Autoreview restriction
			if ( isset( $pars['autoreview'] ) && strlen( $pars['autoreview'] ) ) {
				$set[] = 'autoreview=' . $pars['autoreview'];
			}
		}
		if ( $set ) {
			$settings = '[' . $langObj->commaList( $set ) . ']';
		}
		# Expiry is a MW timestamp or 'infinity'
		if ( isset( $pars['expiry'] ) && $pars['expiry'] != 'infinity' ) {
			$expiry_description = $wfMsg( 'stabilize-expiring',
				$langObj->timeanddate( $pars['expiry'], false, false ) ,
				$langObj->date( $pars['expiry'], false, false ) ,
				$langObj->time( $pars['expiry'], false, false )
			);
			if ( $settings != '' ) $settings .= ' ';
			$settings .= $wfMsg( 'parentheses', $expiry_description );
		}
		return htmlspecialchars( $settings );
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
				$msg = FlaggedRevsLog::isReviewDeapproval( $action )
					? 'review-logentry-diff2' // unreviewed
					: 'review-logentry-diff'; // reviewed
				$links .= '(';
				$links .= $wgUser->getSkin()->linkKnown(
					$title,
					wfMsgHtml( $msg ),
					array(),
					array( 'oldid' => $oldStable, 'diff' => $revId )
				);
				$links .= ')';
			}
			# Show a diff link to this revision
			$ts = empty( $params[2] )
				? Revision::getTimestampFromId( $title, $revId )
				: $params[2];
			$time = $wgLang->timeanddate( $ts, true );
			$links .= ' (';
			$links .= $wgUser->getSkin()->linkKnown(
				$title,
				wfMsgHtml( 'review-logentry-id', $revId, $time ),
				array(),
				array( 'oldid' => $revId, 'diff' => 'prev' ) + FlaggedRevs::diffOnlyCGI()
			);
			$links .= ')';
		}
		return $links;
	}
}
