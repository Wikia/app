<?php

/**
 * Class FastStats
 *
 * Get Licensed Video Swap (LVS) summary statistics for all wikis
 */
class FastStats {
	public static function run( DatabaseMysql $db, $test = false, $verbose = false, $params ) {
		$dbname = $params['dbname'];

		// Don't bother getting stats for the video wiki
		if ( $dbname == 'video151' ) {
			return;
		}

		// Get total local videos
		$sql = 'SELECT COUNT(*) as local_count FROM video_info WHERE premium = 0';
		$result = $db->query( $sql );

		$local_count = 0;
		while ( $row = $db->fetchObject($result) ) {
			$local_count = $row->local_count;
		}

		// Get number of matching videos and total number of matches
		$sql = 'SELECT page_id, props
				FROM page_wikia_props
				WHERE propname = '.WPP_LVS_SUGGEST;
		$result = $db->query( $sql );

		$num_matching = 0;
		$total_matches = 0;
		$countedPages = array();
		while ( $row = $db->fetchObject($result) ) {
			$info = unserialize( $row->props );
			$num_matching++;
			$total_matches += count($info);
			$countedPages[$row->page_id] = 1;
		}

		$sql = 'SELECT page_id, props
				FROM page_wikia_props
				WHERE propname = '.WPP_LVS_STATUS_INFO;
		$result = $db->query( $sql );

/*
 * Constants made available by LicensedVideoSwapHelper
		const STATUS_KEEP = 1;            // set bit to 1 = kept video
		const STATUS_SWAP = 2;            // set bit to 1 = swapped video
		const STATUS_EXACT = 4;           // set bit to 0 = normal swap, 1 = swap with an exact match
		const STATUS_SWAPPABLE = 8;       // set bit to 1 = video with suggestions
		const STATUS_NEW = 16;            // set bit to 1 = video with new suggestions
		const STATUS_FOREVER = 32;        // set bit to 1 = no more matches
*/

		$num_keeps = 0;
		$num_swaps = 0;
		while ( $row = $db->fetchObject($result) ) {
			$info = unserialize( $row->props );
			if ( $info['status'] & LicensedVideoSwapHelper::STATUS_KEEP ) {
				$num_keeps++;
			} else if ( $info['status'] & LicensedVideoSwapHelper::STATUS_SWAP ) {
				$num_swaps++;
			}

			// If this page wasn't counted above as having or more suggestions,
			// count it here.  This can happen if the suggestions get cleared out
			// after the video has been kept/swapped
			if ( !array_key_exists( $row->page_id, $countedPages) ) {
				$num_matching++;
			}
		}

		$url = WikiFactory::DBtoUrl( $dbname );
		echo "$dbname,$url,$local_count,$num_matching,$total_matches,$num_keeps,$num_swaps\n";
	}
}