<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:11 PM
 */

class MockLyricsApiHandler extends AbstractLyricsApiHandler {
	const LYRICS_WIKI_URL = 'http://lyrics.wikia.com/';

	public function getArtist( $artist ) {
		$result = new stdClass();
		$result->name = $artist;
		$result->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
		$result->url = self::LYRICS_WIKI_URL . $artist;

		$album1 = new stdClass();
		$album1->name = 'Album #1';
		$album1->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
		$album1->url = self::LYRICS_WIKI_URL . $artist . ':' . $album1->name;

		$album2 = new stdClass();
		$album2->name = 'Album #2';
		$album2->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
		$album2->url = self::LYRICS_WIKI_URL . $artist . ':' . $album2->name;

		$result->albums = [
			$album1,
			$album2
		];

		return $result;
	}

	public function getAlbum( $artist, $album ) {
		return [
			'artist' => [
				'name' => $artist,
				'image' => $artist . '.jpg',
				'url' => $artist
			],
			'name' => $album,
			'image' => $album . '.jpg',
			'songs' => [
				[
					'name' => $album . ' song 1',
					'url' => $album . ' song 1',
				],
				[
					'name' => $album . ' song 2',
					'url' => $album . ' song 2',
				],
			]
		];
	}

	public function getSong( $artist, $album, $song ) {}
	public function searchArtist( $query ) {}
	public function searchSong( $query ) {}
	public function searchLyrics( $query ) {}

} 