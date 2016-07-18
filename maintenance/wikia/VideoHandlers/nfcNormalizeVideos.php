<?php

/**
 * Class NfcNormalizeVideos
 * Usage: Use runOnCluster with --method run
 *
 * Normalizes video records into NFC form
 * @see VID-2153 & http://unicode.org/reports/tr15/
 */
class NfcNormalizeVideos {
	protected static $metadataFieldsContainingName = [
		'title',
		'name',
		'keywords',
	];

	/**
	 * Used by runOnCluster to Normalize video titles and metadata
	 *
	 * @param DatabaseBase $db
	 * @param bool $test
	 * @param bool $verbose
	 * @param array $params
	 */
	public static function run( DatabaseBase $db, $test, $verbose = false, $params ) {

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
	 * @param DatabaseBase $db
	 * @return array
	 */
	protected static function getVideoRows( DatabaseBase $db ) {
		return ( new WikiaSQL() )
			->SELECT( 'img_name', 'img_metadata', 'img_sha1' )
			->FROM( 'image' )
			->WHERE( 'img_media_type' )->EQUAL_TO( 'VIDEO' )
			->AND_( FluentSql\StaticSQL::RAW( 'img_name <> CONVERT(img_name USING ASCII)' ) )
			->runLoop( $db, function ( &$videos, $row ) {
				$videos[] = $row;
			} );
	}

	/**
	 * Update title and metadata for videos with titles not in normalized NFC form
	 *
	 * @param stdClass $video
	 * @param DatabaseBase $db
	 * @param bool $test
	 * @param bool $verbose
	 */
	protected static function updateVideo( $video, DatabaseBase $db, $test, $verbose ) {
		$originalName = $video->img_name;

		// image.img_name & video_info.video_title
		$name = \UtfNormal::toNFC( $originalName );
		if ( $name == $originalName ) {
			echo "No change detected. Skipped conversion for: $originalName\n";
			return;
		}

		// This is also required because PHP unserialize fails otherwise
		$metadata = self::getNormalizedMetadata( $video );

		$affectedImage = 'NOT';
		$affectedVideoInfo = 'NOT';

		if ( !$test ) {
			$sql = new WikiaSQL();
			$sql->UPDATE( 'image' )
				->SET( 'img_name', $name )
				->SET( 'img_metadata', $metadata )
				->WHERE( 'img_name' )->EQUAL_TO( $originalName )
				->run( $db );
			$affectedImage = $db->affectedRows() ? '' : 'NOT';

			$sql = new WikiaSQL();
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
			echo "\tNew title: $name"
				. "\n\tNew metadata: $metadata\n";
		}
	}

	/**
	 * Get Normalized metadata in PHP-serialized form
	 *
	 * @param stdClass $video
	 * @return string
	 */
	protected static function getNormalizedMetadata( $video ) {
		// image.img_metadata
		$metadata = unserialize( $video->img_metadata );
		foreach ( self::$metadataFieldsContainingName as $field ) {
			if ( isset( $metadata[ $field ] ) ) {
				$metadata[ $field ] = \UtfNormal::toNFC( $metadata[ $field ] );
			}
		}
		return serialize( $metadata );
	}
}
