<?php

/**
 * Hooks for Usability Initiative ClickTracking extension
 *
 * @file
 * @ingroup Extensions
 */

class ClickTrackingHooks {

	/* Static Functions */

	/* initializations */

	/* 3 tables for click tracking */
	public static function schema() {
		global $wgExtNewTables, $wgExtNewIndexes;

		$wgExtNewTables[] = array(
			'click_tracking',
			dirname( __FILE__ ) . '/ClickTracking.sql'
		);

		$wgExtNewTables[] = array(
			'click_tracking_events',
			dirname( __FILE__ ) . '/ClickTrackingEvents.sql'
		);
		
		$wgExtNewIndexes[] = array(
			'click_tracking', 'click_tracking_action_time',
			dirname( __FILE__ ) . '/patch-action_time.sql'
		);

		return true;
	}

	/**
	 * Make sure the table exists for parser tests
	 * @param $tables
	 * @return unknown_type
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'click_tracking';
		$tables[] = 'click_tracking_events';
		return true;
	}

	/**
	 * Check to see if user is throttled
	 */
	public static function isUserThrottled() {
		global $wgClickTrackThrottle;
		return !( $wgClickTrackThrottle >= 0 && rand() % $wgClickTrackThrottle == 0 );
	}

	/**
	 * Adds JavaScript
	 */
	public static function addJS() {
		global $wgClickTrackingStyleVersion;
		
		// HACK: Only add scripts when they're really needed by not initializing UIH here
		//UsabilityInitiativeHooks::initialize();
		UsabilityInitiativeHooks::addScript( 'ClickTracking/ClickTracking.js', $wgClickTrackingStyleVersion );
		UsabilityInitiativeHooks::addVariables(
			array(
				'wgTrackingToken' => ClickTrackingHooks::get_session_id(),
				'wgClickTrackingIsThrottled' => ClickTrackingHooks::isUserThrottled()
			)
		);

		return true;
	}

	/**
	 * Gets the session ID...we just want a unique random ID for the page load
	 * @return session ID
	 */
	public static function get_session_id() {
		global $wgUser;
		return wfGenerateToken( array( $wgUser->getName(), time() ) );
	}

	/**
	 * Get the number of revisions a user has made since a given time
	 * @param $ts beginning timestamp
	 * @return number of revsions this user has made
	 */
	public static function getEditCountSince( $ts ) {
		global $wgUser;

		// convert to just the day
		$time = gmdate( 'Y-m-d', wfTimestamp( TS_UNIX, $ts ) );

		$dbr = wfGetDB( DB_SLAVE );

		$edits = $dbr->selectField(
			'user_daily_contribs',
			'SUM(contribs)',
			array(
				'user_id' => $wgUser->getId(),
				"day >= " . $dbr->addQuotes( $time )
			),
			__METHOD__
		);

		// user hasn't made any edits in whatever amount of time
		if ( $edits == null ) {
			$edits = 0;
		}

		return $edits;
	}

	/**
	 * Get event ID from name
	 * @param $event_name String: name of the event to get
	 * @return integer
	 */
	public static function getEventIDFromName( $event_name ) {
		$dbw = wfGetDB( DB_MASTER ); // replication lag means sometimes a new event will not exist in the table yet

		$id_num = $dbw->selectField(
			'click_tracking_events',
			'id',
			array(
				'event_name' => $event_name
			),
			__METHOD__
		);

		// if this entry doesn't exist...
		// this will be incredibly rare as the whole database will only have a few hundred entries in it at most
		// and getting DB_MASTER up top would be wasteful
		// FIXME: Use replace() instead of this selectField --> insert or update logic
		if ( $id_num === false ) {
			$dbw->insert(
				'click_tracking_events',
				array( 'event_name' => (string) $event_name ),
				__METHOD__
			);
			$id_num = $dbw->insertId();
		}

		if ( $id_num === false ) {
			return 0;
		}

		return $id_num;
	}

	/**
	 * Track particular event
	 * @param $session_id String: unique session id for this editing sesion
	 * @param $is_logged_in Boolean: whether or not the user is logged in
	 * @param $namespace Integer: namespace the user is editing
	 * @param $event_id Integer: event type
	 * @param $contribs Integer: contributions the user has made (or NULL if user not logged in)
	 * @param $contribs_in_timespan1 Integer: number of contributions user has made in timespan of granularity 1 (defined by ClickTracking/$wgClickTrackContribGranularity1)
	 * @param $contribs_in_timespan2 Integer: number of contributions user has made in timespan of granularity 2 (defined by ClickTracking/$wgClickTrackContribGranularity2)
	 * @param $contribs_in_timespan3 Integer: number of contributions user has made in timespan of granularity 3 (defined by ClickTracking/$wgClickTrackContribGranularity3)
	 * @return true if the event was stored in the DB
	 */
	public static function trackEvent( $session_id, $is_logged_in, $namespace, $event_id, $contribs = 0,
						$contribs_in_timespan1 = 0, $contribs_in_timespan2 = 0, $contribs_in_timespan3 = 0 ) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->begin();

		// Builds insert information
		$data = array(
			'action_time' => $dbw->timestamp(),
			'session_id' => (string) $session_id,
			'is_logged_in' => (bool) $is_logged_in,
			'user_total_contribs' => ( $is_logged_in ? (int) $contribs : null ),
			'user_contribs_span1' => ( $is_logged_in ? (int) $contribs_in_timespan1 : null ),
			'user_contribs_span2' => ( $is_logged_in ? (int) $contribs_in_timespan2 : null ),
			'user_contribs_span3' => ( $is_logged_in ? (int) $contribs_in_timespan3 : null ),
			'namespace' => (int) $namespace,
			'event_id' => (int) $event_id
		);

		$db_status = $dbw->insert( 'click_tracking', $data, __METHOD__ );
		$dbw->commit();
		return $db_status;
	}
}
