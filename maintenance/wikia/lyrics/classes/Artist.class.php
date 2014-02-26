<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 12:54 PM
 */

class Artist extends BaseLyricsEntity {

	const ARTIST_TABLE_NAME = 'lyrics_api.artist';

	var $dataMap = [
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

	public function save( $artistData ) {
		$artistData = $this->sanitiseData( $artistData, $this->dataMap );
		$this->db->replace(
			self::ARTIST_TABLE_NAME,
			null,
			$artistData,
			__METHOD__
		);
	}
} 