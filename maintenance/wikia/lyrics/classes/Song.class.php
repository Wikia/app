<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 3:00 PM
 */

class Song extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.song';

	var $dataMap = [
		'article_id' => 'article_id',
		'artist_id' => 'artist_id',
		'song' => 'name',
		'lyrics' => 'lyrics',
		'romanizedSong' => 'romanized_name',
		'language' => 'language',
		'youtube' => 'youtube',
		'goear' => 'goear',
		'itunes' => 'itunes',
		'asin' => 'asin',
		'musicbrainz' => 'musicbrainz',
		'allmusic' => 'allmusic',
		'download' => 'download',
	];

	function save( $albumData ) {
		$albumData = $this->sanitiseData( $albumData, $this->dataMap );
		$this->db->replace(
			self::TABLE_NAME,
			null,
			$albumData,
			__METHOD__
		);
	}
} 