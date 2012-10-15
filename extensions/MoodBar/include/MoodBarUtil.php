<?php

/**
 * Utility class for MoodBar
 */
class MoodBarUtil {

	/**
	 * Calculate the time diff between $time and now, format the time diff to have the largest time block
	 * or 'less than 1 minute' if the time diff is less than 1 minute
	 * @param $time string - the UNIX time stamp
	 * @return string - formatted time string
	 */
	public static function formatTimeSince( $time ) {
		
		$blocks = array( array( 'total' => 60 * 60 * 24 * 365, 'name' => 'years' ),
					array( 'total' => 60 * 60 * 24 * 30, 'name' => 'months'),
					array( 'total' => 60 * 60 * 24 * 7, 'name' => 'weeks'),
					array( 'total' => 60 * 60 * 24, 'name' => 'days'),
					array( 'total' => 60 * 60, 'name' => 'hours'),
					array( 'total' => 60, 'name' => 'minutes') );

		$since = wfTimestamp( TS_UNIX ) - $time;
		$displayTime = 0;
		$displayBlock = '';

		// get the largest time block, 1 minute 35 seconds -> 2 minutes
		for ( $i = 0, $count = count( $blocks ); $i < $count; $i++ ) {
			$seconds = $blocks[$i]['total'];
			$displayTime = floor( $since / $seconds );
			
			if ( $displayTime > 0 ) {
				$displayBlock = $blocks[$i]['name'];
				// round up if the remaining time is greater than
				// half of the time unit
				if ( ( $since % $seconds ) >= ( $seconds / 2 ) ) {
					$displayTime++;
					
					//advance to upper unit if possible, eg, 24 hours to 1 day
					if ( isset( $blocks[$i-1] ) && $displayTime * $seconds ==  $blocks[$i-1]['total'] ) {
						$displayTime = 1;
						$displayBlock = $blocks[$i-1]['name'];
					}
					
				}
				break;
			}
		}

		if ( $displayTime > 0 ) {
			global $wgLang;
			
			// message key defined in moodbar only
			if ( in_array( $displayBlock, array( 'years', 'months', 'weeks' ) ) ) {
				$messageKey = 'moodbar-' . $displayBlock;
			}
			else {
				$messageKey = $displayBlock;
			}
			
			return wfMessage( $messageKey )->params( $wgLang->formatNum( $displayTime ) )->escaped();

		} else {
			return wfMessage( 'moodbar-seconds' )->escaped();
		}
	
	}
	
	/**
	 * Get the top responders for feedback in past week, default is top 5
	 * @param $num int - the number of top responders we want to get
	 * @return array
	 */
	public static function getTopResponders( $num = 5 ) {
	
		global $wgMemc;

		$timestamp = wfTimestamp( TS_UNIX ) - 7 * 24 * 60 * 60; // 1 week ago

		// Try cache first
		$key = wfMemcKey( 'moodbar_feedback_response', 'top_responders', 'past_week' );
		$topResponders = $wgMemc->get( $key );

		if ( $topResponders === false ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( 'moodbar_feedback_response', 'user' ),
							array( 'COUNT(*) AS number', 'user_id', 'user_name', 'user_real_name' ),
							array( 'mbfr_user_id = user_id', 'mbfr_timestamp > ' . $dbr->addQuotes( $dbr->timestamp( $timestamp ) ) ),
							__METHOD__,
							array( 'GROUP BY' => 'user_id', 'ORDER BY' => 'number DESC', 'LIMIT' => $num )
			);
			
			$topResponders = iterator_to_array( $res );

			// Cache the results in cache for 2 hours
			$wgMemc->set( $key, $topResponders, 2 * 60 * 60 );
		}

		return $topResponders;

	}

	/**
	 * Get the stats for the moodbar type in the last 24 hours
	 * @return array - count of number for each moodbar type
	 */
	public static function getMoodBarTypeStats() {

		global $wgMemc;

		$timestamp = wfTimestamp( TS_UNIX ) - 24 * 60 * 60; // 24 hours ago
		
		// Try cache first
		$key = wfMemcKey( 'moodbar_feedback', 'type_stats', 'last_day' );
		$moodbarStat = $wgMemc->get( $key );

		if ( $moodbarStat === false ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( 'moodbar_feedback' ),
						array( 'mbf_type', 'COUNT(*) AS number' ),
						array( 'mbf_hidden_state' => 0, 'mbf_timestamp > ' . $dbr->addQuotes( $dbr->timestamp( $timestamp ) ) ),
						__METHOD__,
						array( 'GROUP BY' => 'mbf_type' )
			);

			$moodbarStat = array( 'happy' => 0, 'sad' => 0, 'confused' => 0 );

			foreach ( $res as $row ) {
				$moodbarStat[$row->mbf_type] = $row->number;
			}

			// Cache the results in cache for 1 hour
			$wgMemc->set( $key, $moodbarStat, 60 * 60 );
		}

		return $moodbarStat;

	}

	/**
	 * Check if MarkAsHelpful extension is enabled
	 * @return bool
	 */
	public static function isMarkAsHelpfulEnabled() {
		global $wgMarkAsHelpfulType;

		return is_array( $wgMarkAsHelpfulType ) && in_array( 'mbresponse', $wgMarkAsHelpfulType );
	}

}