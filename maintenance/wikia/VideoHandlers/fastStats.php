<?php

class FastStats {
	public static function lvsStats( DatabaseMysql $db, $dbname, $verbose = false, $test = false ) {
		// Get total local videos
		$sql = 'SELECT COUNT(*) as local_count FROM video_info WHERE premium = 0';
		$result = $db->query( $sql );

		$local_count = 0;
		while ( $row = $db->fetchObject($result) ) {
			$local_count = $row->local_count;
		}

		// Get number of matching videos and total number of matches
		$sql = 'SELECT props
				FROM video_info v, page p, page_wikia_props wp
				WHERE video_title=page_title
				  AND p.page_id = wp.page_id
				  AND wp.propname = 19
				  AND premium = 0';
		$result = $db->query( $sql );

		$num_matching = 0;
		$total_matches = 0;
		while ( $row = $db->fetchObject($result) ) {
			$info = unserialize( $row->props );
			$num_matching++;
			$total_matches += count($info);
		}

		$sql = 'SELECT props
				FROM page_wikia_props
				WHERE propname = 18';
		$result = $db->query( $sql );

		$num_keeps = 0;
		$num_swaps = 0;
		while ( $row = $db->fetchObject($result) ) {
			$info = unserialize( $row->props );
			if ( $info['status'] == 1 ) {
				$num_keeps++;
			} else {
				$num_swaps++;
			}
		}

		echo "$dbname,$local_count,$num_matching,$total_matches,$num_keeps,$num_swaps\n";
	}
}