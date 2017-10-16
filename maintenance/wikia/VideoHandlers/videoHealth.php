<?php

/**
 * Find common data errors in image and video_info table for all wikis
 */
class VideoHealth {
	public static function run( DatabaseBase $db, $test = false, $verbose = false, $params ) {
		$dbname = $params['dbname'];

		// 1. How many local video_info are missing provider or video_id
		$label = 'missing provider or video_id';
		$sql = <<<SQL
			SELECT added_at AS video_timestamp,
				video_title AS video_title
			FROM video_info
			WHERE (provider IS NULL OR video_id IS NULL)
				AND premium = 0
				AND removed = 0
SQL;
		self::outputRows( $db, $dbname, $label, $sql );

		// 2. How many video_info rows are missing
		$label = 'missing video_info rows';
		$sql = <<<SQL
			SELECT DATE_FORMAT(img_timestamp, '%c/%e/%y %k:%i') AS video_timestamp,
				img_name AS video_title
			FROM image
			LEFT JOIN video_info ON (
				image.img_name = video_info.video_title
			)
			WHERE img_media_type = 'VIDEO'
				AND video_info.video_title IS NULL
SQL;
		self::outputRows( $db, $dbname, $label, $sql );

		// 3. How many image/video_info rows mismatch in video_id
		$label = 'video_id mismatch';
		// 3.1 string ids
		$sql = <<<SQL
			SELECT added_at AS video_timestamp,
				video_title AS video_title
			FROM image
			JOIN video_info ON (
				image.img_name = video_info.video_title
			)
			WHERE img_media_type = 'VIDEO'
				AND premium = 0
				AND removed = 0
				AND img_metadata like '%"videoId";s:%'
				AND substring_index(
					substring_index(
						substring(img_metadata, locate('"videoId";s:', img_metadata)), '"', 4
					), '"', -1) != video_info.video_id
SQL;
		self::outputRows( $db, $dbname, $label, $sql );

		// 3.2 integer ids
		$sql = <<<SQL
			SELECT added_at AS video_timestamp,
				video_title AS video_title
			FROM image
			JOIN video_info ON (
				image.img_name = video_info.video_title
			)
			WHERE img_media_type = 'VIDEO'
				AND premium = 0
				AND removed = 0
				AND img_metadata like '%"videoId";i:%'
				AND substring(
					substring_index(
					substring_index(
						substring(img_metadata, locate('"videoId";i:', img_metadata)), ';', 2
					), ';', -1), 3) != video_info.video_id
SQL;
		self::outputRows( $db, $dbname, $label, $sql );
	}

	protected static function outputRows( DatabaseBase $db, $dbname, $label, $sql ) {
		$result = $db->query( $sql );
		while ( $row = $db->fetchObject( $result ) ) {
			echo "$dbname,$label,$row->video_timestamp,$row->video_title\n";
		}
	}
}