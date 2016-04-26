<?php

/**
 * Class PopulateVideoId
 *
 * This script is no longer necessary after we've added all
 */
class PopulateVideoId {
	public static function run( DatabaseBase $db, $dbname, $test = false, $verbose = false ) {

		// Don't process the video wiki
		if ( $dbname == 'video151' ) {
			return true;
		}

		$str_sql = <<<SQL
update video_info, image
   set video_id = substring_index(substring_index(SUBSTRING_INDEX(img_metadata, 's:7:"videoId";', -1), '";', 1),':"', -1)
 where premium = 0
   and video_title = img_name
   and video_title is not null
   and img_metadata like '%s:7:"videoId";s:%'
   and video_id = ''
SQL;

		$int_sql = <<<SQL
update video_info, image
   set video_id = substring_index(SUBSTRING_INDEX(img_metadata, 's:7:"videoId";i:', -1), ';', 1)
 where premium = 0
   and video_title = img_name
   and video_title is not null
   and img_metadata like '%s:7:"videoId";i:%'
SQL;

		if ( $verbose ) {
			echo "Running on $dbname:\n\t$str_sql\n\t$int_sql\n";
		}

		if ( empty($test) ) {
			$res = $db->query( $str_sql );
			$res = $db->query( $int_sql );
		}
	}
}
