<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 3:00 PM
 */

class Song extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.song';
	const ES_TYPE = 'artist';

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function getESType() {
		return self::ES_TYPE;
	}

	public function getDataMap() {
		return [
			'article_id' => 'article_id',
			'index' => 'index',
			'type' => 'type',
			'artist_id' => 'artist_id',
			'Artist' => 'artist',
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
	}
} 