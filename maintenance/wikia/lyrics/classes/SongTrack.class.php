<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 4:30 PM
 */

class SongTrack extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.track';

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function getDataMap() {
		return [
			'album_id' => 'album_id',
			'song_id' => 'song_id',
			'track_number' => 'track_number'
		];
	}
} 