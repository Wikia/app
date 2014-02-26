<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 3:00 PM
 */

class Song extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.song';

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function getDataMap() {
		return [
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
	}

	public function getIdByNameAndArtistId( $songName, $artistId ) {
		return 1; // TODO: REMOVE_ME
		return $this->db->selectField(
			$this->getTableName(),
			'article_id',
			[
				'name' => $albumName,
				'artist_id' => $artist_id
			],
			__METHOD__);
	}
} 