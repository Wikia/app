<?php

/* Test
print_r( LqtHotTopicsController::generateHotTopics() )
*/
class LqtHotTopicsController {
	public static function generateHotTopics( $count = 10 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$now = wfTimestamp( TS_UNIX, wfTimestampNow() );
		$dateCutoff = $dbr->addQuotes( $dbr->timestamp( $now - ( 7 * 86400 ) ) );

		$conds = array();

		// Grab the ID cutoff
		$idCutoff = $dbr->selectField( 'thread_history', 'th_id',
						array( 'th_timestamp>' . $dateCutoff ),
						__METHOD__,
						array( 'ORDER BY' => 'th_id desc',
							'OFFSET' => 10000 )
						);

		if ( $idCutoff ) {
			$idCutoff = $dbr->addQuotes( $idCutoff );
			$conds[] = 'th_id>' . $idCutoff;
		}

		$res = $dbr->select( array( 'thread_history' ),
				array( 'th_id', 'th_thread', 'th_timestamp' ),
				$conds,
				__METHOD__,
				array( 'LIMIT' => 10000 )
			);

		$threads = array();

		foreach ( $res as $row ) {
			if ( isset( $threads[$row->th_thread] ) ) {
				$thread =& $threads[$row->th_thread];
				$thread['count']++;

				if ( $thread['firstpost'] > $row->th_timestamp ) {
					$thread['firstpost'] = $row->th_timestamp;
				}

				if ( $thread['lastpost'] < $row->th_timestamp ) {
					$thread['lastpost'] = $row->th_timestamp;
				}
				unset( $thread );
			} else {
				$thread = array();

				$thread['id'] = $row->th_thread;
				$thread['count'] = 1;
				$thread['firstpost'] = $row->th_timestamp;
				$thread['lastpost'] = $row->th_timestamp;

				$threads[$row->th_thread] = $thread;
			}
		}

		foreach ( $threads as &$thread ) {
			$thread['rate'] = self::getThreadPostRate( $thread );
		}

		// Filter out useless stuff
		$threads = array_filter( $threads, array( __CLASS__, 'threadFilterCallback' ) );

		// Sort
		usort( $threads, array( __CLASS__, 'threadSortCallback' ) );

		$threads = array_slice( $threads, 0, $count, true );

		$outputThreads = array();

		foreach ( $threads as $thread ) {
			$outputThreads[$thread['id']] = $thread['id'];
		}

		return $outputThreads;
	}

	public static function getHotThreads( $count = 10 ) {
		$topics = array_values( self::generateHotTopics( $count ) );

		return Threads::where( array( 'thread_id' => $topics ) );
	}

	public static function threadFilterCallback( $entry ) {
		return $entry['count'] > 3;
	}

	public static function threadSortCallback( $a, $b ) {
		$rateA = floatval( $a['rate'] );
		$rateB = floatval( $b['rate'] );

		if ( $rateA == $rateB ) {
			$val = 0;
		} elseif ( $rateA < $rateB ) {
			$val = 1;
		} elseif ( $rateA > $rateB ) {
			$val = - 1;
		}

		return $val;
	}

	public static function getThreadPostRate( $entry ) {
		if ( $entry['count'] < 2 ) {
			return 0;
		}

		$startTime = wfTimestamp( TS_UNIX, $entry['firstpost'] );
		$endTime = wfTimestamp( TS_UNIX, wfTimestampNow() );
		$duration = $endTime - $startTime;

		// Get count over duration, multiply out to give posts per day
		return ( $entry['count'] / $duration ) * 86400;
	}
}
