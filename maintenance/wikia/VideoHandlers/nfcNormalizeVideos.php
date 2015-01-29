<?php
ini_set('display_errors', 'stderr');
putenv("SERVER_ID=177");

/**
 * Class NfcNormalizeVideos
 * Usage: Use runOnCluster with --method run
 *
 * Normalizes video records into NFC form
 * @see VID-2153 & http://unicode.org/reports/tr15/
 */
class NfcNormalizeVideos {
	/**
	 * Used by runOnCluster to Normalize video titles
	 *
	 * @param DatabaseMysql $db
	 * @param bool $test
	 * @param bool $verbose
	 * @param array $params
	 */
	public static function run( DatabaseMysql $db, $test, $verbose = false, $params ) {

		if ( !$db->tableExists( 'image' ) || !$db->tableExists( 'video_info' ) ) {
			echo "ERROR: $params[dbname] (ID:$params[cityId]): image/video_info table does not exist.\n";
			return;
		}

		foreach ( self::getVideoRows( $db ) as $video ) {
			$originalName = $video->img_name;
			if ( \UtfNormal::quickIsNFC( $originalName ) ) {
				if ( $verbose ) {
					echo "Already in NFC form; skipping: $originalName\n";
				}
				continue;
			}

			self::updateVideo( $video, $db, $test, $verbose );
		}
	}

	/**
	 * Return an array of videos
	 *
	 * @param DatabaseMysql $db
	 * @return array
	 */
	protected static function getVideoRows( DatabaseMysql $db ) {
		return ( new WikiaSQL() )
			->SELECT( 'img_name', 'img_sha1' )
			->FROM( 'image' )
			->WHERE( 'img_media_type' )->EQUAL_TO( 'VIDEO' )
			->AND_( FluentSql\StaticSQL::RAW( 'img_name <> CONVERT(img_name USING ASCII)' ) )
			->runLoop( $db, function ( &$videos, $row ) {
				$videos[] = $row;
			} );
	}

	/**
	 * Update title for videos with titles not in normalized NFC form
	 *
	 * @param stdClass $video
	 * @param DatabaseMysql $db
	 * @param bool $test
	 * @param bool $verbose
	 */
	protected static function updateVideo( $video, DatabaseMysql $db, $test, $verbose ) {
		$originalName = $video->img_name;

		// image.img_name & video_info.video_title
		$name = \UtfNormal::toNFC( $originalName );
		if ( $name == $originalName ) {
			echo "No change detected. Skipped conversion for: $originalName\n";
			return;
		}

		$affectedImage = 0;
		$affectedVideoInfo = 0;

		if ( !$test ) {
			$sql = new WikiaSQL();
			$sql->UPDATE( 'image' )
				->SET( 'img_name', $name )
				->WHERE( 'img_name' )->EQUAL_TO( $originalName )
				->run( $db );
			$affectedImage = $db->affectedRows() ? '' : 'NOT';

			$sql->UPDATE( 'video_info' )
				->SET( 'video_title', $name )
				->WHERE( 'video_title' )->EQUAL_TO( $originalName )
				->run( $db );
			$affectedVideoInfo = $db->affectedRows() ? '' : 'NOT';
		}

		echo "image $affectedImage updated, "
			. "video_info $affectedVideoInfo updated "
			. "for: $originalName img_sha1: {$video->img_sha1}\n";

		if ( $verbose ) {
			echo "\tNew title: $name\n";
		}
	}

}
