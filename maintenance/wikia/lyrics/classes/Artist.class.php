<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 12:54 PM
 */

class Artist extends BaseLyricsEntity {

	const TABLE_NAME = 'lyrics_api.artist';

	var $dataMap = [
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

	public function save( $artistData ) {
		$artistData = $this->sanitiseData( $artistData, $this->dataMap );
		$this->db->replace(
			self::TABLE_NAME,
			null,
			$artistData,
			__METHOD__
		);
	}

	public function getIdByName( $artistName ) {
		return 1; // TODO: REMOVEME
		return $this->db->selectField(
			self::TABLE_NAME,
			id,
			[ 'name' =>	$artistName],
			__METHOD__);
	}
} 