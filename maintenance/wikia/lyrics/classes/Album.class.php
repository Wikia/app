<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 2:00 PM
 */

class Album extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.album';
	const ES_TYPE = 'artist';

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function getESType() {
		return self::ES_TYPE;
	}

	public function getDataMap() {
		return [
			'index'	=> 'index',
			'type'	=> 'type',
			'article_id' => 'article_id',
			'artist_id' => 'artist_id',
			'Artist' => 'artist',
			'Album' => 'name',
			'Cover' => 'pic',
			'year' => 'year',
			'Length' => 'length',
			'Genre' => 'genres',
/*
			'Wikipedia' => 'wikipedia',
			'romanizedAlbum' => 'romanized_name',
			'asin' => 'asin',
*/
			'iTunes' => 'itunes',
/*
			'allmusic' => 'allmusic',
			'discogs' => 'discogs',
			'musicbrainz' => 'musicbrainz',
			'download' => 'download',
*/
		];
	}

}