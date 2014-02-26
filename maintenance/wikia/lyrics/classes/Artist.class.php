<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 12:54 PM
 */

class Artist extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.artist';

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function getDataMap() {
		return [
			'article_id' => 'article_id',
			'name' => 'name',
			'romanizedArtist' => 'romanized_name',
			'pic' => 'image',
			'officialSite' => 'official_site',
			'myspace' => 'myspace',
			'twitter' => 'twitter',
			'facebook' => 'facebook',
			'wikia' => 'wikia',
			'wikipedia' => 'wikipedia',
			'wikipedia2' => 'wikipedia2',
			'country' => 'country',
			'state' => 'state',
			'hometown' => 'hometown',
			'iTunes' => 'itunes',
			'asin' => 'asin',
			'allmusic' => 'allmusic',
			'discogs' => 'discogs',
			'musicbrainz' => 'musicbrainz',
			'youtube' => 'youtube',
		];
	}
} 